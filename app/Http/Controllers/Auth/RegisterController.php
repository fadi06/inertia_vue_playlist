<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterFormRequest;

class RegisterController extends Controller
{
    public function create()
    {
        return Inertia::render("Auth/Register");
    }

    public function store(RegisterFormRequest $request)
    {
        $user = User::create($request->validated());

        Auth::login($user);

        return redirect()->route('register')->with('success', 'Registered successfully');
    }
}
