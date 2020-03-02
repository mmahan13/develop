<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon"  href="">


    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="app-cookie-name" content="{{ 'XSRF-TOKEN_' . substr(md5(env('APP_NAME')), 0, 10) }}">
    <title></title>
  
    <!-- Styles -->
 
    <script src="{{mix('/js/bootstrap.js')}}" ></script>
    <script src="{{mix('/js/angular.js')}}" ></script>
    <script src="{{mix('/js/moment-weekdaysin.js')}}"></script>

    
    
    <script src="{{mix('js/app.js')}}" ></script>

    <!-- Fonts -->
    <!--<link rel="dns-prefetch" href="https://fonts.gstatic.com">-->
    <!--<link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">-->
    <link href="{{mix('/css/app.css')}}" rel="stylesheet">
    <link href="{{mix('/css/angular-toastr.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/ui-grid.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.21/themes/redmond/jquery-ui.css" type="text/css" />
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-158768804-2"></script>
    
    <script>
    window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-158768804-2');
    </script>
</head>

<body ng-app="erp" class="bg-transparent">
    <div id="">
   <nav class="navbar navbar-expand-lg navbar-light bg-light navbar-laravel">
            <a class="navbar-brand" href="{{ url('/') }}">
                <!--<img src="{{asset('img/logo.png')}}" class="img-responsive mt-1">-->
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                </ul>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                            @guest
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            @else
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    @auth
                                        @if(Auth::getUser()->hasPermission('user_admin'))
                                            <a class="dropdown-item" href="{{ url('/admin')}} "><i class="fa fa-btn fa-cog"></i>Administrar</a>
                                        @endif
                                    @endauth
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                        <i class="fa fa-btn fa-sign-out" aria-hidden="true"></i> {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            @endguest
                        </li>
                </ul>
            </div>
        </nav>


        <main class="py-4">
            @yield('content')
        </main>
    </div>

 
</body>
</html>
