<?php

use Illuminate\Database\Seeder;
use App\Models\PageType;

class PageTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PageType::create(
            [
                'name'         => 'Blog',
                'slug'         => str_slug('Blog'),
                'icon'         => 'fa fa-book',
                'order'        => 1,
                'menu_id'      => 1,
                'status'       => true,
                'created_by'   => 1,
                'updated_by'   => 1
            ]
        );

        PageType::create(
            [
                'name'         => 'News',
                'slug'         => str_slug('News'),
                'icon'         => 'fa fa-newspaper-o',
                'order'        => 2,
                'menu_id'      => 2,
                'status'       => true,
                'created_by'   => 1,
                'updated_by'   => 1
            ]
        );

        PageType::create(
            [
                'name'         => 'Reports',
                'slug'         => str_slug('Reports'),
                'icon'         => 'fa fa-bar-chart',
                'order'        => 3,
                'menu_id'      => 3,
                'status'       => true,
                'created_by'   => 1,
                'updated_by'   => 1
            ]
        );

        PageType::create(
            [
                'name'         => 'Downloads',
                'slug'         => str_slug('Downloads'),
                'icon'         => 'fa fa-cloud-download',
                'order'        => 4,
                'menu_id'      => 4,
                'status'       => true,
                'created_by'   => 1,
                'updated_by'   => 1
            ]
        );
    }
}
