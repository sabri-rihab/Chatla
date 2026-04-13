<?php

use App\Http\Controllers\Api\NurseryController;
use App\Http\Controllers\Api\PlantController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Chatla🌱 API Routes
|--------------------------------------------------------------------------
|
| All routes are prefixed with /api (configured in bootstrap/app.php).
|
| Middleware:
|   auth          → Laravel's built-in session/sanctum auth guard
|   nursery_owner → Custom: checks role + nursery, attaches $request->nursery
|
*/

// ══════════════════════════════════════════════════════════════════════
//  NURSERY – Public routes
// ══════════════════════════════════════════════════════════════════════

Route::prefix('nurseries')->group(function () {

    // GET /api/nurseries/search?region=&city=&name=
    Route::get('/search', [NurseryController::class, 'search'])
        ->name('nurseries.search');

    // GET /api/nurseries/{id}
    Route::get('/{id}', [NurseryController::class, 'show'])
        ->name('nurseries.show')
        ->whereNumber('id');

    // GET /api/nurseries/{id}/plants?per_page=15
    Route::get('/{id}/plants', [NurseryController::class, 'plants'])
        ->name('nurseries.plants')
        ->whereNumber('id');
});

// ══════════════════════════════════════════════════════════════════════
//  PLANTS – Public search routes
//  NOTE: specific named paths (search, search/advanced, search/location)
//        MUST come BEFORE /{id} to avoid route shadowing.
// ══════════════════════════════════════════════════════════════════════

Route::prefix('plants')->group(function () {

    // GET /api/plants/search?name=&family=
    Route::get('/search', [PlantController::class, 'search'])
        ->name('plants.search');

    // GET /api/plants/search/advanced?name=&growth=
    Route::get('/search/advanced', [PlantController::class, 'searchAdvanced'])
        ->name('plants.search.advanced');

    // GET /api/plants/search/location?region=&city=
    Route::get('/search/location', [PlantController::class, 'searchByLocation'])
        ->name('plants.search.location');

    // GET /api/plants/{id}  – single plant
    Route::get('/{id}', [PlantController::class, 'show'])
        ->name('plants.show')
        ->whereNumber('id');
});

// ══════════════════════════════════════════════════════════════════════
//  PLANTS – Protected routes (nursery_owner only)
// ══════════════════════════════════════════════════════════════════════

Route::middleware(['auth', 'nursery_owner'])->group(function () {

    // POST /api/plants  – add plant to logged-in nursery's inventory
    Route::post('/plants', [PlantController::class, 'store'])
        ->name('plants.store');

    // DELETE /api/plants/{id}?confirm=1  – delete from owner's inventory
    Route::delete('/plants/{id}', [PlantController::class, 'destroy'])
        ->name('plants.destroy')
        ->whereNumber('id');
});
