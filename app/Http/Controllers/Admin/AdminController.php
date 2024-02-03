<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Order;
use App\Models\Review;
use App\Models\Product;
use App\Models\Visitor;
use App\Models\Category;
use App\Models\ProductSize;
use App\Models\SubCategory;
use App\Models\ProductColor;
use Illuminate\Http\Request;
use App\Models\ProductColorSize;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\AddProductRequest;
use App\Http\Requests\Admin\LoginAdminRequest;
use App\Http\Requests\Admin\AddCategoryRequest;
use App\Http\Requests\Admin\AddSubCategoryRequest;
use App\Http\Requests\Admin\EditSubProductRequest;
use App\Http\Requests\Admin\EditMainProductRequest;
use App\Http\Requests\Admin\AddProductColorSizeRequest;
use App\Http\Requests\Admin\EditOrderRequest;

class AdminController extends Controller
{

    public function loginForm()
    {
        return view('Dashboard.Forms.login');
    }

    public function handleAdminLogin(LoginAdminRequest $request)
    {
        $is_login = Auth::attempt(["email" => $request->email, "password" => $request->password]);
        if ($is_login) {
            $admin = User::where("email", $request->email)->first();
            if ($admin) {
                return redirect()->route("dash");
            } else {
                return redirect()->back()->with(["error" => "you don't allow access this page"]);
            }
        } else {
            return redirect()->back()->with(["error" => "You're not to access here"]);
        }
    }

    public function dashboard()
    {
        $allProduct = Product::all();
        $allCust = User::where('user_type', '1')->orderBy('created_at', 'desc')->take(5)->get();
        $allOrder = Order::orderBy('created_at', 'desc')->take(5)->get();
        $allVisitors = Visitor::where("id", 1)->first();
        $allRev = Review::latest('created_at')->groupBy('user_id')->limit(5)->get();
        return view('Dashboard.dashboard', compact('allProduct', 'allCust', 'allOrder', 'allVisitors', 'allRev'));
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
                return redirect()->back()->with(['success' => "category created sussfully"]);
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
                    return redirect()->back()->with(['success' => " subcategory created sussfully"]);
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
        $categories = Category::paginate(6);
        return view('Dashboard.Show All.all_category', compact('categories'));
    }

    public function oneCategory($category_id)
    {
        $category = Category::where('id', decrypt($category_id))->first();
        if ($category) {
            $subCates = $category->categorySubcategory()->paginate(6);
            return view('Dashboard.Show All.one_category', compact('category', 'subCates'));
        } else {
            return redirect()->route('dash')->with("error", "Something's going Wrong");
        }
    }

    public function oneSubCategory($category_id, $subcategory_id)
    {
        $category = Category::where('id', decrypt($category_id))->first();
        if ($category) {
            $subcategory = SubCategory::where('id', decrypt($subcategory_id))->first();
            if ($subcategory) {
                // added
                $products = $subcategory->subcategoryProduct()->paginate(6);
                return view('Dashboard.Show All.one_subcategory', compact('category', 'subcategory', "products"));
            } else {
                return redirect()->back()->with("error", "Something's going Wrong");
            }
        } else {
            return redirect()->route('dash')->with("error", "Something's going Wrong");
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
                return redirect()->back()->with("error", "This subcategory does not exist");
            }
        } else {
            return redirect()->route('dash')->with("error", "This category does not exist");
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
                            return redirect()->route('Show_one subcategory', ["category_id" => encrypt($category->id), "subcategory_id" => encrypt($subcategory->id)])->with('success', "product created successfully");
                        } else {
                            return redirect()->back()->with('error', 'This Product already Exist');
                        }
                    } else {
                        return redirect()->back()->with("error", "This subcategory does not exist");
                    }
                } else {
                    return redirect()->route('dash')->with("error", "This category does not exist");
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
                    return redirect()->back()->with("error", "This product does not exist");
                }
            } else {
                return redirect()->back()->with("error", "This subcategory does not exist");
            }
        } else {
            return redirect()->route('dash')->with("error", "This category does not exist");
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
                    return redirect()->back()->with("error", "This product does not exist");
                }
            } else {
                return redirect()->back()->with("error", "This subcategory does not exist");
            }
        } else {
            return redirect()->route('dash')->with("error", "This category does not exist");
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

                            $is_color = ProductColor::where('color', $request->color)
                                ->where('product_id', $is_product_exist->id)->first();
                            $is_size = ProductSize::where('size', $request->size)
                                ->where('product_id', $is_product_exist->id)->first();
                            if ($is_color && $is_size) {
                                // dd($is_color);
                                $is_productCS_exist = ProductColorSize::where("product_sizes_id", $is_size->id)
                                    ->where("product_colors_id", $is_color->id)->first();
                                if ($is_productCS_exist) {
                                    return redirect()->route('Show_one product', ["category_id" => encrypt($category->id), "subcategory_id" => encrypt($subcategory->id), "product_id" => encrypt($is_product_exist->id)])->with('error', 'This Product is already Exist');
                                } else {
                                    $product_color_size = ProductColorSize::create([
                                        "product_sizes_id" => $is_size->id,
                                        "product_colors_id" => $is_color->id,
                                        "quantity" => $request->quantity,
                                        "image" => $product_image,
                                    ]);
                                    return redirect()->route('Show_one product', ["category_id" => encrypt($category->id), "subcategory_id" => encrypt($subcategory->id), "product_id" => encrypt($is_product_exist->id)])->with('success', "product created successfully");
                                }
                            } elseif (!$is_color && !$is_size) {
                                $color = ProductColor::create([
                                    "product_id" => $is_product_exist->id,
                                    "color" => $request->color,
                                ]);
                                $size = ProductSize::create([
                                    "product_id" => $is_product_exist->id,
                                    "size" => $request->size,
                                ]);
                                $product_color_size = ProductColorSize::create([
                                    "product_sizes_id" => $size->id,
                                    "product_colors_id" => $color->id,
                                    "quantity" => $request->quantity,
                                    "image" => $product_image,
                                ]);
                                return redirect()->route('Show_one product', ["category_id" => encrypt($category->id), "subcategory_id" => encrypt($subcategory->id), "product_id" => encrypt($is_product_exist->id)])->with('success', "product created successfully");
                            } elseif ($is_color) {
                                $size = ProductSize::create([
                                    "product_id" => $is_product_exist->id,
                                    "size" => $request->size,
                                ]);
                                $product_color_size = ProductColorSize::create([
                                    "product_sizes_id" => $size->id,
                                    "product_colors_id" => $is_color->id,
                                    "quantity" => $request->quantity,
                                    "image" => $product_image,
                                ]);
                                return redirect()->route('Show_one product', ["category_id" => encrypt($category->id), "subcategory_id" => encrypt($subcategory->id), "product_id" => encrypt($is_product_exist->id)])->with('success', "product created successfully");
                            } elseif ($is_size) {
                                $color = ProductColor::create([
                                    "product_id" => $is_product_exist->id,
                                    "color" => $request->color,
                                ]);
                                $product_color_size = ProductColorSize::create([
                                    "product_sizes_id" => $is_size->id,
                                    "product_colors_id" => $color->id,
                                    "quantity" => $request->quantity,
                                    "image" => $product_image,
                                ]);
                                return redirect()->route('Show_one product', ["category_id" => encrypt($category->id), "subcategory_id" => encrypt($subcategory->id), "product_id" => encrypt($is_product_exist->id)])->with('success', "product created successfully");
                            }
                        } else {
                            return redirect()->route('Show_one subcategory', ['category_id' => encrypt($category->id), 'subcategory_id' => encrypt($subcategory->id)])->with('error', 'This Product not Exist');
                        }
                    } else {
                        return redirect()->back()->with("error", "This subcategory does not exist");
                    }
                } else {
                    return redirect()->route('dash')->with("error", "Something's going Wrong");
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
        $allCust = User::where('user_type', '1')->paginate(6);
        return view('Dashboard.Show All.all_customers', compact("allCust"));
    }

    public function logout()
    {
        $user = Auth::user();
        Auth::logout();
        if ($user) {
            $user->save();
        }
        return redirect()->route('admin login');
    }

    public function allOrders()
    {
        return view('Dashboard.Show All.all_orders');
    }

    public function deleteMainProduct($category_id, $subcategory_id, $product_id)
    {
        $user = Auth::user();
        if ($user) {
            $admin = User::where('user_type', '0')->where('email', $user->email)->first();
            if ($admin) {
                $category = Category::where('id', $category_id)->first();
                $subcat = SubCategory::where('id', $subcategory_id)->where('category_id', $category->id)->first();
                if ($subcat) {
                    $product = Product::where('id', decrypt($product_id))->first();
                    foreach ($product->productColor as $productColors) {
                        foreach ($productColors->colorSize as $productCSs) {
                            if ($productCSs->pivot->image != null) {
                                Storage::delete($productCSs->pivot->image);
                            }
                            $productCSs->pivot->delete();
                        }
                        $productColors->delete();
                    }
                    foreach ($product->productSize as $subProductSize) {
                        $subProductSize->delete();
                    }
                    if ($product->image != null) {
                        Storage::delete($product->image);
                        $product->delete();
                    }
                    return redirect()->route('Show_one subcategory', ['category_id' => encrypt($category->id), 'subcategory_id' => encrypt($subcat->id)])->with('success', "product is deleted successfully");
                } else {
                    return redirect()->back()->with("error", "This subcategory does not exist");
                }
            } else {
                abort(404);
            }
        } else {
            return redirect()->route('adminlogin')->with('error', 'You Must Login First');
        }
    }

    public function deleteProductCS($category_id, $subcategory_id, $product_id, $productColor_id, $productSize_id, $productCS_id)
    {
        $user = Auth::user();
        if ($user) {
            $admin = User::where('user_type', '0')->where('email', $user->email)->first();
            if ($admin) {
                $category = Category::where('id', $category_id)->first();
                $subcat = SubCategory::where('id', $subcategory_id)->where('category_id', $category->id)->first();
                if ($subcat) {
                    $product = Product::where('id', decrypt($product_id))->where('sub_category_id', $subcat->id)->first();
                    if ($product) {
                        $productColor = ProductColor::where('id', $productColor_id)->where('product_id', $product->id)->first();
                        $productSize = ProductSize::where('id', $productSize_id)->where('product_id', $product->id)->first();
                        if ($productColor && $productSize) {
                            $productCS = ProductColorSize::where('id', $productCS_id)->where('product_sizes_id', $productSize->id)
                                ->where('product_colors_id', $productColor->id)->first();
                            if ($productCS) {
                                if ($productCS->image != null) {
                                    Storage::delete($productCS->image);
                                }
                                $productCS->delete();

                                $is_size_agian = ProductColorSize::where('product_sizes_id', $productSize->id)->first();
                                $is_color_agian = ProductColorSize::where('product_colors_id', $productColor->id)->first();
                                if (!$is_size_agian) {
                                    $productSize->delete();
                                } elseif (!$is_color_agian) {
                                    $productColor->delete();
                                } elseif (!$is_size_agian && !$is_color_agian) {
                                    $productSize->delete();
                                    $productColor->delete();
                                }
                                return redirect()->route('Show_one product',['category_id' => encrypt($category->id), 'subcategory_id' => encrypt($subcat->id), 'product_id' => encrypt($product->id)])->with('success', "product color size is deleted successfully");
                            } else {
                                return redirect()->back()->with("error", "this product color size does not exist");
                            }
                        } else {
                            return redirect()->back()->with("error", "This product is not available in the specified color and size.");
                        }
                    } else {
                        return redirect()->back()->with("error", "This product does not exist");
                    }
                } else {
                    return redirect()->back()->with("error", "This subcategory does not exist");
                }
            } else {
                abort(404);
            }
        } else {
            return redirect()->route('adminlogin')->with('error', 'You Must Login First');
        }
    }

    public function editMainProduct($category_id, $subcategory_id, $product_id)
    {
        $category = Category::where('id', $category_id)->first();
        if ($category) {
            $subcategory = SubCategory::where('id', $subcategory_id)->where('category_id', $category_id)->first();
            if ($subcategory) {
                $product = Product::where('id', decrypt($product_id))->where('sub_category_id', $subcategory_id)->first();
                if ($product) {
                    $color = $product->productColor->first()->color;
                    $size = $product->productSize->first()->size;
                    $color_data = $product->productColor->first();
                    foreach ($color_data->colorSize as $pQuantity) {
                        $quantity = $pQuantity->pivot->quantity;
                    }
                    return view('Dashboard.Forms.edit_Products', compact('quantity', 'category', 'subcategory', 'product', 'color', 'size'));
                } else {
                    return redirect()->back()->with("error", "this product does not exist");
                }
            } else {
                return redirect()->back()->with("error", "This subcategory does not exist");
            }
        } else {
            return redirect()->route('dash')->with("error", "This category does not exist");
        }
    }

    public function mainProductEditHandle($category_id, $subcategory_id, $product_id, EditMainProductRequest $request)
    {
        $is_login = Auth::user();
        if ($is_login) {
            $admin = User::where('user_type', '0')->where('email', $is_login->email)->first();
            if ($admin) {
                $category = Category::where('id', $category_id)->first();
                if ($category) {
                    $subcategory = SubCategory::where('id', $subcategory_id)
                        ->where('category_id', $category_id)
                        ->first();
                    if ($subcategory) {
                        $is_product_exist = Product::where("product_code", $request->product_code)->where("id", decrypt($product_id))->first();
                        if ($is_product_exist) {
                            $cate = $category->name;
                            $subCate = $subcategory->name;
                            if ($request->hasFile("image")) {
                                // if we have image in the file but we don't have now so comment
                                if ($is_product_exist->image != null) {
                                    Storage::delete($is_product_exist->image);
                                    $product_image = Storage::putFile("$cate" . "/" . "$subCate" . " Products", $request->image);
                                }
                            } elseif ($request->image == null) {
                                $product_image = $is_product_exist->image;
                            }
                            $is_product_exist->update([
                                "name" => $request->name,
                                "image" => $product_image,
                                "main_price" => $request->main_price,
                                "main_discount" => $request->main_discount,
                                "product_code" => $request->product_code,
                                "status" => $request->status,
                                "sub_category_id" => $subcategory->id,
                            ]);
                            $is_product_exist->productColor->first()->update([
                                "product_id" => $is_product_exist->id,
                                "color" => $request->color,
                            ]);
                            $is_product_exist->productSize->first()->update([
                                "product_id" => $is_product_exist->id,
                                "size" => $request->size,
                            ]);
                            $size_id = $is_product_exist->productSize->first()->id;
                            $color_id = $is_product_exist->productColor->first()->id;
                            $is_product_exist->productColor->first()->colorSize()->update([
                                "product_sizes_id" => $size_id,
                                "product_colors_id" => $color_id,
                                "quantity" => $request->quantity,
                                "image" => $product_image,
                            ]);
                            return redirect()->route('Show_one product', ["category_id" => encrypt($category->id), "subcategory_id" => encrypt($subcategory->id), "product_id" => encrypt($is_product_exist->id)])->with('success', "the product updated successfully");
                        } else {
                            return redirect()->route('Show_one subcategory', ['category_id' => encrypt($category->id), 'subcategory_id' => encrypt($subcategory->id)])->with('error', 'This Product does not Exist');
                        }
                    } else {
                        return redirect()->back()->with("error", "This subcategory does not exist");
                    }
                } else {
                    return redirect()->route('dash')->with("error", "This category does not exist");
                }
            } else {
                abort(404);
            }
        } else {
            return redirect()->route('adminlogin')->with('error', 'You Must Login First');
        }
    }

    public function editSubProduct($category_id, $subcategory_id, $product_id, $productColor_id, $productSize_id, $productCS_id)
    {
        $category = Category::where('id', $category_id)->first();
        if ($category) {
            $subcategory = SubCategory::where('id', $subcategory_id)->where('category_id', $category_id)->first();
            if ($subcategory) {
                $product = Product::where('id', decrypt($product_id))->where('sub_category_id', $subcategory_id)->first();
                if ($product) {
                    $color = ProductColor::where('id', $productColor_id)->where('product_id', $product->id)->first();
                    $size = ProductSize::where('id', $productSize_id)->where('product_id', $product->id)->first();
                    $is_productColorSize_exist = ProductColorSize::where('id', $productCS_id)->where("product_sizes_id", $size->id)->where("product_colors_id", $color->id)->first();
                    if ($is_productColorSize_exist) {
                        return view('Dashboard.Forms.edit_subProduct_color_size', compact('category', 'subcategory', 'product', 'is_productColorSize_exist', 'color', 'size'));
                    } else {
                        return redirect()->back()->with("error", "This product is not available in the specified color and size.");
                    }
                } else {
                    return redirect()->back()->with("error", "This product does not exist");
                }
            } else {
                return redirect()->back()->with("error", "This subcategory does not exist");
            }
        } else {
            return redirect()->route('dash')->with("error", "This category does not exist");
        }
    }

    public function editSubProductHandle($category_id, $subcategory_id, $product_id, $productColor_id, $productSize_id, $productCS_id, EditSubProductRequest $request)
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
                            $proColor = ProductColor::where('id', $productColor_id)->where('product_id', $is_product_exist->id)->first();
                            $proSize = ProductSize::where('id', $productSize_id)->where('product_id', $is_product_exist->id)->first();
                            $is_productColorSize_exist = ProductColorSize::where('id', $productCS_id)->where("product_sizes_id", $proSize->id)->where("product_colors_id", $proColor->id)->first();
                            if ($is_productColorSize_exist) {
                                $cate = $category->name;
                                $subCate = $subcategory->name;
                                if ($request->hasFile("image")) {
                                    // if we have image in the file but we don't have now so comment
                                    if ($is_productColorSize_exist->image != null) {
                                        Storage::delete($is_productColorSize_exist->image);
                                        $productCS_image = Storage::putFile("$cate" . "/" . "$subCate" . " Products", $request->image);
                                    }
                                } elseif ($request->image == null) {
                                    $productCS_image = $is_productColorSize_exist->image;
                                }
                                $proColor->update([
                                    "color" => $request->color,
                                ]);
                                $proSize->update([
                                    "size" => $request->size,
                                ]);
                                $is_productColorSize_exist->update([
                                    "quantity" => $request->quantity,
                                    "image" => $productCS_image,
                                ]);
                                return redirect()->route('Show_one product', ["category_id" => encrypt($category->id), "subcategory_id" => encrypt($subcategory->id), "product_id" => encrypt($is_product_exist->id)])->with('success', "The Product color size is Updated Successfully");
                            } else {
                                return redirect()->route("Show_one product", ['category_id' => encrypt($category->id), 'subcategory_id' => encrypt($subcategory->id), 'product_id' => encrypt($is_product_exist->id)])->with('error', 'This product is not available in the specified color and size.');
                            }
                        } else {
                            return redirect()->back()->with('error', 'This Product does not Exist');
                        }
                    } else {
                        return redirect()->back()->with("error", "This subcategory does not exist");
                    }
                } else {
                    return redirect()->route('dash')->with("error", "This category does not exist");
                }
            } else {
                abort(404);
            }
        } else {
            return redirect()->route('adminlogin')->with('error', 'You Must Login First');
        }
    }

    public function adminSearch(Request $request)
    {
        $product_name = $request->search;
        $product = Product::where('name', 'LIKE', '%' . str_replace(' ', '%', $product_name) . '%')->first();
        if ($product) {
            $subcategory = SubCategory::find($product->sub_category_id);
            if ($subcategory) {
                $category = Category::find($subcategory->category_id);
                if ($category) {
                    return view('Dashboard.Show All.one_product', compact('category', 'subcategory', 'product'));
                } else {
                    return redirect()->back()->with('error', "Something's going Wrong");
                }
            } else {
                return redirect()->back()->with('error', "Something's going Wrong");
            }
        } else {
            return redirect()->back()->with('error', "not found this product");
        }
    }

    public function adminOrderHistory()
    {
        $orders = Order::orderBy('created_at', 'desc')->paginate(10);
        return view('Dashboard.Show All.all_orders', compact('orders'));
    }

    public function adminOneOrder($order_id)
    {
        $is_login = Auth::user();
        if ($is_login) {
            $admin = User::where('user_type', '0')->where('email', $is_login->email)->first();
            if ($admin) {
                $order = Order::find($order_id);
                if ($order) {
                    $orders = Order::count();
                    return view('Dashboard.Show All.one_order', compact('order', 'orders'));
                } else {
                    return redirect()->back()->with("error", "This no order like this here");
                }
            } else {
                abort(404);
            }
        } else {
            return redirect()->route('adminlogin')->with('error', 'You Must Login First');
        }
    }

    public function adminEditOrder($order_id)
    {
        $order = Order::find($order_id);
        if ($order) {
            $orders = Order::count();
            return view('Dashboard.Forms.edit_order', compact('order', 'orders'));
        } else {
            return redirect()->back()->with("error", "This no order like this here");
        }
    }

    public function adminEditOrderHandle($order_id, EditOrderRequest $request)
    {
        $is_login = Auth::user();
        if ($is_login) {
            $admin = User::where('user_type', '0')->where('email', $is_login->email)->first();
            if ($admin) {
                $order = Order::find($order_id);
                if ($order) {
                    $sub_total = $order->sub_total;
                    $discount_total = $sub_total - ($sub_total * ($request->discount / 100));
                    $total = $request->shipping + $request->tax + $discount_total;
                    $order->update([
                        "discount" => $request->discount,
                        "tax" => $request->tax,
                        "shipping" => $request->shipping,
                        "status" => $request->status,
                        "total" => $total,
                    ]);
                    return redirect()->route("admin one order", ['order_id' => $order->id])->with('success', "order details are updated successfully");
                } else {
                    return redirect()->back()->with("error", "This no order like this here");
                }
            } else {
                abort(404);
            }
        } else {
            return redirect()->route('adminlogin')->with('error', 'You Must Login First');
        }
    }
}
