<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $user = factory(\App\Models\User::class)->create([
            'email' => 'test@test.test',
            'password' => 'secret',
        ]);
    }
}
