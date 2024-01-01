{{-- ! DONE  --}}
@extends('Dashboard.Admin Layout.layout')

@section('title')
    Add SubCategory
@endsection

@section('content')
@include('pages.includes.session')

    <section class="blobs">
        <div class="category">
            <h3>TOTAL CATEGORY</h3>
            <img src="../../../img/dashboard/icons/category.png" alt="nobe">
            <h1>800</h1>
        </div>
        <div class="text">
            <h1>FTRU TOTAL CATEGORY COUNTER</h1>
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
    <section class="form">
        <h1>ADD SUBCATEGORY</h1>
        <form action="{{route('handle add subcategory')}}" method="post">
            @csrf
            <div class="label_inputs">
                <div>
                    <label for="">NAME</label>
                    <input name="name" class="input" type="text">
                    @error('name')
                        {{$message}}
                    @enderror
                </div>
                <div>
                    {{-- {{$cate_name}} --}}
                    <label for="">MAIN CATEGORY</label>
                    <select name="category_id" id="" class="input select_height_53">
                        <option value="" selected disabled></option>
                        @foreach ($cate_name as $cate)
                            <option value="{{$cate->id}}">{{$cate->name}}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        {{$message}}
                    @enderror
                </div>
            </div>
            <button class="submit" type="submit">SUBMIT</button>
        </form>
    </section>

@endsection
