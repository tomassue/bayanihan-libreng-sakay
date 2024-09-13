<?php

namespace App\Livewire\NewProcess;

use App\Models\AdminInformationModel;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Illuminate\Support\Str; //THIS IS FOR THE str::random()

#[Layout('components.layouts.page')]
#[Title('User Management')]
class UserManagement extends Component
{
    public $editMode = false;
    public $id_user;
    public $search;

    /* -------------------------------------------------------------------------- */

    public $name;
    public $email;
    public $status;

    public function render()
    {
        $data = [
            'admin' => $this->loadUsers()
        ];

        return view('livewire.new-process.user-management', $data);
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email:rfc,dns|unique:users,email'
        ];
    }

    public function add()
    {
        $this->validate();

        try {
            DB::beginTransaction();

            $user = User::create([
                'user_id' =>  'ADMIN',
                'email' => $this->email,
                'contactNumber' => '123456',
                'id_account_type' => 'admin',
                'password' => Hash::make('password'),
                'status' => '1'
            ]);

            AdminInformationModel::create([
                'user_id' => $user->id,
                'name' => $this->name
            ]);

            DB::commit();

            $this->reset();
            $this->dispatch('hide_addUserModal');
            $this->dispatch('success_save');
        } catch (\Exception $e) {
            DB::rollBack();
            // dd($e->getMessage());
            $this->dispatch('something_went_wrong');
        }
    }

    public function edit($id)
    {
        $this->editMode = true;
        $this->id_user = $id;

        $user = User::join('admin_information', 'admin_information.user_id', '=', 'users.id')
            ->where('users.id', $id)
            ->first();

        $this->name = $user->name;
        $this->email = $user->email;
        $this->status = $user->status;

        $this->dispatch('show_addUserModal');
    }

    public function update()
    {
        try {
            DB::beginTransaction();

            AdminInformationModel::where('user_id', $this->id_user)
                ->update([
                    'name' => $this->name
                ]);

            User::where('id', $this->id_user)
                ->update([
                    'email' => $this->email,
                    'status' => $this->status
                ]);

            DB::commit();

            $this->reset();
            $this->dispatch('hide_addUserModal');
            $this->dispatch('success_update');
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
        $admin = User::join('admin_information', 'admin_information.user_id', '=', 'users.id')
            ->select(
                'users.id',
                DB::raw("
                    CASE
                        WHEN users.id_account_type = 'admin' THEN 'Admin'
                        ELSE ''
                    END AS account_type
                "),
                DB::raw("
                    CASE
                        WHEN users.status = '1' THEN 'Active'
                        WHEN users.status = '0' THEN 'Inactive'
                        ELSE ''
                    END AS status
                "),
                'admin_information.name'
            )
            ->whereNot('users.id', '1')
            ->whereNot('users.id', '2')
            ->where('admin_information.name', 'like', '%' . $this->search . '%')
            ->get();

        return $admin;
    }
}
