@extends('layout.layout')
@section('title')
    Cart
@endsection
@section('content')
    <section class="contant_info_order">
        @include('pages.includes.top_info')

        <section class="next_container">
            @include('pages.includes.session')
            <h1 class="info_title">YOUR CART</h1>
            @if ($all_product->isEmpty())
                <div class="order_history_list_not">
                    <div class="img">
                        <img src="{{ asset('img/Stars/exclamation-mark.png') }}" alt="not">
                    </div>
                    <div class="not_found">
                        <h1 class="empty">you don't have any items in your cart</h1>
                        {{-- <h1>no data here</h1> --}}
                    </div>
                </div>
            @else
                @foreach ($all_product as $prod)
                    @php
                        $pro_sc = DB::table('product_color_sizes')
                            ->where('id', $prod->product_color_size_id)
                            ->first();
                        $pro_id = DB::table('product_colors')
                            ->select('product_id')
                            ->where('id', $pro_sc->product_colors_id)
                            ->first();
                        $pro_data = DB::table('products')
                            ->where('id', $pro_id->product_id)
                            ->first();
                    @endphp
                    <div class="order_history_list">
                        <div class="image_cont">
                            <img src="{{ asset('storage') . '/' . $pro_sc->image }}" alt="">
                        </div>
                        <div class="qty">
                            <p class="pro_price">{{ $prod->quantity }}</p>
                        </div>
                        <div class="product_notes">
                            <h1>{{ $pro_data->name }}</h1>
                            <p class="pro_price">{{ $prod->price . " $" }}</p>
                        </div>
                        <div class="options">
                            <a href="{{ route('payment') }}"><img src="../../img/Stars/payment-method.png"
                                    alt="no"></a>
                            <a href="{{ route('edit cart', ['product_id' => $pro_data->id, 'cart_item_id' => $prod->id]) }}"><img
                                    src="../../img/Stars/edit.png" alt="no"></a>
                            <form action="{{ route('remove from cart', ['cart_item_id' => $prod->id]) }}" method="post">
                                @csrf
                                @method('delete')
                                <button type="submit"><img src="../../img/Stars/delete (1).png" alt="no"></button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @endif



        </section>
    </section>
@endsection
@section('script')
    <script src="../js/nav.js"></script>
@endsection
