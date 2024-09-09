<?php

namespace App\Livewire\NewProcess;

use App\Models\ClientInformationModel;
use App\Models\IndividualInformationModel;
use App\Models\OrganizationInformationModel;
use App\Models\RefBarangayModel;
use App\Models\SchoolInformationModel;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str; //THIS IS FOR THE str::random()

#[Layout('components.layouts.page')]
#[Title('Registration')]
class Registration extends Component
{
    use WithPagination;

    /* ------------------------------ USER'S TABLE ------------------------------ */
    public $user_id;
    public $email;

    public $account_type;
    public $last_name;
    public $first_name;
    public $middle_name;
    public $ext_name;
    public $sex;
    public $id_barangay;
    public $address;
    public $contactNumber; //NOTE - Can be used for organization's contact number

    /* ---------------------------------- RIDER --------------------------------- */
    public $id_organization;

    /* --------------------------------- CLIENT --------------------------------- */
    public $user_type;
    public $birthday;
    public $id_school;
    public $guardian_name;
    public $guardian_contact_number;

    /* ------------------------------ ORGANIZATION ------------------------------ */
    public $organization_name;
    public $date_established;
    public $representative_name;
    public $representative_position;
    public $representative_contact_number;

    public function render()
    {
        $data = [
            'organization' => $this->loadOrganization(),
            'school' => $this->loadSchool(),
            'barangay' => $this->loadBarangay(),
            'combined' => $this->loadUsers()
        ];

        return view('livewire.new-process.registration', $data);
    }

    public function updated($property)
    {
        if ($property == 'account_type') {
            $this->resetExcept('account_type');
            $this->resetValidation();
        }

        if ($property == 'user_type') {
            $this->reset('id_school');
            $this->resetValidation('id_school');
        }
    }

    public function add()
    {
        $rules = [
            'account_type' => 'required',
            'contactNumber' => 'required',
            'address' => 'required'
        ];

        if ($this->account_type == 'rider' || $this->account_type == 'client') {
            $rules['first_name'] = 'required';
            $rules['last_name'] = 'required';
            $rules['sex'] = 'required';
            $rules['id_barangay'] = 'required';
        }

        if ($this->account_type == 'rider' || $this->account_type == 'organization') {
            $rules['email'] = 'required|email:rfc,dns';
        }

        if ($this->account_type == 'rider') {
            $rules['id_organization'] = 'required';
        }

        if ($this->account_type == 'client') {
            $rules['user_type'] = 'required';
            $rules['birthday'] = 'required';
            $rules['guardian_name'] = 'required';
            $rules['guardian_contact_number'] = 'required';

            if ($this->user_type == 'student' || $this->user_type == 'school_staff') {
                $rules['id_school'] = 'required';
            }
        }

        if ($this->account_type == 'organization') {
            $rules['organization_name'] = 'required';
            $rules['date_established'] = 'required';
            $rules['representative_name'] = 'required';
            $rules['representative_position'] = 'required';
            $rules['representative_contact_number'] = 'required';
        }

        $attributes = [
            'id_barangay' => 'barangay',
            'id_organization' => 'organization',
            'id_school' => 'school'
        ];

        // Generate random letters and numbers for doctype_code
        $timestamp = now()->timestamp;
        $randomString = Str::random(10);
        $user_id = strtoupper($timestamp . $randomString);

        if ($this->account_type == 'rider') {
            $this->validate($rules, [], $attributes);

            DB::beginTransaction();

            try {
                User::create([
                    'user_id' => $user_id,
                    'email' => $this->email,
                    'contactNumber' => $this->contactNumber,
                    'id_account_type' => '2',
                    'password' => Hash::make('password'),
                    'status' => '1'
                ]);

                IndividualInformationModel::create([
                    'user_id' => $user_id,
                    'last_name' => $this->last_name,
                    'first_name' => $this->first_name,
                    'middle_name' => $this->middle_name,
                    'ext_name' => $this->ext_name,
                    'sex' => $this->sex,
                    'id_barangay' => $this->id_barangay,
                    'address' => $this->address,
                    'id_organization' => $this->id_organization
                ]);

                DB::commit();

                $this->dispatch('success_save');
                // $this->dispatch('hide_addModal');
                $this->reset();
                $this->resetValidation();
            } catch (\Exception $e) {
                // Rollback the transaction on failure
                DB::rollBack();

                $this->dispatch('something_went_wrong');
            }
        } elseif ($this->account_type == 'client') {
            $this->validate($rules, [], $attributes);

            DB::beginTransaction();

            try {
                User::create([
                    'user_id' => $user_id,
                    'email' => 'null',
                    'contactNumber' => $this->contactNumber,
                    'id_account_type' => '3',
                    'password' => Hash::make('password'),
                    'status' => '1'
                ]);

                ClientInformationModel::create([
                    'user_id' => $user_id,
                    'user_type' => $this->user_type,
                    'last_name' => $this->last_name,
                    'first_name' => $this->first_name,
                    'middle_name' => $this->middle_name,
                    'ext_name' => $this->ext_name,
                    'sex' => $this->sex,
                    'birthday' => $this->birthday,
                    'id_barangay' => $this->id_barangay,
                    'address' => $this->address,
                    'id_school' => $this->id_school,
                    'guardian_name' => $this->guardian_name,
                    'guardian_contact_number' => $this->guardian_contact_number
                ]);

                DB::commit();

                $this->dispatch('success_save');
                // $this->dispatch('hide_addModal');
                $this->reset();
                $this->resetValidation();
            } catch (\Exception $e) {
                DB::rollBack();

                $this->dispatch('something_went_wrong');
                dd($e->getMessage());
            }
        } elseif ($this->account_type == 'organization') {
            $this->validate($rules, [], $attributes);

            DB::beginTransaction();

            try {
                User::create([
                    'user_id' => $user_id,
                    'email' => 'null',
                    'contactNumber' => $this->contactNumber,
                    'id_account_type' => '3',
                    'password' => Hash::make('password'),
                    'status' => '1'
                ]);

                OrganizationInformationModel::create([
                    'user_id' => $user_id,
                    'organization_name' => $this->organization_name,
                    'date_established' => $this->date_established,
                    'address' => $this->address,
                    'representative_name' => $this->representative_name,
                    'representative_position' => $this->representative_position,
                    'representative_contact_number' => $this->representative_contact_number
                ]);

                DB::commit();

                $this->dispatch('success_save');
                // $this->dispatch('hide_addModal');
                $this->reset();
                $this->resetValidation();
            } catch (\Exception $e) {
                DB::rollBack();
            }
        } else {
            $this->dispatch('something_went_wrong');
        }
    }

    //REVIEW - https://chatgpt.com/share/0b8db142-caa7-4d70-b842-13127b3f1067
    public function loadUsers()
    {
        $clients = ClientInformationModel::join('users', 'users.user_id', '=', 'client_information.user_id')
            // ->join('tbl_ref_barangay', 'tbl_ref_barangay.id_barangay', '=', 'client_information.id_barangay')
            ->select(
                DB::raw("CONCAT(client_information.first_name, COALESCE(client_information.middle_name, ''), ' ', client_information.last_name, IF(TRIM(IFNULL(client_information.ext_name, '')) != '', CONCAT(', ', client_information.ext_name), '')) as name"),
                // 'tbl_ref_barangay.barangay AS address',
                DB::raw("
                CASE
                    WHEN users.status = '1' THEN 'Rider'
                    WHEN users.status = '2' THEN 'Organization'
                    WHEN users.status = '3' THEN 'Client'
                    ELSE ''
                END AS account_type
                "),
                'users.contactNumber',
                'users.created_at',
                DB::raw("'Client' AS type")
            );

        $riders = IndividualInformationModel::join('users', 'users.user_id', '=', 'individual_information.user_id')
            // ->join('tbl_ref_barangay', 'tbl_ref_barangay.id_barangay', '=', 'individual_information.id_barangay')
            ->select(
                DB::raw("CONCAT(individual_information.first_name, COALESCE(individual_information.middle_name, ''), ' ', individual_information.last_name, IF(TRIM(IFNULL(individual_information.ext_name, '')) != '', CONCAT(', ', individual_information.ext_name), '')) as name"),
                // 'tbl_ref_barangay.barangay AS address',
                DB::raw("
                CASE
                    WHEN users.status = '1' THEN 'Rider'
                    WHEN users.status = '2' THEN 'Organization'
                    WHEN users.status = '3' THEN 'Client'
                    ELSE ''
                END AS account_type
                "),
                'users.contactNumber',
                'users.created_at',
                DB::raw("'Rider' AS type")
            );

        $organizations = OrganizationInformationModel::join('users', 'users.user_id', '=', 'organization_information.user_id')
            ->select(
                'organization_information.organization_name AS name',
                // 'organization.address AS address',
                DB::raw("
                CASE
                    WHEN users.status = '1' THEN 'Rider'
                    WHEN users.status = '2' THEN 'Organization'
                    WHEN users.status = '3' THEN 'Client'
                    ELSE ''
                END AS account_type
                "),
                'users.contactNumber',
                'users.created_at',
                DB::raw("'Organization' AS type")
            );

        // Combine the queries using UNION
        $combined = $clients
            ->union($riders)
            ->union($organizations)
            ->orderBy('created_at', 'desc')
            ->get();

        return $combined;
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
