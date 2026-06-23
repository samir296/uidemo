<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_registration_saves_mobile_token(): void
    {
        Storage::fake('public');

        $response = $this->postJson(route('register.store'), [
            'role' => 'user',
            'profile_image_data' => $this->fakeImageDataUri(),
            'user_name' => 'Aman',
            'user_phone' => '9876543210',
            'user_email' => 'aman@example.com',
            'user_password' => 'secret123',
            'user_password_confirmation' => 'secret123',
            'user_address' => 'Sector 62, Mohali',
            'user_help_type' => 'Cleaning',
            'user_note' => 'Need weekend cleaning help',
            'mobile_token' => 'fcm-token-123',
        ]);

        $response->assertCreated()
            ->assertJsonPath('user.mobile_token_saved', true);

        $this->assertAuthenticated();

        $this->assertDatabaseHas('users', [
            'email' => 'aman@example.com',
            'role' => 'user',
            'mobile_token' => 'fcm-token-123',
            'help_type' => 'Cleaning',
        ]);

        $user = User::where('email', 'aman@example.com')->firstOrFail();
        $this->assertNotNull($user->profile_image_path);
        Storage::disk('public')->assertExists($user->profile_image_path);
    }

    public function test_customer_registration_requires_phone_number(): void
    {
        Storage::fake('public');

        $response = $this->postJson(route('register.store'), [
            'role' => 'user',
            'profile_image_data' => $this->fakeImageDataUri(),
            'user_name' => 'Aman',
            'user_email' => 'aman@example.com',
            'user_password' => 'secret123',
            'user_password_confirmation' => 'secret123',
            'user_address' => 'Sector 62, Mohali',
            'user_help_type' => 'Cleaning',
            'user_note' => 'Need weekend cleaning help',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['user_phone']);
    }

    public function test_registration_requires_profile_image_for_both_roles(): void
    {
        $customerResponse = $this->postJson(route('register.store'), [
            'role' => 'user',
            'user_phone' => '9876543210',
            'user_password' => 'secret123',
            'user_password_confirmation' => 'secret123',
        ]);

        $customerResponse->assertStatus(422)
            ->assertJsonValidationErrors(['profile_image_data']);

        $providerResponse = $this->postJson(route('register.store'), [
            'role' => 'provider',
            'provider_name' => 'Riya Sharma',
            'provider_phone' => '9988776655',
            'provider_password' => 'secret123',
            'provider_password_confirmation' => 'secret123',
            'provider_aadhaar' => '123456789012',
            'provider_city' => 'Chandigarh',
            'provider_address' => 'Sector 17, Chandigarh',
            'provider_offerings' => [
                [
                    'service_type' => 'cleaner',
                    'service_subtype' => 'Deep cleaning',
                    'offering_name' => 'Deep Cleaning',
                    'details' => 'Kitchen and bathroom deep clean',
                    'service_mode' => 'Bring own tools',
                    'pricing_model' => 'Per visit',
                    'price_amount' => 1200,
                    'timing' => 'Mon-Sat, 9 AM - 5 PM',
                    'price' => 'Rs. 1,200 / visit',
                ],
            ],
        ]);

        $providerResponse->assertStatus(422)
            ->assertJsonValidationErrors(['profile_image_data']);
    }

    public function test_provider_registration_creates_service_offerings(): void
    {
        Storage::fake('public');

        $response = $this->postJson(route('register.store'), [
            'role' => 'provider',
            'profile_image_data' => $this->fakeImageDataUri(),
            'provider_name' => 'Riya Sharma',
            'provider_phone' => '9988776655',
            'provider_email' => 'riya@example.com',
            'provider_password' => 'secret123',
            'provider_password_confirmation' => 'secret123',
            'provider_aadhaar' => '123456789012',
            'provider_city' => 'Chandigarh',
            'provider_address' => 'Sector 17, Chandigarh',
            'mobile_token' => 'webpush:test-endpoint',
            'provider_offerings' => [
                [
                    'service_type' => 'cleaner',
                    'service_subtype' => 'Deep cleaning',
                    'offering_name' => 'Deep Cleaning',
                    'details' => 'Kitchen and bathroom deep clean',
                    'service_mode' => 'Bring own tools',
                    'pricing_model' => 'Per visit',
                    'price_amount' => 1200,
                    'experience_years' => 4,
                    'timing' => 'Mon-Sat, 9 AM - 5 PM',
                    'price' => 'Rs. 1,200 / visit',
                    'notes' => 'Eco-friendly liquids only',
                    'service_attributes' => [
                        'work_option' => '2-3 BHK / family home',
                    ],
                ],
            ],
        ]);

        $response->assertCreated()
            ->assertJsonPath('user.role', 'provider');

        $user = User::where('email', 'riya@example.com')->firstOrFail();

        $this->assertDatabaseHas('provider_offerings', [
            'user_id' => $user->id,
            'service_type' => 'cleaner',
            'service_subtype' => 'Deep cleaning',
            'offering_name' => 'Deep Cleaning',
            'pricing_model' => 'Per visit',
            'price_amount' => 1200.00,
        ]);

        $this->assertNotNull($user->profile_image_path);
        Storage::disk('public')->assertExists($user->profile_image_path);
    }

    private function fakeImageDataUri(): string
    {
        return 'data:image/png;base64,'.base64_encode(
            base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAusB9sX8nKQAAAAASUVORK5CYII=', true)
        );
    }
}
