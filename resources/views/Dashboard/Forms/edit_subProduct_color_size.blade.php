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
        <form action="{{route("edit sub handle product",["category_id"=>encrypt($category->id),"subcategory_id"=>encrypt($subcategory->id),"product_id"=>encrypt($product->id),'productColor_id'=>$color->id,'productSize_id'=>$size->id,'productCS_id'=>$is_productColorSize_exist->id])}}" method="post" enctype="multipart/form-data">
            @method('put')
            @csrf
            <div class="label_inputs">
                <div class="right">
                    <label for="">PRODUCT CODE</label>
                    <input readonly name="product_code" value="{{$product->product_code}}" class="input" type="text">
                    <div class="main_PQ">
                        <div>
                            <label for="">SIZE</label>
                            <select name="size" class="main_input">
                                <option value="ONE SIZE" @if ($size->size == 'ONE SIZE') selected @endif >ONE SIZE</option>
                                <option value="S" @if ($size->size == 'S') selected @endif >S</option>
                                <option value="M" @if ($size->size == 'M') selected @endif>M</option>
                                <option value="L"  @if ($size->size == 'L') selected @endif>L</option>
                                <option value="XL"@if ($size->size == 'XL') selected @endif >XL</option>
                                <option value="XXL" @if ($size->size == 'XXL') selected @endif>XXL</option>
                                <option value="XXXL" @if ($size->size == 'XXXL') selected @endif>XXXL</option>
                                <option value="NO SIZE" @if ($size->size == 'NO SIZE') selected @endif>NO SIZE</option>
                            </select>
                            @error('main_size')
                                {{ $message }}
                            @enderror
                        </div>
                        <div>
                            <label for="">QUANTITY</label>
                            <input name="quantity" class="main_input" type="text" value="{{$is_productColorSize_exist->quantity}}">
                            @error('quantity')
                                {{ $message }}
                            @enderror
                        </div>
                        <div class="color_carry">
                            <label for="">COLOR</label>
                            {{-- <input name="color" class="color_input" type="color" value="#3F4045"> --}}
                            <input name="color" class="color_input" type="color" value="{{$color->color}}">
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
