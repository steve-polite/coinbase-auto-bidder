<?php

namespace App\Http\Controllers\Coinbase;

use App\Http\Controllers\Controller;
use App\Models\Coinbase\AccountMovement;
use App\Models\Coinbase\Order;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
    public function index(Request $request)
    {
        $last_orders = Order::orderBy('created_at', 'desc')->limit(5)->get();

        // Fees
        $total_fees_eur = AccountMovement::select(['amount'])->where('product_id', 'LIKE', '%-EUR')->where('type', 'fee')->sum('amount');
        $total_fees_usd = AccountMovement::select(['amount'])->where('product_id', 'LIKE', '%-USD')->where('type', 'fee')->sum('amount');
        $total_fees = - ($total_fees_eur + $total_fees_usd); // TODO: use exchanges rates

        // Deposits
        $total_deposits = AccountMovement::select(['amount'])->where('transfer_type', 'deposit')->sum('amount'); // TODO: check how to know the account that receives the transfer (EUR, USD, ecc.)

        // Withdrawals
        $total_withdrawals = -AccountMovement::select(['amount'])->where('transfer_type', 'withdraw')->sum('amount');

        return view('coinbase.homepage.index', [
            'title' => 'Homepage',
            'last_orders' => $last_orders,
            'total_fees' => number_format($total_fees, 2, ",", "."),
            'total_transfers' => number_format($total_deposits, 2, ",", "."),
            'total_withdrawals' => number_format($total_withdrawals, 2, ",", "."),
        ]);
    }
}
