<?php

namespace App\Livewire\NewProcess;

use App\Models\AccountTypeModel;
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
use Livewire\Attributes\On;

#[Layout('components.layouts.page')]
#[Title('Registration')]
class Registration extends Component
{
    use WithPagination;

    public $editMode = false;
    public $user_id;


    /* --------------------------------- FILTER --------------------------------- */
    public $search;
    public $filter_accountType;

    /* ------------------------------ USER'S TABLE ------------------------------ */
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
            'combined' => $this->loadUsers(),
            'accountType' => $this->loadAccountType()
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

    public function rules()
    {
        $rules = [
            'account_type' => 'required',
            'contactNumber' => 'required|unique:users,contactNumber',
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
            $rules['organization_name'] = 'required|unique:organization_information,organization_name';
            $rules['date_established'] = 'required';
            $rules['representative_name'] = 'required';
            $rules['representative_position'] = 'required';
            $rules['representative_contact_number'] = 'required';
        }

        return $rules;
    }
    public function attributes()
    {
        return [
            'id_barangay' => 'barangay',
            'id_organization' => 'organization',
            'id_school' => 'school'
        ];
    }

    public function add()
    {
        // Generate random letters and numbers for doctype_code
        $timestamp = now()->timestamp;
        $randomString = Str::random(10);
        $user_id = strtoupper($timestamp . $randomString);

        if ($this->account_type == 'rider') {
            $this->validate($this->rules(), [], $this->attributes());

            // Check for duplicates
            // $it_exist = User::join()

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
            $this->validate($this->rules(), [], $this->attributes());

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
            $this->validate($this->rules(), [], $this->attributes());

            DB::beginTransaction();

            try {
                User::create([
                    'user_id' => $user_id,
                    'email' => $this->email,
                    'contactNumber' => $this->contactNumber,
                    'id_account_type' => '1',
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

    public function edit($id)
    {
        $this->editMode = true;
        $this->user_id = $id;

        // Check what account type
        $check_user_account = User::select('id_account_type')->where('user_id', $id)->first();

        if ($check_user_account->id_account_type == '1') {
            // ORGANIZATION
            $this->account_type = 'organization';

            $organization = OrganizationInformationModel::join('users', 'users.user_id', '=', 'organization_information.user_id')->where('organization_information.user_id', $id)->first();
            $this->organization_name = $organization->organization_name;
            $this->date_established = $organization->date_established;
            $this->contactNumber = $organization->contactNumber;
            $this->address = $organization->address;
            $this->representative_name = $organization->representative_name;
            $this->representative_position = $organization->representative_position;
            $this->representative_contact_number = $organization->representative_contact_number;
            $this->email = $organization->email;

            $this->dispatch('show_addModal');
        } elseif ($check_user_account->id_account_type == '2') {
            // RIDER
            $this->account_type = 'rider';

            $rider = IndividualInformationModel::join('users', 'users.user_id', '=', 'individual_information.user_id')->where('individual_information.user_id', $id)->first();
            $this->first_name = $rider->first_name;
            $this->middle_name = $rider->middle_name;
            $this->last_name = $rider->last_name;
            $this->ext_name = $rider->ext_name;
            $this->sex = $rider->sex;
            $this->contactNumber = $rider->contactNumber;
            $this->id_barangay = $rider->id_barangay;
            $this->address = $rider->address;
            $this->id_organization = $rider->id_organization;
            $this->email = $rider->email;

            $this->dispatch('show_addModal');
        } elseif ($check_user_account->id_account_type == '3') {
            // CLIENT
            $this->account_type = 'client';

            $client = ClientInformationModel::join('users', 'users.user_id', '=', 'client_information.user_id')->where('client_information.user_id', $id)->first();
            $this->user_type = $client->user_type;
            $this->first_name = $client->first_name;
            $this->middle_name = $client->middle_name;
            $this->last_name = $client->last_name;
            $this->ext_name = $client->ext_name;
            $this->sex = $client->sex;
            $this->contactNumber = $client->contactNumber;
            $this->id_barangay = $client->id_barangay;
            $this->address = $client->address;
            $this->birthday = $client->birthday;
            $this->id_school = $client->id_school;
            $this->guardian_name = $client->guardian_name;
            $this->guardian_contact_number = $client->guardian_contact_number;

            $this->dispatch('show_addModal');
        }
    }

    public function update()
    {
        // Check what account type
        $check_user_account = User::select('id_account_type')->where('user_id', $this->user_id)->first();

        if ($check_user_account->id_account_type == '1') {
            // ORGANIZATION
            $this->account_type = 'organization';

            $this->validate($this->rules(), [], $this->attributes());

            //FIXME - We added unique in our rules(), however when we update the record, it triggers the validation. WORK SOMETHING OUT ABOUT THIS.

            $this->dispatch('hide_addModal');
        } elseif ($check_user_account->id_account_type == '2') {
            // RIDER
            $this->account_type = 'rider';

            $this->validate($this->rules(), [], $this->attributes());

            $this->dispatch('hide_addModal');
        } elseif ($check_user_account->id_account_type == '3') {
            // CLIENT
            $this->account_type = 'client';

            $this->validate($this->rules(), [], $this->attributes());

            $this->dispatch('hide_addModal');
        }
    }

    public function clear()
    {
        $this->reset();
        $this->resetValidation();
    }

    //REVIEW - https://chatgpt.com/share/0b8db142-caa7-4d70-b842-13127b3f1067
    public function loadUsers()
    {
        $clients = ClientInformationModel::join('users', 'users.user_id', '=', 'client_information.user_id')
            // ->join('tbl_ref_barangay', 'tbl_ref_barangay.id_barangay', '=', 'client_information.id_barangay')
            ->select(
                'client_information.user_id',
                DB::raw("CONCAT(client_information.first_name, ' ',COALESCE(client_information.middle_name, ''), ' ', client_information.last_name, IF(TRIM(IFNULL(client_information.ext_name, '')) != '', CONCAT(', ', client_information.ext_name), '')) as name"),
                // 'tbl_ref_barangay.barangay AS address',
                DB::raw("
                CASE
                    WHEN users.id_account_type = '1' THEN 'Organization'
                    WHEN users.id_account_type = '2' THEN 'Rider'
                    WHEN users.id_account_type = '3' THEN 'Client'
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
                'individual_information.user_id',
                DB::raw("CONCAT(individual_information.first_name, ' ', COALESCE(individual_information.middle_name, ''), ' ', individual_information.last_name, IF(TRIM(IFNULL(individual_information.ext_name, '')) != '', CONCAT(', ', individual_information.ext_name), '')) as name"),
                // 'tbl_ref_barangay.barangay AS address',
                DB::raw("
                CASE
                    WHEN users.id_account_type = '1' THEN 'Organization'
                    WHEN users.id_account_type = '2' THEN 'Rider'
                    WHEN users.id_account_type = '3' THEN 'Client'
                    ELSE ''
                END AS account_type
                "),
                'users.contactNumber',
                'users.created_at',
                DB::raw("'Rider' AS type")
            );

        $organizations = OrganizationInformationModel::join('users', 'users.user_id', '=', 'organization_information.user_id')
            ->select(
                'organization_information.user_id',
                'organization_information.organization_name AS name',
                // 'organization.address AS address',
                DB::raw("
                CASE
                    WHEN users.id_account_type = '1' THEN 'Organization'
                    WHEN users.id_account_type = '2' THEN 'Rider'
                    WHEN users.id_account_type = '3' THEN 'Client'
                    ELSE ''
                END AS account_type
                "),
                'users.contactNumber',
                'users.created_at',
                DB::raw("'Organization' AS type")
            );

        // Filters
        if ($this->search) {
            $clients->where(function ($query) {
                $query->where('client_information.last_name', 'like', '%' . $this->search . '%')
                    ->orWhere('client_information.first_name', 'like', '%' . $this->search . '%');
            });

            $riders->where(function ($query) {
                $query->where('individual_information.last_name', 'like', '%' . $this->search . '%')
                    ->orWhere('individual_information.first_name', 'like', '%' . $this->search . '%');
            });

            $organizations->where(function ($query) {
                $query->where('organization_information.organization_name', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filter_accountType) {
            $clients->where('users.id_account_type', 'like', '%' . $this->filter_accountType . '%');
            $riders->where('users.id_account_type', 'like' . $this->filter_accountType . '%');
            $organizations->where('users.id_account_type', 'like' . $this->filter_accountType . '%');
        }

        // Combine the queries using UNION
        $combined = $clients
            ->union($riders)
            ->union($organizations)
            ->where('id_account_type', '!=', 'admin')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

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

    public function loadAccountType()
    {
        $accountType = AccountTypeModel::all();
        return $accountType;
    }
}
