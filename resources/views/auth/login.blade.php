@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card max-w-lg mx-auto">
        <div class="mb-4">Login</div>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-4">
                <label for="email" class="text-xs font-bold font-gray-600">{{ __('E-Mail Address') }}</label>

                <div class="col-md-6">
                    <input id="email" type="email" class="px-3 py-1 border border-gray-400 w-full rounded-lg"
                        name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <label for="password" class="text-xs font-bold font-gray-600">{{ __('Password') }}</label>

                <input id="password" type="password" class="px-3 py-1 border border-gray-400 w-full rounded-lg"
                    name="password" required autocomplete="current-password">

                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="mb-4">
                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                    {{ old('remember') ? 'checked' : '' }}>

                <label class="form-check-label" for="remember">
                    {{ __('Remember Me') }}
                </label>
            </div>

            <div>
                <button type="submit" class="btn btn-green">
                    {{ __('Login') }}
                </button>

                @if (Route::has('password.request'))
                <a class="btn" href="{{ route('password.request') }}">
                    {{ __('Forgot Your Password?') }}
                </a>
                @endif
            </div>
        </form>
    </div>
</div>
@endsection