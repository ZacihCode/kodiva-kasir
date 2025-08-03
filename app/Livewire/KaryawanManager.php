<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\WithPagination;
use Endroid\QrCode\Builder\Builder;
use Illuminate\Support\Facades\File;

#[\Livewire\Attributes\Layout('layouts.app')]
class KaryawanManager extends Component
{
    use WithPagination;

    public $name, $email, $password, $phone, $address;
    public $editMode = false, $userIdBeingEdited;
    public $search = '';
    public $selectedKaryawan = [], $selectAll = false;
    public $confirmingDelete = false, $userIdToDelete;
    public $confirmingBulkDelete = false;
    public $showModal = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6',
        'phone' => 'nullable|string|max:20',
        'address' => 'nullable|string',
    ];

    public function resetForm()
    {
        $this->reset(['name', 'email', 'password', 'phone', 'address']);
        $this->resetValidation();
        $this->showModal = true;
    }

    public function save()
    {
        $validatedData = $this->validate();

        if ($this->editMode) {
            $user = User::findOrFail($this->userIdBeingEdited);
            $user->update(array_merge(
                $validatedData,
                ['password' => Hash::make($this->password)]
            ));
        } else {
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'phone' => $this->phone,
                'address' => $this->address,
                'role' => 'user'
            ]);

            // Generate QR Code berisi ID, nama, dan email
            $qrData = "ID: {$user->id}\nNama: {$user->name}\nEmail: {$user->email}";
            $filename = "karyawan_{$user->id}.png";
            $qrFolder = public_path('qrcodes');
            $qrPath = $qrFolder . DIRECTORY_SEPARATOR . $filename;

            // Cek dan buat folder jika belum ada
            if (!File::exists($qrFolder)) {
                File::makeDirectory($qrFolder, 0755, true);
            }

            Builder::create()
                ->data($qrData)
                ->size(300)
                ->margin(10)
                ->writer(new \Endroid\QrCode\Writer\PngWriter())
                ->build()
                ->saveToFile($qrPath);

            // Simpan path relatif ke database
            $user->qr_code = "qrcodes/{$filename}";
            $user->save();
        }

        $this->resetForm();
        $this->showModal = false;
    }

    public function edit($userId)
    {
        $user = User::findOrFail($userId);
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->address = $user->address;
        $this->editMode = true;
        $this->userIdBeingEdited = $userId;
        $this->showModal = true;
    }

    public function render()
    {
        $users = User::where('role', 'user')
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.karyawan-manager', compact('users'));
    }

    public function toggleSelectAll()
    {
        if ($this->selectAll) {
            $this->selectedKaryawan = User::where('role', 'user')
                ->pluck('id')
                ->toArray();
        } else {
            $this->selectedKaryawan = [];
        }
    }

    public function confirmDelete($id)
    {
        $this->confirmingDelete = true;
        $this->userIdToDelete = $id;
    }

    public function deleteKaryawanConfirmed()
    {
        User::findOrFail($this->userIdToDelete)->delete();
        $this->confirmingDelete = false;
        $this->selectedKaryawan = array_diff($this->selectedKaryawan, [$this->userIdToDelete]);
        $this->userIdToDelete = null;
    }

    public function confirmBulkDelete()
    {
        $this->confirmingBulkDelete = true;
    }

    public function deleteSelectedConfirmed()
    {
        User::whereIn('id', $this->selectedKaryawan)->delete();
        $this->selectedKaryawan = [];
        $this->selectAll = false;
        $this->confirmingBulkDelete = false;
    }
}
