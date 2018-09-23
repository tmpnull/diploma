<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        #page-loading {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            z-index: 999;
            background-color: #F5F5F5;
        }

        .three-balls {
            margin: 0 auto;
            width: 70px;
            text-align: center;
            position: absolute;
            left: 0;
            right: 0;
            top: 45%;
        }

        .three-balls .ball {
            position: relative;
            width: 15px;
            height: 15px;
            border-radius: 50%;
            display: inline-block;
            -webkit-animation: bouncedelay 3.0s infinite cubic-bezier(.62, .28, .23, .99) both;
            animation: bouncedelay 3.0s infinite cubic-bezier(.62, .28, .23, .99) both;
        }

        .three-balls .ball1 {
            -webkit-animation-delay: -.16s;
            animation-delay: -.16s;
        }

        .three-balls .ball2 {
            -webkit-animation-delay: -.08s;
            animation-delay: -.08s;
        }

        @keyframes bouncedelay {
            0% {
                bottom: 0;
                background-color: #03A9F4;
            }
            16.66% {
                bottom: 40px;
                background-color: #FB6542;
            }
            33.33% {
                bottom: 0px;
                background-color: #FB6542;
            }
            50% {
                bottom: 40px;
                background-color: #FFBB00;
            }
            66.66% {
                bottom: 0px;
                background-color: #FFBB00;
            }
            83.33% {
                bottom: 40px;
                background-color: #03A9F4;
            }
            100% {
                bottom: 0;
                background-color: #03A9F4;
            }
        }

        @-webkit-keyframes bouncedelay {
            0% {
                bottom: 0;
                background-color: #03A9F4;
            }
            16.66% {
                bottom: 40px;
                background-color: #FB6542;
            }
            33.33% {
                bottom: 0px;
                background-color: #FB6542;
            }
            50% {
                bottom: 40px;
                background-color: #FFBB00;
            }
            66.66% {
                bottom: 0px;
                background-color: #FFBB00;
            }
            83.33% {
                bottom: 40px;
                background-color: #03A9F4;
            }
            100% {
                bottom: 0;
                background-color: #03A9F4;
            }
        }
    </style>
    <title>Timetable</title>
</head>
<body>
<div id="app">
    <div id="page-loading">
        <div class="three-balls">
            <div class="ball ball1"></div>
            <div class="ball ball2"></div>
            <div class="ball ball3"></div>
        </div>
    </div>
</div>
<script src="{{ asset('spa/main.js') }}" defer></script>
<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:400,500,700,400italic|Material+Icons">
</body>
</html>
