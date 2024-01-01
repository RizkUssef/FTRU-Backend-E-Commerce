@extends('Dashboard.Admin Layout.layout')

@section('title')
    Add New Color & Size
@endsection

@section('content')
    <section class="blobs">
        <div class="product">
            <h3>TOTAL PRODUCTS</h3>
            <img src="{{asset('img/dashboard/icons/box.png')}}" alt="nobe">
            <h1>800</h1>
        </div>
        <div class="text">
            <h1>FTRU TOTAL PRODUCTS COUNTER</h1>
            <p class="one">Discover the depth and breadth of our extensive product catalog with the FTRU Total Products
                Counter.
                This counter showcases the remarkable range of offerings we have curated for our valued customers.
            </p>

            <p class="two">From trending items to timeless classics, each increment in the counter represents a unique
                product waiting to enhance your lifestyle.
                Explore the diversity of our collection and experience the excitement of finding your perfect match.
                With every new addition, we strive to bring you the finest selection and exceed your expectations.
                Embrace the journey of exploration as you witness our product counter grow, reflecting our commitment to
                quality, innovation, and customer satisfaction.
            </p>
        </div>
    </section>

    <section class="form">
        <h1>ADD NEW COLOR & SIZE FOR PRODUCT</h1>
        <form action="{{route("handel add new CS to product",["category_id"=>encrypt($category->id),"subcategory_id"=>encrypt($subcategory->id),"product_id"=>encrypt($product->id)])}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="label_inputs">
                <div class="right">
                    <label for="">PRODUCT CODE</label>
                    <input name="product_code" value="{{$product->product_code}}" class="input" type="text">
                    <div class="main_PQ">
                        <div>
                            <label for="">SIZE</label>
                            <select name="size" class="main_input">
                                <option value="ONE SIZE" >ONE SIZE</option>
                                <option value="S">S</option>
                                <option value="M ">M</option>
                                <option value="L" >L</option>
                                <option value="XL" >XL</option>
                                <option value="XXL" >XXL</option>
                                <option value="XXXL" >XXXL</option>
                                <option value="NO SIZE" >NO SIZE</option>
                            </select>
                            @error('size')
                                {{ $message }}
                            @enderror
                        </div>
                        <div>
                            <label for="">QUANTITY</label>
                            <input name="quantity" class="main_input" type="text">
                            @error('quantity')
                                {{ $message }}
                            @enderror
                        </div>
                        <div class="color_carry">
                            <label for="">COLOR</label>
                            <input name="color" class="color_input" type="color" value="#3F4045">
                            @error('color')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="left">
                    <label for="">IMAGE</label>
                    <div class="input_image input_image_height_82">
                        <input name="image" type="file" accept="image/*"/>
                        @error('image')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>
            <button class="submit" type="submit">SUBMIT</button>
        </form>
    </section>
@endsection
