<?php

namespace App\Console\Commands;

use App\Models\OrderDetail;
use Illuminate\Console\Command;

class DeleteExpiredOrderDetails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:orderdetails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'detele the order details mountly';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $thresholdDate = now()->subDays(30);
        OrderDetail::where('created_at', '<', $thresholdDate)->delete();
        $this->info('Expired rows deleted successfully.');
    }
}
