<?php

namespace App\Models\Coinbase;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountMovement extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = "accounts_movements";

    public $incrementing = false;

    protected $casts = [
        "created_at" => "datetime",
    ];

    protected $guarded = [];
}
