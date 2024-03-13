<?php

namespace App\Livewire;

use App\Models\SchoolInformationModel;
use Livewire\Component;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\WithPagination;

#[Layout('components.layouts.page')]
#[Title('References')]
class References extends Component
{
    use WithPagination;

    // Search
    public $search_school = "";

    // School Modal options
    public $add_school;

    // IDs for updating
    public $post_school_id;

    // Input fields
    #[Validate('required')]
    public $school_name;

    public function render()
    {
        $school = SchoolInformationModel::select('id', 'school_name')
            ->where('school_name', 'like', '%' . $this->search_school . '%')
            ->paginate(10);

        return view('livewire.references', [
            'school'             =>      $school,
            'currentPage'        =>      $school->currentPage(),
            'totalPages'         =>      $school->lastPage(),
            'totalRecords'       =>      $school->total(),
            'noRecords'          =>      $school->isEmpty(),
        ]);
    }

    public function updating()
    {
        $this->resetPage();
    }

    public function addSchool()
    {
        $this->add_school = true;
    }

    public function editSchool($id)
    {
        $this->add_school = false;

        $query = SchoolInformationModel::where('id', $id)
            ->first();

        $this->school_name = $query->school_name;
        $this->post_school_id = $query->id;
    }

    public function saveSchool()
    {
        $this->validate();

        $query = new SchoolInformationModel;
        $query->create([
            'school_name'   =>  $this->school_name
        ]);

        $this->dispatch('close-School-Modal');
        session()->flash('status', 'School is updated successfully.');
        return redirect()->to('references');
    }

    public function updateSchool()
    {
        $this->validate();

        if ($this->post_school_id) {
            $query = SchoolInformationModel::findOrFail($this->post_school_id);
            $query->update([
                'school_name'   => $this->school_name
            ]);
        }
        $this->reset('post_school_id');
        $this->dispatch('close-School-Modal');
        session()->flash('status', 'School is updated successfully.');
        return redirect()->to('references');
    }
}
