<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
        'city',
        'aadhaar_number',
        'help_type',
        'notes',
        'mobile_token',
        'mobile_token_updated_at',
        'profile_image_path',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'mobile_token_updated_at' => 'datetime',
        ];
    }

    public function providerOfferings(): HasMany
    {
        return $this->hasMany(ProviderOffering::class);
    }

    public function customerBookingRequests(): HasMany
    {
        return $this->hasMany(BookingRequest::class, 'customer_id');
    }

    public function providerBookingRequests(): HasMany
    {
        return $this->hasMany(BookingRequest::class, 'provider_id');
    }

    public function appNotifications(): HasMany
    {
        return $this->hasMany(AppNotification::class)->latest();
    }

    public function updateMobileToken(?string $token): void
    {
        $this->forceFill([
            'mobile_token' => $token,
            'mobile_token_updated_at' => $token ? now() : null,
        ])->save();
    }
}
