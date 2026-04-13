<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Nursery;
use Illuminate\Http\Request;

/**
 * NurseryController
 *
 * Handles:
 *  - GET  /api/nurseries/:id/plants   (public – paginated plant list)
 *  - GET  /api/nurseries/search       (public – filter by city/region)
 */
class NurseryController extends Controller
{
    // ─────────────────────────────────────────────────────────────────
    // GET /api/nurseries/{id}/plants
    // Public endpoint – returns paginated inventory for one nursery.
    // ─────────────────────────────────────────────────────────────────
    public function plants(Request $request, int $id)
    {
        // Fetch nursery or 404
        $nursery = Nursery::select('id', 'name', 'city', 'region', 'address', 'phone', 'email', 'status', 'rating')
            ->findOrFail($id);

        // Load inventory with plant + family + images, paginated
        $perPage = (int) $request->query('per_page', 15);
        $perPage = min(max($perPage, 1), 100); // clamp 1–100

        $inventories = $nursery->inventory()
            ->with([
                'plant.family:id,name,slug',
                'plant.defaultImages' => fn ($q) => $q->where('is_primary', true),
                'images',               // inventory-specific images
            ])
            ->paginate($perPage);

        // Shape the response
        $plants = $inventories->map(fn ($inv) => [
            'inventory_id'   => $inv->id,
            'stock_status'   => $inv->stock_status,
            'growth_status'  => $inv->growth_status,
            'quantity'       => $inv->quantity,
            'price'          => $inv->price,
            'plant' => [
                'id'          => $inv->plant->id,
                'name'        => $inv->plant->name,
                'slug'        => $inv->plant->slug,
                'family'      => $inv->plant->family?->name,
                'description' => $inv->custom_description ?? $inv->plant->about_description,
                'images'      => $inv->images->pluck('image_path')
                                   ->merge($inv->plant->defaultImages->pluck('image_path')),
            ],
        ]);

        return response()->json([
            'success' => true,
            'nursery' => $nursery,
            'plants'  => $plants,
            'pagination' => [
                'current_page' => $inventories->currentPage(),
                'per_page'     => $inventories->perPage(),
                'total'        => $inventories->total(),
                'last_page'    => $inventories->lastPage(),
            ],
        ]);
    }

    // ─────────────────────────────────────────────────────────────────
    // GET /api/nurseries/search?region=&city=
    // Public – filter nurseries by region and/or city.
    // ─────────────────────────────────────────────────────────────────
    public function search(Request $request)
    {
        $region = $request->query('region');
        $city   = $request->query('city');
        $name   = $request->query('name');

        $query = Nursery::select('id', 'name', 'city', 'region', 'address', 'phone', 'email', 'status', 'rating')
            ->where('status', 'active');

        if ($region) {
            // Case-insensitive partial match
            $query->where('region', 'LIKE', "%{$region}%");
        }

        if ($city) {
            $query->where('city', 'LIKE', "%{$city}%");
        }

        if ($name) {
            $query->where('name', 'LIKE', "%{$name}%");
        }

        $nurseries = $query->orderBy('name')->paginate(20);

        return response()->json([
            'success'    => true,
            'filters'    => compact('region', 'city', 'name'),
            'nurseries'  => $nurseries->items(),
            'pagination' => [
                'current_page' => $nurseries->currentPage(),
                'per_page'     => $nurseries->perPage(),
                'total'        => $nurseries->total(),
                'last_page'    => $nurseries->lastPage(),
            ],
        ]);
    }

    // ─────────────────────────────────────────────────────────────────
    // GET /api/nurseries/{id}
    // Public – single nursery details.
    // ─────────────────────────────────────────────────────────────────
    public function show(int $id)
    {
        $nursery = Nursery::with('owner:id,name')->findOrFail($id);

        return response()->json([
            'success' => true,
            'nursery' => $nursery,
        ]);
    }
}
