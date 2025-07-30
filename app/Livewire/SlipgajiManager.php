<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\SlipGaji;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SlipGajiManager extends Component
{
    use WithPagination;

    public $nama_karyawan, $posisi, $gaji_pokok, $tunjangan, $potongan, $no_wa;

    public function addSlip()
    {
        $total = ($this->gaji_pokok + $this->tunjangan) - $this->potongan;

        SlipGaji::create([
            'nama_karyawan' => $this->nama_karyawan,
            'posisi' => $this->posisi,
            'gaji_pokok' => $this->gaji_pokok,
            'tunjangan' => $this->tunjangan,
            'potongan' => $this->potongan,
            'total_gaji' => $total,
            'no_wa' => $this->no_wa,
        ]);

        $this->reset(['nama_karyawan', 'posisi', 'gaji_pokok', 'tunjangan', 'potongan', 'no_wa']);
    }

    public function sendWa($id)
    {
        $slip = SlipGaji::find($id);

        $text = "-----*GAJI*-----\n" .
            "*SETIANA BROILER*\n" .
            "SUPPLIER AYAM POTONG\n" .
            "HP/WA: 081225679511\n" .
            "Jl.Mayor Ahmadi pelangi No.1\n" .
            "Mojosongo Solo\n" .
            "Lapak Ps.Legi Solo lantai atas\n\n" .
            now()->translatedFormat('l, d-m-Y') . "\n" .
            strtoupper($slip->nama_karyawan) . "\n\n" .
            "GAJI POKOK: Rp " . number_format($slip->gaji_pokok) . "\n" .
            "TUNJANGAN: Rp " . number_format($slip->tunjangan) . "\n" .
            "POTONGAN: Rp " . number_format($slip->potongan) . "\n" .
            "TOTAL GAJI: Rp " . number_format($slip->total_gaji) . "\n\n" .
            "TERIMA KASIH, SEMOGA BAROKAH";

        // Kirim ke webhook WhatsApp via grup atau API eksternal (misal ke n8n)
        Http::post('https://webhook-url-anda', [
            'message' => $text,
            'to' => 'GROUP_ID_OR_NUMBER'
        ]);

        $slip->update(['status' => 'Terkirim']);
    }

    public function render()
    {
        return view('livewire.slipgaji-manager', [
            'slips' => SlipGaji::latest()->paginate(10)
        ]);
    }
}
