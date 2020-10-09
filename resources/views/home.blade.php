@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-8">
        <div class="card mb-8">
           <h2 class="text-2xl">Dashboard</h2>

            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
        </div>

        <div class="card mb-8">
            <h2 class="text-2xl">Active Projects</h2>

        </div>

        <div class="card mb-8">
            <h2 class="text-2xl">Participations</h2>

        </div>
    </div>
@endsection
