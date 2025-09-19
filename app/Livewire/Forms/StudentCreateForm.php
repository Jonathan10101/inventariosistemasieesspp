<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;
use App\Models\Estudiante;

class StudentCreateForm extends Form
{
    //Este tipo de validación es muy buena ya que evita el crear el  protected $rules, Nota.- Se puede aplicar en algunos casos
    
    #[Rule('required|string|max:40')]
    public $nombre1;

    #[Rule('required|min:3')]
    public $apellido1;
    
    #[Rule('required|string|size:18|unique:estudiantes,curp')]
    public $curp;

    #[Rule('required')]
    public $fecha_nacimiento;

    #[Rule('required|exists:escolaridad,id')]
    public $id_escolaridad;

    #[Rule('required|in:M,H')]
    public $genero;
    
    #[Rule('required|string|size:10|unique:estudiantes,celular')]
    public $celular;
    
    #[Rule('required|email|unique:estudiantes,correo_electronico')]
    public $correo_electronico;
    
    #[Rule('required|unique:estudiantes,matricula_cuip|min:20|max:20')]
    public $matricula_cuip;
}
