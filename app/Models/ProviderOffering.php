<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProviderOffering extends Model
{
    use HasFactory;

    private const FIXED_SERVICE_PRICING = [
        'electrician' => [
            ['label' => 'Visit fee', 'price' => 'Rs. 99 - 149'],
            ['label' => 'Switch / socket', 'price' => 'Rs. 100 - 200'],
            ['label' => 'Fan repair', 'price' => 'Rs. 150 - 300'],
            ['label' => 'Wiring', 'price' => 'Rs. 300 - 800'],
        ],
        'plumber' => [
            ['label' => 'Visit fee', 'price' => 'Rs. 99 - 149'],
            ['label' => 'Tap repair', 'price' => 'Rs. 100 - 200'],
            ['label' => 'Leakage fix', 'price' => 'Rs. 150 - 300'],
            ['label' => 'Pipe work', 'price' => 'Rs. 300 - 1000'],
        ],
        'ac_cooler_repair' => [
            ['label' => 'Visit fee', 'price' => 'Rs. 149 - 199'],
            ['label' => 'Gas check', 'price' => 'Rs. 0 - 100'],
            ['label' => 'Gas refill', 'price' => 'Rs. 1500 - 2500'],
            ['label' => 'General service', 'price' => 'Rs. 300 - 600'],
        ],
        'driver' => [
            ['label' => 'Driver only (without car)', 'price' => 'Rs. 800 - 1200'],
            ['label' => 'Driver with car', 'price' => 'Rs. 1800 - 3000'],
            ['label' => 'Office pickup / drop', 'price' => 'Rs. 1000 - 1800'],
            ['label' => 'Outstation driver duty', 'price' => 'Rs. 2000 - 3000'],
        ],
    ];

    protected $fillable = [
        'user_id',
        'service_type',
        'service_subtype',
        'offering_name',
        'details',
        'service_mode',
        'pricing_model',
        'price_amount',
        'experience_years',
        'timing',
        'price',
        'notes',
        'service_attributes',
    ];

    protected $casts = [
        'price_amount' => 'decimal:2',
        'experience_years' => 'integer',
        'service_attributes' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function fixedPricingOptionsFor(?string $serviceType): array
    {
        return self::FIXED_SERVICE_PRICING[$serviceType ?? ''] ?? [];
    }

    public static function fixedPricingSummaryFor(?string $serviceType): string
    {
        $options = self::fixedPricingOptionsFor($serviceType);

        if ($options === []) {
            return '';
        }

        return 'Fixed rates: '.$options[0]['label'].' '.$options[0]['price'];
    }

    public static function minimumFixedPriceFor(?string $serviceType): int
    {
        $options = self::fixedPricingOptionsFor($serviceType);
        $prices = collect($options)
            ->map(function (array $option): int {
                preg_match('/Rs\.\s*(\d+)/', $option['price'], $matches);

                return isset($matches[1]) ? (int) $matches[1] : 0;
            })
            ->filter(fn (int $price): bool => $price >= 0);

        return $prices->isEmpty() ? 0 : $prices->min();
    }
}
