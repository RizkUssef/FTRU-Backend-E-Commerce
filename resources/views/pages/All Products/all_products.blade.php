@extends('layout.layout')
@section('title')
    {{ $category->name }}
@endsection
@section('content')
    <section class="{{ $category->name }}">
    </section>
    @include('pages.includes.session')
    <section class="section_search">
        <form id="submit_search" action="{{ route('search', ['category_name' => $category->name]) }}" method="POST">
            @csrf
            <div class="search-container">
                <input name="search" type="text" id="search" placeholder="Search">
                <button type="submit"><img src="{{ asset('img/Stars/search green.png') }}" alt=""></button>
            </div>
            <div class="sugg_container">
            </div>
        </form>
    </section>

    <section class="man_product">
        <div class="title">
            <div>
                <h1>{{ $category->name . "'S PRODUCTS" }}</h1>
            </div>
            <div class="sub_category_links">
                <button class="dropbtn">SUB CATEGORY</button>
                <div class="dropdown-content">
                    @foreach ($category->categorySubcategory as $subcate)
                        @php
                            $db_allsubname = $subcate->name;
                            $show_allsubname = str_replace('_', ' ', $db_allsubname);
                        @endphp
                        <a
                            href="{{ route('one subcategory', ['category_name' => $category->name, 'subcategory_name' => $subcate->name]) }}">{{ $show_allsubname }}</a>
                    @endforeach
                </div>
            </div>
        </div>

        @foreach ($category->categorySubcategory as $subcate)
            @foreach ($subcate->subcategoryProduct()->inRandomOrder()->where('status', 'show')->take(2)->get() as $product)
                <div class="first_product">
                    <a
                        href="{{ route('one product', ['category_name' => $category->name, 'subcategory_name' => $subcate->name, 'product_id' => $product->id]) }}">
                        <div class="inner_bg">
                            <div class="rate_number">
                                @if ($product->productReview->avg('rating_value'))
                                    <img src="../../img/Stars/star.png" alt="no" srcset="">
                                    <p>{{ $product->productReview->avg('rating_value') }}</p>
                                @endif
                            </div>
                            <div class="pro_img">
                                <img src="{{ asset("storage/$product->image") }}" alt="no">
                            </div>
                            <div class="pro_name">
                                <h1>{{ $product->name }}</h1>
                                <form id="love" action="{{ route('add to wishlist') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <button type="submit"><img src="{{ asset('img/Stars/heart (1).png') }}"
                                            alt="nui"></button>
                                </form>
                            </div>
                            <div class="price_stock">
                                @if ($product->main_discount)
                                    <div class="price">
                                        <p>{{ $product->main_price . " $" }}</p>
                                    </div>
                                    <div class="price_disc">
                                        @php
                                            $price_after_disc = $product->main_price - $product->main_price * ($product->main_discount / 100);
                                        @endphp
                                        {{-- <p>{{"discount  ". $product->main_discount. " %" }}</p> --}}
                                        <p>{{ $price_after_disc . " $" }}</p>
                                    </div>
                                @else
                                    <div class="price_disc">
                                        <p>{{ $product->main_price . " $" }}</p>
                                    </div>
                                @endif
                            </div>

                        </div>
                    </a>

                </div>
            @endforeach
        @endforeach
    </section>

    <hr>

    <section class="man_product">
        <div class="title">
            <div>
                <h1>NEW PRODUCTS</h1>
            </div>
        </div>

        @foreach ($category->categorySubcategory as $subcate)
            @foreach ($subcate->subcategoryProduct()->latest('created_at')->take(1)->get() as $product)
                <div class="first_product">
                    <a
                        href="{{ route('one product', ['category_name' => $category->name, 'subcategory_name' => $subcate->name, 'product_id' => $product->id]) }}">
                        <div class="inner_bg">
                            <div class="rate_number">
                                @if ($product->productReview->avg('rating_value'))
                                    <img src="../../img/Stars/star.png" alt="no" srcset="">
                                    <p>{{ $product->productReview->avg('rating_value') }}</p>
                                @endif
                            </div>
                            <div class="pro_img">
                                <img src="{{ asset("storage/$product->image") }}" alt="no">
                            </div>
                            <div class="pro_name">
                                <h1>{{ $product->name }}</h1>
                                <form action="{{ route('add to wishlist') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <button type="submit"><img src="{{ asset('img/Stars/heart (1).png') }}"
                                            alt="nui"></button>
                                </form>
                            </div>
                            <div class="price_stock">
                                @if ($product->main_discount)
                                    <div class="price">
                                        <p>{{ $product->main_price . " $" }}</p>
                                    </div>
                                    <div class="price_disc">
                                        @php
                                            $price_after_disc = $product->main_price - $product->main_price * ($product->main_discount / 100);
                                        @endphp
                                        {{-- <p>{{"discount  ". $product->main_discount. " %" }}</p> --}}
                                        <p>{{ $price_after_disc . " $" }}</p>
                                    </div>
                                @else
                                    <div class="price_disc">
                                        <p>{{ $product->main_price . " $" }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        @endforeach
    </section>
    <hr>

    @include('pages.includes.somehints')
@endsection
@section('script')
    <script src="../js/nav.js"></script>
@endsection
