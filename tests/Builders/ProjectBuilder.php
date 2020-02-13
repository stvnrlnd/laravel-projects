<?php

namespace Tests\Builders;

class ProjectBuilder
{
    protected $user;
    protected $taskCount = 0;

    public function ownedBy($user)
    {
        $this->user = $user;

        return $this;
    }

    public function withTasks($count)
    {
        $this->taskCount = $count;

        return $this;
    }

    public function build()
    {
        $project = create('Project', [
            'owner_id' => $this->user->id ?? create('User')->id
        ]);

        create('Task', [
            'project_id' => $project->id
        ], $this->taskCount);

        return $project;
    }
}
