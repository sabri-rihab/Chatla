<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NurseryInventory;
use App\Models\Plant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

/**
 * PlantController
 *
 * Public endpoints:
 *   GET  /api/plants/search                     — search by name and/or family
 *   GET  /api/plants/search/advanced            — search by name and/or growth
 *   GET  /api/plants/search/location            — search by nursery region/city
 *   GET  /api/plants/{id}                       — single plant detail
 *
 * Protected (nursery_owner only):
 *   POST   /api/plants                          — add plant to owner's nursery
 *   DELETE /api/plants/{id}                     — delete plant from owner's nursery
 */
class PlantController extends Controller
{
    // ═════════════════════════════════════════════════════════════════
    //  PUBLIC ENDPOINTS
    // ═════════════════════════════════════════════════════════════════

    // ─────────────────────────────────────────────────────────────────
    // GET /api/plants/search?name=&family=
    // Partial, case-insensitive search by name and/or family.
    // ─────────────────────────────────────────────────────────────────
    public function search(Request $request)
    {
        $name   = $request->query('name');
        $family = $request->query('family');

        $query = Plant::with('family:id,name,slug')
            ->with(['inventories.nursery:id,name,city,region']); // for nursery context

        if ($name) {
            $query->where('name', 'LIKE', "%{$name}%");
        }

        if ($family) {
            $query->whereHas('family', fn ($q) =>
                $q->where('name', 'LIKE', "%{$family}%")
            );
        }

        if (! $name && ! $family) {
            return response()->json([
                'success' => false,
                'message' => 'Please provide at least a name or family filter.',
            ], 422);
        }

        $plants = $query->orderBy('name')->paginate(20);

        return response()->json([
            'success' => true,
            'filters' => compact('name', 'family'),
            'plants'  => $plants->map(fn ($p) => $this->formatPlant($p)),
            'pagination' => [
                'current_page' => $plants->currentPage(),
                'per_page'     => $plants->perPage(),
                'total'        => $plants->total(),
                'last_page'    => $plants->lastPage(),
            ],
        ]);
    }

    // ─────────────────────────────────────────────────────────────────
    // GET /api/plants/search/advanced?name=&growth=
    // Combine name + growth_status filter (on nursery_inventories).
    // ─────────────────────────────────────────────────────────────────
    public function searchAdvanced(Request $request)
    {
        $name   = $request->query('name');
        $growth = $request->query('growth');   // seed | seedling | vegetative | mature

        $validGrowth = ['seed', 'seedling', 'vegetative', 'mature'];

        if ($growth && ! in_array($growth, $validGrowth)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid growth value. Allowed: ' . implode(', ', $validGrowth),
            ], 422);
        }

        $query = Plant::with('family:id,name,slug')
            ->with(['defaultImages' => fn ($q) => $q->where('is_primary', true)])
            ->with(['inventories' => fn ($q) => $growth
                ? $q->where('growth_status', $growth)->with('nursery:id,name,city,region')
                : $q->with('nursery:id,name,city,region')
            ]);

        if ($name) {
            $query->where('name', 'LIKE', "%{$name}%");
        }

        if ($growth) {
            // Only return plants that actually have at least one inventory entry
            // with the requested growth_status
            $query->whereHas('inventories', fn ($q) =>
                $q->where('growth_status', $growth)
            );
        }

        if (! $name && ! $growth) {
            return response()->json([
                'success' => false,
                'message' => 'Please provide at least one search parameter.',
            ], 422);
        }

        $plants = $query->orderBy('name')->paginate(20);

        return response()->json([
            'success' => true,
            'filters' => compact('name', 'growth'),
            'plants'  => $plants->map(fn ($p) => $this->formatPlant($p)),
            'pagination' => [
                'current_page' => $plants->currentPage(),
                'per_page'     => $plants->perPage(),
                'total'        => $plants->total(),
                'last_page'    => $plants->lastPage(),
            ],
        ]);
    }

    // ─────────────────────────────────────────────────────────────────
    // GET /api/plants/search/location?region=&city=
    // Find plants available in nurseries of a given region/city.
    // Returns: plant info + nursery name + nursery region/city.
    // ─────────────────────────────────────────────────────────────────
    public function searchByLocation(Request $request)
    {
        $region = $request->query('region');
        $city   = $request->query('city');

        if (! $region && ! $city) {
            return response()->json([
                'success' => false,
                'message' => 'Please provide a region or city filter.',
            ], 422);
        }

        // Join through nursery_inventories → nurseries
        $query = Plant::with('family:id,name')
            ->with(['defaultImages' => fn ($q) => $q->where('is_primary', true)])
            ->whereHas('inventories.nursery', function ($q) use ($region, $city) {
                if ($region) {
                    $q->where('region', 'LIKE', "%{$region}%");
                }
                if ($city) {
                    $q->where('city', 'LIKE', "%{$city}%");
                }
            })
            ->with(['inventories' => function ($q) use ($region, $city) {
                $q->with(['nursery' => function ($nq) use ($region, $city) {
                    $nq->select('id', 'name', 'city', 'region', 'phone', 'email');
                    if ($region) $nq->where('region', 'LIKE', "%{$region}%");
                    if ($city)   $nq->where('city',   'LIKE', "%{$city}%");
                }]);
            }]);

        $plants = $query->orderBy('name')->paginate(20);

        $result = $plants->map(fn ($plant) => [
            'id'     => $plant->id,
            'name'   => $plant->name,
            'slug'   => $plant->slug,
            'family' => $plant->family?->name,
            'image'  => $plant->defaultImages->first()?->image_path,
            'available_in' => $plant->inventories
                ->filter(fn ($inv) => $inv->nursery !== null)
                ->map(fn ($inv) => [
                    'inventory_id'  => $inv->id,
                    'nursery_id'    => $inv->nursery->id,
                    'nursery_name'  => $inv->nursery->name,
                    'nursery_city'  => $inv->nursery->city,
                    'nursery_region'=> $inv->nursery->region,
                    'nursery_phone' => $inv->nursery->phone,
                    'stock_status'  => $inv->stock_status,
                    'growth_status' => $inv->growth_status,
                    'quantity'      => $inv->quantity,
                    'price'         => $inv->price,
                ])->values(),
        ]);

        return response()->json([
            'success' => true,
            'filters' => compact('region', 'city'),
            'plants'  => $result,
            'pagination' => [
                'current_page' => $plants->currentPage(),
                'per_page'     => $plants->perPage(),
                'total'        => $plants->total(),
                'last_page'    => $plants->lastPage(),
            ],
        ]);
    }

    // ─────────────────────────────────────────────────────────────────
    // GET /api/plants/{id}
    // Public – full detail of a single plant.
    // ─────────────────────────────────────────────────────────────────
    public function show(int $id)
    {
        $plant = Plant::with([
            'family:id,name,slug',
            'defaultImages',
            'inventories.nursery:id,name,city,region,phone,email',
            'inventories.images',
        ])->findOrFail($id);

        return response()->json([
            'success' => true,
            'plant'   => $this->formatPlant($plant),
        ]);
    }

    // ═════════════════════════════════════════════════════════════════
    //  PROTECTED ENDPOINTS  (nursery_owner middleware applied in routes)
    // ═════════════════════════════════════════════════════════════════

    // ─────────────────────────────────────────────────────────────────
    // POST /api/plants
    // Add a plant (or inventory entry) to logged-in owner's nursery.
    //
    // Body:
    //   plant_id*        – existing plant species ID
    //   growth_status*   – seed | seedling | vegetative | mature
    //   stock_status     – in_stock (default) | low_stock | pre_ordered
    //   quantity*        – integer >= 0
    //   price            – decimal (MAD), optional
    //   custom_desc      – nursery-specific description, optional
    //   images[]         – up to 5 image files (jpg/png/webp, max 5MB each)
    // ─────────────────────────────────────────────────────────────────
    public function store(Request $request)
    {
        // ── Retrieve nursery attached by middleware ────────────────────
        $nursery = $request->attributes->get('nursery');

        // ── Validate ──────────────────────────────────────────────────
        try {
            $validated = $request->validate([
                'plant_id'       => 'required|integer|exists:plants,id',
                'growth_status'  => 'required|in:seed,seedling,vegetative,mature',
                'stock_status'   => 'sometimes|in:in_stock,low_stock,pre_ordered',
                'quantity'       => 'required|integer|min:0',
                'price'          => 'nullable|numeric|min:0',
                'custom_desc'    => 'nullable|string|max:2000',
                'images'         => 'nullable|array|max:5',
                'images.*'       => 'file|mimes:jpg,jpeg,png,webp|max:5120', // 5MB
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors'  => $e->errors(),
            ], 422);
        }

        // ── Prevent duplicate inventory entries ───────────────────────
        $exists = NurseryInventory::where('nursery_id', $nursery->id)
            ->where('plant_id', $validated['plant_id'])
            ->where('growth_status', $validated['growth_status'])
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'This plant with the same growth status already exists in your nursery inventory.',
            ], 409);
        }

        DB::beginTransaction();
        try {
            // ── Create inventory entry ─────────────────────────────────
            $inventory = NurseryInventory::create([
                'nursery_id'         => $nursery->id,
                'plant_id'           => $validated['plant_id'],
                'growth_status'      => $validated['growth_status'],
                'stock_status'       => $validated['stock_status'] ?? 'in_stock',
                'quantity'           => $validated['quantity'],
                'price'              => $validated['price'] ?? null,
                'custom_description' => $validated['custom_desc'] ?? null,
            ]);

            // ── Handle image uploads ───────────────────────────────────
            $uploadedPaths = [];
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $file) {
                    // Store in storage/app/public/inventory/{nursery_id}/
                    $path = $file->store("inventory/{$nursery->id}", 'public');
                    $uploadedPaths[] = $path;

                    $inventory->images()->create(['image_path' => $path]);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Plant added to your nursery inventory successfully.',
                'inventory' => $inventory->load('plant.family', 'images'),
            ], 201);

        } catch (\Throwable $e) {
            DB::rollBack();
            // Clean up any uploaded files on failure
            foreach ($uploadedPaths as $path) {
                Storage::disk('public')->delete($path);
            }

            return response()->json([
                'success' => false,
                'message' => 'Failed to add plant. Please try again.',
                'error'   => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    // ─────────────────────────────────────────────────────────────────
    // DELETE /api/plants/{id}
    // Delete an inventory entry from the logged-in owner's nursery.
    // {id} is the nursery_inventory.id, not plant.id.
    //
    // Optional query param: ?confirm=1 (safety gate)
    // ─────────────────────────────────────────────────────────────────
    public function destroy(Request $request, int $id)
    {
        $nursery = $request->attributes->get('nursery');

        // ── Optional confirmation flag ─────────────────────────────────
        if (! $request->query('confirm')) {
            return response()->json([
                'success' => false,
                'message' => 'Add ?confirm=1 to the request URL to confirm deletion.',
            ], 400);
        }

        // ── Find the inventory entry ───────────────────────────────────
        $inventory = NurseryInventory::with('images')->find($id);

        if (! $inventory) {
            return response()->json([
                'success' => false,
                'message' => 'Inventory entry not found.',
            ], 404);
        }

        // ── Ownership check ────────────────────────────────────────────
        // CRITICAL: ensure the inventory belongs to THIS nursery owner.
        if ($inventory->nursery_id !== $nursery->id) {
            return response()->json([
                'success' => false,
                'message' => 'Forbidden. You do not own this inventory entry.',
            ], 403);
        }

        DB::beginTransaction();
        try {
            // Delete associated images from storage
            foreach ($inventory->images as $image) {
                Storage::disk('public')->delete($image->image_path);
            }

            // Cascade delete handled by DB, but we clean storage manually first
            $inventory->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Plant inventory entry deleted successfully.',
            ]);

        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete the entry. Please try again.',
                'error'   => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    // ═════════════════════════════════════════════════════════════════
    //  PRIVATE HELPERS
    // ═════════════════════════════════════════════════════════════════

    /**
     * Format a plant model into a consistent API response shape.
     */
    private function formatPlant(Plant $plant): array
    {
        return [
            'id'          => $plant->id,
            'name'        => $plant->name,
            'slug'        => $plant->slug,
            'family'      => $plant->family ? [
                'id'   => $plant->family->id,
                'name' => $plant->family->name,
                'slug' => $plant->family->slug,
            ] : null,
            'description'           => $plant->about_description,
            'light_need'            => $plant->light_need,
            'watering'              => $plant->watering,
            'temperature'           => $plant->temperature,
            'pet_friendly'          => $plant->pet_friendly,
            'sun_exposure'          => $plant->sun_exposure,
            'leaf_care'             => $plant->leaf_care,
            'support_instructions'  => $plant->support_instructions,
            'images' => $plant->defaultImages?->map(fn ($img) => [
                'path'       => $img->image_path,
                'is_primary' => $img->is_primary,
            ]),
            'nurseries' => $plant->inventories?->map(fn ($inv) => [
                'nursery_id'    => $inv->nursery?->id,
                'nursery_name'  => $inv->nursery?->name,
                'nursery_city'  => $inv->nursery?->city,
                'nursery_region'=> $inv->nursery?->region,
                'stock_status'  => $inv->stock_status,
                'growth_status' => $inv->growth_status,
                'quantity'      => $inv->quantity,
                'price'         => $inv->price,
            ])->filter(fn ($n) => $n['nursery_id'] !== null)->values(),
        ];
    }
}
