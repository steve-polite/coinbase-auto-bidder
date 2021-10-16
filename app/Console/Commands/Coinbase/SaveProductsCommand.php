<?php

namespace App\Console\Commands\Coinbase;

use App\Models\Coinbase\Product;
use App\Services\CoinbaseApi\Products;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SaveProductsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coinbase:products:save';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Save Coinbase products (currencies pairs for trading) in database';

    private $coinbase_products_service;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->coinbase_products_service = new Products();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $products = $this->coinbase_products_service->listProducts();

        if (!is_null($products)) {
            foreach ($products as $product) {
                try {
                    $product = Product::whereId($product['id'])->firstOrFail();
                    $product->base_min_size = $product['base_min_size'];
                    $product->base_max_size = $product['base_max_size'];
                    $product->quote_increment = $product['quote_increment'];
                    $product->min_market_funds = $product['min_market_funds'];
                    $product->max_market_funds = $product['max_market_funds'];
                    $product->max_market_funds = $product['max_market_funds'];
                    $product->margin_enabled = $product['margin_enabled'];
                    $product->fx_stablecoin = $product['fx_stablecoin'];
                    $product->max_slippage_percentage = $product['max_slippage_percentage'];
                    $product->post_only = $product['post_only'];
                    $product->limit_only = $product['limit_only'];
                    $product->cancel_only = $product['cancel_only'];
                    $product->trading_disabled = $product['trading_disabled'];
                    $product->status = $product['status'];
                    $product->status_message = $product['status_message'];
                    $product->auction_mode = $product['auction_mode'];
                } catch (ModelNotFoundException $e) {
                    $product = new Product($product);
                }

                $product->save();
            }
        } else {
            $this->line("Error: cannot returns products");
        }
    }
}
