@extends('layouts.app')
@section('content')
    <div class="container mx-auto mt-8">
        <div class="flex justify-between items-center mb-8">
            <div class="text-gray-500">
                <a href="/projects">My Projects</a> / <a href="{{ $project->path() }}">{{ $project->name }}</a>
                / {{ $scenario->name }}
            </div>
        </div>

        <div class="mt-4">
            <builder-wrapper
                    wrappee="scenario-builder"
                    endpoint="{{ $scenario->path() }}"
                    :project="{{ json_encode($project) }}"
                    :data="{{ json_encode($scenario->load('fields')) }}"
            ></builder-wrapper>
        </div>
    </div>
@endsection
