<?php

namespace App\Models\Coinbase;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountHold extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = "accounts_holds";

    public $incrementing = false;

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $fillable = [
        'id', 'account_id', 'created_at', 'updated_at',
        'amount', 'type', 'ref'
    ];
}
