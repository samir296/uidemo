<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookingRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'provider_id',
        'provider_offering_id',
        'service_type',
        'service_name',
        'address',
        'city',
        'scheduled_date',
        'scheduled_time',
        'customer_phone',
        'requested_price',
        'final_price',
        'status',
        'notes',
        'provider_response_note',
        'accepted_at',
        'completed_at',
    ];

    protected $casts = [
        'scheduled_date' => 'date',
        'requested_price' => 'decimal:2',
        'final_price' => 'decimal:2',
        'accepted_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function provider(): BelongsTo
    {
        return $this->belongsTo(User::class, 'provider_id');
    }

    public function providerOffering(): BelongsTo
    {
        return $this->belongsTo(ProviderOffering::class);
    }
}
