<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Límite de almacenamiento por tenant
    |--------------------------------------------------------------------------
    |
    | El valor se define en megabytes desde el archivo .env:
    |
    | TENANT_DATABASE_LIMIT_MB=4
    |
    | Ejemplos:
    | 4    = 4 MB
    | 50   = 50 MB
    | 1024 = 1 GB
    | 4096 = 4 GB
    |
    */

    'tenant_database_limit_mb' => max(
        1,
        (int) env('TENANT_DATABASE_LIMIT_MB', 4096)
    ),

    /*
    |--------------------------------------------------------------------------
    | Conexión de base de datos tenant
    |--------------------------------------------------------------------------
    |
    | Stancl Tenancy normalmente utiliza la conexión "tenant".
    |
    */

    'tenant_database_connection' => env(
        'TENANT_DATABASE_CONNECTION',
        'tenant'
    ),

];