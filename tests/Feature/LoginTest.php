<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login_with_phone_number(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
            'phone' => '9876543210',
            'password' => Hash::make('secret123'),
        ]);

        $response = $this->post(route('login.store'), [
            'login' => $user->phone,
            'password' => 'secret123',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_can_login_with_email_address(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('secret123'),
        ]);

        $response = $this->post(route('login.store'), [
            'login' => $user->email,
            'password' => 'secret123',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_guest_is_redirected_to_login_for_dashboard(): void
    {
        $response = $this->get(route('dashboard'));

        $response->assertRedirect(route('login'));
    }
}
