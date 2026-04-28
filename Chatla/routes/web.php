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

Route::get('/explore', [\App\Http\Controllers\ExploreController::class, 'index'])->name('explore');
Route::get('/nurseries', [\App\Http\Controllers\NurseriesController::class, 'index'])->name('nurseries.index');
Route::get('/nurseries/{nursery}', [\App\Http\Controllers\PublicNurseryController::class, 'show'])->name('public.nurseries.show');
Route::get('/plants/{inventory}', [\App\Http\Controllers\PublicPlantController::class, 'show'])->name('public.plants.show');
Route::post('/nurseries/{nursery}/rate', [\App\Http\Controllers\PublicNurseryController::class, 'rate'])
    ->name('public.nurseries.rate')
    ->middleware('auth');

Route::post('/contact', [\App\Http\Controllers\ContactController::class, 'store'])->name('contact.store');

Route::middleware(['auth', 'verified'])->get('/dashboard', function (\Illuminate\Http\Request $request) {
    $user = $request->user();

    if ($user->role === \App\Models\User::ROLE_SIMPLE) {
        return view('welcome');
    }

    if ($user->role === \App\Models\User::ROLE_ADMIN) {
        return redirect()->route('admin.dashboard');
    }

    // Nursery Owner Logic
    $nursery = $user->nursery;
    $status = $user->status;

    if (!$nursery) {
        abort(403, 'No nursery found for this account.');
    }

    $totalPlants = $nursery->inventory()->count();
    $outOfStock = $nursery->inventory()->where('stock_quantity', '<=', 0)->count();
    $lowStock = $nursery->inventory()->where('stock_quantity', '>', 0)->where('stock_quantity', '<=', 10)->count();
    
    $familyCount = $nursery->inventory()
        ->join('plants', 'nursery_inventories.plant_id', '=', 'plants.id')
        ->distinct('plants.family_id')
        ->count('plants.family_id');

    $inventories = $nursery->inventory()->with(['plant', 'plant.family'])->paginate(8);

    return view('nursery.dashboard', compact('totalPlants', 'outOfStock', 'lowStock', 'familyCount', 'inventories', 'status'));
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

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [\App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::post('/admin/dashboard', [\App\Http\Controllers\Admin\AdminDashboardController::class, 'store'])->name('admin.store');
    Route::patch('/admin/users/{user}/status', [\App\Http\Controllers\Admin\AdminDashboardController::class, 'updateStatus'])->name('admin.users.status.update');
    
    Route::get('/admin/requests', [\App\Http\Controllers\Admin\AdminDashboardController::class, 'requests'])->name('admin.requests');
    Route::patch('/admin/requests/{report}/status', [\App\Http\Controllers\Admin\AdminDashboardController::class, 'updateRequestStatus'])->name('admin.requests.status.update');
});

require __DIR__.'/auth.php';
