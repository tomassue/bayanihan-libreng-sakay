<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ClientInformationModel;
use App\Models\EventAttendanceModel;
use App\Models\EventOrganizationRidersModel;
use App\Models\EventOrganizationsModel;
use App\Models\IndividualInformationModel;
use App\Models\NumberMessageModel;
use App\Models\OrganizationInformationModel;
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
                        'user_id',
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
                    $blaster = new NumberMessageModel();

                    $welcome = "BAYANIHAN LIBRENG SAKAY INFO: " . "\n\nSi " . $checkClient->first_name . ' ' . $checkClient->middle_name . ' ' . $checkClient->last_name . " ay nag-avail ng Libreng Sakay papuntang " . $request->transaction->destination . ". Ang kaniyang rider ay si " . $getRider->rider_fullname . ".";
                    $sms->trans_id = time() . '-' . mt_rand();
                    $sms->received_id = "BAYANIHAN-LIBRENG-SAKAY-OTP";
                    $sms->recipient = $checkClient->guardian_contact_number;
                    $sms->recipient_message = $welcome . " \n\n**This is system-generated message. Please DO NOT REPLY.**";
                    $sms->save();

                    $blaster->user_id       =  $getRider->user_id;
                    $blaster->phone_number  =  $checkClient->guardian_contact_number;
                    $blaster->sms_trans_id  =  $sms->trans_id;
                    $blaster->otp_type      =  "SCANNED NOTIFICATION";
                    $blaster->sms_status    =  "SAVED";
                    $blaster->save();

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
                $checkClientTransaction = TransactionModel::where('id', $request->trans_id)
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

    public function event_list_for_attendance($token) // id_organization was used here
    {
        try {
            $check_admin = OrganizationInformationModel::join('users', 'organization_information.user_id', '=', 'users.user_id')
                ->where('organization_information.id', $token)
                ->where('users.id_account_type', 1)
                ->select(
                    'organization_information.id AS org_id',
                    'users.id_account_type AS account_type'
                )
                ->first();

            if ($check_admin) {
                $event_organizations = EventOrganizationsModel::join('events', 'event_organizations.id_event', '=', 'events.id')
                    ->where('events.tag', 0)
                    ->where('events.status', 1)
                    ->where('event_organizations.id_organization', $check_admin->org_id)
                    ->select(
                        'event_organizations.id AS id',
                        DB::raw("DATE_FORMAT(events.event_date, '%b %d, %Y') AS events_date"),
                        DB::raw("CONCAT(TIME_FORMAT(events.time_start, '%h:%i %p'), ' - ', TIME_FORMAT(events.time_end, '%h:%i %p')) AS events_time"),
                        "events.event_name",
                        "events.event_location AS location",
                        "events.google_map_link AS gmap"
                    )
                    ->get();

                return response()->json($event_organizations);
            } else {
                return response()->json(["error" => "Unauthorized access."], 500);
            }
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    public function attendance(Request $content)
    {
        $request = json_decode($content->getContent());

        try {
            $checkDuplicates = EventAttendanceModel::where('id_event_organization', $request->id_event_organization)
                ->where('id_individual', $request->id_individual)
                ->get()
                ->count();

            if ($checkDuplicates == 0) {
                $attendance = EventAttendanceModel::create([
                    'id_event_organization' => $request->id_event_organization,
                    'id_individual'         => $request->id_individual
                ]);

                return response()->json($attendance);
            } else {
                return response()->json(['error' => 'Duplicate entry.'], 500);
            }
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }
}
