<?php

namespace App\Livewire;

use App\Models\Transaksi;
use App\Models\Diskon;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

#[\Livewire\Attributes\Layout('layouts.app')]
class BroadcastManager extends Component
{
    use WithPagination;

    public $search = '';
    public $selected = [];    // berisi customer_phone
    public $selectAllPage = false;

    public $message = "Halo {nama}, ada promo terbaru dari Wisata Sendang Plesungan";
    public $progress = 0;
    public $sending = false;
    public $diskonId = null;

    // Jika kolom pencarian berubah, reset ke halaman 1
    public function updatingSearch()
    {
        $this->resetPage();
    }

    protected function normalizePhone(?string $raw): string
    {
        $p = preg_replace('/\D+/', '', (string) $raw);
        if ($p === '') return $p;
        if (Str::startsWith($p, '0'))   return '62' . substr($p, 1);
        if (Str::startsWith($p, '620')) return '62' . substr($p, 2);
        return $p;
    }

    protected function personalize(string $msg, ?string $name): string
    {
        $fallback = $name ?: 'Pelanggan';
        return str_replace(['{nama}', '{name}'], $fallback, $msg);
    }

    protected function fonnteToken(): ?string
    {
        return config('services.fonnte.token_device')
            ?? config('services.fonnte.token')
            ?? env('FONNTE_DEVICE_TOKEN')
            ?? env('FONNTE_TOKEN');
    }

    protected function contactsBaseFiltered()
    {
        return Transaksi::query()
            ->whereNotNull('customer_phone')
            ->where('customer_phone', '<>', '')
            ->when($this->search, function ($q) {
                $s = trim($this->search);
                $q->where(function ($qq) use ($s) {
                    $qq->where('customer_name', 'like', "%{$s}%")
                        ->orWhere('customer_phone', 'like', "%{$s}%");
                });
            });
    }

    protected function contactsQuery()
    {
        $base = $this->contactsBaseFiltered()
            ->select([
                'customer_phone',
                'customer_name',
                DB::raw('COUNT(*) as transaksi_count'),
                DB::raw('MAX(created_at) as last_trx'),
            ])
            ->groupBy('customer_phone', 'customer_name');

        // orderBy alias di luar subquery -> aman untuk paginate()
        return DB::query()->fromSub($base, 'c')->orderByDesc('last_trx');
    }

    public function toggleSelectAllPage()
    {
        $this->selectAllPage = !$this->selectAllPage;

        // Ambil item di HALAMAN AKTIF tanpa getPageName()/getPage()
        $pageRows = $this->contactsQuery()
            ->paginate(10)
            ->items();

        $phonesOnPage = array_map(fn($r) => $r->customer_phone, $pageRows);

        if ($this->selectAllPage) {
            $this->selected = array_values(array_unique(array_merge($this->selected, $phonesOnPage)));
        } else {
            $this->selected = array_values(array_diff($this->selected, $phonesOnPage));
        }
    }

    public function clearSelection()
    {
        $this->selected = [];
        $this->selectAllPage = false;
    }

    public function sendSelected()
    {
        $this->validate([
            'message' => 'required|string|min:3',
        ], [
            'message.required' => 'Pesan tidak boleh kosong.',
        ]);

        $numbers = array_values(array_filter(array_unique($this->selected)));
        if (count($numbers) === 0) {
            $this->addError('selected', 'Pilih minimal 1 kontak.');
            return;
        }

        $diskonText = '';
        if ($this->diskonId) {
            $diskon = Diskon::find($this->diskonId);
            if ($diskon) {
                $diskonText = "\n\nKODE DISKON: *{$diskon->jenis_diskon}* 
                \nPERSENTASE: *{$diskon->persentase}%*
                \n{$diskon->deskripsi}";
            }
        }

        $token = $this->fonnteToken();
        if (!$token) {
            $this->dispatch('toast', type: 'error', message: 'FONNTE_DEVICE_TOKEN belum di-set di .env / config.');
            return;
        }

        $endpoint = config('services.fonnte.endpoint', 'https://api.fonnte.com/send');
        $this->sending = true;
        $this->progress = 0;
        $total = count($numbers);
        $sent  = 0;
        $fail  = 0;

        foreach ($numbers as $i => $phone) {
            $last = Transaksi::where('customer_phone', $phone)->orderByDesc('created_at')->first();
            $name = $last->customer_name ?? 'Pelanggan';

            $target = $this->normalizePhone($phone);
            if (!$target) {
                $fail++;
                continue;
            }

            $msg = $this->personalize($this->message, $name) . $diskonText;

            try {
                $res = Http::asForm()
                    ->withHeaders(['Authorization' => $token])
                    ->post($endpoint, [
                        'target'      => $target,
                        'message'     => $msg,
                        'countryCode' => config('services.fonnte.default_country', '62'),
                    ]);

                if ($res->successful()) $sent++;
                else $fail++;
            } catch (\Throwable $e) {
                $fail++;
            }

            $this->progress = intval((($i + 1) / $total) * 100);
        }

        $this->sending = false;
        $this->dispatch('toast', type: 'success', message: "Broadcast Berhasil: {$sent}, Gagal: {$fail}.");
    }

    public function render()
    {
        $contacts = $this->contactsQuery()->paginate(10);

        $totalContacts = $this->contactsBaseFiltered()
            ->distinct('customer_phone')
            ->count('customer_phone');

        return view('livewire.broadcast-manager', [
            'contacts'      => $contacts,
            'totalContacts' => $totalContacts,
            'selectedCount' => count($this->selected),
            'diskons'       => Diskon::all(),
        ]);
    }
}
