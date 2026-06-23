<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show(): View|RedirectResponse
    {
        $user = Auth::user();

        if (! $user instanceof User) {
            return redirect()->route('register');
        }

        return view('pages.my_profile', [
            'userProfile' => $user,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();

        if (! $user instanceof User) {
            return redirect()->route('register');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:2000'],
            'city' => ['nullable', 'string', 'max:255'],
            'help_type' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:3000'],
            'aadhaar_number' => [
                Rule::requiredIf($user->role === 'provider'),
                'nullable',
                'digits:12',
                Rule::unique('users', 'aadhaar_number')->ignore($user->id),
            ],
            'mobile_token' => ['nullable', 'string', 'max:4096'],
        ]);

        if (blank($validated['email'] ?? null) && str_ends_with($user->email ?? '', '@homeease.local')) {
            $validated['email'] = $user->email;
        }

        $user->fill([
            'name' => $validated['name'],
            'email' => $validated['email'] ?? $user->email,
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
            'city' => $validated['city'] ?? null,
            'help_type' => $user->role === 'user' ? ($validated['help_type'] ?? null) : $user->help_type,
            'notes' => $validated['notes'] ?? null,
            'aadhaar_number' => $user->role === 'provider' ? ($validated['aadhaar_number'] ?? null) : null,
        ]);

        if (array_key_exists('mobile_token', $validated)) {
            $user->mobile_token = $validated['mobile_token'] ?: null;
            $user->mobile_token_updated_at = filled($validated['mobile_token'] ?? null) ? now() : null;
        }

        $user->save();

        return redirect()
            ->route('my.profile')
            ->with('status', 'Your profile was updated successfully.');
    }
}
