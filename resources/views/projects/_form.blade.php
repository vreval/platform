<div class="mb-4">
    <label for="name">Name</label>
    <input class="px-3 py-1 border border-gray-400 w-full rounded-lg" type="text" name="name" required
        placeholder="My next project" value="{{ $project->name }}">
</div>

<div class="mb-8">
    <label for="description">Description</label>
    <textarea class="px-3 py-1 border border-gray-400 w-full rounded-lg" name="description" rows="5"
        placeholder="Type project description here...">{{ $project->description }}</textarea>
</div>

<div>
    <button class="btn btn-green" type="submit">{{ $buttonText }}</button>
    <a class="underline ml-4 hover:text-gray-500" href="{{ $project->path() }}">Cancel</a>
</div>

<div class="mb-4">
    <ul>
        @if ($errors->any())
        @foreach ($errors->all() as $error)
        <li class="text-sm text-red-600">{{ $error }}</li>
        @endforeach
        @endif
    </ul>
</div>