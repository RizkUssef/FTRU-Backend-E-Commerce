@extends('Dashboard.Admin Layout.layout')

@section('title')
    {{ $product->name }}
@endsection

@section('content')
    <section class="blobs">
        <div class="product">
            <h3>TOTAL PRODUCTS</h3>
            <img src="{{ asset('img/dashboard/icons/box.png') }}" alt="nobe">
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
        <h1>{{ $category->name . "'s" }} PRODUCTS</h1>
        <div class="main_image_cate">
            <img src="{{ asset('img/dashboard/category_images/man_cate.jpeg') }}" alt="">
        </div>
        <h1>{{ $subcategory->name }}</h1>
        <div class="add_subcate">
            <a
                href="{{ route('Add new CS to product', ['category_id' => encrypt($category->id), 'subcategory_id' => encrypt($subcategory->id), 'product_id' => encrypt($product->id)]) }}">ADD
                COLOR & SIZE</a>
        </div>
        <div class="all_cate_blocks">
            <div class="cate one_prod">
                <div class="id_link">
                    {{ $product->id }}
                </div>
                <div class="left">
                    <div class="img_name_left">
                        <div class="image">
                            <img src="{{ asset("storage/$product->image") }}" alt="no">
                        </div>
                        <div class="name">
                            <h1>{{ $product->name }}</h1>
                        </div>
                    </div>
                </div>
                <div class="right">
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
                        <p>{{ $product->main_price }}</p>
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
                <div class="options">
                    <a
                        href="{{ route('edit main product', ['category_id' => $category->id, 'subcategory_id' => $subcategory->id, 'product_id' => encrypt($product->id)]) }}"><img
                            src="{{ asset('img/dashboard/icons/edit.png') }}" alt="not"></a>
                    <form
                        action="{{ route('deleteProduct', ['category_id' => $category->id, 'subcategory_id' => $subcategory->id, 'product_id' => encrypt($product->id)]) }}"
                        method="post">
                        @method('DELETE')
                        @csrf
                        <button type="submit"><img src="{{ asset('img/dashboard/icons/delete.png') }}"
                                alt="not"></button>
                    </form>
                </div>
            </div>
        </div>
        <div class="sub_products">
            @foreach ($product->productSize as $item)
                @foreach ($item->sizeColor as $quantity)
                    @php
                        $colorId = $quantity->pivot->product_colors_id;
                        $image = $quantity->pivot->image;
                        $quantityReal = $quantity->pivot->quantity;
                        $color = DB::table('product_colors')
                            ->where('id', $colorId)
                            ->first();
                    @endphp
                    @if ($product->image != $image)
                        <div class="sub_product_container">
                            <div class="id_link">
                                <a href="#"># {{ $quantity->pivot->id }}</a>
                            </div>
                            <div class="img_name">
                                <div class="image">
                                    <img src="{{ asset("storage/$image") }}" alt="no" srcset="">
                                </div>
                            </div>
                            <div class="colors">
                                <div class="head_color">
                                    <h1>Color</h1>
                                </div>
                                <div class="pro_color_container">
                                    <div class="color_blobs" style="background-color: {{ $color->color }}">
                                    </div>
                                </div>
                            </div>
                            <div class="sizes">
                                <div class="head_size">
                                    <h1>Size</h1>
                                </div>
                                <div class="pro_size_container">
                                    <div class="size_blobs">
                                        <p>{{ $item->size }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="quantity">
                                <h1>Quantity</h1>
                                <p>{{ $quantityReal }}</p>
                            </div>
                            <div class="options">
                                <a
                                    href="{{ route('edit sub product', ['category_id' => $category->id, 'subcategory_id' => $subcategory->id, 'product_id' => encrypt($product->id),'productColor_id'=>$color->id,'productSize_id'=>$item->id,'productCS_id'=>$quantity->pivot->id]) }}"><img
                                        src="{{ asset('img/dashboard/icons/edit.png') }}" alt="not"></a>
                                <form
                                    action="{{ route('remove product color size', ['category_id' => $category->id, 'subcategory_id' => $subcategory->id, 'product_id' => encrypt($product->id),'productColor_id'=>$color->id,'productSize_id'=>$item->id,'productCS_id'=>$quantity->pivot->id]) }}"
                                    method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"><img src="{{ asset('img/dashboard/icons/delete.png') }}"
                                            alt="not" srcset="">
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                @endforeach
            @endforeach
        </div>
    </section>
@endsection
