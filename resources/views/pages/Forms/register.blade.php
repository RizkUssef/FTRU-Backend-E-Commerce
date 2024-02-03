@extends('layout.layout')
@section('title')
    Register
@endsection
@section('content')
    <section class="reg_form">
        <div class="containt">

            <h1 class="reg">Register</h1>
            @if (session()->has("error"))
            <h1 class="info_title" style="color: #bf3b3b">{{session()->get("error")}} </h1>  
            @endif
            <form action="{{route('handle_register')}}" method="POST">
                @csrf
                <label class="reg_label" for="">Name</label>
                <input  class="reg_inputs_one" type="text" name="name">
                @error('name')
                    {{ $message }}
                @enderror

                <label class="reg_label" for="">Email</label>
                <input class="reg_inputs_two" type="email" name="email">
                @error('email')
                    {{ $message }}
                @enderror

                <label class="reg_label" for="">Gender</label>
                <select class="reg_inputs_four" name="gender" id="">
                    <option selected disabled value=""></option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
                @error('gender')
                    {{ $message }}
                @enderror

                <label class="reg_label" for="">Phone</label>
                <input  class="reg_inputs_five" type="text" name="phone">
                @error('phone')
                    {{ $message }}
                @enderror

                <label class="reg_label" for="">Country</label>
                <select class="reg_inputs_six" name="country_id" id="">
                    <option selected disabled value=""></option>
                    @foreach ($countries as $country)
                        <option value="{{$country->id}}">{{$country->name}}</option>
                    @endforeach
                </select>
                @error('country_id')
                    {{ $message }}
                @enderror

                <label class="reg_label" for="">Address</label>
                <input  class="reg_inputs_seven" type="text" name="address">
                @error('address')
                    {{ $message }}
                @enderror

                <label class="reg_label" for="">Password</label>
                <input class="reg_inputs_three" type="password" name="password">
                @error('password')
                    {{ $message }}
                @enderror

                <label class="reg_label" for="">Password Confirmation</label>
                <input class="reg_inputs_four" type="password" name="password_confirmation">

                {{-- added --}}
                <p class="already">Already have an Account? <span><a href="{{route('login')}}">LOGIN</a></span> </p>
                {{-- added --}}
                <button class="submit" type="submit">Submit</button>
            </form>
        </div>
        <div class="gif_video">
        </div>
    </section>
@endsection
@section('script')
    <script src="../js/nav.js"></script>
@endsection
