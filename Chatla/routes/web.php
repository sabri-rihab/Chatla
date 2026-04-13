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

Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->role === 'nursery_owner') {
        $nursery = $user->nursery;
        $totalPlants = $nursery ? $nursery->inventory()->count() : 0;
        $outOfStock = $nursery ? $nursery->inventory()->where('stock_quantity', '<=', 0)->count() : 0;
        
        $inventories = $nursery 
            ? $nursery->inventory()->with(['plant', 'plant.family'])->paginate(10)
            : new \Illuminate\Pagination\LengthAwarePaginator([], 0, 10);
            
        return view('nursery.dashboard', compact('totalPlants', 'outOfStock', 'inventories'));
    }
    
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
