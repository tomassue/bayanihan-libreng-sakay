<?php

namespace App\Livewire\NewProcess;

use App\Livewire\Navigation;
use App\Models\ActionLogModel;
use App\Models\IndividualInformationModel;
use App\Models\OrganizationInformationModel;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.page')]
#[Title('Registration')]
class RegistrationRider extends Component
{
    public $editMode = false;
    public $user_id;
    public $status;

    /* --------------------------------- Filter --------------------------------- */

    public $search;
    public $filter_status;
    public $filter_organization;

    public function render()
    {
        $data = [
            'riders' => $this->loadRiders(),
            'organizations' => $this->loadOrganization()
        ];
        return view('livewire.new-process.registration-rider', $data);
    }

    public function rules()
    {
        return [
            'status' => 'required'
        ];
    }

    public function clear()
    {
        $this->reset();
        $this->resetValidation();
    }

    public function edit($user_id)
    {
        try {
            $rider = IndividualInformationModel::join('users', 'users.user_id', '=', 'individual_information.user_id')
                ->join('organization_information', 'organization_information.id', '=', 'individual_information.id_organization')
                ->join('tbl_ref_barangay', 'tbl_ref_barangay.id', '=', 'individual_information.id_barangay')
                ->select(
                    'individual_information.user_id',
                    'users.status'
                )
                ->where('individual_information.user_id', $user_id)
                ->first();

            $this->user_id = $rider->user_id;
            $this->status = $rider->status;
            $this->editMode = true;

            $this->dispatch('show_riderModal');
        } catch (\Exception $e) {
            // dd($e->getMessage());
            $this->dispatch('something_went_wrong');
        }
    }

    public function update()
    {
        $this->validate();

        try {
            // Capture original state
            $originalUser = User::where('user_id', $this->user_id)->first()->getAttributes();

            DB::beginTransaction();

            User::where('user_id', $this->user_id)
                ->update([
                    'status' => $this->status
                ]);

            // Re-fetch the updated models
            $updatedUser = User::where('user_id', $this->user_id)->first();
            // Manually determine changes
            $userChanges = array_diff_assoc($updatedUser->getAttributes(), $originalUser);

            // Manually determine changes
            $this->logUserAction('update', $updatedUser, $this->user_id, $userChanges);

            DB::commit();

            $this->dispatch('hide_riderModal');
            $this->dispatch('rider_approval_count')->to(Navigation::class);
            $this->clear();
            $this->dispatch('success_update');
        } catch (\Exception $e) {
            DB::rollBack();

            // dd($e->getMessage());
            $this->dispatch('something_went_wrong');
        }
    }

    public function loadRiders()
    {
        $riders = IndividualInformationModel::join('users', 'users.user_id', '=', 'individual_information.user_id')
            ->join('organization_information', 'organization_information.id', '=', 'individual_information.id_organization')
            ->select(
                'individual_information.user_id',
                DB::raw("CONCAT(individual_information.first_name, ' ',COALESCE(individual_information.middle_name, ''), ' ', individual_information.last_name, IF(TRIM(IFNULL(individual_information.ext_name, '')) != '', CONCAT(', ', individual_information.ext_name), '')) as name"),
                'organization_information.organization_name',
                'users.contactNumber as contact_number',
                DB::raw("
                CASE
                    WHEN users.status = '0' THEN 'Pending'
                    WHEN users.status = '1' THEN 'Approved'
                    ELSE ''
                END AS status
                ")
            )
            ->when($this->filter_status != null, function ($query) {
                $query->where('users.status', $this->filter_status);
            })
            ->when($this->filter_organization != null, function ($query) {
                $query->where('individual_information.id_organization', $this->filter_organization);
            })
            ->where(function ($query) {
                $query->where('individual_information.first_name', 'like', '%' . $this->search . '%')
                    ->orWhere('individual_information.last_name', 'like', '%' . $this->search . '%')
                    ->orWhere('organization_information.organization_name', 'like', '%' . $this->search . '%');
            })
            ->orderBy('users.created_at', 'desc')
            ->paginate(10);

        return $riders;
    }

    public function loadOrganization() // Filter
    {
        $organizations = OrganizationInformationModel::select('id', 'organization_name')->get();

        return $organizations;
    }

    // This function will be called on CRUD processes.
    public function logUserAction($action, $model, $user_id, $changes = [])
    {
        try {
            // Ensure $model is an Eloquent model instance
            $modelType = get_class($model);
            $modelId = $model->id;

            ActionLogModel::create([
                'user_id' => Auth::user()->id,
                'action' => $action,
                'model_type' => $modelType,
                'model_id' => $modelId,
                'model_user_id' => $user_id, // Log shared user_id like the user_id of the updated record.
                'changes' => json_encode($changes), // Log only the changed attributes and save it in json format
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent()
            ]);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}
