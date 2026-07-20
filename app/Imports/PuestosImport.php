<?php

namespace App\Imports;

use App\Models\Puesto;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use RuntimeException;

class PuestosImport implements ToCollection, SkipsEmptyRows
{
    private int $puestosImportados = 0;

    private int $puestosDuplicados = 0;

    private array $errores = [];

    public function collection(Collection $rows): void
    {
        if ($rows->isEmpty()) {
            throw new RuntimeException(
                'El archivo Excel está vacío.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Revisar encabezado A1
        |--------------------------------------------------------------------------
        */

        $primeraFila = $rows->first();

        $encabezado = trim(
            (string) ($primeraFila[0] ?? '')
        );

        /*
         * Eliminar BOM si existe.
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
                'La celda A1 debe llamarse nombre. Actualmente contiene: '
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

            $nombre = mb_strtoupper(
                trim((string) ($row[0] ?? '')),
                'UTF-8'
            );

            if ($nombre === '') {
                continue;
            }

            if (mb_strlen($nombre, 'UTF-8') > 150) {
                $this->errores[] = [
                    'fila' => $numeroFila,
                    'valor' => $nombre,
                    'mensajes' => [
                        'El nombre del puesto no puede superar los 150 caracteres.',
                    ],
                ];

                continue;
            }

            $puesto = Puesto::firstOrCreate([
                'nombre' => $nombre,
            ]);

            if ($puesto->wasRecentlyCreated) {
                $this->puestosImportados++;
            } else {
                $this->puestosDuplicados++;
            }
        }
    }

    public function getPuestosImportados(): int
    {
        return $this->puestosImportados;
    }

    public function getPuestosDuplicados(): int
    {
        return $this->puestosDuplicados;
    }

    public function getErrores(): array
    {
        return $this->errores;
    }
}