@extends('layout.layout')
@section('title')
    Login
@endsection
@section('content')
    <section class="reg_form">
        <div class="gif_video_login">
        </div>
        <div class="containt">
            <h1 class="reg">Login</h1>
            @if($errors->has('msg'))
                {{ $errors->first('msg') }}
            @endif
            @if (session()->has("error"))
                <h1 class="info_title" style="color: #bf3b3b">{{session()->get("error")}} </h1>  
            @endif
            <form action="{{route('login handle')}}" method="POST">
                @csrf
                <label class="reg_label" for="">Email</label>
                <input class="reg_inputs_two" type="email" name="email">
                @error('email')
                    {{ $message }}
                @enderror
                
                <label class="reg_label" for="">Password</label>
                <input class="reg_inputs_three" type="password" name="password">
                @error('password')
                    {{ $message }}
                @enderror
                {{-- added --}}
                <div class="forget_pass">
                    <div>
                        <a href="{{route('forget_pass')}}">Forget Password?</a>
                    </div>
                    <div>
                        <input class="check_box_btn" type="checkbox" name="remember" id="">
                        <label for="check">Remember Me</label>
                    </div>
                </div>
                <p class="already">Don't have an Account? <span><a href="{{route('register')}}">REGISTER</a></span> </p>
                {{-- added --}}
                <button class="submit" type="submit">Submit</button>
            </form>
        </div>
    </section>
@endsection
@section('script')
    <script src="../js/nav.js"></script>
@endsection
