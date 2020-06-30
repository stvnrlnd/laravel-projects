@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <header class="flex items-center justify-between py-4 mb-3">
            <h2 class="text-gray-600">My Projects</h2>
            <a href="/projects/create" class="block px-4 py-3 text-gray-200 no-underline bg-indigo-500 rounded shadow hover:bg-indigo-800 hover:bg-white">New Project</a>
        </header>

        <main class="lg:grid lg:grid-cols-3 lg:gap-4">
            @forelse ($projects as $project)
                @include('projects._card')
            @empty
                <div>No projects yet.</div>
            @endforelse
        </main>
    </div>
@endsection
