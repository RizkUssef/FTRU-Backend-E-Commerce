<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;

class DeleteExpiredOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'detele the orders mountly';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $thresholdDate = now()->subDays(60);
        Order::where('created_at', '<', $thresholdDate)->delete();
        $this->info('Expired rows deleted successfully.');
    }
}
