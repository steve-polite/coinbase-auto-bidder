<?php

namespace App\Models\Coinbase;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = "products";

    public $incrementing = false;

    protected $guarded = [];

    protected $casts = [
        'margin_enabled' => 'boolean',
        'fx_stablecoin' => 'boolean',
        'post_only' => 'boolean',
        'limit_only' => 'boolean',
        'cancel_only' => 'boolean',
        'trading_disabled' => 'boolean',
        'auction_mode' => 'boolean',
    ];
}
