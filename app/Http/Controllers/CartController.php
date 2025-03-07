<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\ProductSize;
use App\Models\ProductColor;
use Illuminate\Http\Request;
use App\Models\ProductColorSize;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\EditCartRequest;
use App\Http\Requests\AddToCartRequest;

class CartController extends Controller
{
    //
    public function Cart()
    {
        $user = Auth::user();
        if ($user) {
            $user_cart = $user->userCart;
            if ($user_cart) {
                $cart_item = $user_cart->cartCItem;
                return view('pages.Profile.cart', compact('cart_item'));
            } else {
                return redirect()->back()->with("error", "you don't have any product in your cart yet");
            }
        } else {
            return redirect()->route('login')->with("error", "you must login first");
        }
    }

    public function addToCart(AddToCartRequest $request)
    {
        $user = Auth::user();
        if ($user) {
            $product = Product::where("id",$request->product_id)->where('delete_status','No')->first();
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
                    $qty = $request->quantity;
                    if ($qty <= $productSC->quantity) {
                        $check = CartItem::where("product_color_size_id", $productSC->id)->first();
                        if ($check) {
                            return redirect()->back()->with("error", "This product is already exists in your cart");
                        } else {
                            if ($product->main_discount != null) {
                                $price = $product->main_price - ($product->main_price *  ($product->main_discount / 100));
                            } else {
                                $price = $product->main_price;
                            }
                            $cart_item = CartItem::create([
                                "quantity" => $qty,
                                "price" => $price * $qty,
                                "cart_id" => $user_cart_id,
                                "product_color_size_id" => $productSC->id,
                            ]);
                            return redirect()->back()->with("success", "Product added sussefully");
                        }
                    } else {
                        return redirect()->back()->with("error", "Sorry! but You have filled up the limit for this product. There is no room for more.");
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

    public function deleteCart($cart_item_id)
    {
        $user = Auth::user();
        if ($user) {
            $item = CartItem::where("id", $cart_item_id)->where("cart_id", $user->userCart->id)->first();
            if ($item) {
                $item->delete();
                return redirect()->back()->with("success", "Product deleted sussefully");
            }
        } else {
            return redirect()->route('login')->with("error", "you must login first");
        }
    }

    public function deleteAllFromCart()
    {
        $user = Auth::user();
        if ($user) {
            if ($user->user_type == 1) {
                $user_cart = $user->userCart;
                $cart_items = CartItem::where('cart_id', $user_cart->id)->get();
                foreach ($cart_items as $item) {
                    $item->delete();
                }
                return redirect()->route('cart')->with('success', "You remove all items from your cart");
            } else {
                return redirect()->route('Register')->with('error', "Create your Account First");
            }
        } else {
            return redirect()->route('Login')->with('error', 'You Must Login First');
        }
    }

    public function editCart($product_id, $cart_item_id)
    {
        $user = Auth::user();
        if ($user) {
            $product = Product::where("id", $product_id)->where('delete_status','No')->first();
            if ($product) {
                $cat_item_product = CartItem::where("id", $cart_item_id)->first();
                if ($cat_item_product) {
                    $pro_c_s = ProductColorSize::where("id", $cat_item_product->product_color_size_id)->first();
                    return view('pages.Profile.edit_cart', compact("product", "cat_item_product", "pro_c_s"));
                } else {
                    return redirect()->route("error")->with("error", "something wrong");
                }
            } else {
                return redirect()->route("error")->with("error", "something wrong");
            }
        } else {
            return redirect()->route('login')->with("error", "you must login first");
        }
    }

    public function handleEditCart($cart_item_id, EditCartRequest $request)
    {
        $product = Product::where("id",$request->product_id)->where('delete_status','No')->first();
        if ($product) {
            $color = ProductColor::where("color", $request->color)->where("product_id", $product->id)->first();
            $size = ProductSize::where("size", $request->size)->where("product_id", $product->id)->first();
            $productSC = ProductColorSize::where("product_colors_id", $color->id)->where("product_sizes_id", $size->id)->first();
            if ($productSC) {
                $qty = $request->quantity;
                if ($qty <= $productSC->quantity) {
                    $cart_item = CartItem::where("id", $cart_item_id)->first();
                    if ($cart_item) {
                        if($product->main_discount != null){
                            $price=$product->main_price - ($product->main_price *  ($product->main_discount/100));
                        }else{
                            $price = $product->main_price;
                        }
                        $cart_item->update([
                            "quantity" => $qty,
                            "price" => $price * $qty,
                            "product_color_size_id" => $productSC->id,
                        ]);
                        return redirect()->route("cart")->with("success", "Product added sussefully");
                    } else {
                        return redirect()->route("error")->with("error", "Sorry! but You have");
                    }
                } else {
                    return redirect()->back()->with("error", "Sorry! but You have filled up the limit for this product. There is no room for more.");
                }
            } else {
                return redirect()->back()->with("error", "This size not avilable for this color");
            }
        } else {
            return redirect()->back()->with("error", "Something is wrong try agian later");
        }
    }
}
