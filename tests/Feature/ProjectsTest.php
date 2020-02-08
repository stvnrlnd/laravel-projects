<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function a_guest_cannot_view_all_projects()
    {
        $this->get('/projects')
            ->assertRedirect('/login');
    }

    /** @test */
    public function a_guest_cannot_create_a_project()
    {
        $this->post('/projects', [])
            ->assertRedirect('/login');
    }

    /** @test */
    public function a_guest_cannot_view_a_project()
    {
        $project = factory('App\Project')->create();

        $this->get($project->path())
            ->assertRedirect('/login');
    }

    /** @test */
    // public function a_user_can_view_their_own_projects()
    // {
    //     $attributes = factory('App\Project')->raw();

    //     $this->get('/projects')
    //         ->assertSee($attributes['title']);
    // }

    /** @test */
    public function a_user_can_create_a_project()
    {
        $this->actingAs(factory('App\User')->create());

        $attributes = factory('App\Project')->raw();

        $this->post('/projects', $attributes)
            ->assertRedirect('/projects');
    }

    /** @test */
    public function a_user_can_view_their_own_project()
    {
        $this->actingAs(factory('App\User')->create());

        $project = factory('App\Project')->create([
            'owner_id' => auth()->id()
        ]);

        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
    }

    /** @test */
    public function a_user_cannot_view_the_project_of_another_user()
    {
        $this->actingAs(factory('App\User')->create());

        $project = factory('App\Project')->create([
            'owner_id' => factory('App\User')->create()
        ]);

        $this->get($project->path())
            ->assertStatus(403);
    }

    /** @test */
    public function a_project_requires_a_title()
    {
        $this->actingAs(factory('App\User')->create());

        $attributes = factory('App\Project')->raw(['title' => '']);

        $this->post('/projects', $attributes)
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_project_requires_a_description()
    {
        $this->actingAs(factory('App\User')->create());

        $attributes = factory('App\Project')->raw(['description' => '']);

        $this->post('/projects', $attributes)
            ->assertSessionHasErrors('description');
    }

    /** @test */
    public function a_project_requires_an_owner()
    {
        $attributes = factory('App\Project')->raw();

        $this->post('/projects', $attributes)
            ->assertRedirect('/login');
    }
}
