@extends('layout.layout')
@section('title')
    Forget Password
@endsection
@section('content')
    <section class="reg_form">
        <div class="gif_video_forget">
        </div>
        <div class="containt">
            <h1 class="reg">Enter Your Email</h1>
            <form action="{{route('forget password handle')}}" method="POST">
                @csrf
                <label class="reg_label" for="">Email</label>
                <input class="reg_inputs_two" type="email" name="email">
                @error("email")
                    {{$message}}
                @enderror

                {{-- <input class="submit" type="submit" value="Submit"> --}}
                <button class="submit" type="submit">Submit</button>
            </form>
        </div>
    </section>
@endsection
@section('script')
    <script src="../js/nav.js"></script>
@endsection
