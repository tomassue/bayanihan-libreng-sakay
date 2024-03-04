<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ClientInformationModel;
use App\Models\EventOrganizationRidersModel;
use App\Models\IndividualInformationModel;
use App\Models\OrganizationInformationModel;
use Illuminate\Http\Client\Request;
use App\Models\TransactionModel;
use Illuminate\Support\Facades\Crypt;
use App\Models\User;
use BaconQrCode\Encoder\QrCode;
use Exception;

class ProfileController extends Controller
{
    // Individual
    public $user;
    public $user_id, $user_data, $full_name, $contact_number, $organization, $indi_id, $user_type;

    // Function encrypt($text_data)
    private string $encryptMethod = 'AES-256-CBC';
    private string $key;
    private string $iv;

    public function index($token)
    {
        try {
            if ($this->checkToken($token)) {
                $decrypt_token = Crypt::decryptString($token);

                $is_auth = User::where('api_token', $decrypt_token)->first();

                if ($is_auth && ($is_auth->id_account_type == '2')) {
                    // Individual
                    $organization_info = OrganizationInformationModel::where('id', $this->organization)->first();

                    $totalTripCount = TransactionModel::join('event_organization_riders', 'transactions.id_event_organization_riders', '=', 'event_organization_riders.id')
                        ->where('event_organization_riders.id_individual', $this->indi_id)
                        ->count();

                    $clientServedCount = TransactionModel::join('event_organization_riders', 'transactions.id_event_organization_riders', '=', 'event_organization_riders.id')
                        ->where('event_organization_riders.id_individual', $this->indi_id)
                        ->count();

                    $eventsJoinedCount = EventOrganizationRidersModel::where('event_organization_riders.id_individual', $this->indi_id)
                        ->count();

                    return response()->json([
                        'fullname'          => $this->full_name,
                        'contact'           => $this->contact_number,
                        'organization'      => $organization_info->organization_name,
                        'totalTripCount'    => $totalTripCount,
                        'clientServedCount' => $clientServedCount,
                        'eventsJoinedCount' => $eventsJoinedCount
                    ]);
                } elseif ($is_auth && ($is_auth->id_account_type == '3')) {
                    // Client
                    $totalTripCount = TransactionModel::where('id_client', $this->indi_id)
                        ->count();

                    return response()->json([
                        'fullname'         =>  $this->full_name,
                        'userType'         =>  ucfirst(trans($this->user_type)),
                        'totalTripCount'   =>  $totalTripCount
                    ]);

                    // return response()->json($totalTripCount);
                }
                // return response()->json($this->indi_id);
            } else {
                return response()->json(['error' => 'User not found.'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong.'], 500);
        }
    }

    private function checkToken($token)
    {
        try {
            $decrypt_token = Crypt::decryptString($token);

            $is_auth = User::where('api_token', $decrypt_token)->first();

            if ($is_auth && ($is_auth->id_account_type == '2')) {
                $is_rider = IndividualInformationModel::join('users', 'individual_information.user_id', '=', 'users.user_id')
                    ->where('individual_information.user_id', $is_auth->user_id)
                    ->select(
                        'individual_information.id',
                        'individual_information.user_id AS user_id',
                        'individual_information.first_name AS first_name',
                        'individual_information.middle_name AS middle_name',
                        'individual_information.last_name AS last_name',
                        'individual_information.ext_name AS ext_name',
                        'users.contactNumber',
                        'individual_information.id_organization',
                    )
                    ->first();

                $this->user             =   $is_rider;
                $this->user_id          =   $is_rider->user_id;
                $this->full_name        =   $is_rider->first_name . ' ' . $is_rider->middle_name . ' ' . $is_rider->last_name . ' ' . $is_rider->ext_name;
                $this->contact_number   =   $is_rider->contactNumber;
                $this->organization     =   $is_rider->id_organization;
                $this->indi_id          =   $is_rider->id;

                return true;
            } elseif ($is_auth && ($is_auth->id_account_type == '3')) {
                $is_client = ClientInformationModel::join('users', 'client_information.user_id', '=', 'users.user_id')
                    ->where('client_information.user_id', $is_auth->user_id)
                    ->select(
                        'client_information.id',
                        'client_information.user_id AS user_id',
                        'client_information.first_name AS first_name',
                        'client_information.middle_name AS middle_name',
                        'client_information.last_name AS last_name',
                        'client_information.ext_name AS ext_name',
                        'users.contactNumber',
                        'client_information.user_type',
                    )
                    ->first();

                $this->user             =   $is_client;
                $this->user_id          =   $is_client->user_id;
                $this->full_name        =   $is_client->first_name . ' ' . $is_client->middle_name . ' ' . $is_client->last_name . ' ' . $is_client->ext_name;
                $this->contact_number   =   $is_client->contactNumber;
                $this->user_type        =   $is_client->user_type;
                $this->indi_id          =   $is_client->id;

                return true;
            }
            return response()->json($is_auth);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    private function encrypt($text_data): string
    {
        $mykey = 'CagayanDeOroIctQrCode';
        $myiv = 'ThisIsASecuredBlock';
        $this->key = substr(hash('sha256', $mykey), 0, 32);
        $this->iv = substr(hash('sha256', $myiv), 0, 16);
        $ciphertext_raw = openssl_encrypt($text_data, $this->encryptMethod, $this->key, 0, $this->iv);

        return $ciphertext_raw;
    }

    public function generateQRCode($token)
    {
        try {
            if ($this->checkToken($token)) {
                // $u_id   = $this->user_id;
                $u_id   = $this->indi_id;
                $f_name = str_replace(',', '|', $this->full_name);
                $c_number = $this->contact_number;

                $to_incrypt = $u_id . ',' . $f_name . ',' . $c_number;
                $value = $this->encrypt($to_incrypt);

                return response()->json(["qr_code" => $value, "name" => $f_name, "c_number" => $c_number]);
            } else {
                return response()->json(['error' => 'Unauthorized.'], 500);
            }
        } catch (\Exception $e) {
            // return response()->json(['error' => 'Something went wrong.'], 500);
            return response()->json($e->getMessage());
        }
    }
}
