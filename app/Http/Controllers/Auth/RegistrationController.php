<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class RegistrationController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'role' => ['required', Rule::in(['user', 'provider'])],
            'mobile_token' => ['nullable', 'string', 'max:4096'],
            'profile_image_data' => ['required', 'string'],
            'user_password' => ['nullable', 'string', 'min:8', 'max:255'],
            'user_password_confirmation' => ['nullable', 'same:user_password'],
            'provider_password' => ['nullable', 'string', 'min:8', 'max:255'],
            'provider_password_confirmation' => ['nullable', 'same:provider_password'],

            'user_name' => ['nullable', 'string', 'max:255'],
            'user_phone' => ['nullable', 'string', 'max:20'],
            'user_email' => ['nullable', 'email', 'max:255', Rule::unique('users', 'email')],
            'user_address' => ['nullable', 'string', 'max:1000'],
            'user_help_type' => ['nullable', 'string', 'max:255'],
            'user_note' => ['nullable', 'string', 'max:2000'],

            'provider_name' => ['nullable', 'string', 'max:255'],
            'provider_phone' => ['nullable', 'string', 'max:20'],
            'provider_email' => ['nullable', 'email', 'max:255', Rule::unique('users', 'email')],
            'provider_aadhaar' => ['nullable', 'digits:12', Rule::unique('users', 'aadhaar_number')],
            'provider_city' => ['nullable', 'string', 'max:255'],
            'provider_address' => ['nullable', 'string', 'max:2000'],

            'provider_offerings' => ['nullable', 'array'],
            'provider_offerings.*.service_type' => ['required_if:role,provider', 'string', 'max:100'],
            'provider_offerings.*.service_subtype' => ['required_if:role,provider', 'string', 'max:150'],
            'provider_offerings.*.offering_name' => ['required_if:role,provider', 'string', 'max:255'],
            'provider_offerings.*.details' => ['required_if:role,provider', 'string', 'max:500'],
            'provider_offerings.*.service_mode' => ['required_if:role,provider', 'string', 'max:255'],
            'provider_offerings.*.pricing_model' => ['required_if:role,provider', 'string', 'max:100'],
            'provider_offerings.*.price_amount' => ['nullable', 'numeric', 'min:0'],
            'provider_offerings.*.experience_years' => ['nullable', 'integer', 'min:0', 'max:60'],
            'provider_offerings.*.timing' => ['required_if:role,provider', 'string', 'max:255'],
            'provider_offerings.*.price' => ['required_if:role,provider', 'string', 'max:255'],
            'provider_offerings.*.notes' => ['nullable', 'string', 'max:2000'],
            'provider_offerings.*.service_attributes' => ['nullable', 'array'],
        ]);

        $validator->after(function ($validator) use ($request): void {
            if ($request->input('role') === 'provider') {
                if (blank($request->input('provider_name'))) {
                    $validator->errors()->add('provider_name', 'Provider name is required.');
                }

                if (blank($request->input('provider_phone'))) {
                    $validator->errors()->add('provider_phone', 'Provider phone is required.');
                }

                if (blank($request->input('provider_aadhaar'))) {
                    $validator->errors()->add('provider_aadhaar', 'Aadhaar number is required.');
                }

                if (blank($request->input('provider_city'))) {
                    $validator->errors()->add('provider_city', 'City or area is required.');
                }

                if (blank($request->input('provider_address'))) {
                    $validator->errors()->add('provider_address', 'Provider address is required.');
                }

                if (count($request->input('provider_offerings', [])) === 0) {
                    $validator->errors()->add('provider_offerings', 'Add at least one service offering.');
                }

            } else {
                if (blank($request->input('user_phone'))) {
                    $validator->errors()->add('user_phone', 'Phone number is required.');
                }
            }

            if ($request->input('role') === 'provider') {
                if (blank($request->input('provider_password'))) {
                    $validator->errors()->add('provider_password', 'Password is required.');
                }
            } else {
                if (blank($request->input('user_password'))) {
                    $validator->errors()->add('user_password', 'Password is required.');
                }
            }
        });

        $validated = $validator->validate();

        $profileImagePath = $this->storeProfileImage($validated['profile_image_data']);

        $user = DB::transaction(function () use ($validated, $profileImagePath): User {
            $role = $validated['role'];

            $user = User::create([
                'name' => $role === 'provider'
                    ? $validated['provider_name']
                    : ($validated['user_name'] ?: 'HomeEase User'),
                'email' => $this->resolveEmail($validated),
                'password' => $role === 'provider'
                    ? $validated['provider_password']
                    : $validated['user_password'],
                'role' => $role,
                'phone' => $role === 'provider'
                    ? ($validated['provider_phone'] ?? null)
                    : ($validated['user_phone'] ?? null),
                'address' => $role === 'provider'
                    ? ($validated['provider_address'] ?? null)
                    : ($validated['user_address'] ?? null),
                'city' => $role === 'provider' ? ($validated['provider_city'] ?? null) : null,
                'aadhaar_number' => $role === 'provider' ? ($validated['provider_aadhaar'] ?? null) : null,
                'help_type' => $role === 'user' ? ($validated['user_help_type'] ?? null) : null,
                'notes' => $role === 'provider'
                    ? $this->buildProviderNotes($validated)
                    : ($validated['user_note'] ?? null),
                'mobile_token' => $validated['mobile_token'] ?? null,
                'mobile_token_updated_at' => filled($validated['mobile_token'] ?? null) ? now() : null,
                'profile_image_path' => $profileImagePath,
            ]);

            if ($role === 'provider') {
                $user->providerOfferings()->createMany(
                    collect($validated['provider_offerings'] ?? [])
                        ->map(fn (array $offering): array => [
                            'service_type' => $offering['service_type'],
                            'service_subtype' => $offering['service_subtype'],
                            'offering_name' => $offering['offering_name'],
                            'details' => $offering['details'],
                            'service_mode' => $offering['service_mode'],
                            'pricing_model' => $offering['pricing_model'],
                            'price_amount' => $offering['price_amount'],
                            'experience_years' => $offering['experience_years'] ?? null,
                            'timing' => $offering['timing'],
                            'price' => $offering['price'],
                            'notes' => $offering['notes'] ?? null,
                            'service_attributes' => $offering['service_attributes'] ?? null,
                        ])
                        ->all()
                );
            }

            return $user;
        });

        Auth::login($user);
        $request->session()->regenerate();

        return response()->json([
            'message' => $user->role === 'provider'
                ? 'Provider profile created successfully.'
                : 'Customer profile created successfully.',
            'redirect' => route('dashboard'),
            'user' => [
                'id' => $user->id,
                'role' => $user->role,
                'mobile_token_saved' => filled($user->mobile_token),
                'profile_image_saved' => filled($user->profile_image_path),
            ],
        ], 201);
    }

    private function storeProfileImage(string $imageData): string
    {
        if (! preg_match('/^data:image\/(?P<type>png|jpe?g|webp);base64,(?P<data>.+)$/i', $imageData, $matches)) {
            throw ValidationException::withMessages([
                'profile_image_data' => ['Upload a valid selfie or profile photo.'],
            ]);
        }

        $decoded = base64_decode($matches['data'], true);

        if ($decoded === false) {
            throw ValidationException::withMessages([
                'profile_image_data' => ['Upload a valid selfie or profile photo.'],
            ]);
        }

        $extension = strtolower($matches['type']) === 'jpeg' ? 'jpg' : strtolower($matches['type']);
        $path = 'profile-images/'.Str::uuid().'.'.$extension;

        Storage::disk('public')->put($path, $decoded);

        return $path;
    }

    private function resolveEmail(array $validated): string
    {
        $email = $validated['role'] === 'provider'
            ? ($validated['provider_email'] ?? null)
            : ($validated['user_email'] ?? null);

        if (filled($email)) {
            return $email;
        }

        $prefix = $validated['role'] === 'provider' ? 'provider' : 'user';

        return sprintf('%s-%s@homeease.local', $prefix, Str::uuid());
    }

    private function buildProviderNotes(array $validated): ?string
    {
        $offerings = collect($validated['provider_offerings'] ?? []);

        if ($offerings->isEmpty()) {
            return null;
        }

        return $offerings
            ->map(function (array $offering, int $index): string {
                $parts = [
                    'Offering '.($index + 1).': '.$offering['offering_name'],
                    'Service: '.$offering['service_type'],
                    'Subtype: '.$offering['service_subtype'],
                    'Details: '.$offering['details'],
                    'Mode: '.$offering['service_mode'],
                    'Pricing: '.$offering['pricing_model'].' - '.$offering['price'],
                    'Timing: '.$offering['timing'],
                ];

                if (filled($offering['experience_years'] ?? null)) {
                    $parts[] = 'Experience: '.$offering['experience_years'].' years';
                }

                if (filled(data_get($offering, 'service_attributes.work_option'))) {
                    $parts[] = 'Work option: '.data_get($offering, 'service_attributes.work_option');
                }

                if (filled($offering['notes'] ?? null)) {
                    $parts[] = 'Notes: '.$offering['notes'];
                }

                return implode(' | ', $parts);
            })
            ->implode("\n");
    }
}
