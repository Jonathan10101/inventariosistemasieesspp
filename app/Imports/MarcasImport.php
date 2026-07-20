<?php

namespace App\Imports;

use App\Models\Marca;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use RuntimeException;

class MarcasImport implements ToCollection, SkipsEmptyRows
{
    private int $marcasImportadas = 0;

    private int $marcasDuplicadas = 0;

    private array $errores = [];

    public function collection(Collection $rows): void
    {
        /*
        |--------------------------------------------------------------------------
        | Verificar que el archivo tenga contenido
        |--------------------------------------------------------------------------
        */

        if ($rows->isEmpty()) {
            throw new RuntimeException(
                'El archivo Excel está vacío.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Revisar directamente la celda A1
        |--------------------------------------------------------------------------
        */

        $primeraFila = $rows->first();

        $encabezado = trim(
            (string) ($primeraFila[0] ?? '')
        );

        /*
         * Elimina BOM, que algunos archivos agregan
         * al inicio del encabezado.
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

        if ($encabezado !== 'nombre') {
            throw new RuntimeException(
                'La celda A1 debe llamarse nombre. '
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
            /*
             * El índice 1 corresponde a la fila 2 de Excel.
             */
            $numeroFila = ((int) $indice) + 1;

            $nombre = mb_strtoupper(
                trim((string) ($row[0] ?? '')),
                'UTF-8'
            );

            /*
             * Ignorar filas vacías.
             */
            if ($nombre === '') {
                continue;
            }

            /*
             * Validar longitud máxima de la migración.
             */
            if (mb_strlen($nombre, 'UTF-8') > 150) {
                $this->errores[] = [
                    'fila' => $numeroFila,
                    'valor' => $nombre,
                    'mensajes' => [
                        'El nombre no puede superar los 150 caracteres.',
                    ],
                ];

                continue;
            }

            /*
             * firstOrCreate evita el error por la columna unique.
             */
            $marca = Marca::firstOrCreate([
                'nombre' => $nombre,
            ]);

            if ($marca->wasRecentlyCreated) {
                $this->marcasImportadas++;
            } else {
                $this->marcasDuplicadas++;
            }
        }
    }

    public function getMarcasImportadas(): int
    {
        return $this->marcasImportadas;
    }

    public function getMarcasDuplicadas(): int
    {
        return $this->marcasDuplicadas;
    }

    public function getErrores(): array
    {
        return $this->errores;
    }
}