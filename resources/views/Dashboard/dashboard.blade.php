@extends('Dashboard.Admin Layout.layout')

@section('title')
    Dashboard
@endsection

@section('content')
    @include('pages.includes.session')
    {{-- {{Auth::user()}} --}}
    <section class="blobs">
        <div class="visitor">
            <h3>TOTAL VISITORS</h3>
            <img src="{{asset('img/dashboard/icons/customer.png')}}" alt="nobe">
            <h1>{{$visitorCount}}</h1>
        </div>
        <div class="customer">
            <h3>TOTAL CUSTOMERS</h3>
            <img src="{{asset('img/dashboard/icons/browser (1).png')}}" alt="nobe">
            <h1>{{$allCust}}</h1>
        </div>
        <div class="product">
            <h3>TOTAL PRODUCTS</h3>
            <img src="{{asset('img/dashboard/icons/box.png')}}" alt="nobe">
            <h1>{{$allProduct}}</h1>
        </div>
        <div class="order">
            <h3>TOTAL ORDERS</h3>
            <img src="{{asset('img/dashboard/icons/checkout.png')}}" alt="nobe">
            <h1>{{$allOrder}}</h1>
        </div>
        <div class="category">
            <h3>TOTAL CATEGORY</h3>
            <img src="{{asset('img/dashboard/icons/category.png')}}" alt="nobe">
            <h1>{{ $category_name->count() }}</h1>
        </div>
    </section>

    <section class="charts">
        <div class="bar">

        </div>
        <div class="pie">

        </div>
    </section>

    <section class="new_last">
        <div class="new_customers">
            <h1>NEW CUSTOMERS</h1>
            <div class="labels">
                <h3>ID</h3>
                <h3>PHOTO</h3>
                <h3>FULL NAME</h3>
                <h3>EMAIL</h3>
                <h3>COUNTRY</h3>
                <h3>STATUS</h3>
            </div>
            <div class="customer_data">
                <div class="id">
                    <p>#18</p>
                </div>
                <div class="img">
                    <img src="" alt="" srcset="">
                </div>
                <div class="name">
                    <p>MR. MJKNF</p>
                </div>
                <div class="email">
                    <p>urgkus@ndvw.com</p>
                </div>
                <div class="country">
                    <p>EG</p>
                </div>
                <div class="status">
                    <p>ACTIVE</p>
                </div>
            </div>
            <div class="customer_data">
                <div class="id">
                    <p>#18</p>
                </div>
                <div class="img">
                    <img src="" alt="" srcset="">
                </div>
                <div class="name">
                    <p>MR. MJKNF</p>
                </div>
                <div class="email">
                    <p>urgkus@ndvw.com</p>
                </div>
                <div class="country">
                    <p>EG</p>
                </div>
                <div class="status">
                    <p>ACTIVE</p>
                </div>
            </div>
            <div class="customer_data">
                <div class="id">
                    <p>#18</p>
                </div>
                <div class="img">
                    <img src="" alt="" srcset="">
                </div>
                <div class="name">
                    <p>MR. MJKNF</p>
                </div>
                <div class="email">
                    <p>urgkus@ndvw.com</p>
                </div>
                <div class="country">
                    <p>EG</p>
                </div>
                <div class="status">
                    <p>ACTIVE</p>
                </div>
            </div>
            <div class="customer_data">
                <div class="id">
                    <p>#18</p>
                </div>
                <div class="img">
                    <img src="" alt="" srcset="">
                </div>
                <div class="name">
                    <p>MR. MJKNF</p>
                </div>
                <div class="email">
                    <p>urgkus@ndvw.com</p>
                </div>
                <div class="country">
                    <p>EG</p>
                </div>
                <div class="status">
                    <p>ACTIVE</p>
                </div>
            </div>
        </div>

        <div class="last_order">
            <h1>LAST ORDERS</h1>
            <div class="labels">
                <h3>ID</h3>
                <h3>NAME</h3>
                <h3>TOTAL</h3>
                <h3>STATUS</h3>
            </div>
            <div class="order_data">
                <div class="id">
                    <p>#18</p>
                </div>
                <div class="name">
                    <p>MR. MJKNF</p>
                </div>
                <div class="total">
                    <p>1250 $</p>
                </div>
                <div class="status">
                    <p>SHIPPED</p>
                </div>
            </div>
            <div class="order_data">
                <div class="id">
                    <p>#18</p>
                </div>
                <div class="name">
                    <p>MR. MJKNF</p>
                </div>
                <div class="total">
                    <p>1250 $</p>
                </div>
                <div class="status">
                    <p>SHIPPED</p>
                </div>
            </div>
            <div class="order_data">
                <div class="id">
                    <p>#18</p>
                </div>
                <div class="name">
                    <p>MR. MJKNF</p>
                </div>
                <div class="total">
                    <p>1250 $</p>
                </div>
                <div class="status">
                    <p>SHIPPED</p>
                </div>
            </div>
            <div class="order_data">
                <div class="id">
                    <p>#18</p>
                </div>
                <div class="name">
                    <p>MR. MJKNF</p>
                </div>
                <div class="total">
                    <p>1250 $</p>
                </div>
                <div class="status">
                    <p>SHIPPED</p>
                </div>
            </div>
        </div>
    </section>
    <section class="resent">
        <h1>RESENT REVIEW</h1>
        <div class="all_review">
            <div class="review_1">
                <div class="top">
                    <div class="img">
                        <img src="" alt="">
                    </div>
                    <div class="name">
                        <h1>MR. SDJVBK</h1>
                    </div>
                </div>
                <div class="comment">
                    <p>ivhsh frghrhg udrg o8hgoudsrgod</p>
                </div>
            </div>
            <div class="review_2">
                <div class="top">
                    <div class="img">
                        <img src="" alt="">
                    </div>
                    <div class="name">
                        <h1>MR. SDJVBK</h1>
                    </div>
                </div>
                <div class="comment">
                    <p>ivhsh frghrhg udrg o8hgoudsrgod</p>
                </div>
            </div>
            <div class="review_3">
                <div class="top">
                    <div class="img">
                        <img src="" alt="">
                    </div>
                    <div class="name">
                        <h1>MR. SDJVBK</h1>
                    </div>
                </div>
                <div class="comment">
                    <p>ivhsh frghrhg udrg o8hgoudsrgod</p>
                </div>
            </div>
        </div>
    </section>
@endsection
