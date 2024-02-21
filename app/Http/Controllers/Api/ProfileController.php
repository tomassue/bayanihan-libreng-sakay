<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EventOrganizationRidersModel;
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
    public $user_id, $user_data, $full_name, $contact_number, $indi_id;

    // Function encrypt($text_data)
    private string $encryptMethod = 'AES-256-CBC';
    private string $key;
    private string $iv;

    public function index($token)
    {
        try {
            if ($this->checkToken($token)) {
                // Individual
                $totalTrip = TransactionModel::join('event_organization_riders', 'transactions.id_event_organization_riders', '=', 'event_organization_riders.id')
                    ->where('event_organization_riders.id_individual', $this->indi_id)
                    ->count();

                $clientServed = TransactionModel::join('event_organization_riders', 'transactions.id_event_organization_riders', '=', 'event_organization_riders.id')
                    ->where('event_organization_riders.id_individual', $this->indi_id)
                    ->count();

                $eventsJoined = EventOrganizationRidersModel::where('event_organization_riders.id_individual', $this->indi_id)
                    ->count();

                return response()->json([$totalTrip, $clientServed, $eventsJoined]);
                // return response()->json($this->contact_number);
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
                return true;
            }
            return false;
        } catch (\Exception $e) {
            return false;
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
                $u_id   = $this->user_id;
                $f_name = str_replace(',', '|', $this->full_name);
                $c_number = $this->contact_number;

                $to_incrypt = $u_id . ',' . $f_name . ',' . $c_number;
                $value = $this->encrypt($to_incrypt);

                return response()->json(["qr_code" => $value, "name" => $f_name, "c_number" => $c_number]);
            } else {
                return response()->json(['error' => 'Something went wrong.'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong.'], 500);
        }
    }
}
