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

        // Eliminar los roles existentes antes de crear nuevos roles
        
        $role1 = Role::create(["name"=>"Administrador"]);
        $role2 = Role::create(["name"=>"ControlEscolar"]);
        $role3 = Role::create(["name"=>"Profesionalizacion"]);
        //$role4 = Role::create(["name"=>"Administrativo"]);
                

        /*          CONTROL ESCOLAR          */
        //Crear permisos Control Escolar
        $perm1 = Permission::create(['name'=>'alumnos.index']);
        $perm1->syncRoles([$role1,$role2,$role3]);
        $perm2 = Permission::create(['name'=>'alumnos.create']);
        $perm2->syncRoles([$role1,$role2]);
        $perm3 = Permission::create(['name'=>'alumnos.edit']);
        $perm3->syncRoles([$role1,$role2]);
        $perm4 = Permission::create(['name'=>'alumnos.destroy']);
        $perm4->syncRoles([$role1]);
        //Crear permisos Cursos
        $perm5 = Permission::create(['name'=>'cursos.index']);
        $perm5->syncRoles([$role1,$role2, $role3]);
        $perm6 = Permission::create(['name'=>'cursos.create']);
        $perm6->syncRoles([$role1,$role2]);
        $perm7 = Permission::create(['name'=>'cursos.edit']);
        $perm7->syncRoles([$role1,$role2]);
        $perm8 = Permission::create(['name'=>'cursos.destroy']);
        $perm8->syncRoles([$role1]);
        //Crear permisos Inscripciones
        $perm9 = Permission::create(['name'=>'inscripciones.index']);
        $perm9->syncRoles([$role1,$role2, $role3]);
        $perm10 = Permission::create(['name'=>'inscripciones.create']);
        $perm10->syncRoles([$role1,$role2]);
        $perm11 = Permission::create(['name'=>'inscripciones.edit']);
        $perm11->syncRoles([$role1,$role2]);
        $perm12 = Permission::create(['name'=>'inscripciones.destroy']);
        $perm12->syncRoles([$role1]);
        

        /*
        //Crear permisos Entradas Cocina
        $perm9 = Permission::create(['name'=>'entradasCocina.index']);
        $perm9->syncRoles([$role1, $role2]);
        $perm10 = Permission::create(['name'=>'entradasCocina.create']);
        $perm10->syncRoles([$role1, $role2]);
        $perm11 = Permission::create(['name'=>'entradasCocina.edit']);
        $perm11->syncRoles([$role1, $role2]);
        $perm12 = Permission::create(['name'=>'entradasCocina.destroy']);
        $perm12->syncRoles([$role1]);
        //Crear permisos Salidas Cocina
        $perm13 = Permission::create(['name'=>'salidasCocina.index']);
        $perm13->syncRoles([$role1, $role2]);
        $perm14 = Permission::create(['name'=>'salidasCocina.create']);
        $perm14->syncRoles([$role1, $role2]);
        $perm15 = Permission::create(['name'=>'salidasCocina.edit']);
        $perm15->syncRoles([$role1, $role2]);
        $perm16 = Permission::create(['name'=>'salidasCocina.destroy']);
        $perm16->syncRoles([$role1]);
        //Crear permisos Reportes Cocina
        $perm17 = Permission::create(['name'=>'reportesCocina.index']);
        $perm17->syncRoles([$role1, $role2]);
        $perm18 = Permission::create(['name'=>'reportesCocina.create']);
        $perm18->syncRoles([$role1, $role2]);
        $perm19 = Permission::create(['name'=>'reportesCocina.edit']);
        $perm19->syncRoles([$role1, $role2]);
        $perm20 = Permission::create(['name'=>'reportesCocina.destroy']);
        $perm20->syncRoles([$role1]);
        */
        
        /*          PAPELERIA          */
        //Crear permisos Requisiciones Papeleria
        /*
        $perm21 = Permission::create(['name'=>'requisicionesPapeleria.index']);
        $perm21->syncRoles([$role1, $role3]);
        $perm22 = Permission::create(['name'=>'requisicionesPapeleria.create']);
        $perm22->syncRoles([$role1, $role3]);
        $perm23 = Permission::create(['name'=>'requisicionesPapeleria.edit']);
        $perm23->syncRoles([$role1, $role3]);
        $perm24 = Permission::create(['name'=>'requisicionesPapeleria.destroy']);
        $perm24->syncRoles([$role1]);
        //Crear permisos Almacen Papeleria
        $perm25 = Permission::create(['name'=>'almacenPapeleria.index']);
        $perm25->syncRoles([$role1, $role3]);
        $perm26 = Permission::create(['name'=>'almacenPapeleria.create']);
        $perm26->syncRoles([$role1, $role3]);
        $perm27 = Permission::create(['name'=>'almacenPapeleria.edit']);
        $perm27->syncRoles([$role1, $role3]);
        $perm28 = Permission::create(['name'=>'almacenPapeleria.destroy']);
        $perm28->syncRoles([$role1]);
        //Crear permisos Entradas Papeleria
        $perm29 = Permission::create(['name'=>'entradasPapeleria.index']);
        $perm29->syncRoles([$role1, $role3]);
        $perm30 = Permission::create(['name'=>'entradasPapeleria.create']);
        $perm30->syncRoles([$role1, $role3]);
        $perm31 = Permission::create(['name'=>'entradasPapeleria.edit']);
        $perm31->syncRoles([$role1, $role3]);
        $perm32 = Permission::create(['name'=>'entradasPapeleria.destroy']);
        $perm32->syncRoles([$role1]);
        //Crear permisos Salidas Papeleria
        $perm33 = Permission::create(['name'=>'salidasPapeleria.index']);
        $perm33->syncRoles([$role1, $role3]);
        $perm34 = Permission::create(['name'=>'salidasPapeleria.create']);
        $perm34->syncRoles([$role1, $role3]);
        $perm35 = Permission::create(['name'=>'salidasPapeleria.edit']);
        $perm35->syncRoles([$role1, $role3]);
        $perm36 = Permission::create(['name'=>'salidasPapeleria.destroy']);
        $perm36->syncRoles([$role1]);
        //Crear permisos Reportes Papeleria
        $perm37 = Permission::create(['name'=>'reportesPapeleria.index']);
        $perm37->syncRoles([$role1, $role3]);
        $perm38 = Permission::create(['name'=>'reportesPapeleria.create']);
        $perm38->syncRoles([$role1, $role3]);
        $perm39 = Permission::create(['name'=>'reportesPapeleria.edit']);
        $perm39->syncRoles([$role1, $role3]);
        $perm40 = Permission::create(['name'=>'reportesPapeleria.destroy']);
        $perm40->syncRoles([$role1]);
        */


        /*          LIMPIEZA          */
        //Crear permisos Requisiciones Limpieza
        /*
        $perm41 = Permission::create(['name'=>'requisicionesLimpieza.index']);
        $perm41->syncRoles([$role1, $role4]);
        $perm42 = Permission::create(['name'=>'requisicionesLimpieza.create']);
        $perm42->syncRoles([$role1, $role4]);
        $perm43 = Permission::create(['name'=>'requisicionesLimpieza.edit']);
        $perm43->syncRoles([$role1, $role4]);
        $perm44 = Permission::create(['name'=>'requisicionesLimpieza.destroy']);
        $perm44->syncRoles([$role1]);
        //Crear permisos Almacen Limpieza
        $perm45 = Permission::create(['name'=>'almacenLimpieza.index']);
        $perm45->syncRoles([$role1, $role4]);
        $perm46 = Permission::create(['name'=>'almacenLimpieza.create']);
        $perm46->syncRoles([$role1, $role4]);
        $perm47 = Permission::create(['name'=>'almacenLimpieza.edit']);
        $perm47->syncRoles([$role1, $role4]);
        $perm48 = Permission::create(['name'=>'almacenLimpieza.destroy']);
        $perm48->syncRoles([$role1]);
        //Crear permisos Entradas Limpieza
        $perm49 = Permission::create(['name'=>'entradasLimpieza.index']);
        $perm49->syncRoles([$role1, $role4]);
        $perm50 = Permission::create(['name'=>'entradasLimpieza.create']);
        $perm50->syncRoles([$role1, $role4]);
        $perm51 = Permission::create(['name'=>'entradasLimpieza.edit']);
        $perm51->syncRoles([$role1, $role4]);
        $perm52 = Permission::create(['name'=>'entradasLimpieza.destroy']);
        $perm52->syncRoles([$role1]);
        //Crear permisos Salidas Limpieza
        $perm53 = Permission::create(['name'=>'salidasLimpieza.index']);
        $perm53->syncRoles([$role1, $role4]);
        $perm54 = Permission::create(['name'=>'salidasLimpieza.create']);
        $perm54->syncRoles([$role1, $role4]);
        $perm55 = Permission::create(['name'=>'salidasLimpieza.edit']);
        $perm55->syncRoles([$role1, $role4]);
        $perm56 = Permission::create(['name'=>'salidasLimpieza.destroy']);
        $perm56->syncRoles([$role1]);
        //Crear permisos Reportes Limpieza
        $perm57 = Permission::create(['name'=>'reportesLimpieza.index']);
        $perm57->syncRoles([$role1, $role4]);
        $perm58 = Permission::create(['name'=>'reportesLimpieza.create']);
        $perm58->syncRoles([$role1, $role4]);
        $perm59 = Permission::create(['name'=>'reportesLimpieza.edit']);
        $perm59->syncRoles([$role1, $role4]);
        $perm60 = Permission::create(['name'=>'reportesLimpieza.destroy']);
        $perm60->syncRoles([$role1]);
        */




















        

  

        /*  PERMISOS ADICIONALES QUE AGREGARE  */
        /*
        //Crear permisos Productos de Cocina
        $perm121 = Permission::create(['name'=>'productosCocina.index']);
        $perm121->syncRoles([$role1, $role2]);
        $perm122 = Permission::create(['name'=>'productosCocina.create']);
        $perm122->syncRoles([$role1, $role2]);
        $perm123 = Permission::create(['name'=>'productosCocina.edit']);
        $perm123->syncRoles([$role1, $role2]);
        $perm124 = Permission::create(['name'=>'productosCocina.destroy']);
        $perm124->syncRoles([$role1]);
        */








    }
}


