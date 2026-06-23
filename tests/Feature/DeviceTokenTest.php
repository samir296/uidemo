<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeviceTokenTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_store_device_token(): void
    {
        $user = User::factory()->create([
            'mobile_token' => null,
        ]);

        $response = $this->actingAs($user)->postJson(route('device.token.store'), [
            'mobile_token' => 'fcm-device-token-123',
        ]);

        $response->assertOk()
            ->assertJsonPath('mobile_token_saved', true);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'mobile_token' => 'fcm-device-token-123',
        ]);
    }
}
