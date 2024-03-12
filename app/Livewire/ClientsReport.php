<?php

namespace App\Livewire;

use App\Models\ClientInformationModel;
use Livewire\Component;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use Barryvdh\DomPDF\Facade\Pdf;

#[Layout('components.layouts.page')]
#[Title('Client Report')]

class ClientsReport extends Component
{
    use WithPagination;

    public $start_date = "", $end_date = "";

    public function search()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = ClientInformationModel::join('users', 'client_information.user_id', '=', 'users.user_id')
            ->select(
                DB::raw("CONCAT(COALESCE(client_information.first_name, ''), ' ', COALESCE(client_information.middle_name, ''), ' ', COALESCE(client_information.last_name, ''), ' ', COALESCE(client_information.ext_name, '')) AS client_fullname"),
                'users.contactNumber AS contactNumber',
                'client_information.user_type AS user_type',
                'client_information.created_at'
            );

        if (!empty($this->start_date) && !empty($this->end_date)) {
            $query->whereBetween('client_information.created_at', [$this->start_date, $this->end_date]);
        }

        $clients = $query->paginate(5);

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
        $this->start_date = "";
        $this->end_date = "";
    }
}
