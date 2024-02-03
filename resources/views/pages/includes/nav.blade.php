<nav>
    <div class="nav_logo">
        <a href="{{ route('home') }}">
            <img src="{{ asset('img/logo/FTRU.svg') }}" alt="Logo Image">
        </a>
    </div>
    <div class="hamburger">
        <div class="line1"></div>
        <div class="line2"></div>
        <div class="line3"></div>
    </div>
    <ul class="nav-links header">
        @foreach ($category_name as $item)
            <li><a href="{{ route('show category', ['category_name' => $item->name]) }}">{{ $item->name }}</a></li>
        @endforeach

        @if (Auth::check())
            @if (Auth::user()->user_type == 1)
                <li><a href="{{ route('cart') }}"><img src="{{ asset('img/Stars/shopping-cart.png') }}" alt=""
                            srcset=""></a></li>
                <li><a href="{{ route('user_profile') }}"><img src="{{ asset('img/Stars/user (1).png') }}"
                            alt=""></a></li>
            @else
                <div class="register" style="margin-top: 12px">
                    <a href="{{ route('register') }}">Register</a>
                </div>
                <div class="login" style="margin-top: 12px">
                    <a href="{{ route('login') }}">Login</a>
                </div>
            @endif
        @else
            <div class="register" style="margin-top: 12px">
                <a href="{{ route('register') }}">Register</a>
            </div>
            <div class="login" style="margin-top: 12px">
                <a href="{{ route('login') }}">Login</a>
            </div>
        @endif
    </ul>
</nav>
