@extends('Dashboard.Admin Layout.layout')

@section('title')
    Dashboard
@endsection

@section('content')

    @include('pages.includes.session')
    <section class="blobs">
        <div class="visitor">
            <h3>TOTAL VISITORS</h3>
            <img src="{{ asset('img/dashboard/icons/customer.png') }}" alt="nobe">
            <h1>{{ $allVisitors->count }}</h1>
        </div>
        <div class="customer">
            <h3>TOTAL CUSTOMERS</h3>
            <img src="{{ asset('img/dashboard/icons/browser (1).png') }}" alt="nobe">
            <h1>{{ $allCust->count() }}</h1>
        </div>
        <div class="product">
            <h3>TOTAL PRODUCTS</h3>
            <img src="{{ asset('img/dashboard/icons/box.png') }}" alt="nobe">
            <h1>{{ $allProduct->count() }}</h1>
        </div>
        <div class="order">
            <h3>TOTAL ORDERS</h3>
            <img src="{{ asset('img/dashboard/icons/checkout.png') }}" alt="nobe">
            <h1>{{ $allOrder->count() }}</h1>
        </div>
        <div class="category">
            <h3>TOTAL CATEGORY</h3>
            <img src="{{ asset('img/dashboard/icons/category.png') }}" alt="nobe">
            <h1>{{ $category_name->count() }}</h1>
        </div>
    </section>

    <section class="new_last">
        @if ($allCust->isEmpty())
            <div class="new_customers">
                <h1>NEW CUSTOMERS</h1>
                <h1 class="info_title" style="color: #bf3b3b">There are no customers yet</h1>
            </div>
        @else
            <div class="new_customers">
                <h1>NEW CUSTOMERS</h1>
                <div class="labels">
                    <h3>ID</h3>
                    <h3>PHOTO</h3>
                    <h3>FULL NAME</h3>
                    <h3>EMAIL</h3>
                    <h3 class="country_label">COUNTRY</h3>
                    <h3>STATUS</h3>
                </div>
                @foreach ($allCust as $item)
                    <div class="customer_data">
                        <div class="id">
                            <p>{{ '# ' . $item->id }}</p>
                        </div>
                        <div class="img">
                            @if ($item->image == null)
                                <img src="{{ asset('img/Stars/user (4).png') }}" alt="no">
                            @else
                                <img src="{{ asset("storage/$item->image") }}" alt="no" srcset="">
                            @endif
                        </div>
                        <div class="name">
                            <p>{{ $item->name }}</p>
                        </div>
                        <div class="email">
                            <p>{{ $item->email }}</p>
                        </div>
                        <div class="country">
                            <p>{{ $item->userCountry->name }}</p>
                        </div>
                        <div class="status">
                            <p>
                                @if ($item->userCart()->exists())
                                    ACTIVE
                                @else
                                    PASSIVE
                                @endif
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        @if ($allOrder->isEmpty())
            <div class="last_order">
                <h1>LAST ORDERS</h1>
                <h1 class="info_title" style="color: #bf3b3b">There are no orders yet</h1>
            </div>
        @else
            <div class="last_order">
                <h1>LAST ORDERS</h1>
                <div class="labels">
                    <h3>ID</h3>
                    <h3>NAME</h3>
                    <h3>TOTAL</h3>
                    <h3>STATUS</h3>
                </div>

                {{-- !first and best way for memory --}}
                {{-- !add cheak --}}
                {{-- @foreach ($allOrder as $order)
                    @if ($order->lastOrder)
                        <div class="order_data">
                            <div class="id">
                                <p>{{ '#' . $loop->iteration }}</p>
                            </div>
                            <div class="name">
                                <p>{{ $order->name }}</p>
                            </div>
                            <div class="total">
                                <p>{{ $order->lastOrder->total . '$' }}</p>
                            </div>
                            <div class="status">
                                <p>{{ $order->lastOrder->status }}</p>
                            </div>
                        </div>
                    @endif
                @endforeach --}}

                @foreach ($users as $user)
                    @foreach ($user->userOrder()->latest("created_at")->take(1)->get() as $order)
                    <div class="order_data">
                        <div class="id">
                            <p>{{ '#'.$loop->iteration }}</p>
                        </div>
                        <div class="name">
                            <p>{{ $order->orderUser->name }}</p>
                        </div>
                        <div class="total">
                            <p>{{$order->total .' $'}}</p>
                        </div>
                        <div class="status">
                            <p>{{ $order->status }}</p>
                        </div>
                    </div>
                    @endforeach
                @endforeach



            </div>
        @endif
    </section>

    <section class="resent">
        <h1>RESENT REVIEW</h1>
        <div class="all_review">

            @foreach ($allCust as $customer)
                @foreach ($customer->userReview()->latest('created_at')->take(1)->get() as $review)
                    <div class="review_1">
                        <div class="top">
                            <div class="img">
                                @php
                                    $image = $review->reviewUser->image;
                                @endphp
                                @if ($image == null)
                                    <img src="{{ asset('img/Stars/user (4).png') }}" alt="no">
                                @else
                                    <img src="{{ asset("storage/$image") }}" alt="no">
                                @endif
                            </div>
                            <div class="name">
                                <h1>{{ $review->reviewUser->name }}</h1>
                            </div>
                        </div>
                        <div class="comment">
                            @if ($review->comment)
                                <p>{{ $review->comment }}</p>
                            @else
                                <p>There's no Comment</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            @endforeach
        </div>
    </section>

@endsection
