<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <h1>Create a new Project</h1>
    <form action="/projects" method="post">
        @csrf
        <div>
            <label for="name">Name</label>
            <input type="text" name="name">
        </div>
        <div>
            <label for="description">Description</label>
            <textarea name="description" rows="5"></textarea>
        </div>
        <div>
            <button type="submit">Create</button>
        </div>
    </form>
</body>

</html>