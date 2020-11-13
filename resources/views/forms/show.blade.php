@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-8">
        <div class="flex justify-between items-center mb-8">
            <div class="text-gray-500">
                <a href="/projects">My Projects</a> / <a href="{{ $project->path() }}">{{ $project->name }}</a>
                / {{ $form->name }}
            </div>
            <a href="{{ $project->path() . '/edit' }}" @click.prevent="$modal.show('edit-project')"
               class="btn btn-gray-outline ml-6">Edit</a>
        </div>
        <div class="flex justify-end">
            <img class="mr-2 rounded-full w-12 border-4 border-green-400" src="{{ gravatar_url($project->owner) }}"
                 alt="{{ $project->owner->name }}'s avatar" title="{{ $project->owner->name }}">

            @foreach($project->members as $member)
                <img class="mr-2 rounded-full w-12 border-4 border-gray-600" src="{{ gravatar_url($member) }}"
                     alt="{{ $member->name }}'s avatar" title="{{ $member->name }}">
            @endforeach
        </div>

        <form-builder :initial-form="{{ json_encode($form) }}"></form-builder>
    </div>
@endsection
