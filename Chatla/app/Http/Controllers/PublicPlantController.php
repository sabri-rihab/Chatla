<?php

namespace App\Http\Controllers;

use App\Models\NurseryInventory;
use Illuminate\Http\Request;

class PublicPlantController extends Controller
{
    /**
     * Display the specified plant from a nursery's inventory.
     */
    public function show(NurseryInventory $inventory)
    {
        // Load relationships
        $inventory->load(['plant.family', 'nursery.city', 'images']);
        
        // Find other plants from the same nursery as "recommendations"
        $relatedPlants = NurseryInventory::where('nursery_id', $inventory->nursery_id)
            ->where('id', '!=', $inventory->id)
            ->with(['plant', 'images'])
            ->limit(4)
            ->get();

        return view('plants.show', compact('inventory', 'relatedPlants'));
    }
}
