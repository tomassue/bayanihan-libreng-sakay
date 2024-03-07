<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EventOrganizationRidersModel;
use App\Models\EventOrganizationsModel;
use App\Models\TransactionModel;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\AssignOp\Concat;

class ClientListController extends Controller
{
    // Individual
    public $user;
    public $user_id, $user_data, $full_name, $contact_number, $indi_id, $id_org;

    public function index($token)
    {
        try {
            if ($this->checkToken($token)) {
                $id = $this->indi_id;

                $servedClients = TransactionModel::join('event_organization_riders', 'transactions.id_event_organization_riders', '=', 'event_organization_riders.id')
                    ->join('event_organizations', 'event_organization_riders.id_event_organization', '=', 'event_organizations.id')
                    ->join('events', 'event_organizations.id_event', '=', 'events.id')
                    ->join('client_information', 'transactions.id_client', '=', 'client_information.id')
                    ->where('event_organization_riders.id_individual', $id)
                    ->select(
                        'client_information.id AS client_id',
                        DB::raw("CONCAT(COALESCE(client_information.last_name, ''), ' ', COALESCE(client_information.first_name, ''), ' ', COALESCE(client_information.middle_name, ''), ' ', COALESCE(client_information.ext_name, '')) AS client_fullname"),
                        'event_organization_riders.id_individual',
                        DB::raw("DATE_FORMAT(transactions.created_at, '%b %d, %Y %h:%i%p') AS formatted_created_at"),
                        'transactions.destination',
                        'events.event_name AS event_name'
                    )
                    ->orderBy('transactions.created_at', 'DESC')
                    ->get();

                return response()->json($servedClients);
                // return response()->json($id);
            } else {
                return response()->json(["error" => 'User not found.'], 500);
            }
        } catch (\Exception $e) {
            // return response()->json(['error' => 'Something went wrong.'], 500);
            return response()->json($e->getMessage());
        }
    }

    private function checkToken($token)
    {
        try {
            $decrypt_token = Crypt::decryptString($token);
            $is_auth = User::join('individual_information', 'users.user_id', '=', 'individual_information.user_id')
                ->select('individual_information.id AS indi_id', 'individual_information.*', 'users.*')
                ->where('api_token', $decrypt_token)
                ->first();

            if ($is_auth) {
                $this->user             =   $is_auth;
                $this->user_id          =   $is_auth->user_id;
                $this->full_name        =   $is_auth->first_name . ' ' . $is_auth->middle_name . ' ' . $is_auth->last_name . ' ' . $is_auth->ext_name;
                $this->contact_number   =   $is_auth->contactNumber;
                $this->indi_id          =   $is_auth->indi_id;
                $this->id_org           =   $is_auth->id_organization;
                return true;
            }
            return false;
        } catch (\Exception $e) {
            return false;
        }
    }
}
