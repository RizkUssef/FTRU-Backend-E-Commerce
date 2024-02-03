@extends('Dashboard.Admin Layout.layout')

@section('title')
    All Orders
@endsection

@section('content')
    <section class="blobs">
        <div class="order">
            <h3>TOTAL ORDERS</h3>
            <img src="../../../img/dashboard/icons/checkout.png" alt="nobe">
            <h1>800</h1>
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

    <section class="new_last">
        <div class="order_all">
            <div class="right">
                <h1>ORDERS</h1>
                <div class="top_labels">
                    <div class="labels">
                        <h3>ID</h3>
                        <h3>NAME</h3>
                        <h3>TOTAL</h3>
                        <h3>STATUS</h3>
                        <h3>DATE</h3>
                    </div>
                    @if ($orders->count() > 5)
                        <div class="labels">
                            <h3>ID</h3>
                            <h3>NAME</h3>
                            <h3>TOTAL</h3>
                            <h3>STATUS</h3>
                            <h3>DATE</h3>
                        </div>
                    @endif
                </div>
                <div class="all_order">
                    @foreach ($orders as $order)
                        @if ($order->status == 'Pending')
                            <a href="{{route('admin one order',['order_id'=>$order->id])}}">
                                <div class="Pending">
                                    <div class="id">
                                        <p>{{ '#' . $loop->iteration }}</p>
                                    </div>
                                    <div class="name">
                                        <p>{{ $order->orderUser->name }}</p>
                                    </div>
                                    <div class="total">
                                        <p>{{ $order->total . 'EGP' }}</p>
                                    </div>
                                    <div class="status">
                                        <p>{{ $order->status }}</p>
                                    </div>
                                    <div class="date">
                                        <p>{{ $order->created_at->format('Y-m-d') }}</p>
                                    </div>
                                </div>
                            </a>
                        @endif

                        @if ($order->status == 'Processing')
                            <a href="{{route('admin one order',['order_id'=>$order->id])}}">
                                <div class="Processing">
                                    <div class="id">
                                        <p>{{ '#' . $loop->iteration }}</p>
                                    </div>
                                    <div class="name">
                                        <p>{{ $order->orderUser->name }}</p>
                                    </div>
                                    <div class="total">
                                        <p>{{ $order->total . 'EGP' }}</p>
                                    </div>
                                    <div class="status">
                                        <p>{{ $order->status }}</p>
                                    </div>
                                    <div class="date">
                                        <p>{{ $order->created_at->format('Y-m-d') }}</p>
                                    </div>
                                </div>
                            </a>
                        @endif

                        @if ($order->status == 'Delivered')
                            <a href="{{route('admin one order',['order_id'=>$order->id])}}">
                                <div class="Delivered">
                                    <div class="id">
                                        <p>{{ '#' . $loop->iteration }}</p>
                                    </div>
                                    <div class="name">
                                        <p>{{ $order->orderUser->name }}</p>
                                    </div>
                                    <div class="total">
                                        <p>{{ $order->total . 'EGP' }}</p>
                                    </div>
                                    <div class="status">
                                        <p>{{ $order->status }}</p>
                                    </div>
                                    <div class="date">
                                        <p>{{ $order->created_at->format('Y-m-d') }}</p>
                                    </div>
                                </div>
                            </a>
                        @endif

                        @if ($order->status == 'Shipped')
                            <a href="{{route('admin one order',['order_id'=>$order->id])}}">
                                <div class="Shipped">
                                    <div class="id">
                                        <p>{{ '#' . $loop->iteration }}</p>
                                    </div>
                                    <div class="name">
                                        <p>{{ $order->orderUser->name }}</p>
                                    </div>
                                    <div class="total">
                                        <p>{{ $order->total . 'EGP' }}</p>
                                    </div>
                                    <div class="status">
                                        <p>{{ $order->status }}</p>
                                    </div>
                                    <div class="date">
                                        <p>{{ $order->created_at->format('Y-m-d') }}</p>
                                    </div>
                                </div>
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    {{ $orders->links('vendor.pagination.custom') }}
@endsection
