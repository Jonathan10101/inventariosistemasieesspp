<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role1 = Role::firstOrCreate(["name"=>"Administrador"]);
        $role2 = Role::firstOrCreate(["name"=>"Empleado"]);


        /*          SISTEMA DE INVENTARIOS         */
        //Crear permisos Inventarios
        $perm1 = Permission::firstOrCreate(['name'=>'inventario.index']);
        $perm1->syncRoles([$role1,$role2]);
        $perm2 = Permission::firstOrCreate(['name'=>'inventario.create']);
        $perm2->syncRoles([$role1]);
        $perm3 = Permission::firstOrCreate(['name'=>'inventario.edit']);
        $perm3->syncRoles([$role1]);
        $perm4 = Permission::firstOrCreate(['name'=>'inventario.destroy']);
        $perm4->syncRoles([$role1]);
        //Crear permisos Marcas
        $perm5 = Permission::firstOrCreate(['name'=>'marcas.index']);
        $perm5->syncRoles([$role1,$role2]);
        $perm6 = Permission::firstOrCreate(['name'=>'marcas.create']);
        $perm6->syncRoles([$role1]);
        $perm7 = Permission::firstOrCreate(['name'=>'marcas.edit']);
        $perm7->syncRoles([$role1]);
        $perm8 = Permission::firstOrCreate(['name'=>'marcas.destroy']);
        $perm8->syncRoles([$role1]);
        //Crear permisos Resguardantes
        $perm9 = Permission::firstOrCreate(['name'=>'resguardante.index']);
        $perm9->syncRoles([$role1,$role2]);
        $perm10 = Permission::firstOrCreate(['name'=>'resguardante.create']);
        $perm10->syncRoles([$role1]);
        $perm11 = Permission::firstOrCreate(['name'=>'resguardante.edit']);
        $perm11->syncRoles([$role1]);
        $perm12 = Permission::firstOrCreate(['name'=>'resguardante.destroy']);
        $perm12->syncRoles([$role1]);
        //Crear permisos Puestos
        $perm13 = Permission::firstOrCreate(['name'=>'puestos.index']);
        $perm13->syncRoles([$role1,$role2]);
        $perm14 = Permission::firstOrCreate(['name'=>'puestos.create']);
        $perm14->syncRoles([$role1]);
        $perm15 = Permission::firstOrCreate(['name'=>'puestos.edit']);
        $perm15->syncRoles([$role1]);
        $perm16 = Permission::firstOrCreate(['name'=>'puestos.destroy']);
        $perm16->syncRoles([$role1]);
        //Crear permisos Ubicaciones Fisicas
        $perm17 = Permission::firstOrCreate(['name'=>'ubicacionfisica.index']);
        $perm17->syncRoles([$role1,$role2]);
        $perm18 = Permission::firstOrCreate(['name'=>'ubicacionfisica.create']);
        $perm18->syncRoles([$role1]);
        $perm19 = Permission::firstOrCreate(['name'=>'ubicacionfisica.edit']);
        $perm19->syncRoles([$role1]);
        $perm20 = Permission::firstOrCreate(['name'=>'ubicacionfisica.destroy']);
        $perm20->syncRoles([$role1]);
        //Crear permisos Areas de Asignación
        $perm21 = Permission::firstOrCreate(['name'=>'areadeasignacion.index']);
        $perm21->syncRoles([$role1,$role2]);
        $perm22 = Permission::firstOrCreate(['name'=>'areadeasignacion.create']);
        $perm22->syncRoles([$role1]);
        $perm23 = Permission::firstOrCreate(['name'=>'areadeasignacion.edit']);
        $perm23->syncRoles([$role1]);
        $perm24 = Permission::firstOrCreate(['name'=>'areadeasignacion.destroy']);
        $perm24->syncRoles([$role1]);

    }
}


