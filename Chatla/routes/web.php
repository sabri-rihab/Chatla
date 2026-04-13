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

Route::middleware(['auth', 'verified', 'nursery_owner'])->group(function () {
    Route::get('/dashboard', function (\Illuminate\Http\Request $request) {
        $nursery = $request->attributes->get('nursery');

        $totalPlants = $nursery->inventory()->count();
        $outOfStock = $nursery->inventory()->where('stock_quantity', '<=', 0)->count();
        
        $inventories = $nursery->inventory()->with(['plant', 'plant.family'])->paginate(8);
            
        return view('nursery.dashboard', compact('totalPlants', 'outOfStock', 'inventories'));
    })->name('dashboard');

    Route::get('/nursery/profile', [\App\Http\Controllers\NurseryProfileController::class, 'edit'])->name('nursery.profile.edit');
    Route::put('/nursery/profile', [\App\Http\Controllers\NurseryProfileController::class, 'update'])->name('nursery.profile.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
