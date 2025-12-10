<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Resguardo;
use Livewire\WithPagination;
use App\Models\HistorialResguardo; // asegúrate de importar el modelo correcto


class ShowResguardosModal extends Component
{   
    use WithPagination;
    public $resguardo_id;
    public $perPage = 1;

    // Para que la paginación funcione dentro de un modal, se recomienda usar un theme tipo bootstrap o tailwind
    protected $paginationTheme = 'bootstrap';

    public function mount($data)
    {
        $this->resguardo_id = $data;
        $this->resetPage(); // Carga página 1 automáticamente
    }

    public function render()
    {
        $historiales = HistorialResguardo::where('resguardo_id', $this->resguardo_id)
            ->orderBy('fecha_asignacion', 'desc')
            ->paginate($this->perPage); // 👈 número de registros por página

        return view('livewire.show-resguardos-modal', [
            'historiales' => $historiales
        ]);
    }
}
