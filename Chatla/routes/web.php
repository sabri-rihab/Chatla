<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-api', function () {
    $plants = \App\Models\Plant::with('family')->orderBy('name')->get();
    return view('test-api', compact('plants'));
});

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::post('/contact', [\App\Http\Controllers\ContactController::class, 'store'])->name('contact.store');

Route::middleware(['auth', 'verified'])->get('/dashboard', function (\Illuminate\Http\Request $request) {
    $user = $request->user();

    if ($user->role === 'simple') {
        return view('welcome');
    }

    // Nursery Owner Logic
    $nursery = $user->nursery;
    if (!$nursery) {
        abort(403, 'No nursery found for this account.');
    }

    $totalPlants = $nursery->inventory()->count();
    $outOfStock = $nursery->inventory()->where('stock_quantity', '<=', 0)->count();
    $inventories = $nursery->inventory()->with(['plant', 'plant.family'])->paginate(8);

    return view('nursery.dashboard', compact('totalPlants', 'outOfStock', 'inventories'));
})->name('dashboard');

Route::middleware(['auth', 'verified', 'nursery_owner'])->group(function () {
    Route::get('/nursery/profile', [\App\Http\Controllers\NurseryProfileController::class, 'edit'])->name('nursery.profile.edit');
    Route::put('/nursery/profile', [\App\Http\Controllers\NurseryProfileController::class, 'update'])->name('nursery.profile.update');

    Route::get('/nursery/plants', [\App\Http\Controllers\NurseryInventoryController::class, 'index'])->name('nursery.inventory.index');
    Route::get('/nursery/plants/create', function () {
        $families = \App\Models\PlantFamily::orderBy('name')->get(['id', 'name']);
        $plants = \App\Models\Plant::with('family:id,name')->orderBy('name')->get(['id', 'name', 'family_id']);
        return view('nursery.inventory.create', compact('families', 'plants'));
    })->name('nursery.inventory.create');
    Route::post('/nursery/plants', [\App\Http\Controllers\NurseryInventoryController::class, 'store'])->name('nursery.inventory.store');
    Route::put('/nursery/plants/{inventory}', [\App\Http\Controllers\NurseryInventoryController::class, 'update'])->name('nursery.inventory.update'); 
    Route::delete('/nursery/plants/{inventory}', [\App\Http\Controllers\NurseryInventoryController::class, 'destroy'])->name('nursery.inventory.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
