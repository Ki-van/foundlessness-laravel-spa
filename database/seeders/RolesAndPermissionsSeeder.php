<?php

namespace Database\Seeders;

use App\Models\Domain;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $actions = ['create', 'read', 'update', 'delete'];
        $entities = ['comments', 'articles', 'versions', 'marks', 'users', 'domains', 'tags'];

        $permissions = [];

        foreach ($entities as $entity) {
            foreach ($actions as $action)
                $permissions = collect($permissions)->push(['name' => $action.' '.$entity, 'guard_name' => 'web']);
        }
        Permission::insert($permissions->toArray());
        $userRole = Role::create(['name' => 'User']);
        $userRolePermissions = ['create articles', 'create versions', 'create marks', 'create comments',
            'update marks', 'update articles'];
        foreach ($userRolePermissions as $userRolePermission){
            $userRole->givePermissionTo($userRolePermission);
        }
        Role::create(['name'=>'Admin']);

        $entities = Domain::get('id')->map(fn ($domain)=>$domain->id)->toArray();
        $permissions = [];
        foreach ($entities as $entity) {
                $permissions = collect($permissions)->push(['name' => 'moderate '.$entity, 'guard_name' => 'web']);
        }

        Permission::insert($permissions->toArray());
        $moderatorRole = Role::create(['name' => 'Moderator']);
        $permissions->each(fn ($permission) => $moderatorRole->givePermissionTo($permission['name']));
    }
}
