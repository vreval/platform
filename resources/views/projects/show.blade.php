@extends('layouts.app')

@section('content')
<main>
    <div class="flex justify-between items-center mb-8">
        <div class="text-gray-500">
            <a href="/projects">My Projects</a> / {{ $project->name }}
        </div>
        <div class="flex items-center">
            <img
                class="mr-2 rounded-full w-12 border-4 border-green-400"
                src="{{ gravatar_url($project->owner) }}"
                alt="{{ $project->owner->name }}'s avatar"
                title="{{ $project->owner->name }}"
            >

            @foreach($project->members as $member)
                <img
                    class="mr-2 rounded-full w-12 border-4 border-gray-600"
                    src="{{ gravatar_url($member) }}"
                    alt="{{ $member->name }}'s avatar"
                    title="{{ $member->name }}"
                >
            @endforeach

            <a href="{{ $project->path() . '/edit' }}" class="btn btn-green ml-6">Edit</a>
        </div>
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
            @include('errors')
        </section>
        <aside class="w-full lg:w-1/4 px-2">
            <h3 class="text-gray-400 font-bold mb-4">About</h3>
            @include('projects.card')
            @include('projects.activity.card')

            @can('administer', $project)
                @include('projects.invite')
            @endcan
            <footer class="flex justify-end mt-4">
                <a class="btn btn-gray" href="/projects">Go back</a>
            </footer>
        </aside>
    </div>
</main>
@endsection
