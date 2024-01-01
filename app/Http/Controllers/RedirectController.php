<?php

namespace App\Http\Controllers;

use App\Events\PageVisited;
use App\Models\Cart;
use App\Models\Country;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductColor;
use App\Models\ProductColorSize;
use App\Models\SubCategory;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectController extends Controller
{
    // !index
    public function Index(){
        $countDate = Visitor::where("id",1)->first();
        $count = $countDate->count;
        PageVisited::dispatch($count);
        return view('index');
    }

    // !men
    public function Men(){
        return view('pages.All Products.man_products');
    }

    // !woman
    public function Woman(){
        return view('pages.All Products.woman_prouducts');
    }

    // !kids
    public function Kids(){
        return view('pages.All Products.kids_products');
    }

    // !bags
    public function Bags(){
        return view('pages.All Products.bags_products');
    }

    // !accessories
    public function Accessories(){
        return view('pages.All Products.accessories_products');
    }

    // !error
    public function Error(){
        return view('pages.errors.error');
    }

    // !show one product
    public function showOne(){
        return view('pages.One Product.one_product');
    }
    
    // !change password
    public function ChangePasswordForm(){
        return view('pages.Forms.change_password');
    }

    // !forgrt password
    public function ForgetPasswordForm(){
        return view('pages.Forms.forget_password');
    }

    // !login
    public function LoginForm(){
        return view('pages.Forms.login');
    }

    // !otp
    public function OtpForm(){
        return view('pages.Forms.otp');
    }

    // !payment
    public function PaymentForm(){
        $countries = Country::orderBy('name', 'asc')->get();
        return view('pages.Forms.payment',compact("countries"));
    }

    // !register
    public function RegisterForm(){
        $countries = Country::orderBy('name', 'asc')->get();
        return view('pages.Forms.register',compact("countries"));
    }

    // !rest password
    public function RestPasswordForm(){
        return view('pages.Forms.reset_password');
    }

    // !billing info
    public function BillingInfo(){
        return view('pages.Profile.billing_info');
    }

    // !cart
    public function Cart(){
        $user = Auth::user();
        if($user){
            $user_cart =$user->userCart;
            if($user_cart){
                $all_product = $user_cart->cartCItem;
                return view('pages.Profile.cart',compact('all_product'));
            }else {
                return redirect()->back()->with("error","you don't have any product in your cart yet");
            }
        }else{
            return redirect()->route('login')->with("error","you must login first");
        }
    }

    // !order history
    public function OrderHistory(){
        return view('pages.Profile.order_history');
    }

    // !personal info
    public function Profile(){
        return view('pages.Profile.personal_info');
    }

    // !success
    public function Success(){
        return view('pages.Success.check_your_email');
    }

    // !edit
    public function editcart(){
        return view('pages.Profile.edit_cart');
    }

}
