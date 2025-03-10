
@extends('Dashboard.Admin Layout.layout')

@section('title')
    All Categories
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

    <section class="all_categories">
        <h1>CATEGORIES</h1>
        <div class="all_cate_blocks">
            {{-- {{$category_name}} --}}
            @php
                $cat_img_logo = ['img/dashboard/category_images/man_cate.jpeg','img/dashboard/category_images/wom.jpeg','img/dashboard/category_images/kid_cate_2.jpeg','img/dashboard/category_images/accessories.jpeg','img/dashboard/category_images/bags.jpeg','img/dashboard/category_images/makeup.jpeg']
            @endphp
            @foreach ($categories as $cate)
                
                <div class="cate">
                    <div class="id_link">
                        <a href="{{ route('Show_one category', ['category_id' =>encrypt($cate->id)]) }}">{{ "#".$loop->iteration }}</a>
                    </div>
                    <div class="img_name">
                        <div class="image">
                            <img src="{{asset($cat_img_logo[$loop->index])}}" alt="" srcset="">
                        </div>
                        <div class="name">
                            <h1>{{ $cate->name }}</h1>
                        </div>
                    </div>
                    <div class="sub_category">
                        <h3>SUBCATEGORIES</h3>
                        <div class="subcate_links">
                            @foreach ($cate->categorySubcategory()->limit(4)->get() as $subcate)
                                @php
                                    $db_allsubname = $subcate->name;
                                    $show_allsubname = str_replace('_', ' ', $db_allsubname);
                                @endphp
                                <a href="{{ route('Show_one subcategory', ['category_id' => encrypt($cate->id), 'subcategory_id' => encrypt($subcate->id)]) }}">{{ $show_allsubname }}</a>
                            @endforeach
                        </div>
                    </div>
                    <div class="cate_pro">
                        <h3>Products</h3>
                        @php
                            $all_product = 0;
                        @endphp
                        @foreach ($cate->categorySubcategory as $subcate)
                            @php
                                $all_product += $subcate->subcategoryProduct->count();
                            @endphp
                        @endforeach
                        <p>{{ $all_product }} <span>Items</span></p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    {{ $categories->links('vendor.pagination.custom') }}

    <section class="add_links">
        <div class="add_cate">
            <a href="{{ route('add category') }}">ADD CATEGORY</a>
        </div>
        <div class="add_subcate">
            <a href="{{ route('add subcategory') }}">ADD SUBCATEGORY</a>
        </div>
    </section>
@endsection
