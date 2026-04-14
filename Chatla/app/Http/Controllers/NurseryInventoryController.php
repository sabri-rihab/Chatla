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

        // Get all inventory items with plants and families
        $inventories = $nursery->inventory()
            ->with(['plant', 'plant.family'])
            ->get();

        // Get all plant families for the filter dropdown
        $families = PlantFamily::orderBy('name')->get();

        return view('nursery.inventory.index', compact('inventories', 'families'));
    }
}
