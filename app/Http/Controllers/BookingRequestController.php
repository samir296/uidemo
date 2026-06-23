<?php

namespace App\Http\Controllers;

use App\Models\AppNotification;
use App\Models\BookingRequest;
use App\Models\ProviderOffering;
use App\Models\User;
use App\Services\PushNotificationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Throwable;

class BookingRequestController extends Controller
{
    public function store(Request $request, PushNotificationService $pushNotificationService): RedirectResponse
    {
        $customer = $request->user();

        if (! $customer instanceof User) {
            return redirect()->route('register', ['role' => 'user']);
        }

        $validated = $request->validate([
            'provider_offering_id' => ['required', 'integer', 'exists:provider_offerings,id'],
            'scheduled_date' => ['required', 'date', 'after_or_equal:today'],
            'scheduled_time' => ['required', 'string', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:1000'],
            'city' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'selected_service_items' => ['required', 'array', 'min:1'],
            'selected_service_items.*' => ['required', 'string', 'max:255'],
            'price_agreement' => ['accepted'],
        ]);

        $offering = ProviderOffering::query()
            ->with('user')
            ->findOrFail($validated['provider_offering_id']);

        $selectedItems = collect($validated['selected_service_items'])
            ->map(fn (string $item): string => trim($item))
            ->filter()
            ->unique()
            ->values();

        $pricingOptions = collect(ProviderOffering::fixedPricingOptionsFor($offering->service_type));
        $allowedItems = $pricingOptions->pluck('label');

        if ($selectedItems->isEmpty() || $selectedItems->diff($allowedItems)->isNotEmpty()) {
            throw ValidationException::withMessages([
                'selected_service_items' => 'Please select valid service items for this booking request.',
            ]);
        }

        $selectedPricingSummary = $pricingOptions
            ->filter(fn (array $option): bool => $selectedItems->contains($option['label']))
            ->map(fn (array $option): string => $option['label'].' ('.$option['price'].')')
            ->implode(', ');

        $provider = $offering->user;

        $bookingRequest = DB::transaction(function () use ($validated, $customer, $provider, $offering, $selectedItems, $selectedPricingSummary) {
            $notes = trim(implode("\n", array_filter([
                $validated['notes'] ?? null,
                'Selected items: '.$selectedItems->implode(', '),
                'Price agreed: '.$selectedPricingSummary,
            ])));
            $notes = $notes !== '' ? mb_substr($notes, 0, 2000) : null;

            $bookingRequest = BookingRequest::create([
                'customer_id' => $customer->id,
                'provider_id' => $provider->id,
                'provider_offering_id' => $offering->id,
                'service_type' => $offering->service_type,
                'service_name' => trim(($offering->offering_name ?: str($offering->service_type)->headline()).' - '.$selectedItems->implode(', ')),
                'address' => $validated['address'],
                'city' => $validated['city'] ?: $customer->city,
                'scheduled_date' => $validated['scheduled_date'],
                'scheduled_time' => $validated['scheduled_time'],
                'customer_phone' => $validated['customer_phone'],
                'requested_price' => null,
                'status' => 'pending',
                'notes' => $notes,
            ]);

            AppNotification::create([
                'user_id' => $provider->id,
                'title' => 'New booking request',
                'body' => "{$customer->name} requested {$offering->offering_name} for {$bookingRequest->scheduled_date->format('d M')} at {$bookingRequest->scheduled_time}.",
                'type' => 'booking_request',
                'related_id' => $bookingRequest->id,
            ]);

            AppNotification::create([
                'user_id' => $customer->id,
                'title' => 'Booking request sent',
                'body' => "Your request for {$offering->offering_name} was sent to {$provider->name}.",
                'type' => 'booking_request',
                'related_id' => $bookingRequest->id,
            ]);

            return $bookingRequest;
        });

        Log::info('Booking request created and notifications queued.', [
            'booking_request_id' => $bookingRequest->id,
            'customer_id' => $customer->id,
            'provider_id' => $provider->id,
            'provider_mobile_token_present' => filled($provider->mobile_token),
        ]);

        try {
            $pushNotificationService->sendToUser(
                $provider,
                'New booking request',
                "{$customer->name} requested {$offering->offering_name} for {$bookingRequest->scheduled_time}.",
                [
                    'booking_request_id' => $bookingRequest->id,
                    'type' => 'booking_request',
                    'status' => $bookingRequest->status,
                ]
            );
        } catch (Throwable $exception) {
            Log::warning('Push notification failed while creating booking request.', [
                'booking_request_id' => $bookingRequest->id,
                'provider_id' => $provider->id,
                'error' => $exception->getMessage(),
            ]);
        }

        return redirect()
            ->route('my.requests')
            ->with('booking_status', 'Booking request sent successfully. The provider has been notified.');
    }

    public function updateStatus(Request $request, BookingRequest $bookingRequest, PushNotificationService $pushNotificationService): RedirectResponse
    {
        $provider = $request->user();

        abort_unless($provider instanceof User && $bookingRequest->provider_id === $provider->id, 403);

        $validated = $request->validate([
            'status' => ['required', Rule::in(['accepted', 'rejected', 'countered', 'completed'])],
            'provider_response_note' => ['nullable', 'string', 'max:2000'],
            'final_price' => ['nullable', 'numeric', 'min:0'],
        ]);

        $status = $validated['status'];

        $bookingRequest->forceFill([
            'status' => $status,
            'provider_response_note' => $validated['provider_response_note'] ?? null,
            'final_price' => $validated['final_price'] ?? $bookingRequest->final_price,
            'accepted_at' => $status === 'accepted' ? now() : ($status === 'rejected' ? null : $bookingRequest->accepted_at),
            'completed_at' => $status === 'completed' ? now() : ($status === 'rejected' ? null : $bookingRequest->completed_at),
        ])->save();

        $statusCopy = match ($status) {
            'accepted' => 'accepted your request',
            'rejected' => 'declined your request',
            'countered' => 'sent a counter update',
            'completed' => 'marked the booking completed',
            default => 'updated your request',
        };

        AppNotification::create([
            'user_id' => $bookingRequest->customer_id,
            'title' => 'Booking update',
            'body' => "{$provider->name} {$statusCopy} for {$bookingRequest->service_name}.",
            'type' => 'booking_update',
            'related_id' => $bookingRequest->id,
        ]);

        Log::info('Booking request status updated.', [
            'booking_request_id' => $bookingRequest->id,
            'provider_id' => $provider->id,
            'customer_id' => $bookingRequest->customer_id,
            'status' => $bookingRequest->status,
            'customer_mobile_token_present' => filled($bookingRequest->customer?->mobile_token),
        ]);

        try {
            $pushNotificationService->sendToUser(
                $bookingRequest->customer,
                'Booking update',
                "{$provider->name} {$statusCopy}.",
                [
                    'booking_request_id' => $bookingRequest->id,
                    'type' => 'booking_update',
                    'status' => $bookingRequest->status,
                ]
            );
        } catch (Throwable $exception) {
            Log::warning('Push notification failed while updating booking request status.', [
                'booking_request_id' => $bookingRequest->id,
                'provider_id' => $provider->id,
                'customer_id' => $bookingRequest->customer_id,
                'status' => $bookingRequest->status,
                'error' => $exception->getMessage(),
            ]);
        }

        return redirect()
            ->back()
            ->with('booking_status', 'Booking request updated successfully.');
    }
}
