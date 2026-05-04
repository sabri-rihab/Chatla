<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\PlantFamily;
use App\Models\NurseryInventory;
use Illuminate\Http\Request;

class ExploreController extends Controller
{
    /**
     * Display the plants listing with advanced filters.
     */
    public function index(Request $request)
    {
        // Base Query: Only get inventories that belong to an 'active' nursery
        $query = NurseryInventory::query()
            ->whereHas('nursery', function($q) {
                $q->where('status', 'active');
            })
            ->with(['plant.family', 'plant.defaultImages', 'nursery.city', 'images']);

        // 1. GLOBAL SEARCH (Name, Slug, or Family Name)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('plant', function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('slug', 'LIKE', "%{$search}%")
                  ->orWhereHas('family', function ($fq) use ($search) {
                      $fq->where('name', 'LIKE', "%{$search}%");
                  });
            });
        }

        // 2. CITY FILTER (Multiple city IDs)
        if ($request->filled('cities')) {
            $cityIds = is_array($request->cities) ? $request->cities : explode(',', $request->cities);
            $query->whereHas('nursery', function ($q) use ($cityIds) {
                $q->whereIn('city_id', $cityIds);
            });
        }

        // 3. PLANT FAMILY FILTER (Multiple family IDs)
        if ($request->filled('families')) {
            $familyIds = is_array($request->families) ? $request->families : explode(',', $request->families);
            $query->whereHas('plant', function ($q) use ($familyIds) {
                $q->whereIn('family_id', $familyIds);
            });
        }

        // 4. GROWTH STAGE FILTER
        if ($request->filled('growth_stages')) {
            $stages = is_array($request->growth_stages) ? $request->growth_stages : explode(',', $request->growth_stages);
            $query->whereIn('growth_status', $stages);
        }

        // Paginate results (9 per page as per requirement)
        $inventories = $query->paginate(9)->withQueryString();

        // Data for dynamic filters
        $allCities = City::orderBy('name')->get(['id', 'name']);
        $allFamilies = PlantFamily::orderBy('name')->get(['id', 'name']);

        return view('explore', compact('inventories', 'allCities', 'allFamilies'));
    }
}
