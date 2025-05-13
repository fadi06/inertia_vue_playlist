<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Inertia\Inertia;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
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

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('register')->with('success', 'Registered successfully');
    }
}
