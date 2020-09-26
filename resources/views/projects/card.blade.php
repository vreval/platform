<div class="card flex flex-col">
    <a class="block text-xl font-bold -mx-4 mb-5 p-4 border-l-4 border-green-400" href="{{ $project->path() }}">
        <h2>{{ $project->name }}</h2>
    </a>
    <p class="flex-1">{{ $project->description }}</p>

    @can('administer', $project)
        <footer>
            <form method="POST" action="{{ $project->path() }}" class="text-right">
                @method('DELETE')
                @csrf
                <button type="submit" class="text-xs">Delete</button>
            </form>
        </footer>
    @endcan
</div>
