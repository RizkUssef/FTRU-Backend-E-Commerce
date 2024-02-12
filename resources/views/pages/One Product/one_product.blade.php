@extends('layout.layout')
@section('title', $product->name)

@section('content')
    <section class="one_product_bg">
    </section>

    <section class="product_info">
        <div class="side_prod">
            <div class="side_imgs">
                @foreach ($product->productColor as $color)
                    @foreach ($color->colorSize as $item)
                        @php
                            $img = $item->pivot->image;
                        @endphp
                        @if ($product->image != $img)
                            <div class="img_container">
                                <img src="{{ asset("storage/$img") }}" alt="">
                            </div>
                        @endif
                    @endforeach
                @endforeach
            </div>
            <div class="the_product">
                <img src="{{ asset("storage/$product->image") }}" alt="">
            </div>
        </div>

        @include('pages.includes.session')
        <div class="text_info">
            <div class="name_desc">
                <h1>{{ $product->name }}</h1>
            </div>
            <div class="price_on_pro">
                <h1>Price</h1>
                @php
                    if ($product->main_discount != null) {
                        $price = $product->main_price - $product->main_price * ($product->main_discount / 100);
                    } else {
                        $price = $product->main_price;
                    }
                @endphp
                <div class="price">
                    <p>{{ $product->main_price . " $" }}</p>
                </div>
                <div class="price_disc">
                    <p>{{ $price . " $" }}</p>
                </div>
            </div>
            <form class="form_color_price" action="{{ route('add to cart') }}" method="POST">
                @csrf
                <div class="color_container">
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <label for="color">Color</label>
                    @foreach ($product->productColor as $color)
                        @if ($color->color == 'Multi')
                            <p>Multiple color</p>
                            <input type="hidden" name="color" value="{{ $color->color }}">
                        @else
                            <input type="radio" name="color" class="pick_one" value="{{ $color->color }}"
                                style="background-color: {{ $color->color }}">
                        @endif
                    @endforeach
                    @error('color')
                        {{ $message }}
                    @enderror
                </div>
                <div class="price_container">
                    <label for="size">Size</label>
                    @foreach ($product->productSize->sortBy('size') as $size)
                        @if ($size->size == 'ONE SIZE' || $size->size == 'NO SIZE')
                            <p>{{ $size->size }}</p>
                            <input type="hidden" name="size" value="{{ $size->size }}">
                        @else
                            <input type="radio" name="size" value="{{ $size->size }}"
                                class="{{ 'size_' . $size->size }}">
                        @endif
                    @endforeach
                    @error('size')
                        {{ $message }}
                    @enderror
                </div>
                <div class="price_container">
                    <label for="price">Quantity</label>
                    <input class="num" type="number" name="quantity" min="1">
                    @error('quantity')
                        {{ $message }}
                    @enderror
                </div>


                @foreach ($product->productColor as $color)
                    @foreach ($color->colorSize as $item)
                        @php
                            $qty = $item->pivot->quantity;
                        @endphp
                    @endforeach
                @endforeach

                <div class="stock">
                    @if ($qty)
                        <p>{{ $qty }}<span class="in_stock">IN STOCK</span></p>
                    @else
                        <p><span class="out_stock">OUT OF STOCK</span></p>
                    @endif
                </div>
                @if ($qty)
                    <button id="disBtn" class=" @if ($product->delete_status == 'Yes') disabled @endif "  type="submit">Add To Cart</button>
                @else
                    <button id="disBtn" class="disabled" type="submit">Add To Cart</button>
                @endif
            </form>

            <form class="wishlist" action="{{ route('add to wishlist') }}" method="post">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <button id="disBtn" type="submit">Add To Wishlist</button>
            </form>
        </div>
    </section>
    <hr>

    <section class="ui">
        <div class="head">
            <h1>RATEING PRODUCT</h1>
        </div>
        <div class="rating_form">

            <form action="{{ route('rating') }}" method="POST">
                @csrf
                <h3>Add your Rate</h3>
                <input type="hidden" name="product_id" value="{{ encrypt($product->id) }}">
                <div class="rating">
                    <input type="radio" class="star5" id="star5" name="rating" value="5">
                    <label class="label_star5" for="star5"></label>

                    <input type="radio" class="star4" id="star4" name="rating" value="4">
                    <label class="label_star4" for="star4"></label>

                    <input type="radio" class="star3" id="star3" name="rating" value="3">
                    <label class="label_star3" for="star3"></label>

                    <input type="radio" class="star2" id="star2" name="rating" value="2">
                    <label class="label_star2" for="star2"></label>

                    <input type="radio" class="star1" id="star1" name="rating" value="1">
                    <label class="label_star1" for="star1"></label>
                </div>
                <h3>If you wish to provide any feedback or comments</h3>
                <div class="comment">
                    <textarea name="comment" cols="165" rows="30"></textarea>
                </div>
                <button class="submit" type="submit">Submit</button>
            </form>

        </div>
    </section>
    <hr>

    @include('pages.includes.somehints')

@endsection
@section('script')
    <script src="../js/nav.js"></script>
    <script>
        document.getElementById('disBtn').addEventListener('click', function(e) {
            e.preventDefault();
        });
    </script>
@endsection
