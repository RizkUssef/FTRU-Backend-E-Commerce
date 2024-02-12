<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
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


Route::get('FTRU/Home/Register', [RedirectController::class, 'RegisterForm'])->name('register');
Route::get('FTRU/Home/Login', [RedirectController::class, 'LoginForm'])->name('login');
Route::get('FTRU/Home', [RedirectController::class, 'Index'])->name('home');
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
Route::post('FTRU/Home/Login/Forget Password', [UserController::class, 'forgetPasswordHandle'])->name('forget password handle');
Route::post('FTRU/Home/Login/Reset Password', [UserController::class, 'resetPasswordHandle'])->name('reset password handle');
Route::get('FTRU/Home/{category_name}', [ProductController::class, 'showCate'])->name('show category');
Route::get('FTRU/Home/{category_name}/{subcategory_name}', [ProductController::class, 'showSubCategory'])->name('one subcategory');
Route::get('FTRU/Home/{category_name}/{subcategory_name}/{product_id}', [ProductController::class, 'product'])->name('one product');
Route::get('FTRU/error', [RedirectController::class, 'Error'])->name('error');
Route::get('FTRU/search/{product_id}', [ProductController::class, 'showSearchProduct'])->name('search product');
Route::post('FTRU/Home/search', [ProductController::class, 'search'])->name('search');

// login to dashboard
Route::get("login to dashboard", [AdminController::class, "loginForm"])->name('admin login');
Route::post("adminLogin", [AdminController::class, "handleAdminLogin"])->name('handle admin login');

// profile handle
Route::middleware(['auth', 'userVerified'])->group(function () {
    Route::get('FTRU/User Profile', [UserController::class, 'userProfile'])->name('user_profile');
    Route::get('FTRU/User Profile/Billing Info', [RedirectController::class, 'BillingInfo'])->name('billing_info');
    Route::get('FTRU/User Profile/Order History', [RedirectController::class, 'OrderHistory'])->name('order_history');
    Route::get('FTRU/User Profile/Your Cart', [CartController::class, 'Cart'])->name('cart');
    Route::get('FTRU/User Profile/edit presonal information', [UserController::class, 'editPersonalInfo'])->name('edit personal info');
    Route::get('FTRU/User Profile/edit cart/{product_id}/{cart_item_id}', [CartController::class, 'editCart'])->name('edit cart');
    Route::get('FTRU/Profile/Your Cart/Payment/order all', [OrderController::class, 'allOrder'])->name('all order');
    Route::post('FTRU/Profile/Your Cart/Payment', [OrderController::class, 'allOrderHandle'])->name('all order handle');
    Route::get('FTRU/Profile/Your Cart/Payment/order one/{cart_item_id}/{productCS_id}', [OrderController::class, 'oneOrder'])->name('one order');
    Route::post('FTRU/Profile/Your Cart/Order/{cartItem_id}/{productcs_id}', [OrderController::class, 'oneOrderHandle'])->name('one order handle');
    Route::delete('FTRU/User Profile/Your wishlist/delete all from wishlist', [WishlistController::class, 'deleteAllFromWishlist'])->name('remove all from wishlist');
    Route::delete('FTRU/User Profile/Your Cart/delete all from cart', [CartController::class, 'deleteAllFromCart'])->name('remove all from cart');
    Route::get('FTRU/User Profile/wishlist', [WishlistController::class, 'wishlist'])->name('wishlist');
    Route::get('FTRU/User Profile/add all wishlist', [WishlistController::class, 'addAllToCartFromWishlist'])->name('add All To CartFromWishlist');
    Route::get('FTRU/Logout', [UserController::class, 'logout'])->name('logout');
    Route::put('FTRU/User Profile/edit presonal information', [UserController::class, 'handleEditPersonalInfo'])->name('handle edit personal info');
    Route::put('FTRU/User Profile/edit cart/{cart_item_id}', [CartController::class, 'handleEditCart'])->name('handle edit cart');
    Route::delete('FTRU/Home/remove from cart/{cart_item_id}', [CartController::class, 'deleteCart'])->name('remove from cart');
    Route::delete('FTRU/Home/remove from wishlist/{wishlist_item_id}', [WishlistController::class, 'deleteWishlist'])->name('remove from wishlist');
    Route::post('FTRU/Home/add to cart', [CartController::class, 'addToCart'])->name('add to cart');
    Route::post('FTRU/Home/add to wishlist', [WishlistController::class, 'addToWishlist'])->name('add to wishlist');
    Route::post('FTRU/Home/add wishlist to cart', [WishlistController::class, 'addWishlistToCart'])->name('add wishlist to cart');
    Route::post('FTRU/Home/rate', [ProductController::class, 'rateProduct'])->name('rating');
    
});

// admin
Route::middleware(['adminDashboard'])->group(function () {
    Route::get('logout', [AdminController::class, 'logout'])->name('dashboard logout');
    Route::get("Dashboard", [AdminController::class, "dashboard"])->name('dash');
    Route::get("Category/add category", [AdminController::class, "categoryForm"])->name('add category');
    Route::get("Category/add subcategory", [AdminController::class, "subCategoryForm"])->name('add subcategory');
    Route::get("Category/all categories", [AdminController::class, "allCategories"])->name("allcate");
    Route::get("Category/Show all Category/One Category/{category_id}", [AdminController::class, "oneCategory"])->name("Show_one category");
    Route::get("Category/Show all Category/One subCategory/{category_id}/{subcategory_id}", [AdminController::class, "oneSubCategory"])->name("Show_one subcategory");
    Route::get('Category/add a new product/{category_id}/{subcategory_id}', [AdminController::class, 'productForm'])->name('Add new product');
    Route::get('Category/One Product/{category_id}/{subcategory_id}/{product_id}', [AdminController::class, 'oneProduct'])->name('Show_one product');
    Route::get("Category/add a new color & size product/{category_id}/{subcategory_id}/{product_id}", [AdminController::class, "productColorSizeForm"])->name("Add new CS to product");
    Route::get('Custmers', [AdminController::class, 'allCustomer'])->name('all customers');
    Route::get('Orders', [AdminController::class, 'allOrders'])->name('all orders');
    Route::get('Category/edit main product/{category_id}/{subcategory_id}/{product_id}', [AdminController::class, 'editMainProduct'])->name('edit main product');
    Route::get('Category/edit sub product/{category_id}/{subcategory_id}/{product_id}/{productColor_id}/{productSize_id}/{productCS_id}', [AdminController::class, 'editSubProduct'])->name('edit sub product');
    Route::post("add category handle", [AdminController::class, "addCategoryHandle"])->name('handle add category');
    Route::post("add subcategory handle", [AdminController::class, "addSubCategoryHandle"])->name('handle add subcategory');
    Route::post("Category/add a new product/{category_id}/{subcategory_id}", [AdminController::class, "productFormHandle"])->name("handle add product");
    Route::post('Category/add a new color & size product handle/{category_id}/{subcategory_id}/{product_id}', [AdminController::class, 'productSizeColorFormHandle'])->name('handel add new CS to product');
    Route::delete('deleteProduct/{category_id}/{subcategory_id}/{product_id}', [AdminController::class, 'deleteMainProduct'])->name('deleteProduct');
    Route::delete('Category/remove product color size/{category_id}/{subcategory_id}/{product_id}/{productColor_id}/{productSize_id}/{productCS_id}', [AdminController::class, 'deleteProductCS'])->name('remove product color size');
    Route::put('Category/edit main product/{category_id}/{subcategory_id}/{product_id}', [AdminController::class, 'mainProductEditHandle'])->name('edit main product handle');
    Route::put('Category/edit sub product handle/{category_id}/{subcategory_id}/{product_id}/{productColor_id}/{productSize_id}/{productCS_id}', [AdminController::class, 'editSubProductHandle'])->name('edit sub handle product');
    Route::post("show search", [AdminController::class, "adminSearch"])->name('show search');
    // order
    Route::get('show all order', [AdminController::class, "adminOrderHistory"])->name('show all order');
    Route::get('one order/{order_id}', [AdminController::class, "adminOneOrder"])->name("admin one order");
    Route::get('edit one order/{order_id}', [AdminController::class, "adminEditOrder"])->name("edit one order");
    Route::put('handle edit one order/{order_id}', [AdminController::class, "adminEditOrderHandle"])->name("handle edit one order");
});

// wrong route
Route::fallback(function () {
    return redirect()->route('error')->with("error", "Oops! It seems like you've reached an incorrect destination");
});

// admin show

Route::get("order", function () {
    return view('pages.Profile.order_details');
});

Route::get("receipt", function () {
    return view('pages.Mails.your_receipt');
});

Route::get('FTRU/order Details/{order_id}', [OrderController::class, 'showOrderDetails'])->name('order details');
Route::get('FTRU/Payment/{order_id}',[OrderController::class,'paymentPage'])->name('payment page');

Route::get('gt',function(){
    return view('pages.Success.check_your_email');
});


// ! join try
// Route::get('go',[AdminController::class,"joinTry"]);
Route::get('kola',[AdminController::class,"GG"]);
