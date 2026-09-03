<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Resguardo;
use Livewire\WithPagination;
use App\Models\HistorialResguardo; // asegúrate de importar el modelo correcto
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;



class ShowResguardosModal extends Component
{   
    use WithPagination;
    use WithFileUploads;

    public $resguardo_id;
    public $perPage = 1;
    public Resguardo $resguardo;

    public $pdfNuevo; // archivo temporal Livewire

    // Para que la paginación funcione dentro de un modal, se recomienda usar un theme tipo bootstrap o tailwind
    protected $paginationTheme = 'bootstrap';

    protected function rules()
    {
        return [
            'pdfNuevo' => 'required|file|mimes:pdf|max:10240', // 10MB
        ];
    }

    public function mount($data)
    {
        $this->resguardo_id = $data;
        $this->resetPage(); // Carga página 1 automáticamente
    }

    public function reemplazarPdf()
    {
        $this->validate();

        // 1) Borra el PDF anterior si existe
        if ($this->resguardo->pdf_path && Storage::disk('public')->exists($this->resguardo->pdf_path)) {
            Storage::disk('public')->delete($this->resguardo->pdf_path);
        }

        // 2) Guarda el nuevo PDF
        $ruta = $this->pdfNuevo->store('resguardos', 'public'); // storage/app/public/resguardos

        // 3) Actualiza BD
        $this->resguardo->update([
            'pdf_path' => $ruta,
        ]);

        // 4) Limpia input file
        $this->reset('pdfNuevo');

        session()->flash('success', 'PDF reemplazado correctamente.');
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
