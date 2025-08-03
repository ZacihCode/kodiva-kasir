<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Parkir;
use Livewire\WithPagination;

#[\Livewire\Attributes\Layout('layouts.app')]
class ParkirManager extends Component
{
    public $jenis_parkir, $deskripsi, $harga;
    public $editMode = false, $parkirIdBeingEdited;
    public $search = '';
    public $selectedParkir = [];
    public $selectAll = false;
    public $confirmingDelete = false;
    public $confirmingBulkDelete = false;
    public $serviceIdToDelete;
    public $showModal = false;
    public $pendapatanHariIni, $totalPendapatan;

    use WithPagination;

    protected $rules = [
        'jenis_parkir' => 'required|string|max:255',
        'deskripsi' => 'nullable|string',
        'harga' => 'required|integer|min:0',
    ];

    public function resetForm()
    {
        $this->reset(['jenis_parkir', 'deskripsi', 'harga']);
        $this->resetValidation();
        $this->editMode = false;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->editMode) {
            Parkir::find($this->parkirIdBeingEdited)->update(
                $this->only(['jenis_parkir', 'deskripsi', 'harga'])
            );
        } else {
            Parkir::create($this->only(['jenis_parkir', 'deskripsi', 'harga']));
        }

        $this->resetForm();
        $this->showModal = false;
    }

    public function edit($id)
    {
        $parkir = Parkir::findOrFail($id);
        $this->fill($parkir->toArray());
        $this->editMode = true;
        $this->parkirIdBeingEdited = $id;
        $this->showModal = true;
    }

    public function confirmDelete($id)
    {
        $this->confirmingDelete = true;
        $this->serviceIdToDelete = $id;
    }

    public function deleteParkirConfirmed()
    {
        Parkir::findOrFail($this->serviceIdToDelete)->delete();
        $this->confirmingDelete = false;
        $this->selectedParkir = array_diff($this->selectedParkir, [$this->serviceIdToDelete]);
        $this->serviceIdToDelete = null;
    }

    public function confirmBulkDelete()
    {
        $this->confirmingBulkDelete = true;
    }

    public function deleteSelectedConfirmed()
    {
        Parkir::whereIn('id', $this->selectedParkir)->delete();
        $this->selectedParkir = [];
        $this->selectAll = false;
        $this->confirmingBulkDelete = false;
    }

    public function toggleSelectAll()
    {
        if ($this->selectAll) {
            $this->selectedParkir = Parkir::where('jenis_parkir', 'like', '%' . $this->search . '%')
                ->pluck('id')
                ->toArray();
        } else {
            $this->selectedParkir = [];
        }
    }

    public function render()
    {
        $parkirs = Parkir::where('jenis_parkir', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.parkir-manager', compact('parkirs'));
    }

    public function hitungPendapatan()
    {
        $this->pendapatanHariIni = Parkir::whereDate('created_at', today())->sum('harga');
        $this->totalPendapatan = Parkir::sum('harga');
    }
}
