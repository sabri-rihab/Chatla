<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Nursery;
use App\Models\Report;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', '!=', User::ROLE_ADMIN)
            ->with(['nursery.city']);

        // Dynamic Filters Data
        $availableRoles = User::where('role', '!=', User::ROLE_ADMIN)->distinct()->pluck('role');
        $availableStatuses = User::distinct()->pluck('status');

        // Basic Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhereHas('nursery', function($nq) use ($search) {
                      $nq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filters
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $users = $query->latest()->paginate(10)->withQueryString();

        return view('admin.dashboard', compact('users', 'availableRoles', 'availableStatuses'));
    }

    public function updateStatus(Request $request, User $user)
    {
        $request->validate([
            'status' => 'required|in:active,inactive,pending',
        ]);

        $user->update(['status' => $request->status]);

        // If it's a nursery owner, also update the nursery status to match
        if ($user->isNurseryOwner() && $user->nursery) {
            $user->nursery->update(['status' => $request->status]);
        }

        return back()->with('success', 'User status updated successfully.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role' => User::ROLE_ADMIN,
            'status' => 'active',
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Admin account created successfully.');
    }

    public function requests(Request $request)
    {
        $query = Report::query();

        $availableTypes = Report::getRequestTypes();
        $availableStatuses = ['pending', 'processing', 'resolved'];

        if ($request->filled('type')) {
            $query->where('request_type', $request->type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $reports = $query->latest()->paginate(10)->withQueryString();

        return view('admin.requests', compact('reports', 'availableTypes', 'availableStatuses'));
    }

    public function updateRequestStatus(Request $request, Report $report)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,resolved',
        ]);

        $report->update(['status' => $request->status]);

        return back()->with('success', 'Request status updated successfully.');
    }
}
