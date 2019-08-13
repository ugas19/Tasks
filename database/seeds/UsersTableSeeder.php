<?php

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        $adminRole = Role::where('name', 'admin')->first();
        $userRole = Role::where('name', 'user')->first();
        // create a test user
        $admin = factory(User::class)->create([
            'name' => 'admin',
            'email' => 'admin@example.com'
        ]);
        
        $user = factory(User::class)->create([
            'name' => 'user',
            'email' => 'user@example.com'
        ]);
        // create 50 random test users
        //factory(User::class, 10)->create();

        $admin->roles()->attach($adminRole);
        $user->roles()->attach($userRole);
    }
}
