<?php

namespace App\Livewire;

use App\Models\OrganizationInformationModel;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;

#[Layout('components.layouts.page')]
#[Title('Update Profile')]
class UpdateProfile extends Component
{
    // Input fields (Update Profile)
    #[Validate('required')]
    public $organization_name, $date_established, $address, $representative_name, $representative_position, $representative_contact_number, $contactNumber, $email;
    #[Validate('required|current_password')]
    public $current_password;

    // Input fields (Change Password)
    public $currentPass, $newPass, $confirmPass;

    // Tabs
    public $page_one, $page_two, $page_three;

    public function render()
    {
        return view('livewire.update-profile');
    }

    public function mount()
    {
        $this->organization_name                = Auth::user()->organization_information->organization_name;
        $this->date_established                 = Auth::user()->organization_information->date_established;
        $this->address                          = Auth::user()->organization_information->address;
        $this->representative_name              = Auth::user()->organization_information->representative_name;
        $this->representative_position          = Auth::user()->organization_information->representative_position;
        $this->representative_contact_number    = Auth::user()->organization_information->representative_contact_number;
        $this->contactNumber                    = Auth::user()->contactNumber;
        $this->email                            = Auth::user()->email;

        $this->page_one                         = true;
    }

    public function pageOne()
    {
        $this->page_one = true;

        $this->reset('page_two', 'page_three');
    }

    public function pageTwo()
    {
        $this->page_two = true;

        $this->reset('page_one', 'page_three');
    }

    public function pageThree()
    {
        $this->page_three = true;

        $this->reset('page_one', 'page_two');
    }

    public function update()
    {
        $this->validate();

        $item = OrganizationInformationModel::where('user_id', Auth::user()->user_id);
        $item->update([
            'organization_name'             =>  $this->organization_name,
            'date_established'              =>  $this->date_established,
            'address'                       =>  $this->address,
            'representative_name'           =>  $this->representative_name,
            'representative_position'       =>  $this->representative_position,
            'representative_contact_number' =>  $this->representative_contact_number,
        ]);

        $item2 = User::where('user_id', Auth::user()->user_id);
        $item2->update([
            'contactNumber'                 =>  $this->contactNumber,
            'email'                         =>  $this->email

        ]);

        session()->flash('status', 'Profile updated successfuly.');
        $this->reset('current_password');
        return redirect()->to('/update-profile');
    }

    public function changePassword()
    {
        // VALIDATION for the change password
        $rules = [
            'currentPass'        => 'required|current_password',
            'newPass'            => 'required|min:8|regex:/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
            'confirmPass'        => 'required|same:newPass',
        ];

        $this->validate($rules);

        $user = Auth::user();

        // password_verify() will check if the inputted current password matches the current password in the database.
        if (password_verify($this->currentPass, $user->password)) {
            $changePassword = User::where('user_id', Auth::user()->user_id);
            $changePassword->update([
                'password'  =>  Hash::make($this->newPass),
            ]);

            session()->flash('status', 'Password updated successfully.');
        } else {
            $this->addError('currentPass', 'Current password is incorrect.');
        }

        $this->reset('currentPass', 'newPass', 'confirmPass');
        session()->flash('status', 'Password updated successfuly.');
        return redirect()->to('/update-profile');
    }
}
