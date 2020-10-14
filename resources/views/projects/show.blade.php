@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-8">
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
                    <data-table
                        :items="{{ $project->scenarios }}"
                        :options="scenariosTableOptions"
                        item-component="scenarios-table-row"
                    ></data-table>
                    <button
                        type="button"
                        class="mt-4 text-gray-500 text-lg font-medium rounded flex flex-col bg-gray-300 hover:shadow-2xl transition-shadow duration-200 justify-center items-center w-full py-4 focus:outline-none"
                        @click.prevent="$modal.show('new-scenario')"
                    ><i class="fa fa-plus-circle mr-2"></i>New Scenario
                    </button>
                </div>

                <div class="mb-8">
                    <h3 class="text-gray-400 font-bold mb-4">Checkpoints</h3>
                    <data-table
                        :items="{{ $project->checkpoints }}"
                        :options="checkpointsTableOptions"
                        item-component="scenarios-table-row"
                    ></data-table>
                    <button
                        type="button"
                        class="mt-4 text-gray-500 text-lg font-medium rounded flex flex-col bg-gray-300 hover:shadow-2xl transition-shadow duration-200 justify-center items-center w-full py-4 focus:outline-none"
                        @click.prevent="$modal.show('new-scenario')"
                    ><i class="fa fa-plus-circle mr-2"></i>New Checkpoint
                    </button>
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
    </div>

    @can('administer', $project)
        <edit-project-modal :project="{{ $project }}" can-administer></edit-project-modal>
    @endcan

    @cannot('administer', $project)
        <edit-project-modal :project="{{ $project }}"></edit-project-modal>
    @endcannot

    <new-scenario-modal :project="{{ $project }}"></new-scenario-modal>
@endsection
