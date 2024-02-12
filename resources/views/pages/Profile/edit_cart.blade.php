@extends('layout.layout')
@section('title')
    Edit Cart
@endsection
@section('content')
    <section class="contant_info_order">
        @include('pages.includes.top_info')

        <section class="next_container">
            @include('pages.includes.session')
                <h1 class="info_title">YOUR CART</h1>
                <div class="edit_list">
                    <div>
                        <div class="image_cont">
                            <img src="{{asset("storage/$pro_c_s->image")}}" alt="">
                        </div>
                        <div class="product_notes">
                            <h1>{{$product->name}}</h1>
                        </div>
                    </div>
                    <form class="form_product_edit" action="{{route('handle edit cart',['cart_item_id'=>$cat_item_product->id])}}" method="POST">
                        @csrf
                        @method("put")
                        <div class="color_container">
                            <input type="hidden" name="product_id" value="{{$product->id}}">
                            <label for="color">Color</label>
                            @foreach ($product->productColor as $color)
                                @if ($color->color == "Multi")
                                    <p>Multiple color</p>
                                    <input type="hidden" name="color" value="{{$color->color}}">     
                                @else
                                    <input type="radio" name="color" class="pick_one" value="{{$color->color}}" style="background-color: {{$color->color}}"> 
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
                                    <p>{{$size->size}}</p>
                                    <input type="hidden" name="size" value="{{$size->size}}">
                                @else
                                    <input type="radio" name="size" value="{{$size->size}}" class="{{"size_".$size->size}}">
                                    @endif
                            @endforeach
                            @error('size')
                                {{ $message }}
                            @enderror 
                        </div>
                        <div class="price_container">
                            <label for="price">Quantity</label>
                            <input class="num" type="number" name="quantity" value="{{$cat_item_product->quantity}}" min="1">
                        </div>
                        <button type="submit">Save Changes</button>
                    </form>
                    {{-- end form --}}
                </div>
        </section>
    </section>
@endsection
@section('script')
    <script src="../js/nav.js"></script>
@endsection




