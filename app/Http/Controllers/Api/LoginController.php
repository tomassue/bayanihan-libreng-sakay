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

class LoginController extends Controller
{
    public function login(Request $request)
    {
        try {
            $user = User::where('email', $request->email)->first();

            if ($user->id_account_type == '2') { // Rider or Individual

                $individual_information = IndividualInformationModel::where('user_id', $user->user_id)->first();

                if ($user != '[]' && Hash::check($request->password, $user->password)) {
                    $user->api_token = Str::random(16) . $user->user_id;
                    $user->save();
                    $token = Crypt::encryptString($user->api_token);
                    return response()->json(["api_token" => $token, "name" => $individual_information->first_name . " " . $individual_information->last_name], 200);
                } else {
                    return response()->json("User not found.", 404);
                }
            } elseif ($user->id_account_type == '3') { // Clients

                $client_information = ClientInformationModel::where('user_id', $user->user_id)->first();

                if ($user != '[]' && Hash::check($request->password, $user->password)) {
                    $user->api_token = Str::random(16) . $user->user_id;
                    $user->save();
                    $token = Crypt::encryptString($user->api_token);
                    return response()->json(["api_token" => $token, "name" => $client_information->first_name . " " . $client_information->last_name], 200);
                } else {
                    return response()->json("User not found.", 404);
                }
            }
        } catch (\Exception $e) {
            return response()->json($request->email, 500);
            // return response()->json($e->getMessage(), 500);
        }
    }
}