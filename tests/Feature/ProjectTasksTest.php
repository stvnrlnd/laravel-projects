<?php

namespace Tests\Feature;

use Facades\Tests\Builders\ProjectBuilder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTasksTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function a_guest_cannot_add_a_task_to_a_project()
    {
        $project = ProjectBuilder::build();

        $this->post($project->path().'/tasks', [])
            ->assertRedirect('/login');
    }

    /** @test */
    public function a_user_cannot_add_a_task_to_the_project_of_another_user()
    {
        $this->signIn();

        $project = ProjectBuilder::build();

        $this->post($project->path().'/tasks', [])
            ->assertStatus(403);
    }

    /** @test */
    public function a_user_cannot_update_a_task_on_the_project_of_another_user()
    {
        $this->signIn();

        $project = ProjectBuilder::withTasks(1)
            ->build();

        $this->patch($project->tasks->first()->path(), [])
            ->assertStatus(403);
    }

    /** @test */
    public function a_project_can_have_tasks()
    {
        $project = ProjectBuilder::build();

        $task = raw('Task');

        $this->actingAs($project->owner)
            ->post($project->path().'/tasks', $task);

        $this->actingAs($project->owner)
            ->get($project->path())
            ->assertSee($task['body']);
    }

    /** @test */
    public function a_task_can_be_updated()
    {
        $project = ProjectBuilder::withTasks(1)
            ->build();

        $taskAttributes = raw('Task', ['project_id' => $project->id]);

        $this->actingAs($project->owner)
            ->patch($project->tasks->first()->path(), $taskAttributes);

        $this->assertDatabaseHas('tasks', $taskAttributes);
    }

    /** @test */
    public function a_task_requires_a_body()
    {
        $project = ProjectBuilder::build();

        $this->actingAs($project->owner)
            ->post($project->path().'/tasks', raw('Task', ['body' => '']))
            ->assertSessionHasErrors('body');
    }
}
