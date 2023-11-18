<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FTRU Store</title>
    <link rel = "icon" href ="{{ asset('img/logo/FTRU.svg') }}" type = "image/svg+xml">
    <link rel="stylesheet" href="{{ asset('sass/style.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Karantina&family=Lora:ital@1&family=Nunito:wght@300&family=Square+Peg&display=swap"
        rel="stylesheet">
</head>

<body>
    <!-- start of the header -->
    <header class="header">
        <div class="logo">
            <a href="{{ route('home') }}">
                <img src="{{ asset('img/logo/FTRU.svg') }}" alt="po">
            </a>
        </div>
        <div class="blob_logo">
            <img src="{{ asset('img/Blob/logo2.svg') }}" alt="">
        </div>
        <ul class="nav-links">
            @auth
                <div class="cart">
                    <a href="{{ route('cart') }}"><img src="{{ asset('img/Stars/shopping-cart.png') }}" alt=""
                            srcset=""></a>
                </div>
                <div class="profile">
                    <a href="{{ route('user_profile') }}"><img src="{{ asset('img/Stars/user (1).png') }}"
                            alt=""></a>
                </div>
            @else
                <div class="register" style="margin-top: 12px ">
                    <a href="{{ route('register') }}">Register</a>
                </div>
                <div class="login" style="margin-top: 12px">
                    <a href="{{ route('login') }}">Login</a>
                </div>
            @endauth
        </ul>
    </header>
    <!-- end of the header  -->
    <!-- start of the section that contain all the contant -->
    <section class="contain_all">
        @foreach ($category_name as $item)
            <section class="{{ $item->name . '_X' }}">
                <div class="link_container">
                    <a href="{{ route('show category', ['category_name' => $item->name]) }}">{{ $item->name }}</a>
                </div>
                <div class="text_container">
                    <h1>{{ 'FTRU FOR ' . $item->name }}</h1>
                </div>
            </section>
        @endforeach
        <section class="best_rated">
            <div class="title">
                <h1>TOP RATED PRODUCTS</h1>
            </div>

            @foreach ($category_name as $category)
                @foreach ($category->categorySubcategory as $subcat)
                    @foreach ($subcat->subcategoryProduct as $product)
                        @foreach ($product->productReview as $review)
                            @if ($product->productReview->avg('rating_value')>=4)
                                <div class="first_product">
                                    <a
                                        href="{{ route('one product', ['category_name' => $category->name, 'subcategory_name' => $subcat->name, 'product_id' => $product->id]) }}">
                                        <div class="inner_bg">
                                            <div class="rate_number">
                                                {{-- @if ($product->productReview->avg('rating_value')) --}}
                                                    <img src="{{ asset('img/Stars/star.png') }}" alt="Ward"
                                                        srcset="">
                                                    <p>{{ $product->productReview->avg('rating_value') }}</p>
                                                {{-- @endif --}}
                                            </div>
                                            <div class="pro_img">
                                                <img src=" {{ asset("storage/$product->image") }}" alt="Product Image">
                                            </div>
                                            <div class="pro_name">
                                                <h1>{{ $product->name }}</h1>
                                            </div>
                                            <div class="price_stock">
                                                @if ($product->main_discount)
                                                    <div class="price">
                                                        <p>{{$product->main_price ." $"}}</p> 
                                                    </div>
                                                    <div class="price_disc">
                                                        @php
                                                            $price_after_disc = $product->main_price - ($product->main_price * ($product->main_discount/100));
                                                        @endphp
                                                        {{-- <p>{{"discount  ". $product->main_discount. " %" }}</p> --}}
                                                        <p>{{ $price_after_disc. " $" }}</p>
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
                            @endif
                        @endforeach
                    @endforeach
                @endforeach
            @endforeach
        </section>
    </section>
    <!-- end contant section -->
    {{-- start footer --}}
    @include('pages.includes.footer')
    {{-- end footer --}}
</body>

</html>
