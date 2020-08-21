<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Projects Index</title>
</head>

<body>
    <h1>Projects</h1>
    <ul>
        @forelse ($projects as $project)
        <li>
            <a href="{{ $project->path() }}">
                <h2>{{ $project->name }}</h2>
            </a>
            <p>{{ $project->description }}</p>
        </li>
        @empty
        <li>
            <p>No Projects yet.</p>
        </li>
        @endforelse
    </ul>
</body>

</html>