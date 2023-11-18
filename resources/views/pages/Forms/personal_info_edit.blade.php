@extends('layout.layout')
@section('title')
    Edit Personal Info
@endsection
@section('content')
    <section class="reg_form">
        <div class="containt">

            <h1 class="reg">Edit Presonal Info</h1>
            <form action="{{route('handle edit personal info')}}" method="POST" enctype="multipart/form-data">
                @method("put")
                @csrf


                <div class="prsonal_img_edit">
                    @if (Auth::user()->image != null)
                    <img src="{{asset("storage")."/".Auth::user()->image}}" alt="">
                    @else
                    <img src="{{asset("img/profile img/profile pic/defalut_profile.jpeg")}}" alt="">
                    @endif
                    <input class="upload" type="file" name="image">
                    @error('name')
                        {{ $message }}
                    @enderror
                </div>


                <label class="reg_label" for="">Name</label>
                <input  class="reg_inputs_one" type="text" name="name" value="{{Auth::user()->name}}">
                @error('name')
                    {{ $message }}
                @enderror

                <label class="reg_label" for="">Email</label>
                <input class="reg_inputs_two" type="email" name="email" value="{{Auth::user()->email}}">
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
                <input  class="reg_inputs_five" type="text" name="phone" value="{{Auth::user()->phone}}">
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
                <input  class="reg_inputs_seven" type="text" name="address" value="{{Auth::user()->main_address}}">
                @error('address')
                    {{ $message }}
                @enderror

                {{--added--}}
                <p class="already"> <span><a href="{{route('change_pass')}}">Change Password</a></span> </p>
                {{--added--}}
                <button class="submit" type="submit">Save Changes</button>
            </form>
        </div>
    </section>
@endsection
@section('script')
    <script src="../js/nav.js"></script>
@endsection
