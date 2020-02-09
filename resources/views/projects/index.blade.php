@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <header class="flex justify-between items-center mb-3 py-4">
            <h2 class="text-gray-600">My Projects</h2>
            <a href="/projects/create" class="block px-4 py-3 rounded shadow no-underline bg-blue-900 text-gray-200 hover:bg-blue-800 hover:bg-white">New Project</a>
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
