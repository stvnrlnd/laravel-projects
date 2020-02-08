<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

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
}
