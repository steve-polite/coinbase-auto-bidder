<?php

namespace App\Services\CoinbaseApi;

use App\Traits\CoinbaseApiAuth;
use Illuminate\Support\Facades\Http;

class Accounts
{
    use CoinbaseApiAuth;

    /**
     * Docs: https://docs.pro.coinbase.com/?php#list-accounts
     */
    public function listAccounts(): ?array
    {
        $response = Http::withHeaders($this->coinbaseHeaders('/accounts', '', 'GET'))
            ->get(config('coinbase.api.base_url') . '/accounts');

        if ($response->ok()) {
            return $response->json();
        }

        return null;
    }

    /**
     * Docs: https://docs.pro.coinbase.com/?php#get-an-account
     */
    public function getAccount(string $account_id): ?array
    {
        $endpoint = '/accounts//' . $account_id;
        $response = Http::withHeaders($this->coinbaseHeaders($endpoint, '', 'GET'))
            ->get(config('coinbase.api.base_url') . $endpoint);

        if ($response->ok()) {
            return $response->json();
        }

        return null;
    }

    /**
     * Docs: https://docs.pro.coinbase.com/?php#get-account-history
     */
    public function getAccountHistory(string $account_id): ?array
    {
        $endpoint = '/accounts//' . $account_id . '/ledger';
        $response = Http::withHeaders($this->coinbaseHeaders($endpoint, '', 'GET'))
            ->get(config('coinbase.api.base_url') . $endpoint);

        if ($response->ok()) {
            return $response->json();
        }

        return null;
    }
}
