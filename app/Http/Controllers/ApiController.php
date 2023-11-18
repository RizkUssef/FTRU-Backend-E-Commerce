<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductSize;
use App\Models\SubCategory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Models\ProductColor;
use Illuminate\Http\Request;
use App\Models\ProductColorSize;
use Illuminate\Support\Facades\Storage;

class ApiController extends Controller
{
    //insert category
    public function insertCategory(Request $request){
        $cate = Category::create([
            "name"=>$request->name,
        ]);
        return response()->json([
            "data"=>$cate
        ]);
    }

    //insert country
    public function insertCountry(Request $request){
        $cate = Country::create([
            "name"=>$request->name,
        ]);
        return response()->json([
            "data"=>$cate
        ]);
    }

    //insert subcategory
    public function insertSubcategory(Request $request){
        $subcate = SubCategory::create([
            "name"=>$request->name,
            "category_id"=>$request->category_id,
        ]);
        return response()->json([
            "data"=>$subcate
        ]);
    }

    //insert product
    public function insertProduct(Request $request){
        $pro_code= Str::random(6);
        $pro_image = Storage::put("Bags Product",$request->image);
        $product = Product::create([
            "name"=>$request->name,
            "image"=>$pro_image,
            "description"=>$request->description,
            "main_price"=>$request->main_price,
            "main_discount"=>$request->main_discount,
            "product_code"=>$pro_code,
            "status"=>'show',
            "sub_category_id"=>$request->sub_category_id,
        ]);

        $color = ProductColor::create([
            "color"=>$request->color,
            "product_id"=>$product->id,
        ]);

        $size = ProductSize::create([
            // "size"=>$request->size,
            "product_id"=>$product->id,
        ]);

        $product_color_size = ProductColorSize::create([
            "quantity"=>$request->quantity,
            "image"=>$pro_image,
            "product_colors_id"=>$color->id,
            "product_sizes_id"=>$size->id,
        ]);

        return response()->json([
            "name" => $product->name,
            "image" => $product->image,
            "main_price" => $product->main_price,
            "main_discount" => $product->main_discount,
            "sub_category_id"=>$product->sub_category_id,
            "color" => $color->color,
            "size" => $size->size,
            "quantity" => $product_color_size->quantity,
        ]);
    }

    public function updateMakeup($id,$sub_id){
        $cate = SubCategory::where('category_id',$id)->where('id',$sub_id)->get();
    
        $product_size=[];
        $array = ['S','M','L','XL','XXL','XXXL'];
        // $randomElement = Arr::random($array);
        foreach ($cate as $key) {
            $products = $key->subcategoryProduct;
            foreach ($products as $value) {
                $product_size []=$value->productSize()->update([
                    "size"=>Arr::random($array)
                ]);
            }
        }
        return response()->json([
            "pro"=>$product_size
        ]);
    }

    public function insertNewColor($cate_id,$sub_id,$prod_id,Request $request){
        $cate = SubCategory::where('category_id',$cate_id)->where('id',$sub_id)->first();
        $pro = Product::where("id",$prod_id)->where("sub_category_id",$sub_id)->first();

        $pro_image = Storage::put("Woman Product",$request->image);

        $color = ProductColor::create([
            "color"=>$request->color,
            "product_id"=>$pro->id,
        ]);

        $size = ProductSize::create([
            "size"=>$request->size,
            "product_id"=>$pro->id,
        ]);

        $product_color_size = ProductColorSize::create([
            "quantity"=>$request->quantity,
            "image"=>$pro_image,
            "product_colors_id"=>$color->id,
            "product_sizes_id"=>$size->id,
        ]);

        return response()->json([
            "color"=>$color,
            "size"=>$size,
            "color_size"=>$product_color_size
        ]);
    }

}
