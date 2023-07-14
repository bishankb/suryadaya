<?php

use Illuminate\Database\Seeder;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(
            [
                'name'           => 'Admin',
                'email'          => 'admin@admin.com',
                'password'       => bcrypt('secret'),
                'remember_token' => str_random(10),
                'role_id'        => 1, 
                'active'         => true,
                'created_by'     => 1,
                'updated_by'     => 1
            ]
        );

        User::create(
            [
                'name'           => 'Bishank Badgami',
                'email'          => 'bishank@bishank.com',
                'password'       => bcrypt('secret'),
                'remember_token' => str_random(10),
                'role_id'        => 2,
                'active'         => true,
                'created_by'     => 1,
                'updated_by'     => 1,     
            ]
        );

        User::create(
            [
                'name'           => 'Surya Poudel',
                'email'          => 'surya@surya.com',
                'password'       => bcrypt('secret'),
                'remember_token' => str_random(10),
                'role_id'        => 3,
                'active'         => true,
                'created_by'     => 1,
                'updated_by'     => 1,     
            ]
        );
    }
}
