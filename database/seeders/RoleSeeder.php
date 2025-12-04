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
        $role1 = Role::create(["name"=>"Administrador"]);
        $role2 = Role::create(["name"=>"Director"]);
        $role3 = Role::create(["name"=>"Delegacion"]);
        $role4 = Role::create(["name"=>"Subdirector"]);
        $role5 = Role::create(["name"=>"Empleado"]);


        /*          SISTEMA DE INVENTARIOS         */
        //Crear permisos Inventarios
        $perm1 = Permission::create(['name'=>'inventario.index']);
        $perm1->syncRoles([$role1,$role2,$role3,$role4,$role5]);
        $perm2 = Permission::create(['name'=>'inventario.create']);
        $perm2->syncRoles([$role1,$role3,$role4]);
        $perm3 = Permission::create(['name'=>'inventario.edit']);
        $perm3->syncRoles([$role1,$role3,$role4]);
        $perm4 = Permission::create(['name'=>'inventario.destroy']);
        $perm4->syncRoles([$role1]);
        //Crear permisos Marcas
        $perm5 = Permission::create(['name'=>'marcas.index']);
        $perm5->syncRoles([$role1,$role2,$role3,$role4,$role5]);
        $perm6 = Permission::create(['name'=>'marcas.create']);
        $perm6->syncRoles([$role1,$role3,$role4]);
        $perm7 = Permission::create(['name'=>'marcas.edit']);
        $perm7->syncRoles([$role1,$role3,$role4]);
        $perm8 = Permission::create(['name'=>'marcas.destroy']);
        $perm8->syncRoles([$role1]);
        //Crear permisos Resguardantes
        $perm9 = Permission::create(['name'=>'resguardante.index']);
        $perm9->syncRoles([$role1,$role2,$role3,$role4,$role5]);
        $perm10 = Permission::create(['name'=>'resguardante.create']);
        $perm10->syncRoles([$role1,$role3,$role4]);
        $perm11 = Permission::create(['name'=>'resguardante.edit']);
        $perm11->syncRoles([$role1,$role3,$role4]);
        $perm12 = Permission::create(['name'=>'resguardante.destroy']);
        $perm12->syncRoles([$role1]);
        //Crear permisos Puestos
        $perm13 = Permission::create(['name'=>'puestos.index']);
        $perm13->syncRoles([$role1,$role2,$role3,$role4,$role5]);
        $perm14 = Permission::create(['name'=>'puestos.create']);
        $perm14->syncRoles([$role1,$role3,$role4]);
        $perm15 = Permission::create(['name'=>'puestos.edit']);
        $perm15->syncRoles([$role1,$role3,$role4]);
        $perm16 = Permission::create(['name'=>'puestos.destroy']);
        $perm16->syncRoles([$role1]);
        //Crear permisos Ubicaciones Fisicas
        $perm17 = Permission::create(['name'=>'ubicacionfisica.index']);
        $perm17->syncRoles([$role1,$role2,$role3,$role4,$role5]);
        $perm18 = Permission::create(['name'=>'ubicacionfisica.create']);
        $perm18->syncRoles([$role1,$role3,$role4]);
        $perm19 = Permission::create(['name'=>'ubicacionfisica.edit']);
        $perm19->syncRoles([$role1,$role3,$role4]);
        $perm20 = Permission::create(['name'=>'ubicacionfisica.destroy']);
        $perm20->syncRoles([$role1]);
        //Crear permisos Areas de Asignación
        $perm21 = Permission::create(['name'=>'areadeasignacion.index']);
        $perm21->syncRoles([$role1,$role2,$role3,$role4,$role5]);
        $perm22 = Permission::create(['name'=>'areadeasignacion.create']);
        $perm22->syncRoles([$role1,$role3,$role4]);
        $perm23 = Permission::create(['name'=>'areadeasignacion.edit']);
        $perm23->syncRoles([$role1,$role3,$role4]);
        $perm24 = Permission::create(['name'=>'areadeasignacion.destroy']);
        $perm24->syncRoles([$role1]);

    }
}


