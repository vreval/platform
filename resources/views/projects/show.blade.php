@extends('layouts.app')

@section('content')
<main>
    <div class="flex justify-between items-center mb-8">
        <div class="text-gray-500">
            <a href="/projects">My Projects</a> / {{ $project->name }}
        </div>
        <a href="{{ $project->path() . '/edit' }}" class="btn btn-green">Edit</a>
    </div>
    <div class="flex flex-wrap -mx-2">
        <section class="w-full lg:w-3/4 px-2">
            <div class="mb-8">
                <h3 class="text-gray-400 font-bold mb-4">Scenarios</h3>
                @foreach ($project->scenarios as $scenario)
                <div class="flex items-center w-full card mb-4">
                    <form class="w-full mr-2" action="{{ $scenario->path() }}" method="post">
                        @csrf
                        @method('PATCH')
                        <input class="w-full" type="text" name="name" value="{{ $scenario->name }}">
                    </form>
                    <form action="{{ $scenario->path() }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-gray text-xs" type="submit">Remove</button>
                    </form>
                </div>
                @endforeach
                <form class="card mb-4" action="{{ $project->path() }}/scenarios" method="post">
                    @csrf
                    <input class="w-full" type="text" name="name" placeholder="Type new scenario name here...">
                </form>
            </div>
            <div class="mb-8">
                <h3 class="text-gray-400 font-bold mb-4">Checkpoints</h3>
            </div>
            <div class="mb-8">
                <h3 class="text-gray-400 font-bold mb-4">Forms</h3>
            </div>
        </section>
        <aside class="w-full lg:w-1/4 px-2">
            <h3 class="text-gray-400 font-bold mb-4">About</h3>
            @include('projects.card')
            <div class="card mt-8">
                <ul>
                    @foreach ($project->activity as $activity)
                    <li class="{{ $loop->last ? '' : 'mb-1' }} text-xs flex justify-between">
                        <div>
                            @include("projects.activity.{$activity->description}")
                        </div>
                        <div class="text-gray-400">
                            {{ $activity->created_at->diffForHumans() }}
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
            <footer class="flex justify-end mt-4">
                <a class="btn btn-gray" href="/projects">Go back</a>
            </footer>
        </aside>
    </div>
</main>
@endsection