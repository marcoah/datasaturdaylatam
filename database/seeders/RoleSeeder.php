<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        //definir los roles para cada usuario en funcion a los requisitos del sistema
        $roleAdmin = Role::create(['name' => 'admin']);
        $rolePonente = Role::create(['name' => 'ponente']);
        $roleAsistente = Role::create(['name' => 'asistente']);
        $roleSuper = Role::create(['name' => 'super-admin']); // gets all permissions via Gate::before rule; see AuthServiceProvider

        //definir las acciones en funcion a los requisitos del sistema
        $permission1 = Permission::create(['name' => 'administracion-read']);
        $permission2 = Permission::create(['name' => 'reportes-read']);
        $permission3 = Permission::create(['name' => 'maestros-read']);
        $permission4 = Permission::create(['name' => 'mensajeria-read']);
        $permission5 = Permission::create(['name' => 'resumen-read']);

        $permission_usuarios_C = Permission::create(['name' => 'usuarios-create']);
        $permission_usuarios_R = Permission::create(['name' => 'usuarios-read']);
        $permission_usuarios_U = Permission::create(['name' => 'usuarios-update']);
        $permission_usuarios_D = Permission::create(['name' => 'usuarios-delete']);

        $permission_roles_C = Permission::create(['name' => 'roles-create']);
        $permission_roles_R = Permission::create(['name' => 'roles-read']);
        $permission_roles_U = Permission::create(['name' => 'roles-update']);
        $permission_roles_D = Permission::create(['name' => 'roles-delete']);

        $permission_documentos_C = Permission::create(['name' => 'documentos-create']);
        $permission_documentos_R = Permission::create(['name' => 'documentos-read']);
        $permission_documentos_U = Permission::create(['name' => 'documentos-update']);
        $permission_documentos_D = Permission::create(['name' => 'documentos-delete']);

        $permission_pagos_C = Permission::create(['name' => 'pagos-create']);
        $permission_pagos_R = Permission::create(['name' => 'pagos-read']);
        $permission_pagos_U = Permission::create(['name' => 'pagos-update']);
        $permission_pagos_D = Permission::create(['name' => 'pagos-delete']);





        //Para definir los permisos para modificar settings

        $roleAdmin->givePermissionTo();
        $rolePonente->givePermissionTo();
        $roleAsistente->givePermissionTo();
    }
}
