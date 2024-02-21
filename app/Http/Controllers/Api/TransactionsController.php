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

class TransactionsController extends Controller
{
    // Individual
    public $user;
    public $user_id, $user_data, $full_name, $contact_number, $indi_id, $id_org;

    public function transaction(Request $content)
    {
        $request = json_decode($content->getContent());

        try {
            if ($this->checkToken($request->token)) {
                $transaction                                =   new TransactionModel();
                $transaction->id_event_organization_riders  =   $request->transaction->id;
                $transaction->id_client                     =   $request->transaction->id_client;
                $transaction->destination                   =   $request->transaction->destination;
                $transaction->save();

                return response()->json(['message' => 'Scanned Successfully.'], 200);
            } else {
                return response()->json(['error' => 'User not found.'], 500);
            }
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
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
                $this->contact_number   =   $is_auth->contact_number;
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
