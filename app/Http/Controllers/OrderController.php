<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Address;
use App\Models\Country;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Support\Str;
use App\Models\ProductColor;
use App\Models\ProductColorSize;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AllOrderRequest;
use App\Models\OrderDetail;
use App\Models\ProductSize;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function allOrder()
    {
        $user = Auth::user();
        if ($user->user_type) {
            $cart = Cart::where('user_id', $user->id)->first();
            $cart_item = CartItem::where('cart_id', $cart->id)->get();
            $pro = [];
            foreach ($cart_item as $cartItem) {
                $proCS = ProductColorSize::where('id', $cartItem->product_color_size_id)->first();
                $proC = ProductColor::where('id', $proCS->product_colors_id)->first();
                $proCheak = Product::where('id', $proC->product_id)->first();
                if ($proCheak->delete_status =='Yes') {
                    $cartItem->delete();
                }else{
                    $pro[]=$proCheak;
                }
            }
            $countries = Country::orderBy('name', 'asc')->get();
            return view('pages.Forms.all_order', compact("countries", "pro", 'cart_item'));
        } else {
            return redirect()->route('login');
        }
    }

    public function allOrderHandle(AllOrderRequest $request)
    {
        $user = Auth::user();
        if ($user) {
            if ($user->user_type == 1) {
                $cart = Cart::where('user_id', $user->id)->first();
                $cart_item = CartItem::where('cart_id', $cart->id)->get();

                $order_code = "#" . Str::random(6);
                $sub_total = $cart_item->sum('price');
                $quantity = $cart_item->sum('quantity');
                $tax = 0.10;
                $shipping = 150;
                if ($quantity < 5) {
                    $discount = 10;
                } else {
                    $discount = 25;
                }
                $discount_total = $sub_total - ($sub_total * ($discount / 100));
                $tax_total = $sub_total * $tax;
                $total = $shipping + $tax_total + $discount_total;


                $address = Address::updateOrCreate(
                    [
                        'user_id' => $user->id,
                    ],
                    [
                        'country_id' => $request->country_id,
                        'state' => $request->state,
                        'city' => $request->city,
                        'street_number' => $request->street_number,
                        'address_line1' => $request->address_line1,
                        'address_line2' => $request->address_line2,
                        'unit_number' => $request->unit_number,
                        'user_id' => $user->id,
                    ]
                );
                $order = Order::create([
                    "order_code" => $order_code,
                    "email" => $request->email,
                    "phone" => $request->phone,
                    "sub_total" => $sub_total,
                    "discount" => $discount,
                    "tax" => $tax_total,
                    "shipping" => $shipping,
                    "total" => $total,
                    "quantity" => $quantity,
                    "status" => "pending",
                    "user_id" => $user->id,
                    "address_id" => $address->id,
                ]);
                foreach ($cart_item as $cartItem) {
                    $productcs = ProductColorSize::find($cartItem->product_color_size_id);
                    $quantity_after_order = ($productcs->quantity) - ($cartItem->quantity);
                    $productcs->update([
                        'quantity' => $quantity_after_order
                    ]);
                    $order_details = OrderDetail::create([
                        'order_id' => $order->id,
                        'quantity' => $cartItem->quantity,
                        'product_color_size_id' => $productcs->id,
                    ]);
                    $cartItem->delete();
                }
                // return redirect()->route('cart')->with('success', "your order is shipped");
                // return view('pages.Profile.order_details',compact(['order_details','productcs','order']))->with('success', 'your orders are shipped');
                return redirect()->route('order details', ['order_id' => encrypt($order->id)])->with('success', 'your orders are shipped');
            } else {
                return redirect()->route('register');
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function oneOrder($cart_item_id, $productCS_id)
    {
        $user = Auth::user();
        if ($user->user_type) {
            $cart = Cart::where('user_id', $user->id)->first();
            $cart_item = CartItem::where('id', $cart_item_id)->where("product_color_size_id", $productCS_id)->where('cart_id', $cart->id)->first();
            if ($cart_item) {
                $proCS = ProductColorSize::where('id', $productCS_id)->first();
                $proC = ProductColor::where('id', $proCS->product_colors_id)->first();
                $pro = Product::where('id', $proC->product_id)->where('delete_status','No')->first();
                // dd($pro);
                $countries = Country::orderBy('name', 'asc')->get();
                return view('pages.Forms.one_order', compact("countries", "pro", 'cart_item'));
            } else {
                return redirect()->back()->with('error', "you don't have this product in cart");
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function oneOrderHandle(AllOrderRequest $request, $cartItem_id, $productcs_id)
    {
        $user = Auth::user();
        if ($user) {
            if ($user->user_type == 1) {
                $user_cart = $user->userCart;
                $cart_item = CartItem::where('id', $cartItem_id)
                    ->where('cart_id', $user_cart->id)
                    ->where('product_color_size_id', $productcs_id)
                    ->first();
                if ($cart_item) {
                    $order_code = '#' . Str::random(6);
                    $sub_total = $cart_item->price;
                    $quantity = $cart_item->quantity;
                    $tax = 0.10;
                    $shipping = 150;
                    if ($quantity < 2) {
                        $discount = 5;
                    } else {
                        $discount = 10;
                    }
                    $discount_total = $sub_total - ($sub_total * ($discount / 100));
                    $tax_total = $sub_total * $tax;
                    $total = $shipping + $tax_total + $discount_total;
                    $address = Address::updateOrCreate(
                        [
                            'user_id' => $user->id,
                        ],
                        [
                            'unit_number' => $request->unit_number,
                            'street_number' => $request->street_number,
                            'address_line1' => $request->address_line1,
                            'address_line2' => $request->address_line2,
                            'city' => $request->city,
                            'state' => $request->state,
                            'user_id' => $user->id,
                            'country_id' => $request->country_id,
                        ]
                    );
                    $order = Order::create([
                        'order_code' => $order_code,
                        'email' => $request->email,
                        'phone' => $request->phone,
                        'quantity' => $quantity,
                        'sub_total' => $sub_total,
                        'discount' => $discount,
                        'tax' => $tax_total,
                        'shipping' => $shipping,
                        'total' => $total,
                        'status' => 'processing',
                        'user_id' => $user->id,
                        'address_id' => $address->id,
                    ]);
                    $productcs = ProductColorSize::find($cart_item->product_color_size_id);
                    $quantity_after_order = $productcs->quantity - $cart_item->quantity;
                    $productcs->update([
                        'quantity' => $quantity_after_order
                    ]);
                    $order_details = OrderDetail::create([
                        'order_id' => $order->id,
                        'quantity' => $quantity,
                        'product_color_size_id' => $productcs->id,
                    ]);
                    $cart_item->delete();

                    return redirect()->route('order details', ['order_id' => encrypt($order->id)]);
                } else {
                    return redirect()->back()->with("error", "this product is not exisit in your cart");
                }
            } else {
                return redirect()->route('register')->with('error', "Create your Account First");
            }
        } else {
            return redirect()->route('login')->with('error', 'You Must Login First');
        }
    }

    public function showOrderDetails($order_id)
    {
        $user = Auth::user();
        if ($user) {
            if ($user->user_type == 1) {
                $address = Address::where('user_id', $user->id)->first();
                $order = Order::where('id', decrypt($order_id))
                    ->where('user_id', $user->id)
                    ->where('address_id', $address->id)
                    ->first();
                if ($order) {
                    return view('pages.Profile.order_details', compact('order'));
                } else {
                    return redirect()->route('error')->with('error', "something is wrong");
                }
            } else {
                return redirect()->route('register')->with('error', "Create your Account First");
            }
        } else {
            return redirect()->route('login')->with('error', 'You Must Login First');
        }
    }

    public function paymentPage($order_id)
    {
        $user = Auth::user();
        if ($user) {
            if ($user->user_type == 1) {
                $address = Address::where('user_id', $user->id)->first();
                $order = Order::where('id', decrypt($order_id))
                    ->where('user_id', $user->id)
                    ->where('address_id', $address->id)
                    ->first();
                if ($order) {
                    // $data["email"]=$user->email;
                    // $data["order"]=$order;
                    Mail::send('pages.Mails.your_receipt', ['order' => $order], function ($message) use ($order) {
                        $message->to($order->email);
                        $message->subject('Receipt');
                    });
                    return view("pages.payment.payment");
                    // return view('pages.Profile.order_details',compact('order'));
                } else {
                    return redirect()->route('error')->with('error', "something is wrong");
                }
            } else {
                return redirect()->route('register')->with('error', "Create your Account First");
            }
        } else {
            return redirect()->route('login')->with('error', 'You Must Login First');
        }
    }
}
