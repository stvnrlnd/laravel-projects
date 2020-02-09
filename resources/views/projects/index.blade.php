@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <div>
            <a href="/projects/create">New Project</a>
        </div>

        <div class="grid grid-cols-3 gap-4">
            @forelse ($projects as $project)
                <div class="bg-white mr-4 p-5 rounded shadow">
                    <h3 class="font-normal text-xl py-4">{{ $project->title }}</h3>
                    <div class="text-gray-600">{{ \Str::limit($project->description, 250) }}</div>
                </div>
            @empty
                <div>No projects yet.</div>
            @endforelse
        </div>
    </div>
@endsection
