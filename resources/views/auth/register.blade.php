@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <div class="card max-w-lg mx-auto mt-32">
        <h3 class="text-2xl text-center">Register</h3>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="mb-4">
                <label for="name" class="input-label">Name</label>
                <input id="name" type="text" class="input" name="name" value="{{ old('name') }}" required
                    autocomplete="name" autofocus>

                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="input-label">E-Mail Addresse</label>
                <input id="email" type="email" class="input" name="email" value="{{ old('email') }}" required
                    autocomplete="email">

                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="input-label">Password</label>
                <input id="password" type="password" class="input" name="password" required autocomplete="new-password">

                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password-confirm" class="input-label">Confirm Password</label>
                <input id="password-confirm" type="password" class="input" name="password_confirmation" required
                    autocomplete="new-password">
            </div>

            <button type="submit" class="btn btn-green mt-8">Register</button>
        </form>
    </div>
</div>
@endsection
