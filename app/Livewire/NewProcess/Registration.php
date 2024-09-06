<?php

namespace App\Livewire\NewProcess;

use App\Models\OrganizationInformationModel;
use App\Models\RefBarangayModel;
use App\Models\SchoolInformationModel;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.page')]
#[Title('Registration')]
class Registration extends Component
{
    use WithPagination;

    public $account_type;

    public $last_name;
    public $first_name;
    public $middle_name;
    public $ext_name;
    public $sex;
    public $id_barangay;
    public $address;
    public $contactNumber;

    /* ---------------------------------- RIDER --------------------------------- */
    public $id_organization;

    /* --------------------------------- CLIENT --------------------------------- */
    public $user_type;
    public $birthday;
    public $id_school;
    public $guardian_name;
    public $guardian_contact_number;

    public function render()
    {
        $data = [
            'organization' => $this->loadOrganization(),
            'school' => $this->loadSchool(),
            'barangay' => $this->loadBarangay()
        ];

        return view('livewire.new-process.registration', $data);
    }

    public function add()
    {
        if ($this->account_type == 'rider') {
            dd('Rider');
        } elseif ($this->account_type == 'client') {
            $this->dispatch('something-went-wrong');
        } else {
            $this->dispatch('something-went-wrong');
        }
    }

    public function loadOrganization()
    {
        $organization = OrganizationInformationModel::select('id', 'organization_name')->get();
        return $organization;
    }

    public function loadSchool()
    {
        $school = SchoolInformationModel::select('id', 'school_name')->get();
        return $school;
    }

    public function loadBarangay()
    {
        $barangay = RefBarangayModel::select('id', 'barangay')->get();
        return $barangay;
    }
}
