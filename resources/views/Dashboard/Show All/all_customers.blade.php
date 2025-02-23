@extends('Dashboard.Admin Layout.layout')

@section('title')
    All Customers
@endsection

@section('content')
    <section class="blobs">
        <div class="customer">
            <h3>TOTAL CUSTOMERS</h3>
            <img src="{{ asset('img/dashboard/icons/browser (1).png') }}" alt="nobe">
            <h1>800</h1>
        </div>
        <div class="text">
            <h1>FTRU TOTAL CUSTOMERS COUNTER</h1>
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

    <section class="all_categories">
        <h1>CUSTOMERS</h1>
        <div class="all_customers_blocks">
            @foreach ($allCust as $cust)
                @php
                    if ($cust->userCart) {
                        $className = 'cate';
                    } else {
                        $className = 'cate_passive';
                    }
                @endphp
                <div class="{{ $className }} width_358">
                    <div class="id_link">
                        <a href="#"># {{ $cust->id }}</a>
                    </div>
                    <div class="img_name">
                        <div class="image">
                            @if ($cust->image)
                                <img src="{{ asset("storage/$cust->image") }}" alt="not" srcset="">
                            @else
                                <img src="{{ asset("img/Stars/user (1).png") }}" alt="not" srcset="">
                            @endif
                        </div>
                        <div class="name">
                            <h1>{{ $cust->name }}</h1>
                            <P>{{ $cust->email }}</P>
                        </div>
                    </div>
                    <div class="phone">
                        <h1>PHONE</h1>
                        <P>{{ $cust->phone }}</P>
                    </div>
                    <div class="address">
                        <h1>ADDRESS</h1>
                        <P>{{ $cust->main_address }}</P>
                    </div>
                    <div class="country">
                        <h1>COUNTRY</h1>
                        <p>{{ $cust->userCountry->name }}</p>
                    </div>
                    <div class="status">
                        @if ($className == 'cate')
                            <h1>ACTIVE</h1>
                        @elseif ($className == 'cate_passive')
                            <h1>PASSIVE</h1>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    {{ $allCust->links('vendor.pagination.custom') }}
@endsection
