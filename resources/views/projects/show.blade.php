@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <header class="flex items-center justify-between py-4 my-3">
            <p class="text-gray-600">
                <a href="/projects">My Projects</a> / {{ $project->title }}
            </p>
        </header>

        <main class="flex -mx-3">
            <div class="w-3/4 mx-3">
                <div class="mb-8">
                    <h3 class="mb-3 text-lg font-normal text-gray-600">Tasks</h3>
                    <div class="mb-3 card">
                        <div class="card-body">
                            <form action="{{ $project->path() }}/tasks" method="POST">
                                @csrf
                                @method('POST')

                                <input type="text" name="body" placeholder="What needs to be done?" class="w-full">
                            </form>
                        </div>
                    </div>
                    @forelse ($project->tasks as $task)
                        <div class="mb-3 card">
                            <div class="card-body">
                                <form action="{{ $project->path() }}/tasks/{{ $task->id }}/edit" method="POST" class="flex">
                                    @csrf
                                    @method('PATCH')
                                    <input type="text" name="body" value="{{ $task->body }}" class="w-full{{ $task->completed ? ' text-gray-600' : '' }}">
                                    <input type="checkbox" name="completed" id="" onChange="this.form.submit()"{{ $task->completed ? ' checked' : '' }}>
                                </form>
                            </div>
                        </div>
                    @empty
                        No tasks yet.
                    @endforelse
                </div>
                <div>
                    <h3 class="mb-3 text-lg font-normal text-gray-600">Notes</h3>
                    <div class="mb-3 card">
                        <div class="card-body">
                            <form action="{{ $project->path() }}" method="POST">
                                @csrf
                                @method('PATCH')

                                <textarea class="w-full h-48 resize-none" name="notes">{{ $project->notes }}</textarea>
                                <button type="submit" class="block px-4 py-3 text-gray-200 no-underline bg-indigo-500 rounded shadow hover:bg-indigo-800 hover:bg-white">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-1/4 mx-3">
                @include('projects._card')
            </div>
        </main>
    </div>
@endsection
