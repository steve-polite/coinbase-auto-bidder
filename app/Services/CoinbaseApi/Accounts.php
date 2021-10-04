<?php

namespace App\Services\CoinbaseApi;

use App\Traits\CoinbaseApiAuth;
use Illuminate\Support\Facades\Http;

class Accounts
{
    use CoinbaseApiAuth;

    public function listAccounts()
    {
        $response = Http::withHeaders($this->coinbaseHeaders('/accounts', '', 'GET'))
            ->get(config('coinbase.api.base_url') . '/accounts');
        return $response->json();
    }
}
