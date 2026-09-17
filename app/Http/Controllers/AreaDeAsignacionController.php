<?php

namespace App\Http\Controllers;

use App\Models\AreaDeUso;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AreaDeAsignacionController extends Controller
{
    private int $perPage = 5;

    /**
     * Mostrar el listado de áreas de asignación.
     */
    public function index(): View
    {
        $areasDeAsignacion = AreaDeUso::query()
            ->orderBy('nombre')
            ->paginate($this->perPage);

        return view(
            'areasasignacion.index',
            compact('areasDeAsignacion')
        );
    }

    /**
     * Registrar una nueva área de asignación.
     */
    public function store(Request $request): RedirectResponse
    {
        $datosValidados = $request->validate([
            'nombre' => [
                'required',
                'string',
                'min:2',
                'max:100',
                'unique:area_de_uso,nombre',
            ],
        ], [
            'nombre.required' => 'El nombre del área es obligatorio.',
            'nombre.string' => 'El nombre del área debe ser texto.',
            'nombre.min' => 'El nombre debe tener al menos 2 caracteres.',
            'nombre.max' => 'El nombre no puede superar los 100 caracteres.',
            'nombre.unique' => 'Esta área de asignación ya está registrada.',
        ]);

        AreaDeUso::create([
            'nombre' => trim($datosValidados['nombre']),
        ]);

        return redirect()
            ->route('areadeasignacion.index')
            ->with(
                'success',
                'Área de asignación registrada correctamente.'
            );
    }
}