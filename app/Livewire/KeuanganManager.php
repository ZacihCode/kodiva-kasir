<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Keuangan;
use Livewire\WithPagination;

#[\Livewire\Attributes\Layout('layouts.app')]
class KeuanganManager extends Component
{
    use WithPagination;

    public $keuangan_id, $jenis_keuangan, $kategori, $jumlah, $keterangan;
    public $editMode = false, $keuanganIdBeingEdited;
    public $search = '';
    public $selectedKeuangan = [];
    public $selectAll = false;
    public $confirmingDelete = false;
    public $keuanganIdToDelete;
    public $confirmingBulkDelete = false;
    public $showModal = false;
    public $totalKeuangan = 0;
    public $totalPemasukan = 0;
    public $totalPengeluaran = 0;
    public $labaBersih = 0;

    protected $rules = [
        'jenis_keuangan' => 'required|in:pemasukan,pengeluaran',
        'kategori' => 'required|string|max:255',
        'jumlah' => 'required|numeric|min:0',
        'keterangan' => 'nullable|string',
    ];

    public function resetForm()
    {
        $this->reset(['jenis_keuangan', 'kategori', 'jumlah', 'keterangan', 'editMode', 'keuanganIdBeingEdited']);
        $this->resetValidation();
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->editMode) {
            Keuangan::find($this->keuanganIdBeingEdited)->update(
                $this->only(['jenis_keuangan', 'kategori', 'jumlah', 'keterangan'])
            );
        } else {
            Keuangan::create($this->only(['jenis_keuangan', 'kategori', 'jumlah', 'keterangan']));
        }

        $this->resetForm();
        $this->showModal = false;
    }

    public function edit($id)
    {
        $keuangan = Keuangan::findOrFail($id);
        $this->fill($keuangan->toArray());
        $this->editMode = true;
        $this->keuanganIdBeingEdited = $id;
        $this->showModal = true;
    }

    public function confirmDelete($id)
    {
        $this->confirmingDelete = true;
        $this->keuanganIdToDelete = $id;
    }

    public function deleteKeuanganConfirmed()
    {
        Keuangan::findOrFail($this->keuanganIdToDelete)->delete();
        $this->confirmingDelete = false;
        $this->selectedKeuangan = array_diff($this->selectedKeuangan, [$this->keuanganIdToDelete]);
        $this->keuanganIdToDelete = null;
    }

    public function deleteSelected()
    {
        Keuangan::whereIn('id', $this->selectedKeuangan)->delete();
        $this->selectedKeuangan = [];
        $this->selectAll = false;
    }

    public function confirmBulkDelete()
    {
        $this->confirmingBulkDelete = true;
    }

    public function deleteSelectedConfirmed()
    {
        Keuangan::whereIn('id', $this->selectedKeuangan)->delete();
        $this->selectedKeuangan = [];
        $this->selectAll = false;
        $this->confirmingBulkDelete = false;
    }

    public function toggleSelectAll()
    {
        if ($this->selectAll) {
            $this->selectedKeuangan = Keuangan::where('kategori', 'like', '%' . $this->search . '%')
                ->pluck('id')
                ->toArray();
        } else {
            $this->selectedKeuangan = [];
        }
    }

    public function render()
    {
        $keuangans = Keuangan::where('kategori', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.keuangan-manager', compact('keuangans'));
    }

    public function mount()
    {
        $this->totalKeuangan = Keuangan::sum('jumlah');
        $this->labaBersih = $this->totalKeuangan - ($this->totalPemasukan - $this->totalPengeluaran);
        $this->totalPemasukan = Keuangan::where('jenis_keuangan', 'pemasukan')->sum('jumlah');
        $this->totalPengeluaran = Keuangan::where('jenis_keuangan', 'pengeluaran')->sum('jumlah');
    }
}
