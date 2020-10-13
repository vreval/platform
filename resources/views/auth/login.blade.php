@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <div class="card max-w-lg mx-auto mt-32">
        <h3 class="text-2xl text-center">Login</h3>

        <form method="POST" action="/login">
            @csrf
            <div class="mb-4">
                <label for="email" class="input-label">E-Mail Address</label>
                <input id="email" type="email" class="input" name="email" value="{{ old('email') }}" required
                    autocomplete="email" autofocus>

                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="input-label">Password</label>
                <input id="password" type="password" class="input" name="password" required
                    autocomplete="current-password">

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
