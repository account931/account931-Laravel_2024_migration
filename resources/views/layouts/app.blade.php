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

	<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>-->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
	<!-- <link href="{{ asset('permission-editor/css/app.css') }}" rel="stylesheet" /> --> <!-- for my forked package https://github.com/account931/laravel-permission-editor-my-modified -->
	
	<!-- added Bootstrap 4 icons -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    
	<!-- Latest compiled and minified CSS -->
    <!--<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">--> <!-- crash menu -->
    <!-- Optional theme -->
    <!--<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">-->
	
	</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
					
					
					    <!-- Common links (make link highlighted ) -->
						@auth <!-- visible for auth only -->
						<li class="nav-item {{ Request::is('home*') ? 'active' : '' }}">
							<a class="nav-link" href="{{ route('home') }}">{{ __('Home') }}</a>
						</li>
						
						<li class="nav-item {{ Request::is('password.request*') ? 'active' : '' }}">
							<a class="nav-link" href="{{ route('password.request') }}">{{ __('Reset pass(b)') }}</a>
						</li>

                        <li class="nav-item {{ Request::is('change-password*') ? 'active' : '' }}">
							<a class="nav-link" href="{{ route('change-password') }}">{{ __('Change passsword') }}</a>
						</li>
						
						<li class="nav-item {{ Request::is('owners*') ? 'active' : '' }}">
							<a class="nav-link" href="{{ route('/owners') }}">{{ __('Owners') }}</a>
						</li>
						
						<li class="nav-item {{ Request::is('api/owners*') ? 'active' : '' }}">
							<a class="nav-link" href="{{ route('api/owners') }}">{{ __('Owners Api') }}</a>
						</li>
						
											
						<!---------- Links Submenu_1 DropDown!!!! (Bootsrap 4) ------------------>
					    <div class="dropdown dropleft">
                            <button type="button" class="btn  dropdown-toggle" data-toggle="dropdown">
                                 Spatie menu
                            </button>
                            <div class="dropdown-menu">
							
							<ul>
                                <!-- My simple manual Spatie Laravel permission 5.3 GUI -->
						        <li class="nav-item {{ Request::is('spatie-permission-gui*') ? 'active' : '' }}">
							        <a class="nav-link" href="{{ route('spatie-permission-gui') }}">{{ __('Spatie-permission-gui') }}</a>
						        </li>
						
						        <!-- https://github.com/LaravelDaily/laravel-permission-editor Laravel permission  GUI, was later forked to mine -->
						        <li>
							        <a class="nav-link" href="{{ route('permission-editor.roles.index') }}">{{ __('SpatieUI Fork') }}</a>
						        </li>
								
								 <!-- My edited copy-pasted package Spatie Laravel permission  from https://github.com/LaravelDaily/laravel-permission-editor -->
						        <li class="nav-item {{ Request::is('roles*') ? 'active' : '' }}" style="white-space: nowrap;">
							        <a class="nav-link" href="{{ route('roles.index') }}">{{ __('SpatieGUI package my modified(TailWind to BS4)') }}</a>
						        </li> 
								
							</ul>
						    
                            </div>
                        </div>
					    <!------------- END Links Submenu_1 DropDown!!!! (Bootsrap 4) ------------->
					 
					 
					 
					 
					    <!---------- Submenu_2 DropDown!!!! (Bootsrap 4) ------------------>
					    <div class="dropdown dropleft">
                            <button type="button" class="btn  dropdown-toggle" data-toggle="dropdown">
                                 VA
                            </button>
                            <div class="dropdown-menu">
							
							<ul>
							
                                <!-- Api route protected by Passport and Spatie permission -->
						        <li class="nav-item {{ Request::is('spatie-permission-gui*') ? 'active' : '' }}">
							        <a class="nav-link" href="{{ route('api/owners/quantity') }}">{{ __('Protected Route(Passport+Spatie)') }}</a>
						        </li>
								
								<!----------- Vue Pages --------------- -->
						        <li class="nav-item {{ Request::is('vue-start-page') ? 'active' : '' }}" style="white-space: nowrap;">
							        <a class="nav-link" href="{{ route('vue-start-page') }}">{{ __('Vue Pages') }}</a>
						        </li>

                                <!----------- Vue Pages with router --------------- -->
						        <li class="nav-item {{ Request::is('vue-pages-with-router') ? 'active' : '' }}" style="white-space: nowrap;">
							        <a class="nav-link" href="{{ route('vue-pages-with-router') }}">{{ __('Vue pages with router') }}</a>
						        </li> 								
								
								<!----------- Venues Locator (in Vue) --------------- -->
						        <li class="nav-item {{ Request::is('venue-locator') ? 'active' : '' }}" style="white-space: nowrap;">
							        <a class="nav-link" href="{{ route('venue-locator') }}">{{ __('Venue store locator') }}</a>
						        </li> 	
								
								<!----------- Send-notification --------------- -->
						        <li class="nav-item {{ Request::is('send-notification') ? 'active' : '' }}" style="white-space: nowrap;">
							        <a class="nav-link" href="{{ route('send-notification') }}">{{ __('Send notification') }}</a>
						        </li					
			                    
							</ul>
							
							
								
						    
                            </div>
                        </div>
					    <!------------- END Submenu_2 DropDown!!!! (Bootsrap 4) ------------->
					 
					 
					 
						@endauth
						<!-- End Common links (make link highlighted ) -->
						
						
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
	
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	<script src="//netdna.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>                 <!-- Mega Fix (collapsed main menu won't open)-->	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css"> <!-- Sweet Alert CSS -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js'></script>     <!-- Sweet Alert JS-->  
	
	<!-- (for Vue.js + Vuex Framework asset only -->
	<!-- To register JS file for specific view only (In layout template) (for Owner Vue.js + Vuex Framework asset only) -->
    @if (in_array(Route::getFacadeRoot()->current()->uri(), ['vue-start-page'])) <!--Route::getFacadeRoot()->current()->uri()  returns testRest--> 
        <!--<script src="{{ asset('js/Vue-Pages/vue-start-page.js') }}"> defer</script> --> <!-- wpress Vue JS --> 

		<!--<link  href="{{ asset('css/Wpress_Vue_JS/wpVue_css.css') }}" rel="stylesheet">-->
        <link  href="{{ asset('css/Wpress_Vue_JS/Element_UI/theme-chalk/index.css') }}" rel="stylesheet"><!-- Elememt-UI icons (fix)  -->		
	@endif
	
	
	
	
</body>
</html>
