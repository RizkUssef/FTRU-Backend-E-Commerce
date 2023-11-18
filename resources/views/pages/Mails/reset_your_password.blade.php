<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Change Your Password</title>
        <link rel = "icon" href ="../../img/logo/FTRU.svg"  type = "image/svg+xml">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Karantina&family=Lora:ital@1&family=Nunito:wght@300&family=Square+Peg&display=swap" rel="stylesheet">
        <style>
            .bg {
            font-family: 'Karantina', cursive;
            }
            .bg .email_container .tlogo {
            width: 119px;
            height: 70px;
            margin: auto; 
            margin-top: 20px;
            margin-bottom: 20px;
            }
            .bg .email_container .tlogo .top_logo {
            width: 100%;
            height: 100%;
            }
            .bg .email_container .tlogo .top_logo img {
            width: 100%;
            height: 100%;
            }
            .bg .email_container .hint {
            margin: auto;
            width: 90%;
            }
            .bg .email_container .hint p {
            color: rgba(63, 64, 69,0.6);
            }
            .bg .email_container .hint p span {
            color: #548686;
            text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.76);
            /* margin-bottom: 50px; */
            }
            .bg .email_container .bottom_logo {
            width: 305px;
            height: 54px;
            margin: auto
            }
            .bg .email_container .bottom_logo img {
            width: 100%;
            height: 100%;
            }
            .bg .email_container .all {
                width: 90%;
                border-radius: 15px; 
                box-shadow: 0px 0px 15px 5px rgba(0,0,0, 0.7); 
                backdrop-filter: blur(7px); 
                background-color: #3F4045; 
                margin: auto; 
                padding-bottom: 50px;
            }
            .bg .email_container .all h1{
                color:#E9E8DE; 
                text-align: center;
                font-size: 30px;
                padding-top: 0px;
                letter-spacing: 1px;

            }
            .bg .email_container .all .error_head h1 {
                color:#E9E8DE; 
                text-align: center;
                font-size: 30px;
                padding-top: 20px;
                letter-spacing: 1px;
            }
            .bg .email_container .all .error_head .text_for {
                color: #E9E8DE;
                text-align: center;
                font-size: 15px;
                letter-spacing: 1px;
                padding: 0px 10px
            }
            .bg .email_container .all .error_image {
            width: 150px;
            height: 150px;
            margin: auto;
            border-radius: 25px;
            margin-bottom: 30px;
            margin-top: 20px;
            }
            .bg .email_container .all .error_image img {
            width: 100%;
            height: 100%;
            border-radius: 25px;
            }
            .bg .email_container .all .error_head {
            color: #3F4045;
            text-align: center;
            }
            .bg .email_container .all .submit {
            padding: 5px 7px;
            border-radius: 8px;
            border-color:#E9E8DE;
            border-style: solid;
            color: #E9E8DE;
            display: block;
            margin: auto;
            width: 120px;
            border-width: 0.1px;
            background-color: transparent;
            text-decoration: none
            }
            .bg .email_container .all .submit:hover {
            color: #3F4045;
            background-color: #E9E8DE;
            border-color: #E9E8DE;
            }
            @media (min-width: 768px) {
                .bg .email_container .all {
                    width: 50%;
                }
                .bg .email_container .all .error_head h1 {
                    font-size: 40px;
                }
                .bg .email_container .all .error_head .text_for {
                    font-size: 20px;
                }
                .bg .email_container .hint {
                    width: 50%;
                }
                .bg .email_container .all .submit {
                    width: 86px;
                }
            }
        </style>
    </head>
    <body style="font-family: 'Karantina', cursive; background-color: #E9E8DE; border-radius: 25px; padding: 30px 0px">  
        <section class="bg">
            <section class="email_container">
                <section class="tlogo" >
                    <div class="top_logo">
                        {{-- <img src="../../img/logo/FTRUkoi.png" alt="no"> --}}
                        <img src="{{$message->embed(public_path("img/logo/FTRUkoi.png"))}}" alt="no">
                    </div>
                </section>
            
            <div class="all" >
                    <div class="error_head">
                        <h1>Welcome to our website</h1>
            <p class="text_for">Hello my Friend, to reset your password just use this link</p>
                    </div>
                    <div class="error_image">
                        {{-- <img src="../../img/illast/Reset password-pana.png" alt="no" > --}}
                        <img src="{{$message->embed(public_path("img/illast/Reset password-pana.png"))}}" alt="no">
                    </div>                
                    <a href="{{ route('Reset password', $token) }}" class="submit" >Reset Your Password</a>
                </div>
                <div class="hint">
                    <p>For your notes this masterpiece made by the most perfect web developers
                        <span>” Faten Elmarzouki ” & “ Rizk Ussef ”</span></p>
                </div>
                <div class="bottom_logo">
                    {{-- <img src="../../" alt="no"> --}}
                    <img src="{{$message->embed(public_path("img/logo/Component koi.png"))}}" alt="no">
                </div>
            </section>
        </section>

    </body>
</html>