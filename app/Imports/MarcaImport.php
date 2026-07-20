<?php

namespace App\Imports;

use App\Models\Marca;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithSkipDuplicates;
use Maatwebsite\Excel\Concerns\WithValidation;

class MarcasImport implements
    ToModel,
    WithHeadingRow,
    WithValidation,
    SkipsOnFailure,
    SkipsEmptyRows,
    WithBatchInserts,
    WithChunkReading,
    WithSkipDuplicates
{
    use Importable;
    use SkipsFailures;

    private int $filasProcesadas = 0;

    /**
     * Convierte cada fila del Excel en una marca.
     */
    public function model(array $row): ?Marca
    {
        $nombre = mb_strtoupper(
            trim((string) ($row['nombre'] ?? '')),
            'UTF-8'
        );

        if ($nombre === '') {
            return null;
        }

        $this->filasProcesadas++;

        return new Marca([
            'nombre' => $nombre,
        ]);
    }

    /**
     * Validación de cada fila.
     */
    public function rules(): array
    {
        return [
            '*.nombre' => [
                'required',
                'string',
                'max:150',
            ],
        ];
    }

    /**
     * Mensajes de validación.
     */
    public function customValidationMessages(): array
    {
        return [
            '*.nombre.required' =>
                'El nombre de la marca es obligatorio.',

            '*.nombre.string' =>
                'El nombre de la marca debe ser texto.',

            '*.nombre.max' =>
                'El nombre de la marca no puede superar los 150 caracteres.',
        ];
    }

    /**
     * Inserta registros por grupos.
     */
    public function batchSize(): int
    {
        return 500;
    }

    /**
     * Lee el archivo por bloques.
     */
    public function chunkSize(): int
    {
        return 500;
    }

    /**
     * Total de filas válidas procesadas.
     */
    public function getFilasProcesadas(): int
    {
        return $this->filasProcesadas;
    }
}