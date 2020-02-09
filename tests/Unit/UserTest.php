<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_projects()
    {
        $user = create('User');

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $user->projects);
    }
}
