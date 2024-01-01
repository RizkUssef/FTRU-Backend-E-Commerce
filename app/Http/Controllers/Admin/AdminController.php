<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductSize;
use App\Models\SubCategory;
use Illuminate\Support\Str;
use App\Models\ProductColor;
use Illuminate\Http\Request;
use App\Models\ProductColorSize;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\AddProductRequest;
use App\Http\Requests\Admin\LoginAdminRequest;
use App\Http\Requests\Admin\AddCategoryRequest;
use App\Http\Requests\Admin\AddProductColorSizeRequest;
use App\Http\Requests\Admin\AddSubCategoryRequest;
use App\Models\Order;
use App\Models\Visitor;

class AdminController extends Controller
{
    // login page
    public function loginForm()
    {
        return view('Dashboard.Forms.login');
    }

    // login handle admin
    public function handleAdminLogin(LoginAdminRequest $request)
    {
        $is_login = Auth::attempt(["email" => $request->email, "password" => $request->password]);
        if ($is_login) {
            $user = User::where("email", $request->email)->where("user_type", "=", "0")->first();
            if ($user) {
                $admin = User::where("email", $request->email)->first();
                return redirect()->route("dash");
            } else {
                return redirect()->route('error')->with(["error" => "you don't allow to access this page"]);
            }
        } else {
            return redirect()->back()->with(["error" => "Wrong credentials invalid email or password"]);
        }
    }

    // dashboard page
    public function dashboard()
    {
        $allProduct = Product::count();
        $allCust = User::where('user_type','1')->count();
        $allOrder = Order::count();
        $allVisitors = Visitor::where("id",1)->first();
        $visitorCount = $allVisitors->count;
        return view('Dashboard.dashboard',compact('allProduct','allCust','allOrder','visitorCount'));
    }

    public function categoryForm()
    {
        return view('Dashboard.Forms.add_category');
    }

    public function addCategoryHandle(AddCategoryRequest $request)
    {
        $is_login = Auth::user();
        if ($is_login) {
            $admin = User::where("email", $is_login->email)->where("user_type", "=", "0")->first();
            if ($admin) {
                Category::create([
                    "name" => $request->name,
                ]);
                return redirect()->back()->with(['success' => "added sussfully"]);
            } else {
                // return redirect()->route('error')->with(["error" => "you don't allow to access this page"]);
                return abort(404);
            }
        } else {
            return redirect()->route('admin login')->with(['error' => 'you must login first']);
        }
    }

    public function subCategoryForm()
    {
        $cate_name = Category::all();
        return view('Dashboard.Forms.add_Subcategory', compact("cate_name"));
    }

    public function addSubCategoryHandle(AddSubCategoryRequest $request)
    {
        $is_login = Auth::user();
        if ($is_login) {
            $admin = User::where("email", $is_login->email)->where("user_type", "=", "0")->first();
            if ($admin) {
                $subCate = SubCategory::where('name', 'like', "%$request->name%")->where("category_id", $request->category_id)->first();
                if ($subCate) {
                    return redirect()->back()->with(['error' => "this subcategory is aleardy exisit"]);
                } else {
                    SubCategory::create([
                        "name" => $request->name,
                        "category_id" => $request->category_id
                    ]);
                    return redirect()->back()->with(['success' => "added sussfully"]);
                }
            } else {
                return abort(404);
            }
        } else {
            return redirect()->route('admin login')->with(['error' => 'you must login first']);
        }
    }

    public function allCategories()
    {
        return view('Dashboard.Show All.all_category');
    }
// changed
    public function oneCategory($category_id)
    {
        $category = Category::where('id', decrypt($category_id))->first();
        if ($category) {
            $subCates = $category->categorySubcategory()->paginate(6);
            return view('Dashboard.Show All.one_category', compact('category','subCates'));
        } else {
            return redirect()->route('Error')->with("error", "Something's going Wrong");
        }
    }
// changed
    public function oneSubCategory($category_id, $subcategory_id)
    {
        $category = Category::where('id', decrypt($category_id))->first();
        if ($category) {
            $subcategory = SubCategory::where('id', decrypt($subcategory_id))->with('subcategoryProduct')->first();
            if ($subcategory) {
                // added
                $products = $subcategory->subcategoryProduct()->paginate(6);
                return view('Dashboard.Show All.one_subcategory', compact('category', 'subcategory',"products"));
            } else {
                return redirect()->route('Error')->with("error", "Something's going Wrong");
            }
        } else {
            return redirect()->route('Error')->with("error", "Something's going Wrong");
        }
    }

    public function productForm($category_id, $subcategory_id)
    {
        $category = Category::where('id', $category_id)->first();
        if ($category) {
            $subcategory = SubCategory::where('id', decrypt($subcategory_id))->where('category_id', $category_id)->first();
            if ($subcategory) {
                return view('Dashboard.Forms.add_Products', compact('category', 'subcategory'));
            } else {
                return redirect()->route('Error')->with("error", "Something's going Wrong");
            }
        } else {
            return redirect()->route('Error')->with("error", "Something's going Wrong");
        }
    }

    public function productFormHandle($category_id, $subcategory_id, AddProductRequest $request)
    {
        $is_login = Auth::user();
        if ($is_login) {
            $admin = User::where('user_type', '0')->where('email', $is_login->email)->first();
            if ($admin) {
                $category = Category::where('id', decrypt($category_id))->first();
                if ($category) {
                    $subcategory = SubCategory::where('id', decrypt($subcategory_id))
                        ->where('category_id', decrypt($category_id))
                        ->first();
                    if ($subcategory) {
                        $is_product_exist = Product::where("product_code", $request->product_code)->first();
                        if (!$is_product_exist) {
                            $cate = $category->name;
                            $subCate = $subcategory->name;
                            $product_image = Storage::putFile("$cate" . "/" . "$subCate" . " Products", $request->image);
                            $product = Product::create([
                                "name" => $request->name,
                                "image" => $product_image,
                                "main_price" => $request->main_price,
                                "main_discount" => $request->main_discount,
                                "product_code" => $request->product_code,
                                "status" => $request->status,
                                "sub_category_id" => $subcategory->id,
                            ]);
                            $color = ProductColor::create([
                                "product_id" => $product->id,
                                "color" => $request->color,
                            ]);
                            $size = ProductSize::create([
                                "product_id" => $product->id,
                                "size" => $request->main_size,
                            ]);
                            $product_color_size = ProductColorSize::create([
                                "product_sizes_id" => $size->id,
                                "product_colors_id" => $color->id,
                                "quantity" => $request->quantity,
                                "image" => $product_image,
                            ]);
                            return redirect()->route('Show_one subcategory', ["category_id" => encrypt($category->id), "subcategory_id" => encrypt($subcategory->id)]);
                        } else {
                            return redirect()->route('error')->with('error', 'This Product already Exist');
                        }
                    } else {
                        return redirect()->route('error')->with("error", "Something's going Wrong");
                    }
                } else {
                    return redirect()->route('error')->with("error", "Something's going Wrong");
                }
            } else {
                abort(404);
            }
        } else {
            return redirect()->route('adminlogin')->with('error', 'You Must Login First');
        }
    }

    public function oneProduct($category_id, $subcategory_id, $product_id)
    {
        $category = Category::where('id', decrypt($category_id))->first();
        if ($category) {
            $subcategory = SubCategory::where('id', decrypt($subcategory_id))->where('category_id', decrypt($category_id))->first();
            if ($subcategory) {
                $product = Product::where('id', decrypt($product_id))->where('sub_category_id', decrypt($subcategory_id))->first();
                if ($product) {
                    return view('Dashboard.Show All.one_product', compact('category', 'subcategory', 'product'));
                } else {
                    return redirect()->route('error')->with("error", "Something's going Wrong");
                }
            } else {
                return redirect()->route('error')->with("error", "Something's going Wrong");
            }
        } else {
            return redirect()->route('error')->with("error", "Something's going Wrong");
        }
    }

    public function productColorSizeForm($category_id, $subcategory_id, $product_id)
    {
        $category = Category::where('id', decrypt($category_id))->first();
        if ($category) {
            $subcategory = SubCategory::where('id', decrypt($subcategory_id))->where('category_id', decrypt($category_id))->first();
            if ($subcategory) {
                $product = Product::where('id', decrypt($product_id))->where('sub_category_id', decrypt($subcategory_id))->first();
                if ($product) {
                    return view('Dashboard.Forms.add_color_size', compact('category', 'subcategory', 'product'));
                } else {
                    return redirect()->route('error')->with("error", "Something's going Wrong");
                }
            } else {
                return redirect()->route('error')->with("error", "Something's going Wrong");
            }
        } else {
            return redirect()->route('error')->with("error", "Something's going Wrong");
        }
    }

    public function productSizeColorFormHandle($category_id, $subcategory_id, $product_id, AddProductColorSizeRequest $request)
    {
        $is_login = Auth::user();
        if ($is_login) {
            $admin = User::where('user_type', '0')->where('email', $is_login->email)->first();
            if ($admin) {
                $category = Category::where('id', decrypt($category_id))->first();
                if ($category) {
                    $subcategory = SubCategory::where('id', decrypt($subcategory_id))
                        ->where('category_id', decrypt($category_id))
                        ->first();
                    if ($subcategory) {
                        $is_product_exist = Product::where("id", decrypt($product_id))->where('sub_category_id', decrypt($subcategory_id))->where("product_code", $request->product_code)->first();
                        if ($is_product_exist) {
                            $cate = $category->name;
                            $subCate = $subcategory->name;
                            $product_image = Storage::putFile("$cate" . "/" . "$subCate" . " Products", $request->image);
                            $color = ProductColor::updateOrCreate(
                                [
                                    "product_id" => $is_product_exist->id,
                                    "color" => $request->color,
                                ],
                                [
                                    "product_id" => $is_product_exist->id,
                                    "color" => $request->color,
                                ]
                            );
                            $size = ProductSize::updateOrCreate(
                                [
                                    "product_id" => $is_product_exist->id,
                                    "size" => $request->size,
                                ],
                                [
                                    "product_id" => $is_product_exist->id,
                                    "size" => $request->size,
                                ]
                            );
                            $product_color_size = ProductColorSize::updateOrCreate(
                                [
                                    "product_sizes_id" => $size->id,
                                    "product_colors_id" => $color->id,
                                ],
                                [
                                    "product_sizes_id" => $size->id,
                                    "product_colors_id" => $color->id,
                                    "quantity" => $request->quantity,
                                    "image" => $product_image,
                                ]
                            );
                            return redirect()->route('Show_one subcategory', ["category_id" => encrypt($category->id), "subcategory_id" => encrypt($subcategory->id)]);
                        } else {
                            return redirect()->route('error')->with('error', 'This Product not Exist');
                        }
                    } else {
                        return redirect()->route('error')->with("error", "Something's going Wrong");
                    }
                } else {
                    return redirect()->route('error')->with("error", "Something's going Wrong");
                }
            } else {
                abort(404);
            }
        } else {
            return redirect()->route('adminlogin')->with('error', 'You Must Login First');
        }
    }

    public function allCustomer()
    {
        $allCust = User::where('user_type','1')->paginate(6);
        return view('Dashboard.Show All.all_customers', compact("allCust"));
    }


}
