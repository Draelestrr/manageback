<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Crear roles
        $admin = Role::create(['name' => 'admin']);
        $supervisor = Role::create(['name' => 'supervisor']);
        $worker = Role::create(['name' => 'worker']);

        // Crear permisos
        $permissions = [
            'manage-users',             // Gestionar usuarios
            'view-inventory',          // Ver inventario
            'manage-inventory',        // Gestionar inventario (crear, editar, eliminar)
            'delete-inventory',        // Eliminar registros de inventario
            'manage-expenses',         // Gestionar gastos (crear, editar, eliminar)
            'delete-expenses',         // Eliminar registros de gastos
            'manage-sales',            // Gestionar ventas
            'delete-sales',            // Eliminar registros de ventas
            'view-stock',              // Ver stock
            'create-stock-entry',      // Hacer ingresos de stock
            'create-expenses',         // Hacer ingresos de gastos
            'create-sales',            // Realizar ventas
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Asignar permisos al rol de administrador (acceso completo)
        $admin->givePermissionTo(Permission::all());

        // Asignar permisos al rol de supervisor (sin permisos para eliminar)
        $supervisor->givePermissionTo([
            'manage-users',
            'view-inventory',
            'manage-inventory',
            'manage-expenses',
            'manage-sales',
            'view-stock',
            'create-stock-entry',
            'create-expenses',
            'create-sales',
        ]);

        // Asignar permisos al rol de trabajador
        $worker->givePermissionTo([
            'view-stock',
            'create-stock-entry',
            'create-expenses',
            'create-sales',
        ]);
    }
}
