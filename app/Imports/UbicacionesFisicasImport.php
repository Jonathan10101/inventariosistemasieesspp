<?php

namespace App\Imports;

use App\Models\UbicacionFisica;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use RuntimeException;

class UbicacionesFisicasImport implements ToCollection, SkipsEmptyRows
{
    private int $ubicacionesImportadas = 0;

    private int $ubicacionesDuplicadas = 0;

    private array $errores = [];

    public function collection(Collection $rows): void
    {
        /*
        |--------------------------------------------------------------------------
        | Verificar archivo
        |--------------------------------------------------------------------------
        */

        if ($rows->isEmpty()) {
            throw new RuntimeException(
                'El archivo Excel está vacío.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Verificar encabezado A1
        |--------------------------------------------------------------------------
        */

        $primeraFila = $rows->first();

        $encabezado = trim(
            (string) ($primeraFila[0] ?? '')
        );

        /*
         * Eliminar BOM, frecuente en archivos CSV.
         */
        $encabezado = preg_replace(
            '/^\xEF\xBB\xBF/',
            '',
            $encabezado
        );

        $encabezado = mb_strtolower(
            trim($encabezado),
            'UTF-8'
        );

        if ($encabezado !== 'descripcion') {
            throw new RuntimeException(
                'La celda A1 debe llamarse descripcion. '
                . 'Actualmente contiene: '
                . ($encabezado !== '' ? $encabezado : 'vacío')
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Procesar desde la segunda fila
        |--------------------------------------------------------------------------
        */

        foreach ($rows->skip(1) as $indice => $row) {
            $numeroFila = ((int) $indice) + 1;

            $descripcion = mb_strtoupper(
                trim((string) ($row[0] ?? '')),
                'UTF-8'
            );

            /*
             * Ignorar filas vacías.
             */
            if ($descripcion === '') {
                continue;
            }

            /*
             * Validar longitud.
             */
            if (mb_strlen($descripcion, 'UTF-8') > 255) {
                $this->errores[] = [
                    'fila' => $numeroFila,
                    'valor' => $descripcion,
                    'mensajes' => [
                        'La descripción no puede superar los 255 caracteres.',
                    ],
                ];

                continue;
            }

            /*
             * Crear ubicación o detectar duplicado.
             */
            $ubicacion = UbicacionFisica::firstOrCreate(
                [
                    'descripcion' => $descripcion,
                ]
            );

            if ($ubicacion->wasRecentlyCreated) {
                $this->ubicacionesImportadas++;
            } else {
                $this->ubicacionesDuplicadas++;
            }
        }
    }

    public function getUbicacionesImportadas(): int
    {
        return $this->ubicacionesImportadas;
    }

    public function getUbicacionesDuplicadas(): int
    {
        return $this->ubicacionesDuplicadas;
    }

    public function getErrores(): array
    {
        return $this->errores;
    }
}