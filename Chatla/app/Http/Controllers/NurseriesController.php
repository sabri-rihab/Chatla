<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Nursery;
use Illuminate\Http\Request;

class NurseriesController extends Controller
{
    public function index(Request $request)
    {
        $query = Nursery::with('city')->where('status', 'active');

        // Search by name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'LIKE', "%{$search}%");
        }

        // Filter by city
        if ($request->filled('cities')) {
            $cityIds = is_array($request->cities) ? $request->cities : explode(',', $request->cities);
            $query->whereIn('city_id', $cityIds);
        }

        $nurseries = $query->orderBy('name')->paginate(9)->withQueryString();
        $allCities  = City::orderBy('name')->get(['id', 'name']);

        return view('nurseries.index', compact('nurseries', 'allCities'));
    }
}
