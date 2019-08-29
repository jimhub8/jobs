<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\models\Product;
use App\models\Product_warehouse;
use App\Notifications\LowStockNotification;
use App\User;

class LowstockCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:lowstock';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notification for low stoke';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $products = Product::all();
        $products->transform(function ($product) {
            $onhand = Product_warehouse::where('product_id', $product->id)->sum('onhand');
            $product->onhand = ($onhand) ? $onhand : 0;
            return $product;
        });
        $low_stock = [];
        foreach ($products as $product) {
            if ($product->onhand < $product->reorder_point) {
                $low_stock[] = $product->id;
            }
        }
        $user = User::find(1);
        // dd($low_stock);
        $low_pro = Product::whereIn('id', $low_stock)->get();
        foreach ($low_pro as $value) {
            $user->notify(new LowStockNotification($value));
        }

        dd(count($low_stock));
    }
}
