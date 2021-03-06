<?php

namespace App\Console\Commands\Coinbase;

use App\Models\Coinbase\Account;
use App\Models\Coinbase\AccountHold;
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

        $this->line(count($accounts) . " accounts found.\n");

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
                $saved_account = new Account($account);
                $saved_account->account_id = $account["id"];
                $saved_account->save();
            }

            $this->line($saved_account->currency . " account data saved.");

            // Get account history (last 1000 items)
            if ($this->option('history')) {
                $this->line("Get " . $saved_account->currency . " account history...");

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
                $this->line("Done.");
            }

            // Get account holds
            if ($this->option('holds')) {
                $this->line("Get " . $saved_account->currency . " account holds...");

                $account_holds = $this->coinbase_accounts_api->getAccountHolds($saved_account->account_id);

                if (!is_null($account_holds)) {
                    AccountHold::whereAccountId($saved_account->account_id)->delete();
                    foreach ($account_holds as $account_hold) {
                        AccountHold::create([
                            'id' => $account_hold['id'],
                            'account_id' => $account_hold['account_id'],
                            'created_at' => $account_hold['created_at'],
                            'updated_at' => $account_hold['updated_at'],
                            'amount' => $account_hold['amount'],
                            'type' => $account_hold['type'],
                            'ref' => $account_hold['ref'],
                        ]);
                    }
                }
                $this->line("Done.");
            }
            $this->line("");
        }
    }
}
