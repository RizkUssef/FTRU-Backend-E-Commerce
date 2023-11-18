@extends('layout.layout')
@section('title')
    Personal Info
@endsection
@section('content')
    <section class="contant_info_all">
        @include('pages.includes.top_info')
        <!-- <hr> -->
        <section class="next_container">            
            <h1 class="info_title">PERSONAL INFO</h1>
            @include('pages.includes.session')
            <div class="personal_info_card">
                <div class="name">
                    <h1>Name</h1>
                    <p>{{Auth::user()->name}}</p>
                </div>
                <div class="email">
                    <h1>Email</h1>
                    <p>{{Auth::user()->email}}</p>
                </div>
                <div class="age">
                    <h1>Phone</h1>
                    <p>{{Auth::user()->phone}}</p>
                </div>
                <div class="country">
                    <h1>Country</h1>
                    <p>{{Auth::user()->userCountry->name}}</p>
                </div>
                <div class="edit">
                    <a href="{{route('edit personal info')}}"><img src="../../img/Stars/editing (1).png" alt=""></a>
                </div>
            </div>
        </section>
    </section>
@endsection
@section('script')
    <script src="../js/nav.js"></script>
@endsection
