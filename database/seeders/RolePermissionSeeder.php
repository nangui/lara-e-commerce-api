<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = Permission::all();
        $admin = Role::whereName('Admin')->first();

        $permissions->each(fn (Permission $permission) => \DB::table('role_permission')->insert([
            'role_id' => $admin->id,
            'permission_id' => $permission->id
        ]));

        $editor = Role::whereName('Editor')->first();
        $viewer = Role::whereName('Viewer')->first();

        foreach ($permissions as $permission) {
            if ($permission->name != 'edit_roles') {
                \DB::table('role_permission')->insert([
                    'role_id' => $editor->id,
                    'permission_id' => $permission->id
                ]);
            }
            if (in_array($permission->name, ['view_users', 'view_roles', 'view_products', 'view_orders'])) {
                \DB::table('role_permission')->insert([
                    'role_id' => $viewer->id,
                    'permission_id' => $permission->id
                ]);
            }
        }
    }
}
