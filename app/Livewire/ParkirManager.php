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
    public $showModal = false;

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
            Parkir::find($this->parkirIdBeingEdited)->update($this->only(['jenis_parkir', 'deskripsi', 'harga']));
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
        $this->parkirIdBeingEdited = $id;
    }

    public function deleteConfirmed()
    {
        Parkir::findOrFail($this->parkirIdBeingEdited)->delete();
        $this->confirmingDelete = false;
        $this->parkirIdBeingEdited = null;
    }

    public function render()
    {
        $parkirs = Parkir::where('jenis_parkir', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.parkir-manager', compact('parkirs'));
    }
}
