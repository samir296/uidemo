<?php

namespace Tests\Feature;

use App\Models\AppNotification;
use App\Models\BookingRequest;
use App\Models\ProviderOffering;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_create_booking_request(): void
    {
        $customer = User::factory()->create([
            'role' => 'user',
            'phone' => '9876543210',
            'address' => 'Sector 62, Mohali',
            'city' => 'Mohali',
        ]);

        $provider = User::factory()->create([
            'role' => 'provider',
            'phone' => '9988776655',
            'city' => 'Chandigarh',
        ]);

        $offering = ProviderOffering::create([
            'user_id' => $provider->id,
            'service_type' => 'cook',
            'service_subtype' => 'daily meal prep',
            'offering_name' => 'Daily Meal Prep',
            'details' => 'Home cooked lunch and dinner',
            'service_mode' => 'at home',
            'pricing_model' => 'day',
            'price_amount' => 1800,
            'timing' => 'Mon-Sat, 9 AM - 6 PM',
            'price' => 'Rs. 1,800 / day',
        ]);

        $response = $this->actingAs($customer)->post(route('booking.requests.store'), [
            'provider_offering_id' => $offering->id,
            'service_name' => 'Daily Meal Prep',
            'scheduled_date' => now()->addDay()->toDateString(),
            'scheduled_time' => 'Tomorrow 10 AM',
            'customer_phone' => $customer->phone,
            'address' => $customer->address,
            'city' => $customer->city,
            'notes' => 'Need lunch and dinner for family of four',
        ]);

        $response->assertRedirect(route('my.requests'));

        $this->assertDatabaseHas('booking_requests', [
            'customer_id' => $customer->id,
            'provider_id' => $provider->id,
            'provider_offering_id' => $offering->id,
            'status' => 'pending',
        ]);

        $this->assertDatabaseHas('app_notifications', [
            'user_id' => $provider->id,
            'type' => 'booking_request',
        ]);
    }

    public function test_provider_can_accept_booking_request_and_customer_gets_notification(): void
    {
        $customer = User::factory()->create(['role' => 'user']);
        $provider = User::factory()->create(['role' => 'provider']);

        $offering = ProviderOffering::create([
            'user_id' => $provider->id,
            'service_type' => 'cleaner',
            'service_subtype' => 'deep cleaning',
            'offering_name' => 'Deep Cleaning',
            'details' => 'Kitchen and bathroom deep clean',
            'service_mode' => 'bring own tools',
            'pricing_model' => 'visit',
            'price_amount' => 1200,
            'timing' => 'Mon-Sat, 9 AM - 5 PM',
            'price' => 'Rs. 1,200 / visit',
        ]);

        $bookingRequest = BookingRequest::create([
            'customer_id' => $customer->id,
            'provider_id' => $provider->id,
            'provider_offering_id' => $offering->id,
            'service_type' => 'cleaner',
            'service_name' => 'Deep Cleaning',
            'address' => 'Sector 15, Chandigarh',
            'city' => 'Chandigarh',
            'scheduled_date' => now()->addDay()->toDateString(),
            'scheduled_time' => 'Tomorrow 9 AM',
            'customer_phone' => '9876543210',
            'requested_price' => 1200,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($provider)->post(route('booking.requests.update-status', $bookingRequest), [
            'status' => 'accepted',
            'provider_response_note' => 'Confirmed for tomorrow morning.',
            'final_price' => 1200,
        ]);

        $response->assertRedirect(route('dashboard'));

        $bookingRequest->refresh();

        $this->assertSame('accepted', $bookingRequest->status);
        $this->assertNotNull($bookingRequest->accepted_at);

        $this->assertDatabaseHas('app_notifications', [
            'user_id' => $customer->id,
            'type' => 'booking_update',
            'related_id' => $bookingRequest->id,
        ]);
    }
}
