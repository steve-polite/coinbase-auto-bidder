<?php

namespace App\Models\Coinbase;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $primaryKey = "account_id";

    public $incrementing = false;

    protected $table = "accounts";

    protected $casts = [
        'trading_enabled' => 'bool',
        'account_id' => 'string'
    ];

    protected $fillable = [
        "account_id", "currency", "balance",
        "hold", "available", "profile_id", "trading_enabled"
    ];
}
