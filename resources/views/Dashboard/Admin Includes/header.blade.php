<header class="dashboard_header">
    <div class="logo">
        <img src="{{asset('img/dashboard/logo/FTRU (2).svg')}}" alt="mjikol">
    </div>
    <div class="links">
        <a class="nav-link" id="dash" href="{{route('dash')}}">DASHBOARD</a>
        <a class="nav-link" id="order" href="{{route('show all order')}}">ORDERS</a>
        <a class="nav-link" id="cate" href="{{route('allcate')}}">CATEGORY </a>
        <a class="nav-link" id="custumer" href="{{route('all customers')}}">CUSTOMERS</a>
        <a class="nav-link" id="product" href="{{route('dashboard logout')}}">LOGOUT</a>
    </div>
    <div class="search_icons">
        <a id="search_link_click" class="nav-link" href="#">SEARCH<img src="{{asset('img/Stars/search green.png')}}" alt="" srcset=""></a>
    </div>
</header>

{{-- {{$category_name}} --}}
<div class="sub_links" id="all_cate">    
    <ul class="cates">
        @foreach ($category_name as $item)
            {{-- {{$item->name}} --}}
            <li class="li_header"><a class="a_header" href="{{route('Show_one category',['category_id'=>encrypt($item->id)])}}">{{$item->name}}</a>
                <ul class="inner_sub">
                    @foreach ($item->categorySubcategory as $i)
                        @php
                            $db_allsubname =$i->name;
                            $show_allsubname = str_replace('_', ' ', $db_allsubname)
                        @endphp
                        {{-- {{$i->name}} --}}
                        <li><a href="{{route('Show_one subcategory',['category_id'=>encrypt($item->id),'subcategory_id'=>encrypt($i->id)])}}">{{$show_allsubname}}</a></li>                    
                    @endforeach
                </ul>
            </li>
        @endforeach
    </ul>
</div>