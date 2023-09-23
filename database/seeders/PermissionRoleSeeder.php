<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'create sections']);
        Permission::create(['name' => 'create subsections']);

        // edit permissions
        Permission::create(['name' => 'edit sections']);
        Permission::create(['name' => 'edit subsections']);

        $authorRole = Role::create(['name' => 'Author']);
        $collaboratorRole = Role::create(['name' => 'Collaborator']);

        $authorRole->givePermissionTo(['create sections', 'create subsections', 'edit sections', 'edit subsections']);
        $collaboratorRole->givePermissionTo(['edit sections', 'edit subsections']);
    }
}
