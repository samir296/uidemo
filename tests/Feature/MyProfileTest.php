<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MyProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_open_my_profile_page(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
            'phone' => '9876543210',
        ]);

        $response = $this->actingAs($user)->get(route('my.profile'));

        $response->assertOk()
            ->assertSee('My Profile')
            ->assertSee($user->name);
    }

    public function test_authenticated_user_can_update_my_profile(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
            'phone' => '9876543210',
            'help_type' => 'Cleaning',
        ]);

        $response = $this->actingAs($user)->put(route('my.profile.update'), [
            'name' => 'Updated User',
            'email' => 'updated@example.com',
            'phone' => '9999999999',
            'city' => 'Mohali',
            'address' => 'Sector 70, Mohali',
            'help_type' => 'Cooking',
            'notes' => 'Needs weekday help',
            'mobile_token' => 'token-updated',
        ]);

        $response->assertRedirect(route('my.profile'));

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated User',
            'email' => 'updated@example.com',
            'phone' => '9999999999',
            'help_type' => 'Cooking',
            'mobile_token' => 'token-updated',
        ]);
    }
}
