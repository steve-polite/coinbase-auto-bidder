<?php

namespace App\Http\Controllers\Coinbase;

use App\Http\Controllers\Controller;
use App\Models\Coinbase\Order;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
    public function index(Request $request)
    {
        $last_orders = Order::orderBy('created_at', 'desc')->limit(5);

        return view('coinbase.homepage.index', [
            'title' => 'Homepage',
            'last_orders' => $last_orders,
        ]);
    }
}
