<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\ProductSize;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Models\ProductColor;
use App\Models\ProductColorSize;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\EditCartRequest;
use App\Http\Requests\AddToCartRequest;
use App\Http\Requests\RateRequest;
use App\Http\Resources\GetAllProductApi;
use App\Models\Review;
use Dotenv\Store\File\Reader;
use Illuminate\Support\Facades\View;
use PhpParser\Node\Stmt\Foreach_;

class ProductController extends Controller
{

    public function showCate($cate_name)
    {
        $category = Category::with("categorySubcategory")->where("name", $cate_name)->first();
        if ($category) {
            return view('pages.All Products.all_products', compact("category"));
        } else {
            return redirect()->route('error')->with("error", "something is wrong");
        }
    }

    public function product($category_name, $subcategory_name, $product_id)
    {
        $category = Category::where("name", $category_name)->first();
        if ($category) {
            $subcategory = SubCategory::where("category_id", $category->id)->where("name", $subcategory_name)->first();
            if ($subcategory) {
                $product = Product::where('sub_category_id', $subcategory->id)->where('id', $product_id)->first();
                if ($product) {
                    return view('pages.One Product.one_product', compact("product"));
                } else {
                    return redirect()->route('error');
                }
            } else {
                return redirect()->route('error');
            }
        } else {
            return redirect()->route('error');
        }
    }

    public function showSubCategory($category_name, $subcategory_name)
    {
        $category = Category::where("name", $category_name)->first();
        if ($category) {
            $subcategory = SubCategory::where("category_id", $category->id)->where("name", $subcategory_name)->first();
            if ($subcategory) {
                $products = $subcategory->subcategoryProduct()->paginate(8);
                return view('pages.All Products.sub_cateproduct', compact("products","subcategory", "category"));
            } else {
                return redirect()->route('error');
            }
        } else {
            return redirect()->route('error');
        }
    }

    public function search(Request $request)
    {
        $product_name = $request->search;
        $products = Product::where('name', 'LIKE', '%' . str_replace(' ', '%', $product_name) . '%')->get();
        return view('pages.All Products.search_products', compact('products'));
    }

    public function showSearchProduct($product_id)
    {
        $product = Product::findOrfail(decrypt($product_id));
        if ($product) {
            return view('pages.One Product.one_product', compact("product"));
        } else {
            return redirect()->route('error');
        }
    }

    public function rateProduct(RateRequest $request)
    {
        $user = Auth::user();
        if ($user) {
            $product = Product::find(decrypt($request->product_id));
            if ($product) {
                Review::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'product_id' => $product->id
                    ],
                    [
                        "rating_value" => $request->rating,
                        "comment" => $request->input("comment"),
                        "user_id" => $user->id,
                        "product_id" => $product->id
                    ]
                );
                return redirect()->back()->with("success", "Thank you");
            } else {
                return redirect()->back()->with("error", "This product doesn't exist");
            }
        } else {
            return redirect()->route("login")->with("error", "You must login first");
        }
    }

    public function productSearchApi()
    {
        $product = Product::all('name');
        return GetAllProductApi::collection($product);
    }

}
