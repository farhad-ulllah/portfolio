<?php

namespace App\Models;

use App\Models\Referral;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];
    public function referrals()
    {
        return $this->hasMany(Referral::class);
    }
    public function activeReferrals()
    {
        return $this->referrals()->where('status', 'active');
    }

    public function successfulReferrals()
    {
        return $this->referrals()->where('status', 'success');
    }

    public function declinedReferrals()
    {
        return $this->referrals()->where('status', 'declined');
    }

    public function totalReferrals()
    {
        return $this->referrals()->count();
    }

    public function totalEarnings()
    {
        return $this->hasManyThrough(Referral::class, 'user_id')->sum('bonus');
    }

    public function thisMonthEarnings()
    {
        $currentMonth = now()->month;

        return $this->hasManyThrough(Referral::class, 'user_id')
            ->whereMonth('referrals.created_at', $currentMonth)
            ->sum('bonus');
    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
