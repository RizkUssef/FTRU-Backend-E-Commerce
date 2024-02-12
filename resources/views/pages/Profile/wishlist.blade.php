@extends('layout.layout')
@section('title')
    Wishlist
@endsection
@section('content')
    <section class="contant_info_order">
        @include('pages.includes.top_info')

        <section class="next_container">
            @include('pages.includes.session')
            <h1 class="info_title">YOUR WISHLIST</h1>
            @if ($user_wishlist->isEmpty())
                <div class="order_history_list_not">
                    <div class="img">
                        <img src="{{ asset('img/Stars/exclamation-mark.png') }}" alt="not">
                    </div>
                    <div class="not_found">
                        <h1 class="empty">you don't have any items in your wishlist</h1>
                        {{-- <h1>no data here</h1> --}}
                    </div>
                </div>
            @else
                @foreach ($user_wishlist as $prod)
                    <div class="order_history_list">
                        <div class="options">
                            @php
                                $wishlist_data = DB::table('wishlists')
                                    ->where('product_id', $prod->id)
                                    ->first();
                            @endphp
                            <form action="{{ route('add wishlist to cart') }}" method="post">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ encrypt($prod->id) }}">
                                <input type="hidden" name="color" value="{{ $prod->productColor->first->color->color }}">
                                <input type="hidden" name="size" value="{{ $prod->productSize->first->size->size }}">
                                {{-- {{$prod->productColor->first->color->color}}
                                {{$prod->productSize->first->size->size}} --}}
                                <button type="submit"><img src="{{ asset('img/Stars/cart.png') }}" alt="no"></button>
                            </form>
                            <form action="{{ route('remove from wishlist', ['wishlist_item_id' => $wishlist_data->id]) }}"
                                method="post">
                                @csrf
                                @method('delete')
                                <button type="submit"><img src="../../img/Stars/delete (1).png" alt="no"></button>
                            </form>

                        </div>
                        <div class="image_cont">
                            <img src="{{ asset('storage') . '/' . $prod->image }}" alt="">
                        </div>
                        <div class="product_notes">
                            <h1>{{ $prod->name }}</h1>
                            <p class="marg_price">{{ $prod->main_price . " $" }}</p>
                        </div>
                    </div>
                @endforeach
            @endif

            @if ($user_wishlist->isNotEmpty())
            <div class="btn_contant">
                <div class="align_btn">
                    <div class="order_all">
                        <form action="{{ route('add All To CartFromWishlist') }}" method="get">
                            @csrf
                            <button type="submit">ADD ALL TO CART</button>
                        </form>
                    </div>
                    <div class="order_all">
                        <form action="{{ route('remove all from wishlist') }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Delete All</button>
                        </form>
                    </div>
                </div>
            </div>
            @endif
        </section>
    </section>



@endsection
@section('script')
    <script src="../js/nav.js"></script>
@endsection
