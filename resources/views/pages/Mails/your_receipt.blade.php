<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Your Password</title>
    <link rel = "icon" href ="../../img/logo/FTRU.svg" type = "image/svg+xml">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Karantina&family=Lora:ital@1&family=Nunito:wght@300&family=Square+Peg&display=swap"
        rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Amiri:wght@700&family=Blaka+Hollow&family=Karantina&family=Lora:ital@1&family=Nunito:wght@300&family=Square+Peg&display=swap"
        rel="stylesheet">
    <style>
        .receipt_container {
            width: 90%;
            margin: auto;
            box-shadow: 0px 0px 15px 5px rgba(63, 64, 69, 0.3);
            backdrop-filter: blur(7px);
            background-color: #ffffff;
            border-radius: 25px;
            padding: 20px 0px;
            color: #3f4045;
            text-transform: capitalize;
        }

        .receipt_container p {
            font-size: 16px
        }

        .receipt_container .logo {
            width: 130px;
            margin: auto;
            margin-bottom: 10px
        }

        .receipt_container .logo img {
            width: 100%;
        }

        .receipt_container .description {
            width: 90%;
            margin: auto;
        }

        .receipt_container .description p {
            text-align: center;
        }

        .receipt_container .products {
            width: 90%;
            margin: auto;
        }

        .receipt_container .products .product {
            width: 100%;
            position: relative;
        }

        .receipt_container .products .product .price {
            display: inline-block;
            position: absolute;
            right: 0px;
            color: rgba(63, 64, 69, 0.7);
        }

        .receipt_container .products .product .name {
            display: inline-block;
            color: #000000;
            font-size: 16px;
            margin-right: 20px;
        }

        .receipt_container .line {
            height: 1px;
            background-color: rgb(63, 64, 69);
            width: 90%;
            margin: auto;
        }

        .receipt_container .discounts {
            width: 90%;
            margin: auto;
        }

        .receipt_container .discounts .discount {
            width: 100%;
            position: relative;
        }

        .receipt_container .discounts .discount .price {
            display: inline-block;
            position: absolute;
            right: 0px;
            color: rgba(63, 64, 69, 0.7);
        }

        .receipt_container .discounts .discount .name {
            display: inline-block;
            color: #000000;
            font-size: 16px;
            margin-right: 20px;
        }

        .receipt_container .total {
            width: 90%;
            margin: auto;
            position: relative;
        }

        .receipt_container .total .price {
            display: inline-block;
            position: absolute;
            right: 0px;
            font-size: 20px;
            color: rgba(63, 64, 69, 0.7);
        }

        .receipt_container .total .name {
            display: inline-block;
            font-size: 20px;
            color: #000000;
            margin-right: 20px;
        }

        .buttom_logo {
            width: 300px;
            margin: auto;
            margin-top: 30px
        }

        .buttom_logo img {
            width: 100%;

        }

        @media screen and (min-width: 740px) and (max-width: 1000px) {
            .receipt_container {
                width: 60%;
            }
        }

        @media screen and (min-width: 1001px) and (max-width: 1700px) {
            .receipt_container {
                width: 40%;
            }
        }
    </style>
</head>

<body style="background-color: #E9E8DE; border-radius: 25px; padding: 30px 0px">
    <section class="receipt_container">
        <div class="logo">
            <img src="{{ $message->embed(public_path('img/logo/email_logo.png')) }}" alt="">
        </div>
        <div class="description">
            <p>Thank you for choosing FTRU Store! We appreciate your business. Below is the receipt for your recent
                transaction</p>
        </div>
        <div class="products">
            @foreach ($order->orderProductCS as $proCS)
                @php
                    $color = $proCS->ProCSProColor;
                    $size = $proCS->ProCSProSize;
                    $unit = $color->colorProduct->main_price - ($color->colorProduct->main_price * $color->colorProduct->main_discount) / 100;
                @endphp
                <div class="product">
                    <p class="name">{{ $color->colorProduct->name }}</p>
                    <p class="price">{{ $unit * $order->OrderOrderDetails[$loop->index]->quantity }} $</p>
                </div>
            @endforeach
        </div>
        <div class="line"></div>
        <div class="discounts">
            <div class="discount">
                <p class="name">Discount</p>
                <p class="price">{{$order->discount}} $</p>
            </div>
            <div class="discount">
                <p class="name">Tax</p>
                <p class="price">{{$order->tax}} $</p>
            </div>
            <div class="discount">
                <p class="name">Delaviry</p>
                <p class="price">{{$order->shipping}} $</p>
            </div>
        </div>
        <div class="line"></div>
        <div class="total">
            <p class="name">Total</p>
            <p class="price">{{$order->total}} $</p>
        </div>
        <div class="description">
            <p>If you have any questions or concerns regarding this transaction, please don't hesitate to contact us at
            </p>
            <p>Email : Ftru@gmail.com</p>
            <p>Phone : 0124578963</p>
        </div>
    </section>
    <div class="buttom_logo">
        <img src="{{ $message->embed(public_path('img/logo/Component koi.png')) }}" alt="">
    </div>


</body>

</html>
