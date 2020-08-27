@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card max-w-lg mx-auto p-8">
        <h3 class="text-2xl text-center">Register</h3>
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="field mb-4">
                <label for="name" class="text-xs">{{ __('Name') }}</label>
                <input id="name" type="text" class="px-3 py-1 border border-gray-400 w-full rounded-lg" name="name"
                    value="{{ old('name') }}" required autocomplete="name" autofocus>

                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="field mb-4">
                <label for="email" class="text-xs">{{ __('E-Mail Address') }}</label>

                <input id="email" type="email" class="px-3 py-1 border border-gray-400 w-full rounded-lg" name="email"
                    value="{{ old('email') }}" required autocomplete="email">

                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="field mb-4">
                <label for="password" class="text-xs">{{ __('Password') }}</label>
                <input id="password" type="password" class="px-3 py-1 border border-gray-400 w-full rounded-lg"
                    name="password" required autocomplete="new-password">

                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="field mb-4">
                <label for="password-confirm" class="text-xs">{{ __('Confirm Password') }}</label>
                <input id="password-confirm" type="password" class="px-3 py-1 border border-gray-400 w-full rounded-lg"
                    name="password_confirmation" required autocomplete="new-password">
            </div>

            <button type="submit" class="btn btn-green mt-8">
                {{ __('Register') }}
            </button>
        </form>
    </div>
</div>
@endsection