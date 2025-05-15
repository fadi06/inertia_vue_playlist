<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $users = User::with('listings')->filter(request(['search', 'user_role']))->paginate(10);
        return Inertia::render("Admin/Dashboard", [
            "users"=> $users,
            'status' => session('status')
        ]);
    }

    public function show(User $user)
    {
        $user_listings = $user->listings()->filters(request(['search', 'disapproved']))->latest()->paginate(10)->withQueryString();
        return Inertia::render('Admin/UserPage', [
            'user'=> $user,
            'userListings' => $user_listings,
            'status' => session('status')
        ]);
    }

    public function role(Request $request, User $user)
    {
        Gate::authorize('modifyRole', $user);
        $request->validate(['role' => 'string|required']);

        $user->role = $request->role;
        $user->save();

        return redirect()->route("admin.index")
            ->with("success","User role changed to {$request->role} successfully.");
    }

    public function approve(Listing $listing)
    {

        Gate::authorize("approve", $listing);

        $listing->update(['approved' => !$listing->approved]);

        $msg = $listing->approved ? 'approved' : 'disapproved';

        return redirect()->back()->with('status', "Listing {$msg} successfully");
    }
}
