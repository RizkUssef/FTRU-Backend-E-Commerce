@extends('Dashboard.Admin Layout.layout')

@section('title')
    All Orders
@endsection

@section('content')
    <section class="blobs">
        <div class="order">
            <h3>TOTAL ORDERS</h3>
            <img src="../../../img/dashboard/icons/checkout.png" alt="nobe">
            <h1>{{$orders}}</h1>
        </div>
        <div class="text">
            <h1>FTRU TOTAL ORDERS COUNTER</h1>
            <p class="one">Stay updated with the real-time count of orders placed on FTRU. Witness the growing number of
                satisfied customers as each new order contributes to our success. Explore the power of our thriving
                community and track the pulse of our business through this dynamic counter.
                Experience the momentum of our business as the FTRU Total Orders Counter continues to rise. </p>

            <p class="two">With each passing order, we are fueled by the trust and satisfaction of our valued customers.
                Join our ever-expanding community and witness the tangible impact of our products and services.
                This dynamic counter reflects our commitment to delivering exceptional experiences and showcases the growth
                of our brand.
                Stay engaged and be a part of our journey towards excellence.
            </p>
        </div>
    </section>

    <section class="one_order">
        <div class="order_container">
            <div class="comp_1">
                <h1>User Data</h1>
                <div class="inner_qu">
                    <div>
                        <h1>Name</h1>
                        <p>{{$order->orderUser->name}}</p>
                    </div>
                    <div>
                        <h1>Email</h1>
                        <p>{{$order->email}}</p>
                    </div>
                    <div>
                        <h1>Phone</h1>
                        <p>{{$order->phone}}</p>
                    </div>
                </div>
            </div>
            <div class="comp_3">
                <h1>Address Data</h1>
                <div class="inner_qu">
                    <div>
                        <h1>Address Line 1</h1>
                        <p>{{$order->orderAddress->address_line1}}</p>
                    </div>
                    <div>
                        <h1>City</h1>
                        <p>{{$order->orderAddress->city}}</p>
                    </div>
                    <div>
                        <h1>State</h1>
                        <p>{{$order->orderAddress->state}}</p>
                    </div>
                    <div>
                        <h1>Address Line 2</h1>
                        <p>{{$order->orderAddress->address_line2}}</p>
                    </div>
                    <div>
                        <h1>Street Number</h1>
                        <p>{{$order->orderAddress->street_number}}</p>
                    </div>
                    <div>
                        <h1>Unit Number</h1>
                        <p>{{$order->orderAddress->unit_number}}</p>
                    </div>
                    <div>
                        <h1>Country</h1>
                        <p>{{$order->orderAddress->addressCountry->name}}</p>
                    </div>
                </div>
            </div>
            <div class="comp_2">
                <h1>Order Data</h1>
                <div class="inner_qu">
                    <div>
                        <h1>Order Code</h1>
                        <p>{{$order->order_code}}</p>
                    </div>
                    <div>
                        <h1>SubTotal</h1>
                        <p>{{$order->sub_total}} $</p>
                    </div>
                    <div>
                        <h1>Tax</h1>
                        <p>{{$order->tax}}</p>
                    </div>
                    <div>
                        <h1>Shipping</h1>
                        <p>{{$order->shipping}}</p>
                    </div>
                    <div>
                        <h1>Quantity</h1>
                        <p>{{$order->quantity}}</p>
                    </div>
                    <div>
                        <h1>Status</h1>
                        <p>{{$order->status}}</p>
                    </div>
                    <div>
                        <h1>Discount</h1>
                        <p>{{$order->discount}}</p>
                    </div>
                    <div>
                        <h1>Total</h1>
                        <p>{{$order->total}} $</p>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <section class="add_links">
        <div class="add_subcate">
            <a id="change_status" href="{{route('edit one order',['order_id'=>$order->id])}}">EDIT ORDER</a>
        </div>
    </section>


@endsection
