<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscribe extends Model
{
    /** @use HasFactory<\Database\Factories\SubscribeFactory> */
    use HasFactory;

     protected $fillable = ['email', 'is_verified', 'verification_token', 'verified_at','is_active'];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($subscriber) {
            $subscriber->verification_token = \string::random(40);
        });
    }
}
