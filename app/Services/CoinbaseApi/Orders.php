<?php

namespace App\Services\CoinbaseApi;

use App\Traits\CoinbaseApiAuth;
use Illuminate\Support\Facades\Http;

class Orders
{
    use CoinbaseApiAuth;

    /**
     * Docs: https://docs.pro.coinbase.com/?php#list-orders
     */
    public function listOrders(array $orders_status): ?array
    {
        $endpoint = '/orders?';

        $oders_status_query = [];
        foreach ($orders_status as $order_status) {
            $oders_status_query[] = "status=" . $order_status;
        }
        $endpoint .= implode("&", $oders_status_query);

        $response = Http::withHeaders($this->coinbaseHeaders($endpoint, '', 'GET'))
            ->get(config('coinbase.api.base_url') . $endpoint);

        if ($response->ok()) {
            return $response->json();
        }

        return null;
    }

    /**
     * Docs: https://docs.pro.coinbase.com/?php#get-an-order
     */
    public function getOrder(string $order_id): ?array
    {
        $endpoint = '/orders//' . $order_id;
        $response = Http::withHeaders($this->coinbaseHeaders($endpoint, '', 'GET'))
            ->get(config('coinbase.api.base_url') . $endpoint);

        if ($response->ok()) {
            return $response->json();
        }

        return null;
    }

    /**
     * https://docs.pro.coinbase.com/?php#place-a-new-order
     */
    public function placeOrder()
    {
        $endpoint = '/orders';
        $body = [
            'side' => 'buy',
            'product_id' => 'BTC-EUR',
            'size' => 100,
            'type' => 'market',
        ];
        $response = Http::withHeaders($this->coinbaseHeaders($endpoint, $body, 'POST'))
            ->post(config('coinbase.api.base_url') . $endpoint, $body);

        return $response->json();
    }
}
