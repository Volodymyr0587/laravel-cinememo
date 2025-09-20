<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Writer Permissions
        Permission::create(['name' => 'create_articles']);
        Permission::create(['name' => 'edit_articles']);
        Permission::create(['name' => 'delete_articles']);

        // Admin Permissions
        Permission::create(['name' => 'view_users']);
        Permission::create(['name' => 'create_users']);
        Permission::create(['name' => 'edit_users']);
        Permission::create(['name' => 'delete_users']);
        Permission::create(['name' => 'view_roles']);
        Permission::create(['name' => 'create_roles']);
        Permission::create(['name' => 'edit_roles']);
        Permission::create(['name' => 'delete_roles']);
        Permission::create(['name' => 'view_permissions']);
        Permission::create(['name' => 'assign_roles_to_users']);
        Permission::create(['name' => 'assign_permissions_to_roles']);

        // Create Roles and assign existing permissions
        $superAdminRole = Role::create(['name' => 'super_admin']);
        $superAdminRole->givePermissionTo(Permission::all());

        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all()); // Admin gets all permissions

        $writerRole = Role::create(['name' => 'writer']);
        $writerRole->givePermissionTo([
            'create_articles', 'edit_articles', 'delete_articles'
        ]);

        // Create Super Admin user (protected from deletion)
        $superAdmin = \App\Models\User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'password' => bcrypt('password123'),
        ]);
        $superAdmin->assignRole('super_admin');

        // Create Admin user and assign Admin role to a it
        $admin = \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password123'),
        ]);
        $admin->assignRole('admin');

        // Create Writer user and assign Writer role to a it
        $writer = \App\Models\User::factory()->create([
            'name' => 'Writer',
            'email' => 'writer@gmail.com',
            'password' => bcrypt('password123'),
        ]);
        $writer->assignRole('writer');
    }
}
