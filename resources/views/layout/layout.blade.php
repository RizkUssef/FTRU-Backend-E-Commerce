<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset("sass/style.css")}}"/>
    <link rel = "icon" href ="{{asset("img/logo/FTRU.svg")}}"  type = "image/svg+xml">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Karantina&family=Lora:ital@1&family=Nunito:wght@300&family=Square+Peg&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amiri:wght@700&family=Blaka+Hollow&family=Karantina&family=Lora:ital@1&family=Nunito:wght@300&family=Square+Peg&display=swap" rel="stylesheet">
    <title>@yield('title')</title>
</head>
<body>
    @include('pages.includes.nav')

    @yield('content')

    @include('pages.includes.footer')
    @yield('script')
    
    <script src="{{asset('js/error.js')}}"></script>
    <script src="{{asset('js/search.js')}}"></script>
</body>
</html>
