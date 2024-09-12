<?php

namespace App\Livewire\NewProcess;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.page')]
#[Title('User Management')]
class UserManagement extends Component
{
    public $name;
    public $email;

    public function render()
    {
        $data = [
            'admin' => $this->loadUsers()
        ];

        return view('livewire.new-process.user-management', $data);
    }

    public function add()
    {
        try {
            DB::beginTransaction();

            User::create([
                'user_id' => $this->name,
                'email' => $this->email,
                'contactNumber' => '123456',
                'id_account_type' => 'admin',
                'password' => Hash::make('P@ssw0rd')
            ]);

            DB::commit();

            $this->reset();
            //FIXME - WORK IT HERE
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
        }
    }

    public function clear()
    {
        $this->reset();
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
