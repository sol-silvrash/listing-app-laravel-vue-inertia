<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::with('listings')
            ->filter(request(['search', 'user_role']))
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Admin/Dashboard', [
            'users' => $users,
            'status' => session('status'),
        ]);
    }

    public function show(User $user)
    {
        $listings = $user
            ->listings()
            ->filter(request(['search', 'disapproved']))
            ->latest()
            ->paginate(6)
            ->withQueryString();

        return Inertia::render('Admin/User', [
            'user' => $user,
            'listings' => $listings,
            'status' => session('status'),
        ]);
    }

    public function role(Request $request, User $user)
    {
        Gate::authorize('modifyRole', $user);

        $request->validate([
            'role' => [
                'string',
                'required',
            ],
        ]);

        $user->update([
            'role' => $request->role,
        ]);

        return redirect()->route('admin.index')->with('status', "User role changed to {$request->role} successfully!");
    }

    public function approve(Listing $listing)
    {
        Gate::authorize('approve', $listing);

        $listing->update([
            'approved' => !$listing->approved,
        ]);

        $msg = $listing->approved ? 'approved' : 'disapproved';
        return back()->with('status', "Listing {$msg} successfully!");
    }
}
