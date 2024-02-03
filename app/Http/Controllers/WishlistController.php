<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\Wishlist;
use App\Models\ProductSize;
use App\Models\ProductColor;
use Illuminate\Http\Request;
use App\Models\ProductColorSize;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\EditCartRequest;
use App\Http\Requests\AddToCartRequest;
use Illuminate\Support\Facades\Session;

use function PHPUnit\Framework\returnCallback;

class WishlistController extends Controller
{

    public function wishlist()
    {
        $user = Auth::user();
        if ($user) {
            $user_wishlist = $user->userWishlist;
            if ($user_wishlist) {
                return view('pages.Profile.wishlist', compact('user_wishlist'));
            } else {
                return redirect()->back()->with("error", "you don't have any product in your cart yet");
            }
        } else {
            return redirect()->route('login')->with("error", "you must login first");
        }
    }

    public function addToWishlist(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            $product = Product::findOrFail($request->product_id);
            if ($product) {
                $check = Wishlist::where('product_id', $product->id)->first();
                if ($check) {
                    return redirect()->back()->with('error', 'Something is wrong please try again');
                } else {
                    $userWish = Wishlist::create([
                        'user_id' => $user->id,
                        'product_id' => $product->id
                    ]);
                    $response = [
                        'status' => 'success',
                        'message' => 'Product added successfully',
                    ];
                    // return response()->json($response);
                    return redirect()->back()->with("success", "Product added sussefully");
                }
            } else {
                return redirect()->back()->with('error', 'Something is wrong please try again');
            }
        } else {
            return redirect()->route('Login')->with('error', 'You Must Login First');
        }
    }

    public function deleteWishlist($wishlist_item_id)
    {
        $user = Auth::user();
        if ($user) {
            $item = Wishlist::where("id", $wishlist_item_id)->where("user_id", $user->id)->first();
            if ($item) {
                $item->delete();
                return redirect()->back()->with("success", "Product deleted sussefully");
            }
        } else {
            return redirect()->route('login')->with("error", "you must login first");
        }
    }

    public function deleteAllFromWishlist()
    {
        $user = Auth::user();
        if ($user) {
            if ($user->user_type == 1) {
                $wishlist_items = Wishlist::where('user_id', $user->id)->get();
                foreach ($wishlist_items as $item) {
                    $item->delete();
                }
                return redirect()->route('wishlist')->with('success', "You remove all items from your cart");
            } else {
                return redirect()->route('Register')->with('error', "Create your Account First");
            }
        } else {
            return redirect()->route('Login')->with('error', 'You Must Login First');
        }
    }

    public function addWishlistToCart(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            $product = Product::findOrFail(decrypt($request->product_id));
            if ($product) {
                $user_cart = Cart::where("user_id", $user->id)->first();
                $user_cart_id = null;
                if ($user_cart) {
                    $user_cart_id = $user_cart->id;
                } else {
                    $cart = Cart::create([
                        "user_id" => $user->id,
                    ]);
                    $user_cart_id = $cart->id;
                }
                $color = ProductColor::where("color", $request->color)->where("product_id", $product->id)->first();
                $size = ProductSize::where("size", $request->size)->where("product_id", $product->id)->first();
                $productSC = ProductColorSize::where("product_colors_id", $color->id)->where("product_sizes_id", $size->id)->first();
                if ($productSC) {
                    $qty = 1;
                    if ($productSC->quantity == 0) {
                        return redirect()->back()->with("error", "Sorry! this product is out of stock");
                    } else {
                        $check = CartItem::where("product_color_size_id", $productSC->id)->first();
                        if ($check) {
                            return redirect()->back()->with("error", "This product is already exists in your cart");
                        } else {
                            $cart_item = CartItem::create([
                                "quantity" => $qty,
                                "price" => $product->main_price * $qty,
                                "cart_id" => $user_cart_id,
                                "product_color_size_id" => $productSC->id,
                            ]);
                            $wishlist_id = Wishlist::where("product_id", decrypt($request->product_id))->where("user_id", $user->id)->first();
                            if ($wishlist_id) {
                                $wishlist_id->delete();
                            } else {
                                return redirect()->back()->with("error", "Something is wrong try agian later");
                            }
                            return redirect()->back()->with("success", "Product added sussefully");
                        }
                    }
                } else {
                    return redirect()->back()->with("error", "This size not avilable for this color");
                }
            } else {
                return redirect()->back()->with("error", "Something is wrong try agian later");
            }
        } else {
            return redirect()->route('login')->with("error", "you must login first");
        }
    }

    public function addAllToCartFromWishlist()
    {
        $user = Auth::user();
        if ($user) {
            $wishlistItems = Wishlist::where('user_id', $user->id)->get();
            if ($wishlistItems) {
                foreach ($wishlistItems as $oneitem) {
                    $product = Product::where("id", $oneitem->product_id)->first();
                    if ($product) {
                        $user_cart = Cart::where("user_id", $user->id)->first();
                        $user_cart_id = null;
                        if ($user_cart) {
                            $user_cart_id = $user_cart->id;
                        } else {
                            $cart = Cart::create([
                                "user_id" => $user->id,
                            ]);
                            $user_cart_id = $cart->id;
                        }
                        $color = ProductColor::where("product_id", $product->id)->first();
                        $size = ProductSize::where("product_id", $product->id)->first();
                        $productSC = ProductColorSize::where("product_colors_id", $color->id)->where("product_sizes_id", $size->id)->first();
                        if ($productSC) {
                            $qty = 1;
                            if ($productSC->quantity == 0) {
                                continue;
                            } else {
                                $check = CartItem::where("product_color_size_id", $productSC->id)->first();
                                if ($check) {
                                    $wishlist_id = Wishlist::where("product_id", $oneitem->product_id)->where("user_id", $user->id)->first();
                                    $wishlist_id->delete();
                                    continue;
                                } else {
                                    $cart_item = CartItem::create([
                                        "quantity" => $qty,
                                        "price" => $product->main_price * $qty,
                                        "cart_id" => $user_cart_id,
                                        "product_color_size_id" => $productSC->id,
                                    ]);
                                    $wishlist_id = Wishlist::where("product_id", $oneitem->product_id)->where("user_id", $user->id)->first();
                                    if ($wishlist_id) {
                                        $wishlist_id->delete();
                                    } else {
                                        return redirect()->back()->with("error", "Something is wrong try agian later");
                                    }
                                }
                            }
                        } else {
                            return redirect()->back()->with("error", "this product not found");
                        }
                    } else {
                        return redirect()->back()->with("error", "product not here");
                    }
                }
                return redirect()->back()->with("success", "All Products added sussefully");
            } else {
                return redirect()->back()->with("error", "no data here");
            }
        } else {
            return redirect()->route('login')->with("error", "you must login first");
        }
    }
}
