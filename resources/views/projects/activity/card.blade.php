<div class="card mt-8">
    <ul>
        @foreach ($project->activity as $activity)
            <li class="{{ $loop->last ? '' : 'mb-1' }} text-xs flex justify-between">
                <div>
                    @include("projects.activity.{$activity->description}")
                </div>
                <div class="text-gray-400">
                    {{ $activity->created_at->diffForHumans() }}
                </div>
            </li>
        @endforeach
    </ul>
</div>
