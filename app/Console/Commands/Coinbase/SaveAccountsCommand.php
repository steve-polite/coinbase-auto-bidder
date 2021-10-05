<?php

namespace App\Console\Commands\Coinbase;

use App\Models\Coinbase\Account;
use App\Models\Coinbase\AccountMovement;
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
    protected $signature = 'coinbase:accounts:save {--history} {--holds}';

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

            // Get account information
            try {
                $saved_account = Account::whereAccountId($account["id"])->firstOrFail();
                $saved_account->balance = $account["balance"];
                $saved_account->hold = $account["hold"];
                $saved_account->available = $account["available"];
                $saved_account->balance = $account["balance"];
                $saved_account->trading_enabled = $account["trading_enabled"];
                $saved_account->save();
            } catch (ModelNotFoundException $e) {
                $saved_account = Account::create([
                    'account_id' => $account["id"],
                    'currency' => $account["currency"],
                    'balance' => $account["balance"],
                    'hold' => $account["hold"],
                    'available' => $account["available"],
                    'profile_id' => $account["profile_id"],
                    'trading_enabled' => $account["trading_enabled"],
                ]);
            }

            // Get account history (last 1000 items)
            if ($this->option('history')) {
                $account_history = $this->coinbase_accounts_api->getAccountHistory($saved_account->account_id);

                if (!is_null($account_history)) {
                    foreach ($account_history as $movement) {
                        if (!AccountMovement::whereId($movement["id"])->exists()) {
                            $movement_details = $movement["details"];
                            AccountMovement::create([
                                "id" => $movement["id"],
                                "account_id" => $saved_account->account_id,
                                "amount" => $movement["amount"],
                                "balance" => $movement["balance"],
                                "created_at" => $movement["created_at"],
                                "type" => $movement["type"],
                                "order_id" => $movement_details["order_id"] ?? null,
                                "product_id" => $movement_details["product_id"] ?? null,
                                "trade_id" => $movement_details["trade_id"] ?? null,
                                "transfer_id" => $movement_details["transfer_id"] ?? null,
                                "transfer_type" => $movement_details["transfer_type"] ?? null
                            ]);
                        }
                    }
                }
            }

            // Get account holds
            if ($this->option('holds')) {
                $account_holds = $this->coinbase_accounts_api->getAccountHolds($saved_account->account_id);

                if (!is_null($account_holds)) {
                    // TODO: save account holds
                }
            }
        }
    }
}
