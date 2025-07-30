<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Produk;
use Livewire\WithPagination;

#[\Livewire\Attributes\Layout('layouts.app')]
class ProdukManager extends Component
{
    public $produk_id, $nama_produk, $kategori, $deskripsi, $harga;
    public $editMode = false, $produkIdBeingEdited;
    public $search = '';
    public $produkList = [];
    public $selectedProduk = [];
    public $selectAll = false;
    public $confirmingDelete = false;
    public $serviceIdToDelete;
    public $confirmingBulkDelete = false;
    public $showModal = false;
    use WithPagination;

    protected $rules = [
        'nama_produk' => 'required|string|max:255',
        'kategori' => 'required|string|max:255',
        'deskripsi' => 'nullable|string',
        'harga' => 'required|integer|min:0',
    ];

    public function resetForm()
    {
        $this->reset(['nama_produk', 'kategori', 'deskripsi', 'harga']);
        $this->resetValidation();
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();
        if ($this->editMode) {
            Produk::find($this->produkIdBeingEdited)->update($this->only([
                'nama_produk',
                'kategori',
                'deskripsi',
                'harga'
            ]));
        } else {
            Produk::create($this->only([
                'nama_produk',
                'kategori',
                'deskripsi',
                'harga'
            ]));
        }
        $this->resetForm();
        $this->showModal = false;
    }

    public function edit($produk_id)
    {
        $produk = Produk::where('id', $produk_id)->firstOrFail();
        $this->fill($produk->toArray());
        $this->editMode = true;
        $this->produkIdBeingEdited = $produk_id;
        $this->showModal = true;
    }

    public function deleteVoucher($produk_id)
    {
        Produk::findOrFail($produk_id)->delete();
    }

    public function render()
    {
        $produks = Produk::where('nama_produk', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'asc')
            ->paginate(10);

        return view('livewire.produk-manager', compact('produks'));
    }

    public function deleteSelected()
    {
        Produk::whereIn('id', $this->selectedProduk)
            ->delete();
        $this->selectedProduk = [];
        $this->selectAll = false;
    }

    public function toggleSelectAll()
    {
        if ($this->selectAll) {
            $this->selectedProduk = Produk::where('nama_produk', 'like', '%' . $this->search . '%')
                ->pluck('id')
                ->toArray();
        } else {
            $this->selectedProduk = [];
        }
    }

    public function confirmDelete($id)
    {
        $this->confirmingDelete = true;
        $this->serviceIdToDelete = $id;
    }

    public function deleteVoucherConfirmed()
    {
        Produk::findOrFail($this->serviceIdToDelete)->delete();
        $this->confirmingDelete = false;
        $this->serviceIdToDelete = null;
        $this->selectedProduk = array_diff($this->selectedProduk, [$this->serviceIdToDelete]);
    }

    public function confirmBulkDelete()
    {
        $this->confirmingBulkDelete = true;
    }

    public function deleteSelectedConfirmed()
    {
        Produk::whereIn('id', $this->selectedProduk)->delete();
        $this->selectedProduk = [];
        $this->selectAll = false;
        $this->confirmingBulkDelete = false;
    }
}
