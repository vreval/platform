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
                    <a href="/#tutorials" class="block font-medium mx-2">Tutorials</a>
                    <a href="/#team" class="block font-medium mx-2">Our Team</a>
                </nav>
            </div>
            <nav class="flex">
                <!-- Authentication Links -->
                @guest
                    <a class="btn btn-gray-text text-sm ml-4" href="{{ route('login') }}">{{ __('Login') }}</a>
                    @if (Route::has('register'))
                        <a class="btn btn-green text-sm ml-4"
                           href="{{ route('register') }}">{{ __('Register') }}</a>
                    @endif
                @else
                    <dropdown class="text-gray-800">
                        <template v-slot:trigger>
                            <button class="dropdown-item block flex items-center bg-gray-200 rounded-full p-1 w-full">
                                <img class="w-8 rounded-full" src="{{ gravatar_url(auth()->user()) }}"
                                     alt="{{ auth()->user()->name }}">
                                <span class="mx-3">{{ auth()->user()->name }}</span>
                            </button>
                        </template>

                        <a href="/projects" class="dropdown-menu-link">Projects</a>
                        <a href="#" class="dropdown-menu-link">Contacts</a>
                        <a href="#" class="dropdown-menu-link">My Profile</a>
                        <form class="w-full" id="logout-form" action="{{ route('logout') }}" method="POST">
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
</body>
</html>
