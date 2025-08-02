<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\GajiSetting;

#[\Livewire\Attributes\Layout('layouts.app')]
class GajiSettingManager extends Component
{
    public $gaji_per_hadir, $tunjangan_default, $potongan_default;
    public $editable = false;

    public function mount()
    {
        $setting = GajiSetting::first();
        if ($setting) {
            $this->fill($setting->toArray());
        }
    }

    public function save()
    {
        $this->validate([
            'gaji_per_hadir' => 'required|integer|min:0',
            'tunjangan_default' => 'required|integer|min:0',
            'potongan_default' => 'required|integer|min:0',
        ]);

        // Ambil data setting pertama
        $setting = GajiSetting::first();

        // Kalau tidak ada, buat baru
        if (!$setting) {
            GajiSetting::create([
                'gaji_per_hadir' => $this->gaji_per_hadir,
                'tunjangan_default' => $this->tunjangan_default,
                'potongan_default' => $this->potongan_default,
            ]);
            session()->flash('message', '✅ Pengaturan gaji berhasil disimpan.');
            return;
        }

        // Cek apakah ada perubahan data
        if (
            $setting->gaji_per_hadir != $this->gaji_per_hadir ||
            $setting->tunjangan_default != $this->tunjangan_default ||
            $setting->potongan_default != $this->potongan_default
        ) {
            $setting->update([
                'gaji_per_hadir' => $this->gaji_per_hadir,
                'tunjangan_default' => $this->tunjangan_default,
                'potongan_default' => $this->potongan_default,
            ]);
            session()->flash('message', '✅ Pengaturan gaji berhasil diperbarui.');
        } else {
            session()->flash('message', 'ℹ️ Tidak ada perubahan yang disimpan.');
        }
        $this->editable = false;
    }

    public function enableEdit()
    {
        $this->editable = true;
    }


    public function render()
    {
        return view('livewire.gaji-setting-manager');
    }
}
