@extends('layouts.app')

@section('content')
    <main>
        <div class="flex justify-between items-center mb-8">
            <div class="text-gray-500">
                <a href="/projects">My Projects</a> / {{ $project->name }}
            </div>
            <div class="flex items-center">
                <img class="mr-2 rounded-full w-12 border-4 border-green-400" src="{{ gravatar_url($project->owner) }}"
                     alt="{{ $project->owner->name }}'s avatar" title="{{ $project->owner->name }}">

                @foreach($project->members as $member)
                    <img class="mr-2 rounded-full w-12 border-4 border-gray-600" src="{{ gravatar_url($member) }}"
                         alt="{{ $member->name }}'s avatar" title="{{ $member->name }}">
                @endforeach

                <a href="{{ $project->path() . '/edit' }}" @click.prevent="$modal.show('edit-project')"
                   class="btn btn-green ml-6">Edit</a>
            </div>
        </div>
        <div class="flex flex-wrap -mx-2">
            <section class="w-full lg:w-3/4 px-2">
                <div class="mb-8">
                    <h3 class="text-gray-400 font-bold mb-4">Scenarios</h3>
                    <div class="w-full card mb-4">
                        <div class="flex -mx-4 px-4 py-2 text-sm font-bold text-gray-500">
                            <div class="w-2/3">Name</div>
                            <div class="w-1/3">Associated Checkpoints</div>
                        </div>
                        @foreach ($project->scenarios as $scenario)
                            <div
                                class="flex items-center hover:bg-gray-200 -mx-4 px-4 py-2 @if(!$loop->last)border-b @endif">
                                <div class="w-2/3">
                                    {{ $scenario->name }}
                                </div>
                                <div class="w-1/3">
                                    {{ $scenario->checkpoints->count() }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <form class="card mb-4" action="{{ $project->path() }}/scenarios" method="post">
                        @csrf
                        <input class="input" type="text" name="name"
                               placeholder="Type new scenario name here and press 'ENTER'...">
                    </form>
                </div>

                <div class="mb-8">
                    <h3 class="text-gray-400 font-bold mb-4">Checkpoints</h3>
                    <div class="w-full card mb-4">
                        <div class="flex -mx-4 px-4 py-2 text-sm font-bold text-gray-500">
                            <div class="w-2/3">Name</div>
                            <div class="w-1/6">Behaviour</div>
                            <div class="w-1/6">Type</div>
                        </div>
                        @foreach ($project->checkpoints as $checkpoint)
                            <div
                                class="flex items-center hover:bg-gray-200 -mx-4 px-4 py-2 @if(!$loop->last)border-b @endif">
                                <div class="w-2/3 overflow-hidden" style="white-space: nowrap;">
                                    {{ $checkpoint->name }}
                                </div>
                                <div class="w-1/6">
                                    Default
                                </div>
                                <div class="w-1/6">
                                    Basic, Info, Gate
                                </div>
                            </div>
                        @endforeach
                    </div>
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
            </aside>
        </div>
    </main>
    @can('administer', $project)
        <edit-project-modal :project="{{ $project }}" can-administer></edit-project-modal>
    @endcan
    @cannot('administer', $project)
        <edit-project-modal :project="{{ $project }}"></edit-project-modal>
    @endcan
@endsection
