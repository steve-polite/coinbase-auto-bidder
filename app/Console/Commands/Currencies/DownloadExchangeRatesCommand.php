<?php

namespace App\Console\Commands\Currencies;

use AmrShawky\LaravelCurrency\Facade\Currency;
use App\Models\Coinbase\Currency as CoinbaseCurrency;
use App\Models\Currency\ExchangeRate;
use App\Models\Settings;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DownloadExchangeRatesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'currencies:exchangerates:download {--currency=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download exchanges rates for a currencies';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $currency = "EUR";
        if (!is_null($this->option('currency'))) {
            $currency = strtoupper($this->option('currency'));
        } elseif (Settings::where('key', 'MAIN_CURRENCY')->exists()) {
            $currency = Settings::where('key', 'MAIN_CURRENCY')->first()->value;
        }

        if (CoinbaseCurrency::where('id', $currency)->exists()) {
            $is_fiat = CoinbaseCurrency::where('id', $currency)->first()->type === "fiat";
        } else {
            return $this->error('Currency ' . $currency . ' does not exist');
        }

        $fiat_currencies = array_diff(CoinbaseCurrency::select(['id'])->whereType('fiat')->get()->pluck('id')->toArray(), [$currency]);
        $crypto_currencies = array_diff(CoinbaseCurrency::select(['id'])->whereType('crypto')->get()->pluck('id')->toArray(), [$currency]);

        $fiat_currencies_rates =
            Currency::rates()
            ->latest()
            ->symbols($fiat_currencies)
            ->base($currency)
            ->get();

        foreach ($fiat_currencies_rates as $fiat_currency => $fiat_rate) {
            ExchangeRate::create([
                'base' => $currency,
                'symbol' => $fiat_currency,
                'rate' => $fiat_rate,
                'rate_datetime' => Carbon::now()->toDateTimeString(),
                'rate_date' => Carbon::now()->toDateString(),
            ]);
        }

        $crypto_currencies_rates =
            Currency::rates()
            ->latest()
            ->symbols($crypto_currencies)
            ->base($currency)
            ->source('crypto')
            ->get();

        // dd($crypto_currencies_rates);
        foreach ($crypto_currencies_rates as $crypto_currency => $crypto_rate) {
            ExchangeRate::create([
                'base' => $currency,
                'symbol' => $crypto_currency,
                'rate' => $crypto_currency == "BTC" ? $crypto_rate : 1 / $crypto_rate,
                'rate_datetime' => Carbon::now()->toDateTimeString(),
                'rate_date' => Carbon::now()->toDateString(),
            ]);
        }
    }
}
