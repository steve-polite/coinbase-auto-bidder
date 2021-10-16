<?php

namespace App\Services\CoinbaseApi;

use App\Traits\CoinbaseApiAuth;
use Illuminate\Support\Facades\Http;

class Currencies
{
    use CoinbaseApiAuth;

    /**
     * Docs: https://docs.cloud.coinbase.com/exchange/reference/exchangerestapi_getcurrencies
     */
    public function listCurrencies(): ?array
    {
        $response = Http::withHeaders($this->coinbaseHeaders('/currencies', '', 'GET'))
            ->get(config('coinbase.api.base_url') . '/currencies');

        if ($response->ok()) {
            return $response->json();
        }

        return null;
    }
}
