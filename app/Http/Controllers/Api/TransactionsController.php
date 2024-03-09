<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ClientInformationModel;
use App\Models\EventOrganizationRidersModel;
use App\Models\EventOrganizationsModel;
use App\Models\IndividualInformationModel;
use App\Models\TransactionModel;
use App\Models\SmsSenderModel;
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
                // Checks if the client exists in the database or if the QR's invalid.
                $checkClient = ClientInformationModel::where('id', $request->transaction->id_client)
                    ->first();
                $a = EventOrganizationRidersModel::where('id', $request->transaction->id)->pluck('id_individual');
                $getRider = IndividualInformationModel::where('id', $a)
                    ->select(
                        DB::raw("CONCAT(COALESCE(last_name, ''), ', ', COALESCE(first_name, ''), ' ', COALESCE(middle_name, ''), ' ', COALESCE(ext_name, '')) AS rider_fullname"),
                    )
                    ->first();

                if ($checkClient) {
                    $transaction                                =   new TransactionModel();
                    $transaction->id_event_organization_riders  =   $request->transaction->id;
                    $transaction->id_client                     =   $request->transaction->id_client;
                    $transaction->destination                   =   $request->transaction->destination;
                    $transaction->save();

                    // SMS to guardian once client's QR is scanned successfully.
                    $sms = new SmsSenderModel();
                    $welcome = "BAYANIHAN LIBRENG SAKAY INFO: " . "\n\nSi " . $checkClient->first_name . ' ' . $checkClient->middle_name . ' ' . $checkClient->last_name . " ay nag-avail ng Libreng Sakay papuntang " . $request->transaction->destination . ". Ang kaniyang rider ay si " . $getRider->rider_fullname . ".";
                    $sms->trans_id = time() . '-' . mt_rand();
                    $sms->received_id = "BAYANIHAN-LIBRENG-SAKAY-OTP";
                    $sms->recipient = $checkClient->guardian_contact_number;
                    $sms->recipient_message = $welcome . " \n\n**This is system-generated message. Please DO NOT REPLY.**";
                    $sms->save();

                    // return response()->json($getRider->rider_fullname);
                    return response()->json(['message' => 'Scanned Successfully.'], 200);
                } else {
                    return response()->json(['message' => 'QR is invalid.'], 200);
                }
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

    public function dropClient(Request $content)
    {
        $request = json_decode($content->getContent());

        try {
            if ($this->checkToken($request->token)) {
                $checkClientTransaction = TransactionModel::where('id', $request->transaction->trans_id)
                    ->first();

                if ($checkClientTransaction) {
                    TransactionModel::where('id', $request->trans_id)
                        ->update([
                            'status'    =>  1
                        ]);

                    return response()->json(['message' => 'Successfully dropped.'], 200);
                }
                return response()->json(['error' => 'User not found.'], 500);
            }
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }
}
