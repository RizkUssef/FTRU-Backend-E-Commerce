<section id="search_page" class="admin_search">
    <div class="form_admin_search">
        <form id="submit_search" class="form_ad" action="{{route('show search')}}" method="POST">
            @csrf
            <input autocomplete="off" id="search" class="search" type="text" name="search">
            <button id="btn_search" class="btn" type="submit"><img src="{{ asset('img/Stars/search green.png') }}" alt="no"></button>
        </form>
        <div id="sugg_list" class="sugg_container">
        </div>
    </div>
</section>
