<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        $user = auth()->user();
        $stats = $user->stats;

        return view('profile.show', compact('user', 'stats'));
    }

    public function edit()
    {
        $user = auth()->user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update($request->only(['name', 'email']));

        return redirect()->route('profile.show')
            ->with('success', 'Profile berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        auth()->user()->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'Password berhasil diperbarui.');
    }

    public function updatePreferences(Request $request)
    {
        $request->validate([
            'preferences' => 'required|array|min:1',
            'preferences.*' => 'exists:categories,id'
        ]);

        auth()->user()->update([
            'preferences' => $request->preferences
        ]);

        return back()->with('success', 'Preferensi berhasil diperbarui.');
    }
}
