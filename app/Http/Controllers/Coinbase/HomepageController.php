<?php

namespace App\Http\Controllers\Coinbase;

use App\Http\Controllers\Controller;
use App\Models\Coinbase\Account;
use App\Models\Coinbase\AccountMovement;
use App\Models\Coinbase\Order;
use App\Traits\CurrenciesConverter;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
    use CurrenciesConverter;

    public function index(Request $request)
    {
        $last_orders = Order::orderBy('created_at', 'desc')->limit(5)->get();

        // Fees
        $fees = [
            'EUR' => AccountMovement::select(['amount'])->where('product_id', 'LIKE', '%-EUR')->where('type', 'fee')->sum('amount'),
            'USD' => AccountMovement::select(['amount'])->where('product_id', 'LIKE', '%-USD')->where('type', 'fee')->sum('amount'),
            'GBP' => AccountMovement::select(['amount'])->where('product_id', 'LIKE', '%-GBP')->where('type', 'fee')->sum('amount'),
        ];
        $total_fees = - ($this->getTotalAmountFromMultipleCurrencies($fees, config('app.main_currency')));

        // Deposits
        $total_deposits = AccountMovement::select(['amount'])->where('transfer_type', 'deposit')->sum('amount'); // TODO: check how to know the account that receives the transfer (EUR, USD, ecc.)

        // Withdrawals
        $total_withdrawals = -AccountMovement::select(['amount'])->where('transfer_type', 'withdraw')->sum('amount');

        // Wallet value
        $accounts = Account::select(['currency', 'balance'])->get();
        $accounts_balances = [];
        foreach ($accounts as $account) {
            $accounts_balances[$account->currency] = $account->balance;
        }
        $total_wallet_value = $this->getTotalAmountFromMultipleCurrencies($accounts_balances, config('app.main_currency'));


        return view('coinbase.homepage.index', [
            'title' => 'Homepage',
            'last_orders' => $last_orders,
            'total_fees' => number_format($total_fees, 2, ",", "."),
            'total_transfers' => number_format($total_deposits, 2, ",", "."),
            'total_withdrawals' => number_format($total_withdrawals, 2, ",", "."),
            'total_wallet_value' => number_format($total_wallet_value, 2, ",", "."),
        ]);
    }
}
