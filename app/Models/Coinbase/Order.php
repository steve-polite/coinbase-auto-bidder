<?php

namespace App\Models\Coinbase;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = "orders";

    public $incrementing = false;

    protected $casts = [
        'created_at' => 'datetime',
        'done_at' => 'datetime',
        'post_only' => 'boolean',
        'settled' => 'boolean'
    ];

    protected $guarded = [];
}
