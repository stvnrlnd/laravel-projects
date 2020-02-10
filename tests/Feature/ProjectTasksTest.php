<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTasksTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function a_guest_cannot_add_a_task_to_a_project()
    {
        $project = create('Project');

        $this->post($project->path().'/tasks', [])
            ->assertRedirect('/login');
    }

    /** @test */
    public function a_user_cannot_add_a_task_to_the_project_of_another_user()
    {
        $this->signIn();

        $project = create('Project');

        $this->post($project->path().'/tasks', [])
            ->assertStatus(403);
    }

    /** @test */
    public function a_user_cannot_update_a_task_on_the_project_of_another_user()
    {
        $this->signIn();

        $project = create('Project');

        $task = $project->addTask(raw('Task'));

        $this->patch($task->path(), [])
            ->assertStatus(403);
    }

    /** @test */
    public function a_project_can_have_tasks()
    {
        $this->signIn();

        $project = auth()->user()->projects()->create(raw('Project'));

        $task = raw('Task');

        $this->post($project->path().'/tasks', $task);

        $this->get($project->path())
            ->assertSee($task['body']);
    }

    /** @test */
    public function a_task_can_be_updated()
    {
        $this->signIn();

        $project = auth()->user()->projects()->create(raw('Project'));

        $task = $project->addTask(raw('Task'));

        $newAttributes = [
            'body' => $this->faker->sentence,
        ];

        $this->patch($task->path(), $newAttributes);

        $this->assertDatabaseHas('tasks', $newAttributes);
    }

    /** @test */
    public function a_task_requires_a_body()
    {
        $this->signIn();

        $project = auth()->user()->projects()->create(raw('Project'));

        $this->post($project->path().'/tasks', raw('Task', [
            'body' => '',
        ]))->assertSessionHasErrors('body');
    }
}
