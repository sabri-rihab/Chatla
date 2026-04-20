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
        $query = $nursery->inventory()->with(['plant.family', 'images']);

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
}
