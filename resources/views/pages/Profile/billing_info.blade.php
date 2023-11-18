@extends('layout.layout')
@section('title')
    Billing Info
@endsection
@section('content')
    <section class="contant_info_all">
        @include('pages.includes.top_info')

        <section class="next_container">
            <h1 class="info_title">BILLING INFO</h1>
            <div class="personal_info_card">
                <div class="name">
                    <h1>Card Holder Name</h1>
                    <p>{{Auth::user()->name}}</p>
                </div>
                <div class="email">
                    <h1>Card Number</h1>
                    <p>**** **** **** 5897</p>
                </div>
                <div class="age">
                    <h1>VAT</h1>
                    <p>145764646468</p>
                </div>
                <div class="country">
                    <h1>Bank Name</h1>
                    <p>Banque Du Caire</p>
                </div>
                <div class="edit">
                    <a href="#"><img src="../../img/Stars/editing (1).png" alt=""></a>
                </div>
            </div>
        </section>
    </section>
@endsection
@section('script')
    <script src="../js/nav.js"></script>
@endsection



