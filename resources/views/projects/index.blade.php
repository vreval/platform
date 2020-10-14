@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-8">
        <h2 class="text-xl font-medium text-gray-500 mb-4">Pinned</h2>
        <div class="flex flex-wrap -mx-2 mb-8">
            @foreach ($projects->where('is_pinned', true) as $project)
                <div class="px-2 mb-4 w-full sm:w-1/2 lg:w-1/3">
                    @include('projects.card')
                </div>
            @endforeach
            <div class="px-2 mb-4 w-full sm:w-1/2 lg:w-1/3">
                <button @click.prevent="$modal.show('new-project')"
                        class="flex flex-col bg-gray-300 hover:shadow-2xl transition-shadow duration-200 justify-center items-center h-64 w-full focus:outline-none">
                    <i class="block fa fa-plus-circle text-center text-4xl text-gray-500 mb-4"></i>
                    <span class="block text-center text-2xl text-gray-500">Create new Project</span>
                </button>
            </div>
        </div>

        <h2 class="text-xl font-medium text-gray-500 mb-4">All</h2>
        <data-table :options="projectsTableOptions" :items="{{ $projects }}" item-component="projects-table-row"></data-table>
        <new-project-modal></new-project-modal>
    </div>
@endsection
