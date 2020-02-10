<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_a_path()
    {
        $project = create('Project');

        $this->assertEquals("/projects/{$project->id}", $project->path());
    }

    /** @test */
    public function it_has_an_owner()
    {
        $project = create('Project');

        $this->assertInstanceOf('App\User', $project->owner);
    }

    /** @test */
    public function it_can_add_a_task()
    {
        $project = create('Project');

        $task = $project->addTask(raw('Task'));

        $this->assertCount(1, $project->tasks);
        $this->assertTrue($project->tasks->contains($task));
    }
}
