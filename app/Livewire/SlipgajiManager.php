<?php

namespace App\Livewire;

use App\Models\SlipGaji;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

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
        $this->status = $this->status ? ucwords(strtolower($this->status)) : 'Belum Terkirim';
        $this->total_gaji = (int)$this->gaji_pokok + (int)$this->tunjangan - (int)$this->potongan;

        $payload = $this->only([
            'nama_karyawan',
            'posisi',
            'gaji_pokok',
            'tunjangan',
            'potongan',
            'total_gaji',
            'no_wa',
            'status'
        ]);

        if ($this->editMode) {
            SlipGaji::findOrFail($this->slipIdBeingEdited)->update($payload);
        } else {
            SlipGaji::create($payload);
        }

        $this->resetForm();
        $this->status = 'Belum Terkirim';
        $this->showModal = false;
        $this->dispatch('toast', type: 'success', message: $this->editMode ? 'Slip gaji diperbarui.' : 'Slip gaji dibuat.');
    }

    public function edit($id)
    {
        $slips = SlipGaji::findOrFail($id);
        $this->fill($slips->toArray());
        $this->status = $this->status ? ucwords(strtolower($this->status)) : 'Belum Terkirim';
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
        $this->slipTerkirim = SlipGaji::whereRaw('LOWER(status) = ?', ['terkirim'])->count();
        $this->slipBelumTerkirim = SlipGaji::whereRaw('LOWER(status) = ?', ['belum terkirim'])->count();
    }

    // Normalisasi nomor ke format internasional (62…)
    protected function normalizePhone(?string $raw): string
    {
        $p = preg_replace('/\D+/', '', (string) $raw); // buang non-digit
        if ($p === '') return $p;
        // 0xxxxxxxx -> 62xxxxxxxx
        if (Str::startsWith($p, '0')) {
            return '62' . substr($p, 1);
        }
        // 6208xxxx -> 628xxxx
        if (Str::startsWith($p, '620')) {
            return '62' . substr($p, 2);
        }
        return $p;
    }

    // Susun pesan slip gaji
    protected function buildSlipMessage(SlipGaji $slip): string
    {
        $rp  = fn($n) => 'Rp ' . number_format((int)$n, 0, ',', '.');
        $pad = fn($label, $val, $w = 12) => str_pad($label, $w) . ': ' . $val;

        $tanggal = optional($slip->created_at)->format('d M Y H:i');

        // Bagian “tabel” dalam code block supaya monospace & rapi
        $blockLines = [
            $pad('Nama',       $slip->nama_karyawan),
            $pad('Posisi',     $slip->posisi),
            $pad('Tanggal',    $tanggal),
            '',
            $pad('Gaji Pokok', $rp($slip->gaji_pokok)),
            $pad('Tunjangan',  $rp($slip->tunjangan)),
            $pad('Potongan',   $rp($slip->potongan)),
        ];
        $block = "```\n" . implode("\n", $blockLines) . "\n```";

        return
            "*Slip Gaji Karyawan*\n" .
            $block . "\n" .
            "*Total*: *" . $rp($slip->total_gaji) . "*\n\n" .
            "Terima kasih atas kerja kerasnya 🙏\n" .
            "(Wisata Sendang Plesungan)";
    }

    // Recalc ringkasan kartu
    protected function recalcSummary(): void
    {
        $this->totalGaji = SlipGaji::sum('total_gaji');
        $this->slipTerkirim = SlipGaji::whereRaw('LOWER(status) = ?', ['terkirim'])->count();
        $this->slipBelumTerkirim = SlipGaji::whereRaw('LOWER(status) = ?', ['belum terkirim'])->count();
    }

    // Aksi: kirim slip via Fonnte
    public function sendSlip($id)
    {
        $slip = SlipGaji::findOrFail($id);

        if (strtolower((string) $slip->status) === 'terkirim') {
            session()->flash('error', 'Slip sudah terkirim, tidak bisa dikirim lagi.');
            return;
        }

        $token = config('services.fonnte.token');
        if (!$token) {
            $this->dispatch('toast', type: 'error', message: 'Fonnte token belum diset pada .env (FONNTE_TOKEN).');
            return;
        }

        $endpoint = config('services.fonnte.endpoint', 'https://api.fonnte.com/send');
        $target   = $this->normalizePhone($slip->no_wa);
        if (!$target) {
            $this->dispatch('toast', type: 'error', message: 'Nomor WhatsApp karyawan belum diisi/format tidak valid.');
            return;
        }

        $payload = [
            'target'      => $target,
            'message'     => $this->buildSlipMessage($slip),
            'countryCode' => config('services.fonnte.default_country', '62'), // opsional
        ];

        try {
            $res = Http::asForm()
                ->withHeaders(['Authorization' => $token])
                ->post($endpoint, $payload);

            // Fonnte mengembalikan JSON; jika 200 kita anggap sukses kirim
            if ($res->successful()) {
                // set status terkirim (standarkan kapitalisasi)
                $slip->status = 'Terkirim';
                $slip->save();
                $this->recalcSummary();
                $this->dispatch('toast', type: 'success', message: 'Slip gaji berhasil dikirim ke WhatsApp.');
            } else {
                $this->dispatch('toast', type: 'error', message: 'Gagal kirim slip: ' . $res->body());
            }
        } catch (\Throwable $e) {
            $this->dispatch('toast', type: 'error', message: 'Gagal terhubung ke Fonnte: ' . $e->getMessage());
        }
    }
}
