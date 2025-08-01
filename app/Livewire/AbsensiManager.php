<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Absensi;
use App\Models\User;
use Livewire\WithPagination;

#[\Livewire\Attributes\Layout('layouts.app')]
class AbsensiManager extends Component
{
    use WithPagination;

    public $absensi_id, $user_id, $tanggal, $status, $keterangan;
    public $editMode = false, $absensiIdBeingEdited;
    public $search = '';
    public $selectedAbsensi = [];
    public $selectAll = false;
    public $confirmingDelete = false;
    public $absensiIdToDelete;
    public $confirmingBulkDelete = false;
    public $showModal = false;
    public $totalKaryawan = 0;
    public $hadirHariIni = 0;
    public $tidakHadirHariIni = 0;

    protected $rules = [
        'user_id' => 'required|exists:users,id',
        'tanggal' => 'required|date',
        'status' => 'required|in:hadir,tidak hadir',
        'keterangan' => 'nullable|string',
    ];

    public function resetForm()
    {
        $this->reset(['user_id', 'tanggal', 'status', 'keterangan']);
        $this->resetValidation();
        $this->showModal = true;
        $this->editMode = false;
    }

    public function save()
    {
        $this->validate();

        if ($this->editMode) {
            Absensi::findOrFail($this->absensiIdBeingEdited)->update(
                $this->only(['user_id', 'tanggal', 'status', 'keterangan'])
            );
        } else {
            Absensi::create($this->only(['user_id', 'tanggal', 'status', 'keterangan']));
        }

        $this->resetForm();
        $this->showModal = false;
    }

    public function edit($absensi_id)
    {
        $absensi = Absensi::findOrFail($absensi_id);
        $this->fill($absensi->toArray());
        $this->editMode = true;
        $this->absensiIdBeingEdited = $absensi_id;
        $this->showModal = true;
    }

    public function deleteAbsensi($absensi_id)
    {
        Absensi::findOrFail($absensi_id)->delete();
    }

    public function deleteSelected()
    {
        Absensi::whereIn('id', $this->selectedAbsensi)->delete();
        $this->selectedAbsensi = [];
        $this->selectAll = false;
    }

    public function toggleSelectAll()
    {
        if ($this->selectAll) {
            $this->selectedAbsensi = Absensi::whereHas('user', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })->pluck('id')->toArray();
        } else {
            $this->selectedAbsensi = [];
        }
    }

    public function confirmDelete($id)
    {
        $this->confirmingDelete = true;
        $this->absensiIdToDelete = $id;
    }

    public function deleteConfirmed()
    {
        Absensi::findOrFail($this->absensiIdToDelete)->delete();
        $this->confirmingDelete = false;
        $this->selectedAbsensi = array_diff($this->selectedAbsensi, [$this->absensiIdToDelete]);
        $this->absensiIdToDelete = null;
    }

    public function confirmBulkDelete()
    {
        $this->confirmingBulkDelete = true;
    }

    public function deleteSelectedConfirmed()
    {
        Absensi::whereIn('id', $this->selectedAbsensi)->delete();
        $this->selectedAbsensi = [];
        $this->selectAll = false;
        $this->confirmingBulkDelete = false;
    }

    public function render()
    {
        $absensis = Absensi::with('user')
            ->whereHas('user', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        $users = User::all();

        return view('livewire.absensi-manager', compact('absensis', 'users'));
    }

    public function mount()
    {
        $this->totalKaryawan = User::where('role', 'user')->count();

        $today = now()->toDateString();

        $this->hadirHariIni = Absensi::whereDate('tanggal', $today)
            ->where('status', 'hadir')
            ->count();

        $this->tidakHadirHariIni = Absensi::whereDate('tanggal', $today)
            ->where('status', 'tidak hadir')
            ->count();
    }
}
