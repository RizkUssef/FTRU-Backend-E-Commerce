    <!-- footer start -->
    <footer class="footer">
        <div class="logo_footer">
            <img src="{{asset("img/logo/FTRU.svg")}}" alt="" srcset="">
        </div>
        <div class="company">
            <div class="head">
                <h1>OUR COMPANY</h1>
            </div>
            <div class="links">
                <div class="links_pos">
                    <a href="#">ABOUT</a>
                    <a  href="#">CARRER</a>
                </div>
            </div>
        </div>
        <div class="product">
            <div class="head">
                <h1>OUR PRODUCTS</h1>
            </div>
            <div class="links">
                <div class="links_pos">
                    @foreach ($category_name as $item)
                        <a href="{{route('show category',["category_name"=>$item->name])}}">{{$item->name}}</a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="contact">
            <div class="head">
                <h1>CONTACT US</h1>
            </div>
            <div class="email_phone">
                <div class="email">
                    <h1>EMAIL</h1>
                    <P>exampleegy@gmail.com</P>
                </div>
                <div class="phone">
                    <h1>PHONE</h1>
                    <P>01457857896</P>
                </div>
                <div class="links">
                    <a href="#"><img src="{{asset("img/Socail/facebook.png")}}" alt="not here"></a>
                    <a href="#"><img src="{{asset("img/Socail/instagram.png")}}" alt="not here"></a>
                    <a href="#"><img src="{{asset("img/Socail/linkedin.png")}}" alt="not here"></a>
                    <a href="#"><img src="{{asset("img/Socail/twitter-sign.png")}}" alt="not here"></a>
                </div>
            </div>
        </div>
        <div class="bottom_footer">
            <div class="head">
                <h1>OUR QUOTE</h1>
            </div>
            <div class="paragraph">
                <p>Αυτός ο ιστότοπος έχει υλοποιηθεί από τους καλύτερους προγραμματιστές ιστοτόπων σε αυτόν τον γαλαξία και γειτονικούς γαλαξίες </p>
            </div>
            <div class="names">
                <h3>“Ριζκ Ουσέφ” & "Φατέν Ελμαρζούκη"</h3>
            </div>
            <div class="last">
                <h3>ψυχή</h3>
            </div>
        </div>
    </footer>
    <!-- footer end -->