<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create a test user
        factory('App\User')->create([
            'name' => 'user',
            'email' => 'user@example.com',
        ]);

        // create 50 random test users
        factory('App\User', 50)->create();
    }
}
