<?php

namespace App\Console\Commands;

use App\Models\CartItem;
use Illuminate\Console\Command;

class DeleteExpiredCartItem extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:cartitem';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'detele the cart item mountly';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $thresholdDate = now()->subDays(30);
        CartItem::where('created_at', '<', $thresholdDate)->delete();
        $this->info('Expired rows deleted successfully.');
    }
}
