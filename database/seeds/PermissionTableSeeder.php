<?php

use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
   /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'dashboard',
            'user',
            'role',
            'menu',
            'slider',
            'gallery',
            'single_page',
            'page_type',
            'category',
            'tag',
            'list_page',
            'important_link',
            'social_medias'
        ];

        foreach ($permissions as $key => $permission) {
        	Artisan::call('crescent:auth:permission', ['name' => $permission]);
        }

    }
}
