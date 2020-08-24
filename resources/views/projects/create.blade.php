@extends('layouts.app')

@section('content')
<h2>Create a new Project</h2>
<form class="" action="/projects" method="post">
    @csrf
    <div class="mb-4">
        <label for="name">Name</label>
        <div>
            <input class="w-full rounded-lg p-4" type="text" name="name">
        </div>
    </div>
    <div class="mb-4">
        <label for="description">Description</label>
        <div>
            <textarea class="w-full rounded-lg p-4" name="description" rows="5"></textarea>
        </div>
    </div>
    <div>
        <button class="btn btn-green" type="submit">Create</button>
        <a href="/projects">Cancel</a>
    </div>
</form>
@endsection