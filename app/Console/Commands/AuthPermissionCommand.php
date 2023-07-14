<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AuthPermissionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature =  'crescent:auth:permission {name} {--R|remove} {--S|single} {--SR|single-remove}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Adding Permission In Database';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $sinlge_permission = $this->generateSinglePermission();
        $permissions = $this->generatePermissions();

        if ($this->option('remove')) {
            if (Permission::where('name', 'LIKE', '%'.$this->getNameArgument())->delete()) {
                $this->warn('Permissions '.implode(', ', $permissions).' deleted.');
            } else {
                $this->warn('No permissions for '.$this->getNameArgument().' found!');
            }
        } elseif($this->option('single-remove')) {
             if (Permission::where('name', 'LIKE', '%'.$sinlge_permission)->delete()) {
                $this->warn('Permission '.$sinlge_permission.' deleted.');
            } else {
                $this->warn('No '.$sinlge_permission.' permission found!');
            }
        } elseif($this->option('single')) {
            Permission::firstOrCreate(['name' => $sinlge_permission]);

            $this->info('Permission '.$sinlge_permission.' created.');
        } else {
            foreach ($permissions as $permission) {
                Permission::firstOrCreate(['name' => $permission]);
            }

            $this->info('Permissions '.implode(', ', $permissions).' created.');
        }

        // sync role for admin
        if ($role = Role::where('name', 'admin')->first()) {
            $role->syncPermissions(Permission::all());
            $this->info('Updating permissions In Database');
        }
    }

    private function generatePermissions()
    {
        $abilities = ['view', 'add', 'edit', 'delete'];
        $name = $this->getNameArgument();

        return array_map(function ($val) use ($name) {
            return $val.'_'.$name;
        }, $abilities);
    }

     private function generateSinglePermission()
    {
        $name = $this->argument('name');

        return $name;
    }

    private function getNameArgument()
    {
        return strtolower(str_plural($this->argument('name')));
    }
}
