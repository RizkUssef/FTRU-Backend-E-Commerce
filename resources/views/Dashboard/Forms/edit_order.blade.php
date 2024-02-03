{{-- ! DONE  --}}
@extends('Dashboard.Admin Layout.layout')

@section('title')
    Add SubCategory
@endsection

@section('content')
{{-- @include('pages.includes.session') --}}

    <section class="blobs">
        <div class="category">
            <h3>TOTAL CATEGORY</h3>
            <img src="../../../img/dashboard/icons/category.png" alt="nobe">
            <h1>{{$orders}}</h1>
        </div>
        <div class="text">
            <h1>FTRU TOTAL CATEGORY COUNTER</h1>
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
    <section class="form">
        <h1>EDIT ORDER</h1>
        <form action="{{route('handle edit one order',["order_id"=>$order->id])}}" method="post">
            @method('PUT')
            @csrf
            <div class="label_inputs">
                <div>
                    <label for="">Discount</label>
                    <input name="discount" class="input" type="text" value="{{$order->discount}}">
                    @error('discount')
                        {{$message}}
                    @enderror
                </div>
                <div>
                    <label for="">Shipping</label>
                    <input class="input" name="shipping" type="text" value="{{$order->shipping}}">
                    @error('shipping')
                        {{$message}}
                    @enderror
                </div>
            </div>

            <div class="label_inputs">
                <div>
                    <label for="">Tax</label>
                    <input class="input" name="tax" type="text" value="{{$order->tax}}">
                    @error('tax')
                        {{$message}}
                    @enderror
                </div>
                <div>
                    <label for="">Status</label>
                    <select class="input select_height_53" name="status" id="">
                        <option @if ($order->status == "Pending") selected @endif value="Pending">Pending</option>
                        <option @if ($order->status == "Processing") selected @endif value="Processing">Processing</option>
                        <option @if ($order->status == "Shipped") selected @endif value="Shipped">Shipped</option>
                        <option @if ($order->status == "Delivered") selected @endif value="Delivered">Delivered</option>
                    </select>
                    @error('status')
                        {{$message}}
                    @enderror
                </div>
            </div>
            <button class="submit" type="submit">SUBMIT</button>
        </form>
    </section>

@endsection
