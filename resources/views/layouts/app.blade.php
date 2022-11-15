<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        .wrapperAlert {
        height: 400px;
        overflow: hidden;
        border-radius: 12px;
        border: thin solid #ddd;           
        }
        .topHalf {
        width: 100%;
        color: white;
        overflow: hidden;
        min-height: 250px;
        position: relative;
        padding: 40px 0;
        background: rgb(0,0,0);
        background: -webkit-linear-gradient(45deg, #019871, #a0ebcf);
        }
        .topHalf p {
        margin-bottom: 30px;
        }
        svg {
        fill: white;
        }
        .topHalf h1 {
        font-size: 2.25rem;
        display: block;
        font-weight: 500;
        letter-spacing: 0.15rem;
        text-shadow: 0 2px rgba(128, 128, 128, 0.6);
        }
        .bg-bubbles{
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;            
        z-index: 1;
        }
        li{
        position: absolute;
        list-style: none;
        display: block;
        width: 40px;
        height: 40px;
        background-color: rgba(255, 255, 255, 0.15);
        bottom: -160px;
        -webkit-animation: square 20s infinite;
        animation:         square 20s infinite;
        -webkit-transition-timing-function: linear;
        transition-timing-function: linear;
        }
        li:nth-child(1){
        left: 10%;
        }		
        li:nth-child(2){
        left: 20%;
        width: 80px;
        height: 80px;
        animation-delay: 2s;
        animation-duration: 17s;
        }		
        li:nth-child(3){
        left: 25%;
        animation-delay: 4s;
        }		
        li:nth-child(4){
        left: 40%;
        width: 60px;
        height: 60px;
        animation-duration: 22s;
        background-color: rgba(white, 0.3);
        }		
        li:nth-child(5){
        left: 70%;
        }		
        li:nth-child(6){
        left: 80%;
        width: 120px;
        height: 120px;
        animation-delay: 3s;
        background-color: rgba(white, 0.2);
        }		
        li:nth-child(7){
        left: 32%;
        width: 160px;
        height: 160px;
        animation-delay: 7s;
        }		
        li:nth-child(8){
        left: 55%;
        width: 20px;
        height: 20px;
        animation-delay: 15s;
        animation-duration: 40s;
        }		
        li:nth-child(9){
        left: 25%;
        width: 10px;
        height: 10px;
        animation-delay: 2s;
        animation-duration: 40s;
        background-color: rgba(white, 0.3);
        }		
        li:nth-child(10){
        left: 90%;
        width: 160px;
        height: 160px;
        animation-delay: 11s;
        }
        @-webkit-keyframes square {
        0%   { transform: translateY(0); }
        100% { transform: translateY(-500px) rotate(600deg); }
        }
        @keyframes square {
        0%   { transform: translateY(0); }
        100% { transform: translateY(-500px) rotate(600deg); }
        }
        .bottomHalf {
        align-items: center;
        padding: 35px;
        }
        .bottomHalf p {
        font-weight: 500;
        font-size: 1.05rem;
        margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ env('APP_SITE', url('/')) }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
