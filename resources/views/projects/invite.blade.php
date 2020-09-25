<div class="card flex flex-col mt-8">
    <h3 class="block text-xl font-bold -mx-4 mb-5 p-4 border-l-4 border-green-400">
        Invite a member
    </h3>
    <form method="POST" action="{{ $project->path() . '/invitations' }}">
        @csrf
        <div class="mb-3">
            <input type="email" name="email" class="border border-gray rounded w-full py-2 px-3" placeholder="E-Mail address">
        </div>
        <button type="submit" class="btn btn-green text-xs">Invite</button>
    </form>
    @include('errors', ['bag' => 'invitations'])
</div>
