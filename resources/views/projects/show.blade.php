@extends('layouts.app')

@section('content')
<main>
    <p class="mb-8 text-gray-500">
        <a href="/projects">My Projects</a> / {{ $project->name }}
    </p>
    <div class="flex flex-wrap -mx-2">
        <section class="w-full lg:w-3/4 px-2">
            <div class="mb-8">
                <h3 class="text-gray-400 font-bold mb-4">Scenarios</h3>
                @forelse ($project->scenarios as $scenario)
                <div class="card mb-4">{{ $scenario->name }}</div>
                @empty
                <p>No scenarios yet.</p>
                @endforelse
            </div>
            <div class="mb-8">
                <h3 class="text-gray-400 font-bold mb-4">Checkpoints</h3>
            </div>
            <div class="mb-8">
                <h3 class="text-gray-400 font-bold mb-4">Forms</h3>
            </div>
        </section>
        <aside class="w-full lg:w-1/4 px-2">
            @include('projects.card')
            <footer class="flex justify-end mt-4">
                <a class="btn btn-gray" href="/projects">Go back</a>
            </footer>
        </aside>
    </div>
</main>
@endsection