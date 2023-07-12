<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'referral_name',
        'mobile_number',
        'email',
        'status',
        'bonus',
        'admin_action',
        'category_id',
        'created_at',
        'updated_at',
    ];
}
