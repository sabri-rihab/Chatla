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
                    'stock' => $stockMap[$item->stock_quantity] ?? 0,
                    'status' => $statusMap[$item->stock_quantity] ?? 'out',
                    'desc' => $item->custom_description ?? $item->plant->about_description ?? '',
                    'img' => $item->images->first()->image_url ?? $item->plant->defaultImages->first()->image_url ?? 'https://via.placeholder.com/400x300?text=Plant'
                ];
            });

        // Get all plant families for the filter dropdown
        $families = PlantFamily::orderBy('name')->get();

        return view('nursery.inventory.index', [
            'plants' => $formattedInventories,
            'families' => $families
        ]);
    }
}
