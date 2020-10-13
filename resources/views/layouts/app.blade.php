<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')VREVAL - The user centric evaluation tool</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body class="bg-gray-200">
<div id="app">
    <nav id="main-navigation" class="bg-gray-800 text-white sticky top-0 transition-all duration-200 bg-opacity-50">
        <div class="container flex justify-between items-center py-4 mx-auto">
            <div class="flex items-center">
                <a class="font-bold text-3xl" href="{{ url('/') }}">
                    <span class="text-green-400">VR</span>EVAL
                </a>
                <nav class="flex ml-6">
                    <a href="/#faq" class="block font-medium mx-2">FAQ</a>
                    <a href="/#tutorials" class="block font-medium mx-2">How To</a>
                    <a href="/#team" class="block font-medium mx-2">Our Team</a>
                </nav>
            </div>
            <nav class="flex items-center">
                <!-- Authentication Links -->
                @guest
                    <a class="btn btn-gray-text text-sm ml-4" href="{{ route('login') }}">{{ __('Login') }}</a>
                    @if (Route::has('register'))
                        <a class="btn btn-green text-sm ml-4"
                           href="{{ route('register') }}">{{ __('Register') }}</a>
                    @endif
                @else
                    <a href="/home" class="block text-2xl mr-4"><i class="fa fa-home"></i></a>

                    <dropdown class="text-gray-800 min-w-32">
                        <template v-slot:trigger>
                            <button class="dropdown-item block flex items-center bg-gray-200 rounded-full p-1 w-full">
                                <img class="w-8 rounded-full" src="{{ gravatar_url(auth()->user()) }}"
                                     alt="{{ auth()->user()->name }}">
                                <span class="mx-3">{{ auth()->user()->name }}</span>
                            </button>
                        </template>

                        <div class="py-2 border-b">
                            <h4 class="text-xs uppercase text-gray-600 font-bold px-2">Management</h4>
                            <a href="/projects" class="dropdown-menu-link">Projects</a>
                            <a href="#" class="dropdown-menu-link">Evaluations</a>
                            <a href="#" class="dropdown-menu-link">Participations</a>
                        </div>
                        <div class="py-2 border-b">
                            <h4 class="text-xs uppercase text-gray-600 font-bold px-2">Profile</h4>
                            <a href="#" class="dropdown-menu-link">My Contacts</a>
                            <a href="#" class="dropdown-menu-link">My Profile</a>
                        </div>
                        <form class="w-full py-2" id="logout-form" action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-menu-link">Logout</button>
                        </form>
                    </dropdown>
                @endguest
            </nav>
        </div>
    </nav>

    <main class="bg-gray-200">
        @yield('content')
    </main>
</div>
<footer class="h-32 mt-12 flex justify-center items-center">
    <p>VREVAL 2020</p>
</footer>
</body>
</html>
