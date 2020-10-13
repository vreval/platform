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
        <div class="bg-white rounded shadow py-2">
            <div class="flex text-xs text-gray-600 font-medium uppercase">
                <div class="px-3 py-1 w-1/2">Name</div>
                <div class="px-3 py-1 w-1/4">Created at</div>
                <div class="px-3 py-1 w-1/4">Updated at</div>
                <div class="px-3 py-1 w-12">Pin</div>
            </div>
            @foreach($projects as $project)
                <a href="{{ $project->path() }}"
                   class="@if(!$loop->last)border-b @endif block flex items-center hover:bg-gray-200">
                    <div class="px-3 py-1 w-1/2">{{ $project->name }}</div>
                    <div class="px-3 py-1 w-1/4">{{ $project->created_at->toFormattedDateString() }}</div>
                    <div class="px-3 py-1 w-1/4">{{ $project->relative_updated }}</div>
                    <div class="px-3 py-1 w-12">
                        <form method="post" action="{{ $project->path() . '/pins' }}">
                            @if($project->is_pinned)
                                @csrf
                                @method('DELETE')
                                <button class="w-6 h-6"><i class="fas fa-thumbtack"></i></button>
                            @else
                                @csrf
                                <button class="w-6 h-6"><i class="fas fa-thumbtack text-gray-400"></i></button>
                            @endif
                        </form>
                    </div>
                </a>
            @endforeach
        </div>
        <new-project-modal></new-project-modal>
    </div>
@endsection
