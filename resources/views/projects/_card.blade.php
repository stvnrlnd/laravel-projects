<div class="card">
    <h3 class="card-heading">
        <a href="{{ $project->path() }}" class="text-indigo-900 no-underline">
            {{ $project->title }}
        </a>
    </h3>
    <div class="card-body">
        <div class="text-gray-600">{{ $project->description }}</div>
    </div>
</div>
