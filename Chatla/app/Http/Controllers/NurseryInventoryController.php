<?php

namespace App\Http\Controllers;

use App\Models\NurseryInventory;
use App\Models\PlantFamily;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NurseryInventoryController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $nursery = $user->nursery;

        if (!$nursery) {
            return redirect()->route('dashboard')->with('error', 'Nursery not found.');
        }

        // Pre-format the data for the frontend catalogue grid
        $formattedInventories = $nursery->inventory()
            ->with(['plant', 'plant.family', 'plant.defaultImages', 'images'])
            ->get()
            ->map(function ($item) {
                // Map the enum values from the DB to the status labels expected by the frontend template
                $statusMap = [
                    'in_stock' => 'available',
                    'low_stock' => 'low',
                    'pre_ordered' => 'out', // or map accordingly
                ];

                // Simple stock number mapping based on status for now, as the DB uses enums but UI expects counts
                $stockMap = [
                    'in_stock' => 20,
                    'low_stock' => 5,
                    'pre_ordered' => 0,
                ];

                return [
                    'id' => $item->id,
                    'name' => $item->plant->name ?? 'Unknown',
                    'common' => $item->plant->common_name ?? '',
                    'family' => $item->plant->family->name ?? 'None',
                    'price' => (float)($item->price ?? 0),
                    'stock' => $item->quantity,
                    'status' => $statusMap[$item->stock_quantity] ?? 'out',
                    'desc' => $item->custom_description ?? $item->plant->about_description ?? '',
                    'img' => $item->images->first()->image_path ?? $item->plant->defaultImages->first()->image_url ?? 'https://via.placeholder.com/400x300?text=Plant'
                ];
            });

        // Get all plant families for the filter dropdown
        $families = PlantFamily::orderBy('name')->get();

        return view('nursery.inventory.index', [
            'plants' => $formattedInventories,
            'families' => $families
        ]);
    }

    public function update(Request $request, $id)
    {
        $nursery = Auth::user()->nursery;
        
        $inventory = NurseryInventory::where('id', $id)
            ->where('nursery_id', $nursery->id)
            ->firstOrFail();

        $validated = $request->validate([
            'price' => 'numeric|min:0',
            'quantity' => 'numeric|min:0',
            'stock_status' => 'string|in:available,low,out',
            'image' => 'nullable|image|max:5120'
        ]);

        $statusReverseMap = [
            'available' => 'in_stock',
            'low' => 'low_stock',
            'out' => 'pre_ordered', 
        ];

        $inventory->price = $validated['price'];
        $inventory->quantity = $validated['quantity'];
        $inventory->stock_quantity = $statusReverseMap[$validated['stock_status']] ?? 'in_stock';
        $inventory->save();

        $imageUrl = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('inventory_images', 'public');
            $imageUrl = '/storage/' . $path;
            
            $image = $inventory->images()->first();
            if ($image) {
                $image->update(['image_path' => $imageUrl]);
            } else {
                $inventory->images()->create([
                    'image_path' => $imageUrl
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'image_url' => $imageUrl
        ]);
    }

    public function destroy($id)
    {
        $nursery = Auth::user()->nursery;

        $inventory = NurseryInventory::where('id', $id)
            ->where('nursery_id', $nursery->id)
            ->firstOrFail();

        $inventory->delete();

        return response()->json(['success' => true]);
    }
}
