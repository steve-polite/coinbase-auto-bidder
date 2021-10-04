<?php

namespace App\Console\Commands\Coinbase;

use App\Models\Coinbase\Account;
use App\Services\CoinbaseApi\Accounts;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SaveAccountsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coinbase:accounts:save';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Save Coinbase accounts in database';

    private $coinbase_accounts_api;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->coinbase_accounts_api = new Accounts();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $accounts = $this->coinbase_accounts_api->listAccounts();

        foreach ($accounts as $account) {
            try {
                $saved_account = Account::whereAccountId($account["id"])->firstOrFail();
                $saved_account->balance = $account["balance"];
                $saved_account->hold = $account["hold"];
                $saved_account->available = $account["available"];
                $saved_account->balance = $account["balance"];
                $saved_account->trading_enabled = $account["trading_enabled"];
                $saved_account->save();
            } catch (ModelNotFoundException $e) {
                Account::create([
                    'account_id' => $account["id"],
                    'currency' => $account["currency"],
                    'balance' => $account["balance"],
                    'hold' => $account["hold"],
                    'available' => $account["available"],
                    'profile_id' => $account["profile_id"],
                    'trading_enabled' => $account["trading_enabled"],
                ]);
            }
        }
    }
}
