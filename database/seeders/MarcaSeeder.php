<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class MarcaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('marcas')->insert([
            ['nombre' => 'DELL'],
            ['nombre' => 'HP'],
            ['nombre' => 'LENOVO'],
            ['nombre' => 'MSI'],
            ['nombre' => 'CANON'],
            ['nombre' => 'EPSON'],
            ['nombre' => 'BROTHER'],
            ['nombre' => 'LOGITECH'],
            ['nombre' => 'APPLE'],
            ['nombre' => 'ASUS'],
            ['nombre' => 'ACER'],
            ['nombre' => 'TOSHIBA'],
            ['nombre' => 'SAMSUNG'],
            ['nombre' => 'LG'],
            ['nombre' => 'HUAWEI'],
            ['nombre' => 'XEROX'],
            ['nombre' => 'KINGSTON'],
            ['nombre' => 'ADATA'],
            ['nombre' => 'SANDISK'],
            ['nombre' => 'SEAGATE'],
            ['nombre' => 'WESTERN DIGITAL'],
            ['nombre' => 'MICROSOFT'],
            ['nombre' => 'CISCO'],
            ['nombre' => 'TP-LINK'],
            ['nombre' => 'HIKVISION'],
            ['nombre' => 'DAHUA'],
            ['nombre' => 'ZEBRA'],
            ['nombre' => 'PANDA'],
            ['nombre' => 'RAZER'],
            ['nombre' => 'GIGABYTE'],
            ['nombre' => 'INTEL'],
            ['nombre' => 'AMD'],
            ['nombre' => 'NVIDIA'],
            ['nombre' => 'BOSE'],
            ['nombre' => 'JBL'],
            ['nombre' => 'POLYCOM'],
            ['nombre' => 'KYOCERA'],
            ['nombre' => 'FUJITSU'],
            ['nombre' => 'LEXMARK'],
            ['nombre' => 'RICHOH'],
            ['nombre' => 'UBIQUITI'],
            ['nombre' => 'APC'],
            ['nombre' => 'VERTIV'],
            ['nombre' => 'HONEYWELL'],
            ['nombre' => 'ZTE'],
            ['nombre' => 'MOTOROLA'],
            ['nombre' => 'GARMIN'],
            ['nombre' => 'VIEWSONIC'],
            ['nombre' => 'PHILIPS']

        ]);  
    }
}
