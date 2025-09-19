<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Estudiante;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Year;
use App\Models\Inscripciones;


class StudentStats extends Component
{
    public $year_selected=0; // Estado seleccionado
    public $hombres;
    public $mujeres;

    public $niveles;
    public $totales;

    public $primaria;
    public $secundaria;
    public $preparatoria;
    public $universidad;
    public $posgrado;

    public $conteoEscolaridades;

    public $edades,$totales2;

    public $years;


    public $estadistica_genero,$totalGeneros,$estadistica_escolaridad,$totalEscolaridades,$estadistica_total_estudiantes,$filteredYears,$estadistica_edades,$totalEdades,
    $labels_municipios,$totals_municipios;


    public function mount()
    {
        $this->years = Year::all();
        
        $currentYear = Carbon::now()->year;
        if ($this->years->contains('number', $currentYear)) {
            $this->year_selected = $currentYear;
        } else {
            $this->year_selected = $this->years->first()->number ?? null;
        }        

        

        $this->updateStats();
    }

    public function save(){

        
        $this->estadistica_genero = DB::select("
            SELECT 
                COUNT(CASE WHEN subquery.genero = 'M' THEN 1 END) AS total_mujeres,
                COUNT(CASE WHEN subquery.genero = 'H' THEN 1 END) AS total_hombres
            FROM (
                SELECT DISTINCT 
                    estudiantes.id, 
                    estudiantes.genero
                FROM 
                    estudiantes
                INNER JOIN 
                    inscripciones ON estudiantes.id = inscripciones.estudiante_id
                INNER JOIN 
                    generaciones ON inscripciones.generacion_id = generaciones.id
                WHERE 
                    YEAR(inscripciones.fecha_inicio) IN ($this->year_selected)
                    OR YEAR(generaciones.fecha_inicio) IN ($this->year_selected)
            ) AS subquery
        ");


        $this->totalGeneros = [
            'Mujeres' => $this->estadistica_genero[0]->total_mujeres,
            'Hombres' => $this->estadistica_genero[0]->total_hombres
        ];

        //dd($this->totalGeneros);


        $this->estadistica_escolaridad = DB::select("
           SELECT 
                COUNT(CASE WHEN subquery.escolaridad_id = 1 THEN 1 END) AS total_kinder,
                COUNT(CASE WHEN subquery.escolaridad_id = 2 THEN 1 END) AS total_primaria,
                COUNT(CASE WHEN subquery.escolaridad_id = 3 THEN 1 END) AS total_secundaria,
                COUNT(CASE WHEN subquery.escolaridad_id = 4 THEN 1 END) AS total_preparatoria,
                COUNT(CASE WHEN subquery.escolaridad_id = 5 THEN 1 END) AS total_universidad,
                COUNT(CASE WHEN subquery.escolaridad_id = 6 THEN 1 END) AS total_maestria,
                COUNT(CASE WHEN subquery.escolaridad_id = 7 THEN 1 END) AS total_doctorado
            FROM (
                SELECT DISTINCT 
                    estudiantes.id, 
                    estudiantes.escolaridad_id
                FROM 
                    estudiantes
                INNER JOIN 
                    inscripciones ON estudiantes.id = inscripciones.estudiante_id
                INNER JOIN 
                    generaciones ON inscripciones.generacion_id = generaciones.id
                WHERE 
                    YEAR(inscripciones.fecha_inicio) IN ($this->year_selected)
                    OR YEAR(generaciones.fecha_inicio) IN ($this->year_selected)
            ) AS subquery
        ");
    

        $this->totalEscolaridades= [
            'Kinder' => $this->estadistica_escolaridad[0]->total_kinder,
            'Primaria' => $this->estadistica_escolaridad[0]->total_primaria,
            'Secundaria' => $this->estadistica_escolaridad[0]->total_secundaria,
            'Preparatoria' => $this->estadistica_escolaridad[0]->total_preparatoria,
            'Universidad' => $this->estadistica_escolaridad[0]->total_universidad,
            'Maestria' => $this->estadistica_escolaridad[0]->total_maestria,
            'Doctorado' => $this->estadistica_escolaridad[0]->total_doctorado
        ];


        $this->estadistica_total_estudiantes = DB::select("
            SELECT 
                YEAR(generaciones.fecha_inicio) AS anio,
                COUNT(DISTINCT estudiantes.id) AS total_alumnos
            FROM 
                estudiantes
            INNER JOIN 
                inscripciones ON estudiantes.id = inscripciones.estudiante_id
            INNER JOIN 
                generaciones ON inscripciones.generacion_id = generaciones.id
            GROUP BY 
                YEAR(generaciones.fecha_inicio)
            ORDER BY 
                anio;
        ");
    
        // Convertir el resultado en una colección de Laravel
        $this->estadistica_total_estudiantes = collect($this->estadistica_total_estudiantes);
    
        // Filtrar los años diferentes de 2000 y extraerlos en un array
        $this->filteredYears = $this->estadistica_total_estudiantes
            ->where('anio', '!=', 2000)
            ->pluck('anio')
            ->toArray();


        




        /*
        //Este muestra la edad del estudiante al momento de ver las estadisticas
        $this->estadistica_edades = DB::select("
            SELECT 
                subquery.edad,
                COUNT(subquery.id) AS total
            FROM (
                SELECT DISTINCT 
                    estudiantes.id,
                    TIMESTAMPDIFF(YEAR, estudiantes.fecha_nacimiento, CURDATE()) AS edad
                FROM 
                    estudiantes
                INNER JOIN 
                    inscripciones ON estudiantes.id = inscripciones.estudiante_id
                LEFT JOIN 
                    generaciones ON inscripciones.generacion_id = generaciones.id
                WHERE
                    YEAR(inscripciones.fecha_inicio) = $this->year_selected
                    OR YEAR(generaciones.fecha_inicio) = $this->year_selected
            ) AS subquery
            GROUP BY 
                subquery.edad
            ORDER BY 
                subquery.edad
        ");
        */
        

         
        //Este muestra la edad que tenia el estudiante al momento de tomar el curso
        $this->estadistica_edades = DB::select("
        SELECT 
            subquery.edad,
            COUNT(subquery.id) AS total
        FROM (
            SELECT DISTINCT 
                estudiantes.id,
                -- Obtener la fecha de inicio del curso (generación o inscripción)
                IF(
                    inscripciones.fecha_inicio = '2000-01-01' OR inscripciones.fecha_inicio IS NULL, 
                    generaciones.fecha_inicio, 
                    inscripciones.fecha_inicio
                ) AS fecha_inicio,
                -- Calcular la edad al momento de iniciar el curso (sin considerar aún el cumpleaños)
                TIMESTAMPDIFF(
                    YEAR, 
                    estudiantes.fecha_nacimiento, 
                    IF(
                        inscripciones.fecha_inicio = '2000-01-01' OR inscripciones.fecha_inicio IS NULL, 
                        generaciones.fecha_inicio, 
                        inscripciones.fecha_inicio
                    )
                ) AS edad_calculada,
                -- Ajustar la edad si el cumpleaños aún no ha ocurrido en el año del curso
                IF(
                    DATE_FORMAT(
                        IF(
                            inscripciones.fecha_inicio = '2000-01-01' OR inscripciones.fecha_inicio IS NULL, 
                            generaciones.fecha_inicio, 
                            inscripciones.fecha_inicio
                        ), '%m-%d'
                    ) < DATE_FORMAT(estudiantes.fecha_nacimiento, '%m-%d'),
                    TIMESTAMPDIFF(YEAR, estudiantes.fecha_nacimiento, IF(
                        inscripciones.fecha_inicio = '2000-01-01' OR inscripciones.fecha_inicio IS NULL, 
                        generaciones.fecha_inicio, 
                        inscripciones.fecha_inicio
                    )) - 1,
                    TIMESTAMPDIFF(YEAR, estudiantes.fecha_nacimiento, IF(
                        inscripciones.fecha_inicio = '2000-01-01' OR inscripciones.fecha_inicio IS NULL, 
                        generaciones.fecha_inicio, 
                        inscripciones.fecha_inicio
                    ))
                ) AS edad,
                -- Calcular la edad real al momento de la consulta (fecha de consulta)
                TIMESTAMPDIFF(
                    YEAR, 
                    estudiantes.fecha_nacimiento, 
                    CURDATE() -- Esto es la fecha actual de la consulta
                ) AS edad_actual
            FROM 
                estudiantes
            INNER JOIN 
                inscripciones ON estudiantes.id = inscripciones.estudiante_id
            LEFT JOIN 
                generaciones ON inscripciones.generacion_id = generaciones.id
            WHERE
                -- Filtrar por el año en el que comenzó el curso
                YEAR(
                    IF(
                        inscripciones.fecha_inicio = '2000-01-01' OR inscripciones.fecha_inicio IS NULL, 
                        generaciones.fecha_inicio, 
                        inscripciones.fecha_inicio
                    )
                ) = $this->year_selected
        ) AS subquery
        GROUP BY 
            subquery.edad
        ORDER BY 
            subquery.edad
    ");
    
    
    
    
    
    
    

    
    
        
        
        $this->totalEdades = [];
        foreach ($this->estadistica_edades as $edad) {
            $this->totalEdades[$edad->edad] = $edad->total;
        }

        //dd($totalEdades);
        /*
        $municipios = Estudiante::with('municipio')
        ->selectRaw('municipio_id, COUNT(*) as total')
        ->groupBy('municipio_id')
        ->get()
        ->map(function ($estudiante) {
            return [
                'municipio' => $estudiante->municipio->nombre_municipio ?? 'Sin asignar',
                'total' => $estudiante->total,
            ];
        });
        */

        /*
        $municipios = Estudiante::with('municipio')
            ->join('inscripciones', 'inscripciones.estudiante_id', '=', 'estudiantes.id')  // Asegúrate de usar el nombre correcto de la columna
            ->join('generaciones', 'generaciones.id', '=', 'inscripciones.generacion_id')  // Ajusta esto si la relación es diferente
            ->whereRaw('YEAR(inscripciones.fecha_inicio) IN (?) OR YEAR(generaciones.fecha_inicio) IN (?)', [$this->year_selected, $this->year_selected])
            ->selectRaw('municipio_id, COUNT(*) as total')
            ->groupBy('municipio_id')
            ->get()
            ->map(function ($estudiante) {
                return [
                    'municipio' => $estudiante->municipio->nombre_municipio ?? 'Sin asignar',
                    'total' => $estudiante->total,
                ];
            });
        */

        $municipios = Estudiante::with('municipio')
            ->join('inscripciones', 'inscripciones.estudiante_id', '=', 'estudiantes.id')
            ->join('generaciones', 'generaciones.id', '=', 'inscripciones.generacion_id')
            ->whereRaw('YEAR(inscripciones.fecha_inicio) IN (?) OR YEAR(generaciones.fecha_inicio) IN (?)', [$this->year_selected, $this->year_selected])
            ->selectRaw('municipio_id, COUNT(DISTINCT estudiantes.id) as total') // Contar estudiantes únicos
            ->groupBy('municipio_id')
            ->get()
            ->map(function ($estudiante) {
                return [
                    'municipio' => $estudiante->municipio->nombre_municipio ?? 'Sin asignar',
                    'total' => $estudiante->total,
            ];
        });



        // Separar los datos en dos listas
        $this->labels_municipios = $municipios->pluck('municipio');
        $this->totals_municipios = $municipios->pluck('total');
        //dd($totals);         

          
    
    
        $this->dispatch('updateCharts',$this->totalGeneros,$this->totalEscolaridades,$this->filteredYears,$this->estadistica_total_estudiantes,$this->totalEdades,
        $this->labels_municipios,$this->totals_municipios);    
    }

    public function updatedYearSelected($value)
    {
        $this->resetForm();
        $this->year_selected = (int) $value; // Convertir a entero  

        //dd($this->year_selected);      
        //dd(gettype($this->year_selected));
       
        //dd($this->hombres);
        //$this->dispatch('updateCharts', $this->hombres, $this->mujeres, $this->niveles, $this->totales, $this->edades, $this->totales2);                        
        //$this->resetForm();
        //$this->updateStats();                
    }

    public function updateStats()
    {
        $this->year_selected =  (int)$this->year_selected; // Cambia esto según el año que quieras filtrar
/*        
        $x = DB::select("SELECT 
        estudiantes.nombre1,
        inscripciones.fecha_inicio,
        generaciones.fecha_inicio AS fechainicioofgeneraciones,
        COUNT(CASE WHEN estudiantes.genero = 'M' THEN 1 END) AS mujeres_count,
        COUNT(CASE WHEN estudiantes.genero = 'H' THEN 1 END) AS hombres_count
    FROM 
        estudiantes 
    INNER JOIN 
        inscripciones ON estudiantes.id = inscripciones.estudiante_id 
    INNER JOIN 
        generaciones ON inscripciones.generacion_id = generaciones.id
    WHERE   
        YEAR(inscripciones.fecha_inicio) IN ($anio)
        OR YEAR(generaciones.fecha_inicio) IN ($anio)
    GROUP BY 
        estudiantes.nombre1, inscripciones.fecha_inicio, generaciones.fecha_inicio
        ");

  


       $anio = 2024;
        

    $estadisticas = [
    'genero' => Inscripciones::with('estudiantes')
    ->join('estudiantes', 'inscripciones.estudiante_id', '=', 'estudiantes.id')
    // Hacemos un join con la tabla Generaciones
    ->leftJoin('generaciones', 'inscripciones.generacion_id', '=', 'generaciones.id')
    // Condición: Si generacion_id es diferente de 1, la fecha_inicio no debe ser null
    ->where(function($query) {
        $query->where('inscripciones.generacion_id', '=', 1)  // Si generacion_id es 1, no importa fecha_inicio
              ->orWhereNotNull('generaciones.fecha_inicio');  // Si generacion_id no es 1, la fecha_inicio debe ser no nula
    })
    ->where('inscripciones.grupo_id', $anio)
    ->selectRaw('estudiantes.genero, COUNT(*) as total')
    ->groupBy('estudiantes.genero')
    ->get(),


    'edades' => Inscripciones::with('estudiantes')
    ->whereYear('inscripciones.fecha_inicio', $anio)
    ->selectRaw('TIMESTAMPDIFF(YEAR, estudiantes.fecha_nacimiento, CURDATE()) as edad, COUNT(*) as total')
    ->join('estudiantes', 'inscripciones.estudiante_id', '=', 'estudiantes.id')
    // Hacemos el JOIN con la tabla Generaciones
    ->join('generaciones', 'inscripciones.generacion_id', '=', 'generaciones.id')
    // Filtramos solo donde generacion_id no es 1 o la fecha_inicio no sea null
    ->where(function($query) {
        $query->where('inscripciones.generacion_id', '=', 1)
              ->orWhereNotNull('generaciones.fecha_inicio');
    })
    ->groupBy('edad')
    ->get(),


    /*        
    'ciudades' => Inscripciones::with('estudiante.municipio')
        ->whereYear('inscripciones.fecha_inicio', $anio)
        ->selectRaw('municipios.nombre_municipio, COUNT(*) as total')
        ->join('estudiantes', 'inscripciones.estudiante_id', '=', 'estudiantes.id_estudiante')
        //->join('municipios', 'estudiantes.municipio_procedencia', '=', 'municipios.id')
        ->groupBy('municipios.id')
        ->get(),
    */
        

    /*     
    'escolaridad' => Inscripciones::with('estudiante.escolaridad')
        ->whereYear('inscripciones.fecha_inicio', $anio)
        ->selectRaw('escolaridad.nivel_escolaridad, COUNT(*) as total')
        ->join('estudiantes', 'inscripciones.estudiante_id', '=', 'estudiantes.id')
        ->join('escolaridad', 'estudiantes.escolaridad_id', '=', 'escolaridad.id')
        ->groupBy('escolaridad.id')
        ->get(),
    */
    
  
                  
    //dd($estadisticas);


        /*
        // Obtener estudiantes filtrados por año de inscripción
        $estudiantes = Estudiante::whereHas('inscripciones', function ($query) {
            $query->where(function($q) {
                // Si la generación es igual a 1, filtra por la fecha de inicio de la inscripción
                $q->whereYear('fecha_inicio', $this->year_selected)
                  ->whereHas('generaciones', function ($q2) {
                      $q2->where('id', 1);  // Verifica si la generacion_id es 1
                  })
                  // Si la generación no es 1, filtra por la fecha de inicio de la tabla generaciones
                  ->orWhere(function ($q2) {
                      $q2->whereHas('generaciones', function ($q3) {
                          $q3->where('id', '!=', 1)  // Si generacion_id es diferente de 1
                             ->whereYear('fecha_inicio', $this->year_selected);  // Filtra por fecha de la generación
                      });
                  });
            });
        })->get();
        
        
        //dd($estudiantes[0]->nombre1);

        // Contar hombres y mujeres
        $this->hombres = $estudiantes->where('genero', 'H')->count();
        $this->mujeres = $estudiantes->where('genero', 'M')->count();
        

        // Contar por niveles de escolaridad
        $conteoEscolaridad = $estudiantes->groupBy(function ($estudiante) {
            return $estudiante->escolaridad->nivel_escolaridad ?? 'Sin nivel'; // Agrupar por nivel escolar
        })->map(function ($grupo) {
            return $grupo->count();
        });

        $this->niveles = $conteoEscolaridad->keys()->toArray();
        $this->totales = $conteoEscolaridad->values()->toArray();

        // Contar edades
        $conteoPorEdad = $estudiantes->groupBy('edad')->map(function ($grupo) {
            return $grupo->count();
        });

        $this->edades = $conteoPorEdad->keys()->toArray();
        $this->totales2 = $conteoPorEdad->values()->toArray();
        */
    }

    public function resetForm()
    {        
        $this->reset(['hombres','mujeres','niveles','totales','edades','totales2','estadistica_genero','totalGeneros','estadistica_escolaridad','totalEscolaridades',
        'estadistica_total_estudiantes','filteredYears','estadistica_edades','estadistica_edades','totalEdades'
        ]);        
    }



    public function render()
    {
        return view('livewire.student-stats');
    }
}
