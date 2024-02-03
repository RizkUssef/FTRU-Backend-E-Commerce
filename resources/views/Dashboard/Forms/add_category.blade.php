{{-- ! DONE  --}}
@extends('Dashboard.Admin Layout.layout')

@section('title')
    Add Category
@endsection

@section('content')
    <section class="blobs">
        <div class="category">
            <h3>TOTAL CATEGORY</h3>
            <img src="../../../img/dashboard/icons/category.png" alt="nobe">
            <h1>{{$category_name->count()}}</h1>
        </div>
        <div class="text">
            <h1>FTRU TOTAL CATEGORY COUNTER</h1>
            <p class="one">Discover the depth and breadth of our extensive product catalog with the FTRU Total Products Counter. 
                This counter showcases the remarkable range of offerings we have curated for our valued customers. </p>

            <p class="two">From trending items to timeless classics, each increment in the counter represents a unique product waiting to enhance your lifestyle. 
                Explore the diversity of our collection and experience the excitement of finding your perfect match. 
                With every new addition, we strive to bring you the finest selection and exceed your expectations. 
                Embrace the journey of exploration as you witness our product counter grow, reflecting our commitment to quality, innovation, and customer satisfaction.
            </p>
        </div>
    </section>
    @include('pages.includes.session')
    <section class="form">
        <h1>ADD CATEGORY</h1>
        <form action="{{route('handle add category')}}" method="POST">
            @csrf
            <div class="label_inputs">
                <div>
                    <label for="">NAME</label>
                    <input name="name" class="input" type="text">
                </div>
            </div>
            <button class="submit" type="submit">SUBMIT</button>
        </form>
    </section>
@endsection 

