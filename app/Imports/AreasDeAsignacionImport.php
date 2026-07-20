<?php

namespace App\Imports;

use App\Models\AreaDeUso;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use RuntimeException;

class AreasDeAsignacionImport implements ToCollection, SkipsEmptyRows
{
    private int $areasImportadas = 0;

    private int $areasDuplicadas = 0;

    private array $errores = [];

    /**
     * Procesar las filas del Excel.
     */
    public function collection(Collection $rows): void
    {
        /*
        |--------------------------------------------------------------------------
        | Verificar que el archivo no esté vacío
        |--------------------------------------------------------------------------
        */

        if ($rows->isEmpty()) {
            throw new RuntimeException(
                'El archivo Excel está vacío.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Verificar encabezado de la celda A1
        |--------------------------------------------------------------------------
        */

        $primeraFila = $rows->first();

        $encabezado = trim(
            (string) ($primeraFila[0] ?? '')
        );

        /*
         * Eliminar BOM que algunos archivos agregan al encabezado.
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
        | Procesar las filas desde la segunda fila
        |--------------------------------------------------------------------------
        */

        foreach ($rows->skip(1) as $indice => $row) {
            /*
             * La fila con índice 1 corresponde a la fila 2 de Excel.
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
             * Validar longitud máxima.
             */
            if (mb_strlen($nombre, 'UTF-8') > 150) {
                $this->errores[] = [
                    'fila' => $numeroFila,
                    'valor' => $nombre,
                    'mensajes' => [
                        'El nombre del área no puede superar los 150 caracteres.',
                    ],
                ];

                continue;
            }

            /*
             * Registrar el área o detectar si ya existe.
             */
            $area = AreaDeUso::firstOrCreate([
                'nombre' => $nombre,
            ]);

            if ($area->wasRecentlyCreated) {
                $this->areasImportadas++;
            } else {
                $this->areasDuplicadas++;
            }
        }
    }

    /**
     * Cantidad de áreas nuevas registradas.
     */
    public function getAreasImportadas(): int
    {
        return $this->areasImportadas;
    }

    /**
     * Cantidad de áreas que ya existían.
     */
    public function getAreasDuplicadas(): int
    {
        return $this->areasDuplicadas;
    }

    /**
     * Errores encontrados por fila.
     */
    public function getErrores(): array
    {
        return $this->errores;
    }
}