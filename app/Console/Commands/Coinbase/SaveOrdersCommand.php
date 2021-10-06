<?php

namespace App\Console\Commands\Coinbase;

use App\Models\Coinbase\Order;
use App\Services\CoinbaseApi\Orders;
use Illuminate\Console\Command;

class SaveOrdersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coinbase:orders:save {--all}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Save Coinbase orders in database';


    private $coinbase_orders_api;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->coinbase_orders_api = new Orders();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if ($this->option('all')) {
            $orders_status = ['open', 'pending', 'rejected', 'done', 'active'];
        } else {
            $orders_status = []; // Only 'open', 'pending' and 'active' by default
        }

        $orders = $this->coinbase_orders_api->listOrders($orders_status);

        if (!is_null($orders)) {
            foreach ($orders as $order) {
                if (!$saved_order = Order::whereId($order['id'])->exists()) {
                    $saved_order = new Order($order);
                    $saved_order->save();
                }
            }
        } else {
            $this->error('Cannot get orders');
        }
    }
}
