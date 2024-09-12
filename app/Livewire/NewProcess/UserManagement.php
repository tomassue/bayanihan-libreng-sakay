<?php

namespace App\Livewire\NewProcess;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.page')]
#[Title('User Management')]
class UserManagement extends Component
{
    public function render()
    {
        $data = [
            'admin' => $this->loadUsers()
        ];
        return view('livewire.new-process.user-management', $data);
    }

    public function loadUsers()
    {
        // Load only the ADMINS
        $admin = User::select(
            'user_id',
            'status',
        )
            ->where('id_account_type', 'admin')
            ->get();

        return $admin;
    }
}
