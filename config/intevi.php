<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Límite de almacenamiento por tenant
    |--------------------------------------------------------------------------
    |
    | 4 GB = 4,294,967,296 bytes
    |
    */

    'tenant_database_limit_bytes' => (int) env(
        'TENANT_DATABASE_LIMIT_BYTES',
        4 * 1024 * 1024 * 1024
    ),

];