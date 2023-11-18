@extends('layout.layout')
@section('title')
    Reset Password
@endsection
@section('content')
    <section class="reg_form">
        <div class="containt">
            <h1 class="reg">Reset Your Password</h1>
            <form action="{{route('reset password handle')}}" method="POST">
                @csrf
                <input type="hidden" name="token" value="{{$token}}">
                <label class="reg_label" for="">Email</label>
                <input class="reg_inputs_two" type="email" name="email">
                <label class="reg_label" for="">Password</label>
                <input class="reg_inputs_three" type="password" name="password">
                <label class="reg_label" for="">Confirm Password</label>
                <input class="reg_inputs_four" type="password" name="password_confirmation">

                <button class="submit" type="submit">Submit</button>
            </form>
        </div>
        <div class="gif_video_reset">
        </div>
    </section>
@endsection
@section('script')
    <script src="../js/nav.js"></script>
@endsection
