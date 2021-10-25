<?php

namespace App\Models\Currency;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExchangeRate extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = "exchange_rates";

    public $incrementing = false;

    protected $guarded = [];

    protected $casts = [
        'rate_datetime' => 'datetime',
        'rate_date' => 'date',
    ];
}
