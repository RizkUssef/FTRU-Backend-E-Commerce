@if (session()->has("success"))
<section id="myError" class="error">
    <div class="image">
        <img src="{{asset('img/Stars/Good team.gif')}}" alt="">
    </div>
    <div class="text">
        <h1 class="info_title" style="color: #548686" >{{session()->get("success")}}</h1>
    </div>
</section>
@elseif (session()->has("error"))
<section id="myError" class="error">
    <div class="image">
        <img src="{{asset('img/Stars/red_error_2.gif')}}" alt="">
    </div>
    <div class="text">
        <h1 class="info_title" style="color: #bf3b3b">{{session()->get("error")}} </h1>  
    </div>
</section>
@endif