<?php

namespace App\Livewire;

use App\Models\SchoolInformationModel;
use Livewire\Component;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.page')]
#[Title('References')]
class References extends Component
{
    public function render()
    {
        $school = SchoolInformationModel::select('school_name')->get();

        return view('livewire.references', [
            'school'    =>  $school
        ]);
    }
}
