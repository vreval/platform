@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card max-w-lg mx-auto p-8">
        <h3 class="text-2xl text-center mb-4">Edit the project</h3>
        <form class="" action="{{ $project->path() }}" method="post">
            @csrf
            @method('PATCH')
            @include('projects._form', ['buttonText' => 'Save Project'])
        </form>
    </div>
</div>
@endsection