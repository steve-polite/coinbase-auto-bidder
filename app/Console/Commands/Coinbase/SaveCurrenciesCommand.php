<?php

namespace App\Console\Commands\Coinbase;

use App\Models\Coinbase\Currency;
use App\Services\CoinbaseApi\Currencies;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SaveCurrenciesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coinbase:currencies:save';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Save Coinbase currencies in database';

    private $coinbase_currencies_api;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->coinbase_currencies_api = new Currencies();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $currencies = $this->coinbase_currencies_api->listCurrencies();

        if (!is_null($currencies)) {
            foreach ($currencies as $currency) {
                if (!Currency::whereId($currency['id'])->exists()) {
                    Currency::create([
                        'id' => $currency['id'],
                        'name' => $currency['name'],
                        'min_size' => (float) $currency['min_size'],
                        'status' => $currency['status'],
                        'max_precision' => (float) $currency['max_precision'],
                        'type' => $currency['details']['type'],
                        'symbol' => $currency['details']['symbol'],
                        'crypto_address_link' => $currency['details']['crypto_address_link'],
                        'crypto_transaction_link' => $currency['details']['crypto_transaction_link'],
                        'min_withdrawal_amount' => (float) $currency['details']['min_withdrawal_amount'],
                        'max_withdrawal_amount' => (float) $currency['details']['max_withdrawal_amount']
                    ]);
                } else {
                    Currency::whereId($currency['id'])
                        ->update(['status' => $currency["status"]]);
                }
            }
        } else {
            $this->line("Error: cannot returns currencies");
        }
    }
}
