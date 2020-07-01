<?php

namespace Tests\Feature;

use Facades\Tests\Builders\ProjectBuilder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function a_guest_cannot_view_any_projects()
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
    public function a_guest_cannot_view_a_single_project()
    {
        $project = create('Project');

        $this->get($project->path())
            ->assertRedirect('/login');
    }

    /** @test */
    public function a_project_owner_can_view_only_their_projects()
    {
        $project1 = create('Project');

        $project2 = create('Project');

        $this->actingAs($project1->owner)
            ->get('/projects')
            ->assertSee($project1->title)
            ->assertDontSee($project2->title);
    }

    /** @test */
    public function a_user_can_create_a_project()
    {
        $this->signIn();

        $this->get('/projects/create')
            ->assertStatus(200);

        $project = raw('Project');
        $response = $this->post('/projects', $project);

        $this->get($response->headers->get('Location'))
            ->assertSee($project['title'])
            ->assertSee($project['description'])
            ->assertSee($project['notes']);
    }

    /** @test */
    public function a_project_owner_can_view_their_own_project()
    {
        $this->signIn();

        $project = auth()->user()->projects()->create(raw('Project'));

        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
    }

    /** @test */
    public function the_project_owner_can_update_the_project()
    {
        $project = ProjectBuilder::build();

        $this->actingAs($project->owner)
            ->patch($project->path(), $attributes = raw('Project', [
                'owner_id' => $project->owner->id,
                'title' => 'Changed title',
                'description' => 'Changed description',
                'notes' => 'Changed notes'
            ]));

        $this->assertDatabaseHas('projects', $attributes);
    }

    /** @test */
    public function a_user_cannot_view_the_project_of_a_project_owner()
    {
        $this->signIn();

        $project = create('Project');

        $this->get($project->path())
            ->assertStatus(403);
    }

    /** @test */
    public function a_user_cannot_update_the_project_of_a_project_owner()
    {
        $this->signIn();

        $project = create('Project');

        $this->patch($project->path(), [])
            ->assertStatus(403);
    }

    /** @test */
    public function a_project_requires_a_title()
    {
        $this->signIn();

        $this->post('/projects', raw('Project', ['title' => '']))
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_project_requires_a_description()
    {
        $this->signIn();

        $this->post('/projects', raw('Project', ['description' => '']))
            ->assertSessionHasErrors('description');
    }

    /** @test */
    public function a_project_requires_an_owner()
    {
        $this->post('/projects', raw('Project', ['owner_id' => '']))
            ->assertRedirect('/login');
    }
}
