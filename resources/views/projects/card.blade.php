<a href="{{ $project->path() }}" class="block card hover:shadow-2xl transition-shadow duration-200 h-64">
    <div class="block text-2xl mb-2 flex justify-between items-center">
        <h2>{{ $project->name }}</h2>
        <div class="flex justify-end">
            @foreach($project->members as $member)
                <img class="w-8 h-8 rounded-full -mr-3" src="{{ $member->gravatar_url }}" alt="{{ $member->name }}'s profile picture">
            @endforeach
            <img class="w-8 h-8 rounded-full" src="{{ $project->owner->gravatar_url }}" alt="{{ $project->owner->name }}'s profile picture">
        </div>
    </div>
    <div class="mb-4">
        <span class="block text-sm font-medium text-gray-600">Created: {{ $project->created_at->toFormattedDateString() }}</span>
        <span class="block text-sm font-medium text-gray-600">Updated {{ $project->updated_at->diffForHumans() }} by {{ $project->activity->first()->user->name }}</span>
    </div>
    <p class="flex-1">{{ str_limit($project->description) }}</p>
</a>
