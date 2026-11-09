<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(): View
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $addresses = $user->addresses()->latest()->get();
        return view('profile.edit', compact('user', 'addresses'));
    }

    public function update(Request $request): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => 'nullable|string|max:20',
        ]);

        $user->update($validated);

        return back()->with('success', 'Profil mis à jour.');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (! Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
        }

        $user->update(['password' => Hash::make($validated['password'])]);

        return back()->with('success', 'Mot de passe mis à jour.');
    }

    public function storeAddress(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:50',
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:30',
            'city' => 'required|string|max:100',
            'neighborhood' => 'nullable|string|max:100',
            'street_address' => 'required|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'additional_info' => 'nullable|string|max:500',
            'is_default' => 'boolean',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($request->has('is_default') && $request->is_default) {
            $user->addresses()->update(['is_default' => false]);
        }

        $user->addresses()->create($validated);

        return back()->with('success', 'Adresse ajoutée.');
    }

    public function updateAddress(Request $request, Address $address): RedirectResponse
    {
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:50',
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:30',
            'city' => 'required|string|max:100',
            'neighborhood' => 'nullable|string|max:100',
            'street_address' => 'required|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'additional_info' => 'nullable|string|max:500',
            'is_default' => 'boolean',
        ]);

        /** @var \App\Models\User $user */
        $user = $address->user;

        if ($request->has('is_default') && $request->is_default) {
            $user->addresses()->where('id', '!=', $address->id)->update(['is_default' => false]);
        }

        $address->update($validated);

        return back()->with('success', 'Adresse mise à jour.');
    }

    public function destroyAddress(Address $address): RedirectResponse
    {
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        $address->delete();

        return back()->with('success', 'Adresse supprimée.');
    }
}
