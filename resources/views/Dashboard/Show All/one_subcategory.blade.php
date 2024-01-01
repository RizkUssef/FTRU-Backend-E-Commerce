@extends('Dashboard.Admin Layout.layout')
@section('title', $subcategory->name . ' ' . 'Subcategory')
@section('content')
    <section class="blobs">
        <div class="product">
            <h3>TOTAL PRODUCTS</h3>
            <img src="{{ asset('img/dashboard/icons/box.png') }}" alt="box">
            <h1>800</h1>
        </div>
        <div class="text">
            <h1>FTRU TOTAL PRODUCTS COUNTER</h1>
            <p class="one">Discover the depth and breadth of our extensive product catalog with the FTRU Total Products
                Counter.
                This counter showcases the remarkable range of offerings we have curated for our valued customers. </p>
            <p class="two">From trending items to timeless classics, each increment in the counter represents a unique
                product waiting to enhance your lifestyle.
                Explore the diversity of our collection and experience the excitement of finding your perfect match.
                With every new addition, we strive to bring you the finest selection and exceed your expectations.
                Embrace the journey of exploration as you witness our product counter grow, reflecting our commitment to
                quality, innovation, and customer satisfaction.
            </p>
        </div>
    </section>
    <section class="all_categories">
        <h1>{{ $category->name . '' . "'S PRODUCTS" }}</h1>
        <div class="main_image_cate">
            <img src="{{ asset('img/dashboard/category_images/man_cate.jpeg') }}" alt="">
        </div>
        <h1>{{ $subcategory->name . ' ' . 'PRODUCTS' }}</h1>
        <div class="all_cate_blocks">
            @foreach ($products as $product)
                <div class="cate">
                    <div class="id_link">
                        <a
                            href="{{ route('Show_one product', ['category_id' => encrypt($category->id), 'subcategory_id' => encrypt($subcategory->id), 'product_id' => encrypt($product->id)]) }}">{{ '#' . $loop->iteration }}</a>
                    </div>
                    <div class="img_name">
                        <div class="image">
                            <img src=" {{ asset("storage/$product->image") }}" alt="Product Image">
                        </div>
                        <div class="name">
                            <h1>{{ $product->name }}</h1>
                        </div>
                    </div>
                    <div class="colors">
                        <div class="head_color">
                            <h1>Colors</h1>
                        </div>
                        <div class="pro_color_container">
                            @foreach ($product->productColor as $color)
                                @if ($color->color == 'Multi')
                                    <p><b>Multiple Color</b></p>
                                @else
                                    <div class="color_blobs" style="background-color: {{ $color->color }}">
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="sizes">
                        <div class="head_size">
                            <h1>Size</h1>
                        </div>
                        <div class="pro_size_container">
                            @foreach ($product->productSize->sortBy('size') as $size)
                                @if ($size->size == 'ONE SIZE' || $size->size == 'NO SIZE')
                                    <p><b>{{ $size->size }}</b></p>
                                @else
                                    <div class="size_blobs">
                                        <p>{{ $size->size }}</p>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="price">
                        <h1>Price</h1>
                        <p>{{ $product->main_price . ' ' . 'EGP' }}</p>
                    </div>
                    <div class="quantity">
                        <h1>Quantity</h1>
                        @php
                            $allQuantity = 0;
                        @endphp
                        @foreach ($product->productSize as $item)
                            @foreach ($item->sizeColor as $quantity)
                                @php
                                    $allQuantity += $quantity->pivot->quantity;
                                @endphp
                            @endforeach
                        @endforeach
                        <p>{{ $allQuantity }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{ $products->links('vendor.pagination.custom') }}

    <section class="add_links">
        <div class="add_subcate">
            <a
                href="{{ route('Add new product', ['category_id' => $category->id, 'subcategory_id' => encrypt($subcategory->id)]) }}">ADD
                PRODUCT</a>
        </div>
    </section>
@endsection
