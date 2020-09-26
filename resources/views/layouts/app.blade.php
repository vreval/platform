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

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body class="bg-gray-200">
<div id="app">
    <nav class="bg-white">
        <div class="container flex justify-between items-center p-4 mx-auto">
            <a class="font-bold text-lg" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <div>
                <!-- Right Side Of Navbar -->
                <ul class="ml-auto">
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
                        <dropdown>
                            <template v-slot:trigger>
                                <button class="dropdown-item block flex items-center bg-gray-200 rounded-full p-1">
                                    <img class="w-8 rounded-full" src="{{ gravatar_url(auth()->user()) }}" alt="{{ auth()->user()->name }}">
                                    <span class="mx-3">{{ auth()->user()->name }}</span>
                                </button>
                            </template>

                            <a href="#" class="dropdown-menu-link">Settings</a>
                            <form class="w-full" id="logout-form" action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-menu-link">Logout</button>
                            </form>
                        </dropdown>

                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="container mx-auto p-4">
        @yield('content')
    </main>
</div>
</body>

</html>
