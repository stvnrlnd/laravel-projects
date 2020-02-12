<?php

use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\Project', 10)->create([
            'owner_id' => 1
        ]);
    }
}
