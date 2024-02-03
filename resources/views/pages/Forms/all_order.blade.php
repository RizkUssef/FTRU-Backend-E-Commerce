@extends('layout.layout')
@section('title')
    Payment
@endsection
@section('content')
    <section class="reg_form">
        <div class="containt">
            <h1 class="reg">Pay</h1>
            <div class="all_product">
                <h1>Your Products</h1>

                @php 
                    $count = min(count($pro), count($cart_item));
                    $total=0;
                @endphp
                @foreach(range(0, $count - 1) as $index)
                    <a href="">
                        <div class="one_product">
                            <h3 class="pro_name">{{ $pro[$index]->name }}</h3>
                            <div class="delete_price">
                                <p class="pro_price">{{ $cart_item[$index]->price }} $</p>
                                @php
                                    $total+=$cart_item[$index]->price;
                                    $cart_item_id=$cart_item[$index]->id;
                                @endphp
                                <form class="delete" action="{{route('remove from cart',['cart_item_id'=>$cart_item_id])}}" method="post">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit"><img src="{{ asset('img/Stars/delete pro.png') }}" alt=""></button>
                                </form>
                            </div>
                        </div>
                    </a>
                    <div class="line"></div>
                @endforeach

                <div class="total">
                    <h1>Total</h1>
                    <p class="total_price">{{$total}} $</p>
                </div>
                <div class="total_line"></div>
            </div>
            <form action="{{route('all order handle')}}" method="POST">
                @csrf
                <h1>Address Details</h1>
                <div class="zip_address">
                    <div>
                        <label class="reg_label" for="">Country</label>
                        <select class="reg_inputs_three" name="country_id" id="">
                            <option selected disabled value=""></option>
                            @foreach ($countries as $country)
                                <option value="{{$country->id}}">{{$country->name}}</option>
                            @endforeach
                        </select>
                        @error('country_id')
                            {{ $message }}
                        @enderror
                    </div>
                    <div>
                        <label class="reg_label" for="">State</label>
                        <input class="reg_inputs_four" type="text" name="state">
                        @error('state')
                        {{ $message }}
                    @enderror
                    </div>
                </div>
                <div class="zip_address">
                    <div>
                        <label class="reg_label" for="">City</label>
                        <input class="reg_inputs_six" type="text" name="city">
                        @error('city')
                        {{ $message }}
                    @enderror
                    </div>
                    <div>
                        <label class="reg_label" for="">Street</label>
                        <input class="reg_inputs_six" type="text" name="street_number">
                        @error('street_number')
                        {{ $message }}
                    @enderror
                    </div>
                </div>
                <div class="zip_address">
                    <div>
                        <label class="reg_label" for="">Address Line 1</label>
                        <input class="reg_inputs_five" type="text" name="address_line1">
                        @error('address_line1')
                        {{ $message }}
                    @enderror
                    </div>
                    <div>
                        <label class="reg_label" for="">Address Line 2</label>
                        <input class="reg_inputs_five" type="text" name="address_line2">
                        @error('address_line2')
                        {{ $message }}
                    @enderror
                    </div>
                </div>
                <div class="zip_address">
                    <div>
                        <label class="reg_label" for="">Building Number</label>
                        <input class="reg_inputs_seven" type="text" name="unit_number">
                        @error('unit_number')
                        {{ $message }}
                    @enderror
                    </div>
                </div>

                <h1>Communication Details</h1>
                <label class="reg_label" for="">Email</label>
                <input class="reg_inputs_one" type="email" name="email">
                @error('email')
                {{ $message }}
            @enderror
                <label class="reg_label" for="">Phone</label>
                <input class="reg_inputs_four" type="text" name="phone">
                @error('phone')
                {{ $message }}
            @enderror
                <input class="submit" type="submit" value="Submit">
            </form>
        </div>
        <div class="gif_video_pay">
        </div>
    </section>
@endsection

@section('script')
    <script src="../js/nav.js"></script>
@endsection
