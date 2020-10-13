@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-8">
        <h2 class="text-xl font-medium text-gray-500 mb-8">Projects</h2>
        <main>
            <div class="flex flex-wrap -mx-2">
                @foreach ($projects->where('is_pinned', true) as $project)
                    <div class="px-2 mb-4 w-full sm:w-1/2 lg:w-1/3">
                        @include('projects.card')
                    </div>
                @endforeach
                <div class="px-2 mb-4 w-full sm:w-1/2 lg:w-1/3">
                    <button @click.prevent="$modal.show('new-project')" class="flex flex-col bg-gray-300 hover:shadow-2xl transition-shadow duration-200 justify-center items-center h-64 w-full focus:outline-none">
                        <i class="block fa fa-plus-circle text-center text-4xl text-gray-500 mb-4"></i>
                        <span class="block text-center text-2xl text-gray-500">Create new Project</span>
                    </button>
                </div>
            </div>

            <projects-table :projects="{{ $projects }}" class="mb-4"></projects-table>
        </main>
        <new-project-modal></new-project-modal>
    </div>
@endsection
