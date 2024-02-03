@if (session()->has('success'))
    <section id="myError" class="error error_admin_sec">
        <h1 class="info_title error_admin_text" style="color: #548686;">{{ session()->get('success') }}</h1>
    </section>
@elseif (session()->has('error'))
    <section id="myError" class="error error_admin_sec">
        <h1 class="info_title error_admin_text" style="color: #bf3b3b">{{ session()->get('error') }} </h1>
    </section>
@endif
