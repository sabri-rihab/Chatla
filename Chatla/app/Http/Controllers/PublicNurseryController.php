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
            ->with(['plant.family', 'images']);

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
        // 1. Make sure they actually sent a number between 1 and 5
        $request->validate([
            'rate' => 'required|integer|min:1|max:5'
        ]);

        // 2. Save the rating to the database!
        // We use 'updateOrCreate' so if the user rates again, it just updates their old score instead of crashing.
        $nursery->ratings()->updateOrCreate(
            ['user_id' => auth()->id()], // Look for an existing rating by this user
            ['rate' => $request->rate]   // Update it (or create it) with the new value
        );

        // 3. Optional: Update the simple "rating" column on your main nurseries table
        // We calculate the new average and round it to a whole number to save it
        $newAverage = $nursery->ratings()->avg('rate');
        $nursery->update(['rating' => round($newAverage)]);

        // 4. Send them back to the page they were just on
        return back()->with('success', 'Thank you for rating this nursery!');
    }
}
