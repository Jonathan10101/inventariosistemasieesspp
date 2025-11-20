<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ResguardanteSeeder extends Seeder
{
    
    public function run(): void
    {
        DB::table('resguardantes')->insert([
            ['nombre1' => 'ADMINISTRADOR','nombre2' => '','apellido1'=>"",'apellido2'=>'','user_id'=>1],
            ['nombre1' => 'JONATHAN','nombre2' => '','apellido1'=>"BEDOLLA",'apellido2'=>'HURTADO','user_id'=>2],
            ['nombre1' => 'ALICIA','nombre2' => '','apellido1'=>"MALDONADO",'apellido2'=>'FLORES','user_id'=>3],
            ['nombre1' => 'YUVITZY','nombre2' => '','apellido1'=>"REBOLLAR",'apellido2'=>'RIVERA','user_id'=>4],
            ['nombre1' => 'BLANCA','nombre2' => 'ESTHELA','apellido1'=>"PADILLA",'apellido2'=>'GARCIA','user_id'=>5],
            /*
            ['nombre1' => 'ANGELICA','nombre2' => '','apellido1'=>"HERRERA",'apellido2'=>'ZAVALA'],
            ['nombre1' => 'ANTONIA','nombre2' => '','apellido1'=>"DELGADO",'apellido2'=>'HERNANDEZ'],
            ['nombre1' => 'BEATRIZ','nombre2' => '','apellido1'=>"CERVANTES",'apellido2'=>'VELAZQUEZ'],
            ['nombre1' => 'BRYAN','nombre2' => 'ALEXIS','apellido1'=>"AYALA",'apellido2'=>'AMBRIZ'],
            ['nombre1' => 'CAROLINA','nombre2' => '','apellido1'=>"CRUZ",'apellido2'=>'GARCIA'],
            ['nombre1' => 'CITLALI','nombre2' => '','apellido1'=>"MARCELA",'apellido2'=>'GAYTAN'],
            ['nombre1' => 'CRISTINA','nombre2' => '','apellido1'=>"GONZALEZ",'apellido2'=>'MARTINEZ'],
            ['nombre1' => 'JOSE','nombre2' => 'GUADALUPE','apellido1'=>"RODRIGUEZ",'apellido2'=>'BARAJAS'],
            ['nombre1' => 'DAFNE','nombre2' => '','apellido1'=>"QUINTANILLA",'apellido2'=>'MORENO'],
            ['nombre1' => 'MARIA','nombre2' => 'DE J.','apellido1'=>"GALLEGOS",'apellido2'=>'RAMIREZ'],
            ['nombre1' => 'MONICA','nombre2' => 'ESMERALDA','apellido1'=>"LOPEZ",'apellido2'=>'ZIZUMBO'],
            ['nombre1' => 'EVA','nombre2' => 'MARIA','apellido1'=>"MARTINEZ",'apellido2'=>'HERNANDEZ'],
            ['nombre1' => 'EVELIA','nombre2' => '','apellido1'=>"ALCANTAR",'apellido2'=>'LEÓN'],
            ['nombre1' => 'EVELIA','nombre2' => '','apellido1'=>"MORA",'apellido2'=>'HERNANDEZ'],
            ['nombre1' => 'FERMIN','nombre2' => '','apellido1'=>"CALDERON",'apellido2'=>'CALDERON'],
            ['nombre1' => 'FRANCISCO','nombre2' => 'JAVIER','apellido1'=>"VILLAGOMEZ",'apellido2'=>'NAVARRETE'],
            ['nombre1' => 'GEOVANI','nombre2' => '','apellido1'=>"VIJOSA",'apellido2'=>'IBARRA'],
            ['nombre1' => 'GRACIELA','nombre2' => '','apellido1'=>"GUTIERREZ",'apellido2'=>'MARTINEZ'],
            ['nombre1' => 'HANNIA','nombre2' => 'MICHELLE','apellido1'=>"GONZALEZ",'apellido2'=>'CALDERON'],
            ['nombre1' => 'HECTOR','nombre2' => '','apellido1'=>"PEREZ",'apellido2'=>'GARCIA'],
            ['nombre1' => 'ILIANA','nombre2' => 'MARISOL','apellido1'=>"PEREZ",'apellido2'=>'CARRILLO'],
            ['nombre1' => 'J.','nombre2' => 'SILVESTRE','apellido1'=>"DOMINGUEZ",'apellido2'=>'CADENAS'],
            ['nombre1' => 'JOVANNA','nombre2' => 'JANET','apellido1'=>"LOPEZ",'apellido2'=>'MENERA'],
            ['nombre1' => 'JUAN','nombre2' => 'DANIEL','apellido1'=>"GONZALEZ",'apellido2'=>'RODRIGUEZ'],
            ['nombre1' => 'JUAN','nombre2' => 'RICARDO','apellido1'=>"ZAVALA",'apellido2'=>'ALVAREZ'],
            ['nombre1' => 'JULIAN','nombre2' => 'SALOMON','apellido1'=>"CAMACHO",'apellido2'=>'RODRIGUEZ'],
            ['nombre1' => 'LAURA','nombre2' => '','apellido1'=>"SERNA",'apellido2'=>'GOMEZ'],
            ['nombre1' => 'ESTEFANIA','nombre2' => '','apellido1'=>"ALMANZA",'apellido2'=>'LAGUNAS'],
            ['nombre1' => 'LEONARDO','nombre2' => 'RENE','apellido1'=>"ROMAN",'apellido2'=>'DOMINGUEZ'],
            ['nombre1' => 'LETICIA','nombre2' => '','apellido1'=>"BEDOLLA",'apellido2'=>'CHAVEZ'],
            ['nombre1' => 'MARIA','nombre2' => 'DEL SOCORRO','apellido1'=>"DOMINGUEZ",'apellido2'=>'B.'],
            ['nombre1' => 'MARIA','nombre2' => 'GUADALUPE','apellido1'=>"OCHOA",'apellido2'=>'DOM.'],
            ['nombre1' => 'MARIO','nombre2' => 'IRAN','apellido1'=>"FUENTES",'apellido2'=>'RAMIREZ'],
            ['nombre1' => 'MIRIAM','nombre2' => '','apellido1'=>"BERNAL",'apellido2'=>'MALDONADO'],
            ['nombre1' => 'NADIR','nombre2' => '','apellido1'=>"MONTELONGO",'apellido2'=>'MARTINEZ'],
            ['nombre1' => 'OSWALDO','nombre2' => '','apellido1'=>"MARTINEZ",'apellido2'=>'GONZALEZ'],
            ['nombre1' => 'PAOLA','nombre2' => 'MONSERRAT','apellido1'=>"MANCERA",'apellido2'=>'C.'],
            ['nombre1' => 'PATRICIO','nombre2' => '','apellido1'=>"ANDRADE",'apellido2'=>'SALGADO'],
            ['nombre1' => 'PAULINA','nombre2' => '','apellido1'=>"RIZO",'apellido2'=>'BOTELLO'],
            ['nombre1' => 'PEDRO','nombre2' => '','apellido1'=>"LOPEZ",'apellido2'=>'MENERA'],
            ['nombre1' => 'PERLA','nombre2' => 'YOLANDA','apellido1'=>"NARANJO",'apellido2'=>'CRUZ'],
            ['nombre1' => 'RAMON','nombre2' => '','apellido1'=>"OROZCO",'apellido2'=>'VELAZQUEZ'],
            ['nombre1' => 'ROGELIO','nombre2' => '','apellido1'=>"ARRIAGA",'apellido2'=>'GUZMAN'],
            ['nombre1' => 'YOQSAN','nombre2' => 'AZAEL','apellido1'=>"PEREZ",'apellido2'=>'MELENDEZ'],
            ['nombre1' => 'YUNUEN','nombre2' => 'IRERI','apellido1'=>"VILLANUEVA",'apellido2'=>'PALENCIA'],
            */
        ]);  
    }

}
