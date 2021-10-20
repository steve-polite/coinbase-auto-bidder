<?php

namespace App\Http\Controllers\Coinbase;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function index(Request $request)
    {
        return view('coinbase.orders.index', [
            'title' => __('coinbase.orders.title'),
        ]);
    }
}
