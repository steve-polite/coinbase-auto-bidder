<?php

namespace App\Services\CoinbaseApi;

use App\Traits\CoinbaseApiAuth;
use Illuminate\Support\Facades\Http;

class Products
{
    use CoinbaseApiAuth;

    /**
     * Docs: https://docs.cloud.coinbase.com/exchange/reference/exchangerestapi_getproducts
     */
    public function listProducts(): ?array
    {
        $response = Http::withHeaders($this->coinbaseHeaders('/products', '', 'GET'))
            ->get(config('coinbase.api.base_url') . '/products');

        if ($response->ok()) {
            return $response->json();
        }

        return null;
    }
}
