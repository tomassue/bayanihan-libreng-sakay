<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ClientInformationModel;
use App\Models\EventOrganizationRidersModel;
use App\Models\EventOrganizationsModel;
use App\Models\TransactionModel;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\AssignOp\Concat;
use Carbon\Carbon;

class RidersListController extends Controller
{
    // Client
    public $user;
    public $user_id, $user_data, $full_name, $contact_number, $indi_id, $id_org;

    public function index($token)
    {
        try {
            if ($this->checkToken($token)) {
                // Riders sakayed XD
                $riders = TransactionModel::join('event_organization_riders', 'transactions.id_event_organization_riders', '=', 'event_organization_riders.id')
                    ->join('event_organizations', 'event_organization_riders.id_event_organization', '=', 'event_organizations.id')
                    ->join('events', 'event_organizations.id_event', '=', 'events.id')
                    ->join('individual_information', 'event_organization_riders.id_individual', '=', 'individual_information.id')
                    ->where('id_client', $this->indi_id)
                    ->select(
                        'event_organization_riders.id AS event_organization_riders_id',
                        'event_organization_riders.id_individual',
                        'individual_information.id AS individual_id',
                        DB::raw("CONCAT(COALESCE(individual_information.last_name, ''), ' ', COALESCE(individual_information.first_name, ''), ' ', COALESCE(individual_information.middle_name, ''), ' ', COALESCE(individual_information.ext_name, '')) AS rider_fullname"),
                        DB::raw("DATE_FORMAT(transactions.created_at, '%b %d, %Y %h:%i%p') AS formatted_created_at"),
                        'transactions.destination',
                        'events.event_name AS event_name'
                    )
                    ->orderBy('transactions.created_at', 'DESC')
                    ->get();

                return response()->json($riders);
            }
            return response()->json($this->checkToken($token));
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    private function checkToken($token)
    {
        try {
            $decrypt_token = Crypt::decryptString($token);

            $is_auth = User::where('api_token', $decrypt_token)->first();

            if ($is_auth && ($is_auth->id_account_type == '3')) {
                $is_client = ClientInformationModel::where('user_id', $is_auth->user_id)
                    ->first();

                $this->user             =   $is_client;
                $this->user_id          =   $is_client->user_id;
                $this->full_name        =   $is_client->first_name . ' ' . $is_client->middle_name . ' ' . $is_client->last_name . ' ' . $is_client->ext_name;
                $this->contact_number   =   $is_client->contact_number;
                $this->indi_id          =   $is_client->id;

                return true;
            }
            return response()->json($is_auth);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }
}
