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

Route::get('/dashboard', function (\Illuminate\Http\Request $request) {
    // The NurseryOwnerMiddleware guarantees the role is nursery_owner
    // and attaches the user's nursery to the request attributes.
    $nursery = $request->attributes->get('nursery');

    $totalPlants = $nursery->inventory()->count();
    $outOfStock = $nursery->inventory()->where('stock_quantity', '<=', 0)->count();
    
    $inventories = $nursery->inventory()->with(['plant', 'plant.family'])->paginate(10);
        
    return view('nursery.dashboard', compact('totalPlants', 'outOfStock', 'inventories'));
})->middleware(['auth', 'verified', 'nursery_owner'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
