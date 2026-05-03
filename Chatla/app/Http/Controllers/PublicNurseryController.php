<?php

namespace App\Http\Controllers;

use App\Models\Nursery;
use App\Models\PlantFamily;
use Illuminate\Http\Request;

class PublicNurseryController extends Controller
{
    /**
     * Display a public profile of the nursery and its plant catalog.
     */
    public function show(Request $request, Nursery $nursery)
    {
        // 1. Add the select() and join() so we can sort by plant names
        $query = $nursery->inventory()
            ->select('nursery_inventories.*') // Keeps inventory IDs safe
            ->join('plants', 'nursery_inventories.plant_id', '=', 'plants.id')
            ->with(['plant.family', 'plant.defaultImages', 'images']);

        //Sort result a-z/z-a
        if($request->sort === 'a-z'){
            $query->orderBy('plants.name', 'asc');
        }else{
            $query->orderBy('plants.name', 'desc');
        }

        // Filter by Search Query
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('plant', function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%");
            });
        }

        // Filter by Plant Family
        if ($request->filled('families')) {
            $familyIds = is_array($request->families) ? $request->families : explode(',', $request->families);
            $query->whereHas('plant', function ($q) use ($familyIds) {
                $q->whereIn('family_id', $familyIds);
            });
        }
        

        // Filter by Stock Status
        if ($request->filled('stock_status')) {
            $status = is_array($request->stock_status) ? $request->stock_status : explode(',', $request->stock_status);
            $query->whereIn('stock_status', $status);
        }

        $catalog = $query->paginate(9)->withQueryString();
        
        $allFamilies = PlantFamily::orderBy('name')->get(['id', 'name']);
        $allCities = \App\Models\City::orderBy('name')->get(['id', 'name']);

        return view('nurseries.show', compact('nursery', 'catalog', 'allFamilies', 'allCities'));
    }

    public function rate(Request $request, Nursery $nursery)
    {
        // 1. Change 'required' to 'nullable' so empty values don't cause errors
        $request->validate([
            'rate' => 'nullable|integer|min:1|max:5'
        ]);

        // 2. If the rate is empty (null), delete the existing rating
        if (is_null($request->rate)) {
            $nursery->ratings()->where('user_id', auth()->id())->delete();
            $message = 'Your rating has been removed.';
        } else {
            // Otherwise, save or update the new rating
            $nursery->ratings()->updateOrCreate(
                ['user_id' => auth()->id()], 
                ['rate' => $request->rate]   
            );
            $message = 'Thank you for rating this nursery!';
        }

        // 3. Recalculate the average (if there are no ratings left, default to 0)
        $newAverage = $nursery->ratings()->avg('rate') ?? 0;
        
        // Update the main nursery table
        $nursery->update(['rating' => round($newAverage)]);

        // 4. Send them back with a success message
        return back()->with('success', $message);
    }
}
