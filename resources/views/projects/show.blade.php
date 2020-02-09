@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <header class="flex justify-between items-center mb-3 py-4">
            <p class="text-gray-600">
                <a href="/projects">My Projects</a> / {{ $project->title }}
            </p>
        </header>

        <main class="flex -mx-3">
            <div class="w-3/4 mx-3">
                <div class="mb-12">
                    <h3 class="text-gray-600 font-normal text-lg mb-3">Tasks</h3>
                    <div class="card">
                        <div class="card-body">
                            test
                        </div>
                    </div>
                </div>
                <div>
                    <h3 class="text-gray-600 font-normal text-lg mb-3">Notes</h3>
                    <div class="card">
                        <div class="card-body">
                            <textarea class="h-48 w-full">test</textarea>
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
