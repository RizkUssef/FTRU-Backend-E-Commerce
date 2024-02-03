<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title')</title>
        <link rel = "icon" href ="{{asset('img/logo/FTRU.svg')}}"  type = "image/svg+xml">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link rel="stylesheet" href="{{asset('sass/style.css')}}">
        <link href="https://fonts.googleapis.com/css2?family=Karantina&family=Lora:ital@1&family=Nunito:wght@300&family=Square+Peg&display=swap" rel="stylesheet">
    </head>
    <body class="body">  
        @include('Dashboard.Admin Includes.header')
        @include('Dashboard.Admin Includes.admin_session')
        @yield('content')
        @include('Dashboard.Admin Includes.footer')
        @include('Dashboard.Admin Includes.search')
        <script src="{{asset("js/showAdminSearch.js")}}"></script>
        {{-- <script src="{{asset("js/search.js")}}"></script> --}}
        <script src="{{asset("js/dashboardShowAllCate.js")}}"> </script>
        <script src="{{asset("js/dashboardActive.js")}}"></script>
        <script src="{{asset("js/error.js")}}"></script>
        <script src="{{asset("js/pagination.js")}}"></script>
    </body>
</html>