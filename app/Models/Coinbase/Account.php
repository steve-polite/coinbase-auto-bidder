<?php

namespace App\Models\Coinbase;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $casts = [
        'trading_enabled' => 'bool'
    ];

    protected $fillable = [
        "account_id", "currency", "balance",
        "hold", "available", "profile_id", "trading_enabled"
    ];
}
