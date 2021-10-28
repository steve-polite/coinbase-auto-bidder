<?php

namespace App\Traits;

use AmrShawky\LaravelCurrency\Facade\Currency;
use App\Models\Currency\ExchangeRate;

trait CurrenciesConverter
{
    public function convertCurrency(string $from, string $to, float $amount)
    {
        $last_exchange_rate = ExchangeRate::select(['base', 'symbol', 'rate'])
            ->where(function ($query) use ($from, $to) {
                $query->whereBase(strtoupper($from))
                    ->whereSymbol(strtoupper($to));
            })
            ->orWhere(function ($query) use ($from, $to) {
                $query->whereBase(strtoupper($to))
                    ->whereSymbol(strtoupper($from));
            })
            ->first();

        if (!is_null($last_exchange_rate)) {
            if ($last_exchange_rate->base === strtoupper($from)) {
                return $amount * $last_exchange_rate->rate;
            } else {
                return $amount * (1 / $last_exchange_rate->rate);
            }
        }

        return Currency::convert()
            ->from(strtoupper($from))
            ->to(strtoupper($to))
            ->amount($amount)
            ->get();
    }

    /**
     * Example:
     * $amount = ["EUR" => 1.2, "USD" => 3.4, "GBP" => 4.2];
     * $to = "EUR";
     *
     * Returns total amount in EUR
     */
    public function getTotalAmountFromMultipleCurrencies(array $amounts, string $to): float
    {
        $total_amount = 0;

        if (array_key_exists($to, $amounts)) {
            $total_amount += $amounts[$to];
            unset($amounts[$to]);
        }

        foreach ($amounts as $amount_currency => $amount) {
            if ($amount != 0) {
                $total_amount += $this->convertCurrency($amount_currency, $to, $amount);
            }
        }

        return $total_amount;
    }
}
