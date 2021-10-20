<?php

namespace App\Http\Controllers\Coinbase;

use App\Http\Controllers\Controller;
use App\Models\Coinbase\Account;
use Illuminate\Http\Request;

class AccountsController extends Controller
{
    public function index(Request $request)
    {
        $accounts = Account::select(['account_id', 'currency', 'balance'])->get();

        return view('coinbase.accounts.index', [
            'title' => __('coinbase.accounts.title'),
            'accounts' => $accounts
        ]);
    }
}
