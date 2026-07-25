<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use RuntimeException;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Verificar que se esté ejecutando dentro de un tenant
        |--------------------------------------------------------------------------
        */

        $tenantActual = tenant();

        if (!$tenantActual) {
            throw new RuntimeException(
                'El UserSeeder debe ejecutarse dentro del contexto de un tenant.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Obtener el dominio del tenant
        |--------------------------------------------------------------------------
        |
        | Ejemplos:
        |
        | ieesspp.intevi.app
        | ofertascreativas.intevi.app
        |
        */

        $dominio = $tenantActual->domains()
            ->value('domain');

        if (!$dominio) {
            throw new RuntimeException(
                'El tenant no tiene un dominio registrado.'
            );
        }

        $dominio = mb_strtolower(trim($dominio));

        /*
        |--------------------------------------------------------------------------
        | Obtener lo que está antes de .intevi.app
        |--------------------------------------------------------------------------
        |
        | ieesspp.intevi.app
        | Resultado: ieesspp
        |
        | ofertascreativas.intevi.app
        | Resultado: ofertascreativas
        |
        */

        if (Str::endsWith($dominio, '.intevi.app')) {
            $nombreTenant = Str::before(
                $dominio,
                '.intevi.app'
            );
        } else {
            /*
             * Esto permite que también funcione localmente:
             *
             * ieesspp.intevi.test -> ieesspp
             */
            $nombreTenant = Str::before($dominio, '.');
        }

        /*
         * Limpiar el nombre para utilizarlo en el correo.
         */
        $nombreTenant = preg_replace(
            '/[^a-z0-9-]/',
            '',
            Str::lower($nombreTenant)
        );

        if (empty($nombreTenant)) {
            throw new RuntimeException(
                'No fue posible obtener el nombre del tenant desde el dominio.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Correo automático del administrador
        |--------------------------------------------------------------------------
        */

        $emailAdministrador = 'administrador@'
            . $nombreTenant
            . '.com';

        /*
        |--------------------------------------------------------------------------
        | Revisar si el administrador ya existe
        |--------------------------------------------------------------------------
        |
        | Si vuelves a ejecutar el seeder, no cambia la contraseña.
        |
        */

        $administrador = User::where(
            'email',
            $emailAdministrador
        )->first();

        if ($administrador) {
            $administrador->update([
                'name' => 'Administrador',
            ]);

            if (!$administrador->hasRole('Administrador')) {
                $administrador->assignRole('Administrador');
            }

            $this->command?->warn(
                'El administrador ya existe: '
                . $emailAdministrador
            );

            $this->command?->warn(
                'La contraseña existente no fue modificada.'
            );

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Generar una contraseña diferente para cada tenant
        |--------------------------------------------------------------------------
        |
        | Ejemplo:
        | hT9kP3wLmQ2xAa#5841
        |
        */

        $passwordPlano = Str::random(12)
            . 'Aa#'
            . random_int(1000, 9999);

        /*
        |--------------------------------------------------------------------------
        | Crear administrador
        |--------------------------------------------------------------------------
        */

        $administrador = User::create([
            'name' => 'Administrador',
            'email' => $emailAdministrador,
            'password' => Hash::make($passwordPlano),
        ]);

        $administrador->assignRole('Administrador');

        /*
        |--------------------------------------------------------------------------
        | Mostrar credenciales una sola vez
        |--------------------------------------------------------------------------
        */

        $this->command?->newLine();

        $this->command?->info(
            'Administrador creado correctamente'
        );

        $this->command?->line(
            'Tenant: ' . $nombreTenant
        );

        $this->command?->line(
            'Dominio: https://' . $dominio
        );

        $this->command?->line(
            'Correo: ' . $emailAdministrador
        );

        $this->command?->line(
            'Contraseña: ' . $passwordPlano
        );

        $this->command?->warn(
            'Guarda esta contraseña ahora. '
            . 'No volverá a mostrarse al ejecutar el seeder.'
        );

        $this->command?->newLine();
    }
}