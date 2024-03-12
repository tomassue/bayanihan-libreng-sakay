<?php

namespace App\Livewire;

use App\Models\ClientInformationModel;
use Livewire\Component;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

#[Layout('components.layouts.page')]
#[Title('Client Report')]

class ClientsReport extends Component
{
    use WithPagination;

    public $query = "";

    public function search()
    {
        $this->resetPage();
    }

    public function render()
    {
        $clients = ClientInformationModel::join('users', 'client_information.user_id', '=', 'users.user_id')
            ->select(
                DB::raw("CONCAT(COALESCE(client_information.first_name, ''), ' ', COALESCE(client_information.middle_name, ''), ' ', COALESCE(client_information.last_name, ''), ' ', COALESCE(client_information.ext_name, '')) AS client_fullname"),
                'users.contactNumber AS contactNumber',
                'client_information.user_type AS user_type'
            )
            ->where('client_information.user_type', 'like', '%' . $this->query . '%')
            ->paginate(5);

        return view('livewire.clients-report', [
            'clients'       =>  $clients,
            'currentPage'   =>  $clients->currentPage(),
            'totalPages'    =>  $clients->lastPage(),
            'totalRecords'  =>  $clients->total(),
            'noRecords'     =>  $clients->isEmpty(),
        ]);
    }

    public function clear()
    {
        $this->query = "";
    }
}
