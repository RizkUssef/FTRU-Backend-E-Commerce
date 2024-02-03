@extends('Dashboard.Admin Layout.layout')

@section('title')
    Add Product
@endsection

@section('content')
@include('pages.includes.session')
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
        <h1>ADD PRODUCT</h1>
        <form action="{{route('edit main product handle',["category_id"=>$category->id,"subcategory_id"=>$subcategory->id,"product_id"=>encrypt($product->id)])}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="label_inputs">
                <div class="right">
                    <label for="">NAME</label>
                    <input name="name" class="input" type="text" value="{{$product->name}}">
                    @error('name')
                        {{ $message }}
                    @enderror
                    <label for="">PRODUCT CODE</label>
                    <input name="product_code" class="input" type="text" value="{{$product->product_code}}">
                    @error('product_code')
                        {{ $message }}
                    @enderror
                    <div>
                        <label for="">MAIN PRICE</label>
                        <input name="main_price" class="input" type="text" value="{{$product->main_price}}">
                        @error('main_price')
                            {{ $message }}
                        @enderror
                    </div>
                    <div class="main_PQ">
                        <div>
                            <label for="">QUANTITY</label>
                            <input name="quantity" class="main_input" type="text" value="{{$quantity}}">
                            @error('quantity')
                                {{ $message }}
                            @enderror
                        </div>
                        <div class="sec">
                            <label for="">MAIN DISCOUNT</label>
                            <input name="main_discount" class="main_input" type="text" value="{{$product->main_discount}}">
                            @error('main_discount')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>


                </div>
                <div class="left">
                    <label for="">IMAGE</label>
                    <div class="input_image">
                        <input name="image" type="file" accept="image/*"/>
                        @error('image')
                            {{ $message }}
                        @enderror
                    </div>
                    <div class="main_PQ">
                        <div>
                            <label for="">SIZE</label>
                            <select name="size" class="main_input">
                                <option value="ONE SIZE" @if ($size == 'ONE SIZE') selected @endif >ONE SIZE</option>
                                <option value="S" @if ($size == 'S') selected @endif >S</option>
                                <option value="M" @if ($size == 'M') selected @endif>M</option>
                                <option value="L"  @if ($size == 'L') selected @endif>L</option>
                                <option value="XL"@if ($size == 'XL') selected @endif >XL</option>
                                <option value="XXL" @if ($size == 'XXL') selected @endif>XXL</option>
                                <option value="XXXL" @if ($size == 'XXXL') selected @endif>XXXL</option>
                                <option value="NO SIZE" @if ($size == 'NO SIZE') selected @endif>NO SIZE</option>
                            </select>
                            @error('main_size')
                                {{ $message }}
                            @enderror
                        </div>
                        <div>
                            <label for="">STATUS</label>
                            <select name="status" class="main_input">
                                <option value="show" @if ($product->status == 'show') selected @endif >SHOW</option>
                                <option value="hide" @if ($product->status == 'hide') selected @endif>HIDE</option>
                            </select>
                            @error('status')
                                {{ $message }}
                            @enderror
                        </div>
                        <div class="color_carry">
                            <label for="">COLOR</label>
                            <input name="color" class="color_input" type="color" value="{{$color}}">
                            @error('color')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <button class="submit" type="submit">SUBMIT</button>
        </form>
    </section>
@endsection
