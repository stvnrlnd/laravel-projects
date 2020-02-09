<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function a_guest_cannot_view_projects()
    {
        $this->get('/projects')
            ->assertRedirect('/login');
    }

    /** @test */
    public function a_guest_cannot_create_a_project()
    {
        $this->get('/projects/create')
            ->assertRedirect('/login');

        $this->post('/projects', [])
            ->assertRedirect('/login');
    }

    /** @test */
    public function a_guest_cannot_view_a_project()
    {
        $project = create('Project');

        $this->get($project->path())
            ->assertRedirect('/login');
    }

    /** @test */
    public function a_user_can_view_only_their_projects()
    {
        $this->signIn();

        $project = create('Project', [
            'owner_id' => auth()->id(),
        ]);

        $project2 = create('Project', [
            'owner_id' => create('User')->id,
        ]);

        $this->get('/projects')
            ->assertSee($project->title)
            ->assertDontSee($project2->title);
    }

    /** @test */
    public function a_user_can_create_a_project()
    {
        $this->signIn();

        $this->get('/projects/create')
            ->assertStatus(200);

        $this->post('/projects', raw('Project'))
            ->assertRedirect('/projects');
    }

    /** @test */
    public function a_user_can_view_their_own_project()
    {
        $this->signIn();

        $project = create('Project', [
            'owner_id' => auth()->id(),
        ]);

        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
    }

    /** @test */
    public function a_user_cannot_view_the_project_of_another_user()
    {
        $this->signIn();

        $project = create('Project', [
            'owner_id' => create('User')->id,
        ]);

        $this->get($project->path())
            ->assertStatus(403);
    }

    /** @test */
    public function a_project_requires_a_title()
    {
        $this->signIn();

        $this->post('/projects', raw('Project', [
            'title' => '',
        ]))->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_project_requires_a_description()
    {
        $this->signIn();

        $this->post('/projects', raw('Project', [
            'description' => '',
        ]))->assertSessionHasErrors('description');
    }

    /** @test */
    public function a_project_requires_an_owner()
    {
        $this->post('/projects', raw('Project'))
            ->assertRedirect('/login');
    }
}
