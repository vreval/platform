@extends('layouts.app')

@section('content')
<header class="flex justify-between items-end mb-4">
    <h2 class="text-gray-400">Projects</h2>
    <a class="btn btn-green" href="/projects/create">New</a>
</header>
<main>
    <div class="flex flex-wrap -mx-2">
        @forelse ($projects as $project)
        <div class="p-2 w-full sm:w-1/2 lg:w-1/4">
            @include('projects.card')
        </div>
        @empty
        <div>
            <p>No Projects yet.</p>
        </div>
        @endforelse
    </div>
</main>
@endsection