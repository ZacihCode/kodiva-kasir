<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Diskon;
use Livewire\WithPagination;

#[\Livewire\Attributes\Layout('layouts.app')]
class DiskonManager extends Component
{
    public $jenis_diskon, $deskripsi, $persentase;
    public $editMode = false, $diskonIdBeingEdited;
    public $search = '';
    public $selectedDiskon = [];
    public $selectAll = false;
    public $confirmingDelete = false;
    public $confirmingBulkDelete = false;
    public $showModal = false;

    use WithPagination;

    protected $rules = [
        'jenis_diskon' => 'required|string|max:255',
        'deskripsi' => 'nullable|string',
        'persentase' => 'required|integer|min:0|max:100',
    ];

    public function resetForm()
    {
        $this->reset(['jenis_diskon', 'deskripsi', 'persentase']);
        $this->resetValidation();
        $this->editMode = false;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->editMode) {
            Diskon::find($this->diskonIdBeingEdited)->update($this->only(['jenis_diskon', 'deskripsi', 'persentase']));
        } else {
            Diskon::create($this->only(['jenis_diskon', 'deskripsi', 'persentase']));
        }

        $this->resetForm();
        $this->showModal = false;
    }

    public function edit($id)
    {
        $diskon = Diskon::findOrFail($id);
        $this->fill($diskon->toArray());
        $this->editMode = true;
        $this->diskonIdBeingEdited = $id;
        $this->showModal = true;
    }

    public function confirmDelete($id)
    {
        $this->confirmingDelete = true;
        $this->diskonIdBeingEdited = $id;
    }

    public function deleteConfirmed()
    {
        Diskon::findOrFail($this->diskonIdBeingEdited)->delete();
        $this->confirmingDelete = false;
        $this->diskonIdBeingEdited = null;
    }

    public function render()
    {
        $diskons = Diskon::where('jenis_diskon', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.diskon-manager', compact('diskons'));
    }
}
