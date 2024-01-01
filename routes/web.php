<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// index page
Route::get('FTRU/Home', [RedirectController::class, 'Index'])->name('home');
// user register 
Route::get('FTRU/Home/Register', [RedirectController::class, 'RegisterForm'])->name('register');
Route::get('FTRU/Home/Login', [RedirectController::class, 'LoginForm'])->name('login');
Route::get('FTRU/Home/Login/Forget Password', [RedirectController::class, 'ForgetPasswordForm'])->name('forget_pass');
Route::get('FTRU/User Profile/Change Password', [RedirectController::class, 'ChangePasswordForm'])->name('change_pass');
Route::get('FTRU/Otp', [RedirectController::class, 'OtpForm'])->name('otp');
Route::get('FTRU/Rest Password', [RedirectController::class, 'RestPasswordForm'])->name('rest_pass');
Route::get('FTRU/resend the OTP', [UserController::class, 'resendOTP'])->name('resend otp');
Route::get('FTRU/Login/Reset your Password/{token}', [UserController::class, 'reset_password'])->name('Reset password');
Route::post('FTRU/User Profile/Change Password', [UserController::class, 'changePasswordHandle'])->name('handle_change_pass');
Route::post('FTRU/Otp', [UserController::class, 'handleOTP'])->name('verfiy handle');
Route::post('FTRU/Home/Register', [UserController::class, 'handleRegister'])->name('handle_register');
Route::post('FTRU/Home/Login', [UserController::class, 'handleLogin'])->name('login handle');
Route::get('FTRU/Logout', [UserController::class, 'logout'])->name('logout');
Route::post('FTRU/Home/Login/Forget Password', [UserController::class, 'forgetPasswordHandle'])->name('forget password handle');
Route::post('FTRU/Home/Login/Reset Password', [UserController::class, 'resetPasswordHandle'])->name('reset password handle');

// show products
Route::get('FTRU/Home/{category_name}', [ProductController::class, 'showCate'])->name('show category');
Route::get('FTRU/Home/{category_name}/{subcategory_name}', [ProductController::class, 'showSubCategory'])->name('one subcategory');
Route::get('FTRU/Home/{category_name}/{subcategory_name}/{product_id}', [ProductController::class, 'product'])->name('one product');

// not found page
Route::get('FTRU/error', [RedirectController::class, 'Error'])->name('error');

// profile handle &
Route::get('FTRU/User Profile', [UserController::class, 'userProfile'])->name('user_profile');
Route::get('FTRU/User Profile/Billing Info', [RedirectController::class, 'BillingInfo'])->name('billing_info');
Route::get('FTRU/User Profile/Order History', [RedirectController::class, 'OrderHistory'])->name('order_history');
Route::get('FTRU/User Profile/Your Cart', [CartController::class, 'Cart'])->name('cart');
Route::get('FTRU/User Profile/edit presonal information', [UserController::class, 'editPersonalInfo'])->name('edit personal info');
Route::get('FTRU/User Profile/edit cart/{product_id}/{cart_item_id}', [CartController::class, 'editCart'])->name('edit cart');
Route::get('FTRU/Home/Profile/Your Cart/Payment', [RedirectController::class, 'PaymentForm'])->name('payment');
Route::put('FTRU/User Profile/edit presonal information', [UserController::class, 'handleEditPersonalInfo'])->name('handle edit personal info');
Route::put('FTRU/User Profile/edit cart/{cart_item_id}', [CartController::class, 'handleEditCart'])->name('handle edit cart');
Route::delete('FTRU/Home/remove from cart/{cart_item_id}', [CartController::class, 'deleteCart'])->name('remove from cart');
Route::delete('FTRU/Home/remove from wishlist/{wishlist_item_id}', [WishlistController::class, 'deleteWishlist'])->name('remove from wishlist');
Route::post('FTRU/Home/add to cart', [CartController::class, 'addToCart'])->name('add to cart');
Route::post('FTRU/Home/add to wishlist', [WishlistController::class, 'addToWishlist'])->name('add to wishlist');
Route::get('FTRU/User Profile/wishlist', [WishlistController::class, 'wishlist'])->name('wishlist');
Route::post('FTRU/Home/add wishlist to cart', [WishlistController::class, 'addWishlistToCart'])->name('add wishlist to cart');
Route::get('FTRU/User Profile/add all wishlist', [WishlistController::class, 'addAllToCartFromWishlist'])->name('add All To CartFromWishlist');

// search
Route::post('FTRU/Home/search',[ProductController::class,'search'])->name('search');
Route::get('FTRU/search/{product_id}', [ProductController::class, 'showSearchProduct'])->name('search product');
// rate
Route::post('FTRU/Home/rate',[ProductController::class,'rateProduct'])->name('rating');
// wrong route
Route::fallback(function(){
    return redirect()->route('error')->with("error","Oops! It seems like you've reached an incorrect destination");
});

Route::get("dashboard",[AdminController::class,"dashboard"])->name('dash');

Route::get("login to dashboard",[AdminController::class,"loginForm"])->name('admin login');
Route::post("adminLogin",[AdminController::class,"handleAdminLogin"])->name('handle admin login');

Route::get("Dashboard/add category",[AdminController::class,"categoryForm"])->name('add category');
Route::post("add category handle",[AdminController::class,"addCategoryHandle"])->name('handle add category');

Route::get("Dashboard/add subcategory",[AdminController::class,"subCategoryForm"])->name('add subcategory');
Route::post("add subcategory handle",[AdminController::class,"addSubCategoryHandle"])->name('handle add subcategory');

Route::get("all categories",[AdminController::class,"allCategories"])->name("allcate");
//show one categorty
Route::get("Dashboard/Show all Category/One Category/{category_id}", [AdminController::class, "oneCategory"])->name("Show_one category");
//show one subcategory
Route::get("Dashboard/Show all Category/One subCategory/{category_id}/{subcategory_id}", [AdminController::class, "oneSubCategory"])->name("Show_one subcategory");
// Route::get("all customer",[AdminController::class,"allCustomer"])->name("all customer");

// add product
Route::get('Dashboard/add a new product/{category_id}/{subcategory_id}',[AdminController::class, 'productForm'])->name('Add new product');
Route::post("Dashboard/add a new product/{category_id}/{subcategory_id}",[AdminController::class,"productFormHandle"])->name("handle add product");

// show one product 
Route::get('Dashboard/One Product/{category_id}/{subcategory_id}/{product_id}',[AdminController::class, 'oneProduct'])->name('Show_one product');

Route::get("Dashboard/add a new color & size product/{category_id}/{subcategory_id}/{product_id}",[AdminController::class,"productColorSizeForm"])->name("Add new CS to product");
Route::post('add a new color & size product handle/{category_id}/{subcategory_id}/{product_id}',[AdminController::class, 'productSizeColorFormHandle'])->name('handel add new CS to product');

Route::get('Dashboard/all Custmers',[AdminController::class, 'allCustomer'])->name('all customers');