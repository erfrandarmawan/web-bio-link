<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'string', 'email', 'max:50', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'website_name' => ['required', 'string', 'max:50'],
            'username' => ['required', 'string', 'max:50', 'unique:users,username', 'alpha_dash'],
        ]);

        $user = User::create([
            'id' => (string) Str::uuid(),
            'email' => $validated['email'],
            'password' => $validated['password'],
            'website_name' => $validated['website_name'],
            'username' => $validated['username'],
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard'));
    }
}
