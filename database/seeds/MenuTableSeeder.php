<?php

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Menu::create(
            [
                'name'         => 'About Us',
                'slug'         => str_slug('About Us'),
                'positions'    => '1,4',
                'has_sub_menu' => 1, 
                'order'        => 2,
                'status'       => true,
                'created_by'   => 1,
                'updated_by'   => 1
            ]
        );

        Menu::create(
            [
                'name'         => 'Reports',
                'slug'         => str_slug('Reports'),
                'positions'    => '1,4',
                'has_sub_menu' => 0, 
                'order'        => 4,
                'status'       => true,
                'created_by'   => 1,
                'updated_by'   => 1
            ]
        );

        Menu::create(
            [
                'name'         => 'Notice',
                'slug'         => str_slug('Notice'),
                'positions'    => '1,4',
                'has_sub_menu' => 0, 
                'order'        => 5,
                'status'       => true,
                'created_by'   => 1,
                'updated_by'   => 1
            ]
        );

        Menu::create(
            [
                'name'         => 'Download',
                'slug'         => str_slug('Download'),
                'positions'    => '1,4',
                'has_sub_menu' => 0, 
                'order'        => 7,
                'status'       => true,
                'created_by'   => 1,
                'updated_by'   => 1
            ]
        );

        Menu::create(
            [
                'name'         => 'Service Center',
                'slug'         => str_slug('Service Center'),
                'icon'         => 'fa fa-map-marker',
                'positions'    => 0,
                'has_sub_menu' => 0, 
                'order'        => 9,
                'status'       => true,
                'created_by'   => 1,
                'updated_by'   => 1
            ]
        );

        Menu::create(
            [
                'name'         => 'Check Rates',
                'slug'         => str_slug('Check Rates'),
                'icon'         => 'fa fa-dollar',
                'positions'    => 0,
                'has_sub_menu' => 0, 
                'order'        => 10,
                'status'       => true,
                'created_by'   => 1,
                'updated_by'   => 1
            ]
        );

        Menu::create(
            [
                'name'         => '365 Banking Service',
                'slug'         => str_slug('365 Banking Service'),
                'icon'         => 'fa fa-university',
                'positions'    => 2,
                'has_sub_menu' => 0, 
                'order'        => 11,
                'status'       => true,
                'created_by'   => 1,
                'updated_by'   => 1
            ]
        );

        Menu::create(
            [
                'name'         => 'SMS Banking',
                'slug'         => str_slug('SMS Banking'),
                'positions'    => 2,
                'has_sub_menu' => 0, 
                'order'        => 12,
                'status'       => true,
                'created_by'   => 1,
                'updated_by'   => 1
            ]
        );

        Menu::create(
            [
                'name'         => 'Make Payment',
                'slug'         => str_slug('Make Payment'),
                'positions'    => 2,
                'has_sub_menu' => 0, 
                'order'        => 13,
                'status'       => true,
                'created_by'   => 1,
                'updated_by'   => 1
            ]
        );

        Menu::create(
            [
                'name'         => 'Upcoming Events',
                'slug'         => str_slug('Upcoming Events'),
                'positions'    => 3,
                'has_sub_menu' => 0, 
                'order'        => 14,
                'status'       => true,
                'created_by'   => 1,
                'updated_by'   => 1
            ]
        );

        Menu::create(
            [
                'name'         => 'Vacancy Announcements',
                'slug'         => str_slug('Vacancy Announcements'),
                'positions'    => 3,
                'has_sub_menu' => 0, 
                'order'        => 15,
                'status'       => true,
                'created_by'   => 1,
                'updated_by'   => 1
            ]
        );

        Menu::create(
            [
                'name'         => 'KYM Notice',
                'slug'         => str_slug('KYM Notice'),
                'positions'    => 3,
                'has_sub_menu' => 0, 
                'order'        => 16,
                'status'       => true,
                'created_by'   => 1,
                'updated_by'   => 1
            ]
        );

        Menu::create(
            [
                'name'         => 'Change in interest Rates',
                'slug'         => str_slug('Change in interest Rates'),
                'positions'    => 3,
                'has_sub_menu' => 0, 
                'order'        => 17,
                'status'       => true,
                'created_by'   => 1,
                'updated_by'   => 1
            ]
        );
    }
}
