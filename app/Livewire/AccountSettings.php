<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AccountSettings extends Component
{
    public $name, $email, $phone, $address;
    public $current_password, $new_password, $confirm_password;
    public $editMode = false;

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->address = $user->address;
    }

    public function enableEdit()
    {
        $this->editMode = !$this->editMode;
    }

    public function updateProfile()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        $user = User::find(auth()->id());
        $user->name = $this->name;
        $user->phone = $this->phone;
        $user->address = $this->address;
        $user->save();

        $this->editMode = false;
        $this->dispatch('toast', type: 'success', message: 'Profil berhasil diperbarui!');
    }

    public function updatePassword()
    {
        $this->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'same:new_password',
        ]);

        $user = User::find(auth()->id());

        if (!Hash::check($this->current_password, $user->password)) {
            $this->addError('current_password', 'Password saat ini salah.');
            return;
        }

        $user->password = Hash::make($this->new_password);
        $user->save();

        $this->reset(['current_password', 'new_password', 'confirm_password']);
        $this->dispatch('toast', type: 'success', message: 'Password berhasil diperbarui!');
    }

    public function render()
    {
        return view('livewire.account-settings');
    }
}
