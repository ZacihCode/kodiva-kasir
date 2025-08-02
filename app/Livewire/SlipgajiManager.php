<?php

namespace App\Livewire;

use App\Models\SlipGaji;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

#[\Livewire\Attributes\Layout('layouts.app')]
class SlipGajiManager extends Component
{
    use WithPagination;

    public $nama_karyawan, $posisi, $gaji_pokok, $tunjangan, $potongan, $total_gaji, $status = 'Belum Terkirim', $no_wa;
    public $search = '';
    public $editMode = false, $slipIdBeingEdited;
    public $selectedSlip = [], $selectAll = false;
    public $confirmingDelete = false, $confirmingBulkDelete = false;
    public $showModal = false;
    public $slipIdToDelete;
    public $totalGaji = 0;
    public $slipTerkirim = 0;
    public $slipBelumTerkirim = 0;

    protected $rules = [
        'nama_karyawan' => 'required|string|max:255',
        'posisi' => 'required|string|max:255',
        'gaji_pokok' => 'required|integer',
        'tunjangan' => 'required|integer',
        'potongan' => 'required|integer',
        'total_gaji' => 'required|integer',
        'no_wa' => 'required|string|max:20',
        'status' => 'nullable|string',
    ];

    public function resetForm()
    {
        $this->reset(['nama_karyawan', 'posisi', 'gaji_pokok', 'tunjangan', 'potongan', 'total_gaji', 'no_wa', 'status']);
        $this->resetValidation();
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->editMode) {
            SlipGaji::find($this->slipIdBeingEdited)->update(
                $this->only(['nama_karyawan', 'posisi', 'gaji_pokok', 'tunjangan', 'potongan', 'total_gaji', 'no_wa', 'status'])
            );
        } else {
            SlipGaji::create(
                $this->only(['nama_karyawan', 'posisi', 'gaji_pokok', 'tunjangan', 'potongan', 'total_gaji', 'no_wa', 'status'])
            );
        }

        $this->resetForm();
        $this->showModal = false;
    }

    public function edit($id)
    {
        $slips = SlipGaji::findOrFail($id);
        $this->fill($slips->toArray());
        $this->editMode = true;
        $this->slipIdBeingEdited = $id;
        $this->showModal = true;
    }

    public function deleteSlip($id)
    {
        SlipGaji::findOrFail($id)->delete();
    }

    public function confirmDelete($id)
    {
        $this->confirmingDelete = true;
        $this->slipIdToDelete = $id;
    }

    public function deleteSlipConfirmed()
    {
        SlipGaji::findOrFail($this->slipIdToDelete)->delete();
        $this->confirmingDelete = false;
        $this->selectedSlip = array_diff($this->selectedSlip, [$this->slipIdToDelete]);
        $this->slipIdToDelete = null;
    }

    public function deleteSelected()
    {
        SlipGaji::whereIn('id', $this->selectedSlip)->delete();
        $this->selectedSlip = [];
        $this->selectAll = false;
    }

    public function confirmBulkDelete()
    {
        $this->confirmingBulkDelete = true;
    }

    public function deleteSelectedConfirmed()
    {
        SlipGaji::whereIn('id', $this->selectedSlip)->delete();
        $this->selectedSlip = [];
        $this->confirmingBulkDelete = false;
        $this->selectAll = false;
    }

    public function toggleSelectAll()
    {
        if ($this->selectAll) {
            $this->selectedSlip = SlipGaji::where('nama_karyawan', 'like', '%' . $this->search . '%')->pluck('id')->toArray();
        } else {
            $this->selectedSlip = [];
        }
    }

    public function render()
    {
        $slipGajis = SlipGaji::where('nama_karyawan', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.slipgaji-manager', [
            'slipGajis' => $slipGajis,
            'karyawanList' => User::where('role', 'user')->get(),
        ]);
    }

    public function mount()
    {
        $this->totalGaji = SlipGaji::sum('total_gaji');
        $this->slipTerkirim = SlipGaji::where('status', 'terkirim')->count();
        $this->slipBelumTerkirim = SlipGaji::where('status', 'belum terkirim')->count();
    }
}
