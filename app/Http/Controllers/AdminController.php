<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;

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

    public function role(Request $request, User $user)
    {
        $request->validate(['role' => 'string|required']);

        $user->role = $request->role;
        $user->save();

        return redirect()->route("admin.index")
            ->with("success","User role changed to {$request->role} successfully.");
    }
}
