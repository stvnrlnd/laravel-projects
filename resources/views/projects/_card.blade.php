<div class="card">
    <h3 class="card-heading">
        <a href="projects/{{$project->id}}" class="text-blue-900 no-underline">
            {{ $project->title }}
        </a>
    </h3>
    <div class="card-body">
        <div class="text-gray-600">{{ \Str::limit($project->description, 250) }}</div>
    </div>
</div>
