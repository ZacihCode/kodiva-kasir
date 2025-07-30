<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Diskon;
use Livewire\WithPagination;

#[\Livewire\Attributes\Layout('layouts.app')]
class DiskonManager extends Component
{
    public $diskon_id, $jenis_diskon, $deskripsi, $persentase;
    public $editMode = false, $diskonIdBeingEdited;
    public $search = '';
    public $diskonList = [];
    public $selectedDiskon = [];
    public $selectAll = false;
    public $confirmingDelete = false;
    public $serviceIdToDelete;
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
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->editMode) {
            Diskon::find($this->diskonIdBeingEdited)->update(
                $this->only(['jenis_diskon', 'deskripsi', 'persentase'])
            );
        } else {
            Diskon::create($this->only(['jenis_diskon', 'deskripsi', 'persentase']));
        }

        $this->resetForm();
        $this->showModal = false;
    }

    public function edit($diskon_id)
    {
        $diskon = Diskon::where('id', $diskon_id)->firstOrFail();
        $this->fill($diskon->toArray());
        $this->editMode = true;
        $this->diskonIdBeingEdited = $diskon_id;
        $this->showModal = true;
    }

    public function deleteDiskon($diskon_id)
    {
        Diskon::findOrFail($diskon_id)->delete();
    }

    public function render()
    {
        $diskons = Diskon::where('jenis_diskon', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'asc')
            ->paginate(10);

        return view('livewire.diskon-manager', compact('diskons'));
    }

    public function deleteSelected()
    {
        Diskon::whereIn('id', $this->selectedDiskon)->delete();
        $this->selectedDiskon = [];
        $this->selectAll = false;
    }

    public function toggleSelectAll()
    {
        if ($this->selectAll) {
            $this->selectedDiskon = Diskon::where('jenis_diskon', 'like', '%' . $this->search . '%')
                ->pluck('id')
                ->toArray();
        } else {
            $this->selectedDiskon = [];
        }
    }

    public function confirmDelete($id)
    {
        $this->confirmingDelete = true;
        $this->serviceIdToDelete = $id;
    }

    public function deleteDiskonConfirmed()
    {
        Diskon::findOrFail($this->serviceIdToDelete)->delete();
        $this->confirmingDelete = false;
        $this->selectedDiskon = array_diff($this->selectedDiskon, [$this->serviceIdToDelete]);
        $this->serviceIdToDelete = null;
    }

    public function confirmBulkDelete()
    {
        $this->confirmingBulkDelete = true;
    }

    public function deleteSelectedConfirmed()
    {
        Diskon::whereIn('id', $this->selectedDiskon)->delete();
        $this->selectedDiskon = [];
        $this->selectAll = false;
        $this->confirmingBulkDelete = false;
    }
}
