<?php

namespace App\Traits;

trait CoinbaseApiAuth
{
    public function coinbaseHeaders(string $request_path, $body, string $method)
    {
        $timestamp = time();
        return [
            'Content-Type' => 'application/json',
            'CB-ACCESS-KEY' => config('coinbase.api.key'),
            'CB-ACCESS-SIGN' => $this->signature($request_path, $body, $method, $timestamp),
            'CB-ACCESS-TIMESTAMP' => $timestamp,
            'CB-ACCESS-PASSPHRASE' => config('coinbase.api.passphrase')
        ];
    }

    private function signature(string $request_path, $body, string $method, int $timestamp): string
    {
        $body = is_array($body) ? json_encode($body) : $body;

        $what = $timestamp . $method . $request_path . $body;

        return base64_encode(hash_hmac("sha256", $what, base64_decode(config('coinbase.api.secret')), true));
    }
}
