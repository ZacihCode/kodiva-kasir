<?php

namespace App\Livewire;

use App\Models\Transaksi;
use Livewire\Component;
use Livewire\WithPagination;

#[\Livewire\Attributes\Layout('layouts.app')]
class TransaksiManager extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $showDetail = false;
    public $selectedTransaksi;

    public function viewDetail($id)
    {
        $this->selectedTransaksi = Transaksi::find($id);
        $this->showDetail = true;
    }

    public function closeDetail()
    {
        $this->showDetail = false;
        $this->selectedTransaksi = null;
    }

    public function render()
    {
        $transaksis = Transaksi::latest()
            ->where('metode_pembayaran', 'like', '%' . $this->search . '%')
            ->paginate($this->perPage);

        return view('livewire.transaksi-manager', compact('transaksis'));
    }
}
