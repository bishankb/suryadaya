<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Spatie\Permission\Models\Role::create(['display_name' => 'admin', 'name' => 'admin']);
        Spatie\Permission\Models\Role::create(['display_name' => 'Developer', 'name' => 'developer']);       

        App\User::where('id', 1)->first()->assignRole('admin');
    }
}