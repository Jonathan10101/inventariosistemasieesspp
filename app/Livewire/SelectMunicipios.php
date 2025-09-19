<?php

namespace App\Livewire;



use Livewire\Component;
use App\Models\Municipio;
use App\Models\Estado;


class SelectMunicipios extends Component
{
    public $estado_id; // Estado seleccionado
    public $municipios = []; // Lista de municipios
    public $municipio_id;
    public $valor;

    public $municipio_procedencia;


    public function mount($idMunicipio=0){
        if($idMunicipio!=0){            
            $municipio = Municipio::find($idMunicipio);
            $estadoid = $municipio->estado_id;
            $this->estado_id = $estadoid;
            $this->municipio_id = $idMunicipio;      
            $this->municipio_procedencia = $idMunicipio;
            
            $this->municipios = Municipio::where('estado_id', $this->estado_id)->get();
        }
    }


    public function cambiarMunicipio($valor)
    {        
        //$this->municipio_procedencia = $valor;
        // Disparar el evento solo cuando el municipio cambia
        $this->dispatch('municipio-seleccionado', ['municipioId' => $valor]);
    }


  
      // Este método se ejecuta cuando el valor de $estado_id cambia
      public function updatedEstadoId($value)
      {            
          // Actualizar la lista de municipios cuando el estado cambia
          $this->municipios = Municipio::where('estado_id', $value)->get();
          // Si el estado cambia, asegurarse de que el municipio_id se resetee a null
          $this->municipio_id = null; // Esto limpia el municipio seleccionado al cambiar el estado
      }
    

    public function render()
    {

        return view('livewire.select-municipios', [
            'estados' => Estado::all(),
            'municipios' => $this->estado_id ? Municipio::where('estado_id', $this->estado_id)->get() : [],            
        ]);
        

    }

 
}
