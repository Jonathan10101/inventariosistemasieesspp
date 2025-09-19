<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CursoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cursos')->insert([
            //PROGRAMAS
            [
                'nombre_curso'  => 'FORMACIÓN INICIAL POLICÍA DE PROXIMIDAD',
                'type_of_course' => 'programa',
                'duracion_en_horas' => 1080

            ],
            [
                'nombre_curso' => 'FORMACIÓN INICIAL PARA POLICÍA INTRAMUROS',
                'type_of_course' => 'programa',
                'duracion_en_horas' => 1105
            ],
            [
                'nombre_curso' => 'FORMACIÓN INICIAL PARA POLICÍA INVESTIGADOR',                
                'type_of_course' => 'programa',
                'duracion_en_horas' => 1100
            ],
            [
                'nombre_curso' => 'FORMACIÓN INICIAL PARA PERITO',                
                'type_of_course' => 'programa',
                'duracion_en_horas' => 1080
            ],
            /*
            [
                'nombre_curso' => 'FORMACIÓN INICIAL PARA MINISTERIO PÚBLICO',                
                'type_of_course' => 'programa',
                'duracion_en_horas' => 790
            ],
            [
                'nombre_curso' => 'FORMACIÓN INICIAL PARA ANALISTA DE INFORMACIÓN CRIMINAL',                
                'type_of_course' => 'programa',
                'duracion_en_horas' => 825
            ],
            [
                'nombre_curso' => 'FORMACIÓN INICIAL PARA EVALUADORES DE RIESGOS PROCESALES, SUPERVSORES DE MEDIDAS CAUTELARES Y SUSPENCIÓN CONDICIONAL DEL PROCESO',                
                'type_of_course' => 'programa',
                'duracion_en_horas' => 290
            ],
            [
                'nombre_curso' => 'FORMACIÓN INICIAL POLICÍA CUSTODIO PENITENCIARIO',                
                'type_of_course' => 'programa',
                'duracion_en_horas' => 610
            ],
            [
                'nombre_curso' => 'FORMACIÓN INICIAL DEL SISTEMA PENITENCIARIO PARA EL PERFIL JURÍDICO',                
                'type_of_course' => 'programa',
                'duracion_en_horas' => 610
            ],
            [
                'nombre_curso' => 'FORMACIÓN INICIAL DEL SISTEMA PENITENCIARIO PARA EL PERFIL TÉCNICO',                
                'type_of_course' => 'programa',
                'duracion_en_horas' => 440
            ],
            //CURSOS
            [
                'nombre_curso' => ' CURSO DE ACTUALIZACIÓN PARA POLICÍA DE TRANSITO',
                'type_of_course' => 'curso',
                'duracion_en_horas' => 130
            ],
            [
                'nombre_curso' => 'CURSO DE ACTUALIZACIÓN INTRODUCCIÓN A LAS METODOLOGÍAS DE INVESTIGACIÓN CUANTITATIVAY CUALITATIVA EN MATERIA DE SEGURIDAD PÚBLICA',
                'type_of_course' => 'curso',
                'duracion_en_horas' => 40
            ],
            [
                'nombre_curso' => 'CURSO DE COMPETENCIAS BÁSICAS DE LA FUNCIÓN POLICIAL',
                'type_of_course' => 'curso',
                'duracion_en_horas' => 40
            ],
            [
                'nombre_curso' => 'CURSO DE JUSTICIA CÍVICA',
                'type_of_course' => 'curso',
                'duracion_en_horas' => 60
            ],
            [
                'nombre_curso' => 'CURSO DE CADENA DE CUSTODIA',
                'type_of_course' => 'curso',
                'duracion_en_horas' => 40
            ],
            [
                'nombre_curso' => 'CURSO DE ACTUALIZACIÓN TALLER DE ACTUALIZACIÓN EN MATERIA DE COORDINACIÓN OPERATIVA EN EL SISTEMA DE JUSTICIA PENAL PARA INSTITUCIONES DE SEGURIDAD PÚBLICA',
                'type_of_course' => 'curso',
                'duracion_en_horas' => 135
            ],
            [
                'nombre_curso' => 'CURSO DE ACTUALIZACIÓN TALLER DE LA ACTUACIÓN DEL POLICIA EN EL JUICIO ORAL',
                'type_of_course' => 'curso',
                'duracion_en_horas' => 30
            ],
            [
                'nombre_curso' => 'CURSO DE ACTUALIZACIÓN TALLER DE LA FUNCIÓN POLICIAL Y SU EFICACIA EN LOS PRIMEROS ACTOS DE INVESTIGACIÓN',
                'type_of_course' => 'curso',
                'duracion_en_horas' => 30
            ],
            [
                'nombre_curso' => 'CURSO DE ACTUALIZACIÓN TALLER DE LA FUNCIÓN DEL PRIMER RESPONDIENTE Y LA CIENCIA FORENSE APLICADA EN EL LUGAR DE LOS HECHOS',
                'type_of_course' => 'curso',
                'duracion_en_horas' => 30
            ],
            [
                'nombre_curso' => 'CURSO DE ACTUALIZACIÓN MANEJO DEL CONFLICTO- MEDIACIÓN Y NEGOCIACIÓN',
                'type_of_course' => 'curso',
                'duracion_en_horas' => 40
            ],
            [
                'nombre_curso' => 'CURSO DE ACTUALIZACIÓN MANEJO TÁCTICO DEL VEHÍCULO POLICIAL',
                'type_of_course' => 'curso',
                'duracion_en_horas' => 40
            ],
            [
                'nombre_curso' => 'CURSO DE ACTUALIZACIÓN ÉTICA POLICIAL',
                'type_of_course' => 'curso',
                'duracion_en_horas' => 40
            ],
            [
                'nombre_curso' => 'CURSO DE ACTUALIZACIÓN VALORES DEL TRABAJO EN EQUIPO Y LIDERAZGO',
                'type_of_course' => 'curso',
                'duracion_en_horas' => 40
            ],
            [
                'nombre_curso' => 'CURSO DE ACTUALIZACIÓN DESARROLLO INTEGRAL DEL POLICÍA',
                'type_of_course' => 'curso',
                'duracion_en_horas' => 40
            ],
            [
                'nombre_curso' => 'CURSO DE ESPECIALIZACIÓN PARA POLICÍA DE REACCIÓN',
                'type_of_course' => 'curso',
                'duracion_en_horas' => 250
            ],
            [
                'nombre_curso' => 'CURSO DE ESPECIALIZACIÓN PARA POLICÍA DE TRÁNSITO ESPECIALIZADO',
                'type_of_course' => 'curso',
                'duracion_en_horas' => 240
            ],
            [
                'nombre_curso' => 'CURSO DE ESPECIALIZACIÓN PARA INTEGRANTES DE LAS UNIDADES DE POLICÍA CIBERNÉTICA ,PREVENCIÓN DE DELITOS CIBERNÉTICOS O NIVEL ¨0¨',
                'type_of_course' => 'curso',
                'duracion_en_horas' => 90
            ],
            [
                'nombre_curso' => 'CURSO DE ESPECIALIZACIÓN PARA INTEGRANTES DE LAS UNIDADES DE POLICÍA CIBERNÉTICA ,PREVENCIÓN DE DELITOS CIBERNÉTICOS O NIVEL ¨1¨',
                'type_of_course' => 'curso',
                'duracion_en_horas' => 70
            ],
            [
                'nombre_curso' => 'CURSO DE ESPECIALIZACIÓN OPERACIONES TÁCTICAS EN REACCIÓN A LA EMBOSCADA',
                'type_of_course' => 'curso',
                'duracion_en_horas' => 80
            ],
            [
                'nombre_curso' => 'CURSO INTERNACIONAL DE OPERACIONES TÁCTICAS DE COMBATE EN ESTRUCTURAS URBANAS',
                'type_of_course' => 'curso',
                'duracion_en_horas' => 120
            ],
            [
                'nombre_curso' => 'CURSO INTERNACIONAL PARA INSTRUCTORES EN EL USO DE LA FUERZA, ARMAS DE FUEGO, MANTENIMIENTO Y RESTAURACIÓNDEL ORDEN PÚBLICO',
                'type_of_course' => 'curso',
                'duracion_en_horas' => 165
            ],
            [
                'nombre_curso' => 'CURSO BÁSICO DE TÉCNICAS DE IDENTIFICACIÓN VEHICULAR E INVESTIGACIÓNDE ROBO DE VEHÍCULOS',
                'type_of_course' => 'curso',
                'duracion_en_horas' => 40
            ],
            [
                'nombre_curso' => 'CURSO DE TRAYECTORIAS BALÍSTICAS',
                'type_of_course' => 'curso',
                'duracion_en_horas' => 80
            ],
            [
                'nombre_curso' => 'CURSO DE MANTENIMIENTO Y RESTABLECIMIENTO DEL ORDEN PÚBLICO',
                'type_of_course' => 'curso',
                'duracion_en_horas' => 150
            ],
            [
                'nombre_curso' => 'CURSO BÁSICO DEL POLICÍA AUXILIAR',
                'type_of_course' => 'curso',
                'duracion_en_horas' => 135
            ],
            [
                'nombre_curso' => 'CURSO DE ACTUALIZACIÓN TALLER DE INVESTIGACIÓN CRIMINAL CONJUNTA',
                'type_of_course' => 'curso',
                'duracion_en_horas' => 30
            ],
            [
                'nombre_curso' => 'CURSO TALLER DE ACTUALIZACIÓN PARA AGENTES DEL MINISTERIO PÚBLICO EN EL SISTEMA DE JUSTICIA PENAL',
                'type_of_course' => 'curso',
                'duracion_en_horas' => 280
            ],
            [
                'nombre_curso' => 'CURSO TALLER DE ACTUALIZACIÓN PARA POLICÍA INVESTIGADOR EN EL SISTEMA DE JUSTICIA PENAL',
                'type_of_course' => 'curso',
                'duracion_en_horas' => 180
            ],
            [
                'nombre_curso' => 'CURSO TALLER DE ACTUALIZACIÓN PARA PERITO EN EL SISTEMA DE JUSTICIA PENAL',
                'type_of_course' => 'curso',
                'duracion_en_horas' => 180
            ],
            [
                'nombre_curso' => 'CURSO TALLER DE ACTUALIZACIÓN PARA MINISTERIO PÚBLICO ORIENTADOR EN EL SISTEMA DE JUSTICIA PENAL',
                'type_of_course' => 'curso',
                'duracion_en_horas' => 90
            ],
            [
                'nombre_curso' => 'CURSO DE ESPECIALIZACIÓN PARA FACILITADOR EN MECANISMOS ALTERNATIVOS DE SOLUCIÓN DE CONTROVERSIAS EN MATERIA PENAL',
                'type_of_course' => 'curso',
                'duracion_en_horas' => 180
            ],
            [
                'nombre_curso' => 'CURSO DE ESPECIALIZACIÓN PARA POLICÍA PROCESAL EN EL SISTEMA DE JUSTICIA PENAL',
                'type_of_course' => 'curso',
                'duracion_en_horas' => 130
            ],
            [
                'nombre_curso' => 'CURSO TALLER DE ESPELIZACIÓN PARA AGENTES DEL MINISTERIO PÚBLICO EN EL SISTEMA DE JUSTICIA PENAL',
                'type_of_course' => 'curso',
                'duracion_en_horas' => 140
            ],
            [
                'nombre_curso' => 'CURSO TALLER DE ESPECIALIZACIÓN PARA POLICÍA INVESTIGADOR EN EL SISTEMA DE JUSTICIA PENAL',
                'type_of_course' => 'curso',
                'duracion_en_horas' => 90
            ],
            [
                'nombre_curso' => 'CURSO TALLER DE ESPECIALIZACIÓN PARA PERITO EN EL SISTEMA DE JUSTICIA PENAL',
                'type_of_course' => 'curso',
                'duracion_en_horas' => 30
            ],
            [
                'nombre_curso' => 'CURSO TALLER DE ESPECIALIZACIÓN PARA MINISTERIO PÚBLICO ORIENTADOR EN EL SISTEMA DE JUSTICIA PENAL',
                'type_of_course' => 'curso',
                'duracion_en_horas' => 30
            ],
            [
                'nombre_curso' => 'CURSO DE ESPECIALIZACIÓN PARA ASESOR JURÍDICO DE VÍCTIMAS',
                'type_of_course' => 'curso',
                'duracion_en_horas' => 234
            ],
            [
                'nombre_curso' => 'CURSO DE ACTUALIZACIÓN DE LA LEY NACIONAL DE EJECUCIÓN PENAL PARA PERSONAL PENITENCIARIO',
                'type_of_course' => 'curso',
                'duracion_en_horas' => 50
            ],
            [
                'nombre_curso' => 'CURSO DE ACTUALIZACIÓN PARA INTERVINIENTES EN EL SISTEMA INTEGRAL DE JUSTICIA PENAL PARA ADOLESCENTES',
                'type_of_course' => 'curso',
                'duracion_en_horas' => 50
            ],
            [
                'nombre_curso' => 'CURSO DE ESPECIALIZACIÓN PARA LOS OPERADORES DEL SISTEMA INTEGRAL DE JUSTICIA PENAL PARA ADOLESCENTES',
                'type_of_course' => 'curso',
                'duracion_en_horas' => 160
            ],
            [
                'nombre_curso' => 'CURSO DE ACTUALIZACIÓN PARA ANALISTA DE INFORMACIÓN',
                'type_of_course' => 'curso',
                'duracion_en_horas' => 50
            ],
            [
                'nombre_curso' => 'CURSO DE ACTUALIZACIÓN TALLER DE ANALISIS DE INFORMACIÓN PARA EL DESARROLLO DE PRODUCTOS DE INTELIGENCIA',
                'type_of_course' => 'curso',
                'duracion_en_horas' => 90
            ],
            [
                'nombre_curso' => 'CURSO DE ACTUALIZACIÓN ANÁLISIS DE INFORMACIÓN A TRAVÉS DE REDES',
                'type_of_course' => 'curso',
                'duracion_en_horas' => 90
            ],
            [
                'nombre_curso' => 'CURSO DE PROTOCOLO DE ACTUACIÓN POLICIAL CON EMPLEO DE LA LENGUA DE SEÑAS MEXICANA',
                'type_of_course' => 'curso',
                'duracion_en_horas' => 80
            ],
            [
                'nombre_curso' => 'CURSO INTERNACIONAL IDENTIFICACÍON MORFOLOGICA Y FISIONOMÍA HUMANA',
                'type_of_course' => 'curso',
                'duracion_en_horas' => 80
            ],
            [
                'nombre_curso' => 'CURSO INTERNACIONAL CÓMO DETECTAR MENTIRAS A TRAVÉZ DE LA OBSERVACIÓN, DECODIFICACIÓN, INTERPRETACIÓN, ANÁLISIS E INVESTIGACIÓN DEL COMPORTAMIENTO HUMANO',
                'type_of_course' => 'curso',
                'duracion_en_horas' => 80
            ],
            [
                'nombre_curso' => 'CURSO DE ESPECIALIZACIÓN PARA UNIDADES ESPECIALIZADAS CONTRA EL SECUESTRO (TRONCO COMÚN)',
                'type_of_course' => 'curso',
                'duracion_en_horas' => 114
            ],
            [
                'nombre_curso' => 'CURSO DE ESPECIALIZACIÓN PARA LOS OPERADORES DEL SISTEMA INTEGRAL DE JUSTICIA PENAL PARA ADOLESCENTES CON ENFOQUE EN FACILITADORES DE MECANISMOS ALTERNATIVOS',
                'type_of_course' => 'curso',
                'duracion_en_horas' => 180
            ],
            */


        ]);
    }
}
