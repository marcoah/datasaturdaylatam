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
        $roleEditor = Role::create(['name' => 'editor']);
        $rolePonente = Role::create(['name' => 'ponente']);
        $roleAsistente = Role::create(['name' => 'asistente']);
        $roleSuper = Role::create(['name' => 'super-admin']); // gets all permissions via Gate::before rule; see AuthServiceProvider

        //definir las acciones en funcion a los requisitos del sistema
        $permission1 = Permission::create(['name' => 'administracion-read']);
        $permission2 = Permission::create(['name' => 'mensajeria-read']);
        $permission3 = Permission::create(['name' => 'notificaciones-read']);
        $permission4 = Permission::create(['name' => 'reportes-read']);
        $permission5 = Permission::create(['name' => 'settings-read']);


        // Opciones de Evento
        $permission_eventos_C = Permission::create(['name' => 'eventos-create']);
        $permission_eventos_R = Permission::create(['name' => 'eventos-read']);
        $permission_eventos_U = Permission::create(['name' => 'eventos-update']);
        $permission_eventos_D = Permission::create(['name' => 'eventos-delete']);
        $permission_eventos_L = Permission::create(['name' => 'eventos-lists']); // ver listas

        $permission_documentos_C = Permission::create(['name' => 'documentos-create']);
        $permission_documentos_R = Permission::create(['name' => 'documentos-read']);
        $permission_documentos_U = Permission::create(['name' => 'documentos-update']);
        $permission_documentos_D = Permission::create(['name' => 'documentos-delete']);
        $permission_documentos_L = Permission::create(['name' => 'documentos-lists']); // ver listas

        // Capas y Objetos
        $permission_turismo_C = Permission::create(['name' => 'turismo-create']);
        $permission_turismo_R = Permission::create(['name' => 'turismo-read']);
        $permission_turismo_U = Permission::create(['name' => 'turismo-update']);
        $permission_turismo_D = Permission::create(['name' => 'turismo-delete']);

        $permission_hoteles_C = Permission::create(['name' => 'hoteles-create']);
        $permission_hoteles_R = Permission::create(['name' => 'hoteles-read']);
        $permission_hoteles_U = Permission::create(['name' => 'hoteles-update']);
        $permission_hoteles_D = Permission::create(['name' => 'hoteles-delete']);

        $permission_restaurantes_C = Permission::create(['name' => 'restaurantes-create']);
        $permission_restaurantes_R = Permission::create(['name' => 'restaurantes-read']);
        $permission_restaurantes_U = Permission::create(['name' => 'restaurantes-update']);
        $permission_restaurantes_D = Permission::create(['name' => 'restaurantes-delete']);

        $permission_cultura_C = Permission::create(['name' => 'cultura-create']);
        $permission_cultura_R = Permission::create(['name' => 'cultura-read']);
        $permission_cultura_U = Permission::create(['name' => 'cultura-update']);
        $permission_cultura_D = Permission::create(['name' => 'cultura-delete']);

        $permission_paseos_C = Permission::create(['name' => 'paseos-create']);
        $permission_paseos_R = Permission::create(['name' => 'paseos-read']);
        $permission_paseos_U = Permission::create(['name' => 'paseos-update']);
        $permission_paseos_D = Permission::create(['name' => 'paseos-delete']);

        // Opciones de Sistema
        $permission_usuarios_C = Permission::create(['name' => 'usuarios-create']);
        $permission_usuarios_R = Permission::create(['name' => 'usuarios-read']);
        $permission_usuarios_U = Permission::create(['name' => 'usuarios-update']);
        $permission_usuarios_D = Permission::create(['name' => 'usuarios-delete']);

        $permission_roles_C = Permission::create(['name' => 'roles-create']);
        $permission_roles_R = Permission::create(['name' => 'roles-read']);
        $permission_roles_U = Permission::create(['name' => 'roles-update']);
        $permission_roles_D = Permission::create(['name' => 'roles-delete']);

        $permission_noticias_C = Permission::create(['name' => 'noticias-create']);
        $permission_noticias_R = Permission::create(['name' => 'noticias-read']);
        $permission_noticias_U = Permission::create(['name' => 'noticias-update']);
        $permission_noticias_D = Permission::create(['name' => 'noticias-delete']);

        $permission_descuentos_C = Permission::create(['name' => 'descuentos-create']);
        $permission_descuentos_R = Permission::create(['name' => 'descuentos-read']);
        $permission_descuentos_U = Permission::create(['name' => 'descuentos-update']);
        $permission_descuentos_D = Permission::create(['name' => 'descuentos-delete']);

        $permission_capas_C = Permission::create(['name' => 'capas-create']);
        $permission_capas_R = Permission::create(['name' => 'capas-read']);
        $permission_capas_U = Permission::create(['name' => 'capas-update']);
        $permission_capas_D = Permission::create(['name' => 'capas-delete']);

        $permission_objetos_C = Permission::create(['name' => 'objetos-create']);
        $permission_objetos_R = Permission::create(['name' => 'objetos-read']);
        $permission_objetos_U = Permission::create(['name' => 'objetos-update']);
        $permission_objetos_D = Permission::create(['name' => 'objetos-delete']);

        $permission_plantillas_C = Permission::create(['name' => 'plantillas-create']);
        $permission_plantillas_R = Permission::create(['name' => 'plantillas-read']);
        $permission_plantillas_U = Permission::create(['name' => 'plantillas-update']);
        $permission_plantillas_D = Permission::create(['name' => 'plantillas-delete']);
        $permission_plantillas_L = Permission::create(['name' => 'plantillas-list']);

        //Para definir los permisos para modificar settings
        $roleAdmin->givePermissionTo(
            $permission1,
            $permission2,
            $permission3,
            $permission4,
            $permission5,
        );
        $roleEditor->givePermissionTo(
            $permission1,
        );
        $rolePonente->givePermissionTo(
            $permission_eventos_R,
            $permission_documentos_R,
            $permission_turismo_R,
            $permission_hoteles_R,
            $permission_restaurantes_R,
            $permission_cultura_R,
            $permission_paseos_R,
            $permission_noticias_R,
        );
        $roleAsistente->givePermissionTo(
            $permission_eventos_R,
            $permission_documentos_R,
            $permission_paseos_R,
            $permission_noticias_R,
        );
    }
}
