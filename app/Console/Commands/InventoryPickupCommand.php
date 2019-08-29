<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\models\WarehouseReceive;
use Carbon\Carbon;
use App\User;
use App\Notifications\InventoryPickupNotification;

class InventoryPickupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:inventoryPickup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Inventory pickup notifications';

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
        $tomorrow = Carbon::tomorrow()->format('Y-m-d');
        // dd($tomorrow);
        // dd(WarehouseReceive::find(1));
        $warehouse = WarehouseReceive::whereDate('delivery_date', '2019-07-12')->get();
        $user = User::find(1);
        // dd($warehouse);

        foreach ($warehouse as $value) {
            $user->notify(new InventoryPickupNotification($value));
        }
    }
}
