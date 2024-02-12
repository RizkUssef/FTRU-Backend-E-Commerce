<?php

namespace App\Console\Commands;

use App\Models\CartItem;
use App\Models\OrderDetail;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class AdminDeleteProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:delete-product';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Once the delete_status is updated to yes, the system removes the product';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $thresholdDate = now()->subDays(7);
        // $thresholdDate
        $products = Product::where("delete_status", 'Yes')->whereDate('updated_at', '=', $thresholdDate)->get();
        if ($products) {
            foreach ($products as $product) {
                // get wishlist
                $proWishlist = $product->productWishlist;
                if ($proWishlist) {
                    foreach ($proWishlist as $proWish) {
                        $proWish->pivot->delete();
                    }
                }
                // get review
                $proReview = $product->productReview;
                if ($proReview) {
                    foreach ($proReview as $pro) {
                        $pro->delete();
                    }
                }
                foreach ($product->productColor as $proColor) {
                    foreach ($proColor->colorSize as $productCSs) {
                        // dd($productCSs);
                        $proCartItem = CartItem::where('product_color_size_id', '=', $productCSs->pivot->id)->get();
                        $proOrderDetails = OrderDetail::where('product_color_size_id', '=', $productCSs->pivot->id)->get();
                        if ($proCartItem) {
                            foreach ($proCartItem as $proCart) {
                                $proCart->delete();
                            }
                        }
                        if ($proOrderDetails) {
                            foreach ($proOrderDetails as $proOrderDetail) {
                                $proOrderDetail->delete();
                            }
                        }
                        if ($productCSs->pivot->image != null) {
                            Storage::delete($productCSs->pivot->image);
                        }
                        $productCSs->pivot->delete();
                    }
                    $proColor->delete();
                }
                foreach ($product->productSize as $proSize) {
                    $proSize->delete();
                }
                if ($product->image != null) {
                    Storage::delete($product->image);
                }
                $product->delete();
            }
            $this->info('Products Deleted Successfully');
        } else {
            $this->comment('There are no products where the delete_status has been updated to Yes');
        }

    }
}
