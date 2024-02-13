<?php

namespace App\Livewire;

use App\Models\User;
use \Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Livewire\Component;
use Livewire\Attributes\Validate;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.page')]
#[Title('Change Password')]

class ChangePassword extends Component
{
    #[Validate('required')]
    public $currentPass;

    #[Validate('required|min:8|regex:/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/')]
    public $newPass;

    #[Validate('required|same:newPass')]
    public $confirmPass;

    public function render()
    {
        return view('livewire.change-password');
    }

    public function changePass($user_id)
    {
        $this->validate();

        $user = Auth::user();

        // password_verify() will check if the inputted current password matches the current password in the database.
        if (password_verify($this->currentPass, $user->password)) {
            $changePassword = User::findOrFail($user_id);
            $changePassword->update([
                'password'  =>  Hash::make($this->newPass),
            ]);

            session()->flash('status', 'Password updated successfully.');
        } else {
            dd('No match.');
        }

        $this->reset('currentPass', 'newPass', 'confirmPass');
    }
}
