<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ClientInformationModel;
use App\Models\IndividualInformationModel;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Contracts\Encryption\DecryptException;

class LoginController extends Controller
{
    public $user;

    public function login(Request $request)
    {
        try {
            $user = User::where('email', $request->email)->first();

            if ($user->id_account_type == '2') { // Rider or Individual

                $individual_information = IndividualInformationModel::join('users', 'individual_information.user_id', '=', 'users.user_id')
                    ->select('individual_information.*', 'users.id AS userID', 'users.id_account_type AS account_type')
                    ->where('users.user_id', $user->user_id)
                    ->where('users.status', 1) // ADDED this. Individual with this value will not be able to login.
                    ->first();

                if ($user != '[]' && Hash::check($request->password, $user->password)) {
                    $user->api_token = Str::random(16) . $user->user_id;
                    $user->save();
                    $token = Crypt::encryptString($user->api_token);
                    return response()->json(["api_token" => $token, "account_type" => $individual_information->account_type, "name" => $individual_information->first_name . " " . $individual_information->last_name], 200);
                } else {
                    return response()->json("User not found.", 404);
                }
            } elseif ($user->id_account_type == '3') { // Clients

                $client_information = ClientInformationModel::join('users', 'client_information.user_id', '=', 'users.user_id')
                    ->select('client_information.*', 'users.id AS userID', 'users.id_account_type AS account_type')
                    ->where('users.user_id', $user->user_id)->first();

                if ($user != '[]' && Hash::check($request->password, $user->password)) {
                    $user->api_token = Str::random(16) . $user->user_id;
                    $user->save();
                    $token = Crypt::encryptString($user->api_token);
                    return response()->json(["api_token" => $token, "account_type" => $client_information->account_type, "name" => $client_information->first_name . " " . $client_information->last_name], 200);
                } else {
                    return response()->json("User not found.", 404);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Your account is not yet approved.'], 500);
            // return response()->json($e->getMessage(), 500);
        }
    }

    public function checkUser($token)
    {
        if ($this->checkToken($token)) {
            return response()->json(['message' => 'Active session'], 200);
        } else {
            return response()->json(['message' => 'Session expired'], 500);
        }
    }

    private function checkToken($token)
    {
        try {
            $decrypt_token = Crypt::decryptString($token);
            $is_auth = User::where('api_token', $decrypt_token)->first();

            if ($is_auth) {
                $this->user = $is_auth;
                return true;
            }
            return false;
        } catch (DecryptException $e) {
            return false;
        }
    }
}
