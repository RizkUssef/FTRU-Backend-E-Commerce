@extends('layout.layout')
@section('title')
    Change Password
@endsection
@section('content')
    <section class="reg_form">
        <div class="containt">
            <h1 class="reg">Change Your Password</h1>
            <form action="{{route("handle_change_pass")}}" method="POST">
                @csrf
                <label class="reg_label" for="">Old Password</label>
                <input class="reg_inputs_two" type="password" name="old_password">
                @error('old_password')
                {{ $message }}
                @enderror
                <label class="reg_label" for="">New Password</label>
                <input class="reg_inputs_three" type="password" name="password">
                @error('password')
                {{ $message }}
                @enderror
                <label class="reg_label" for="">Confirm Password</label>
                <input class="reg_inputs_four" type="password" name="password_confirmation">

                {{-- <input class="submit" type="submit" value="Change"> --}}
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
