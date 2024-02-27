<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\IndividualInformationModel;
use App\Models\NumberMessageModel;
use App\Models\SmsSenderModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class NumberMessageController extends Controller
{
    public $user; // Stores the user_id

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    // public function check_contact_number($contactNumber)
    // {
    //     try {
    //         $check_contact_number = User::where('contactNumber', $contactNumber)
    //             ->first();

    //         if ($check_contact_number) {
    //             $this->store($contactNumber);
    //         }

    //         return response()->json($check_contact_number->user_id);
    //     } catch (\Exception $e) {
    //         return response()->json("NO RECORD FOUND");
    //     }
    // }

    // Function to generate OTP 
    function generateNumericOTP($n)
    {

        // Take a generator string which consist of 
        // all numeric digits 
        $generator = "1357902468";

        // Iterate for n-times and pick a single character 
        // from generator and append it to $result 

        // Login for generating a random character from generator 
        //     ---generate a random number 
        //     ---take modulus of same with length of generator (say i) 
        //     ---append the character at place (i) from generator to result 

        $result = "";

        for ($i = 1; $i <= $n; $i++) {
            $result .= substr($generator, (rand() % (strlen($generator))), 1);
        }

        // Return result 
        return $result;
    }

    /**
     * Store a newly created resource in storage.
     * 
     * We store the OTP process in a table
     */
    public function store($contactNumber)
    {
        // Check contact number if it exist.

        $check_user_contact_number = User::where('contactNumber', $contactNumber)
            ->first();

        if (!$check_user_contact_number) {
            return response()->json(['message' => 'Contact number does not exist.', 'code' => 404], 404);
        } else {
            $generator = "1357902468";
            $result = "";

            for ($i = 1; $i <= 6; $i++) {
                $result .= substr($generator, (rand() % (strlen($generator))), 1);
            }

            $otp = $result;

            if ($contactNumber) {
                try {
                    $sms = new SmsSenderModel();
                    $blaster = new NumberMessageModel();

                    $welcome = "BAYANIHAN LIBRENG SAKAY INFO: YOUR SECRET OTP IS: " . $otp;
                    $sms->trans_id = time() . '-' . mt_rand();
                    $sms->received_id = "BAYANIHAN-LIBRENG-SAKAY-OTP";
                    $sms->recipient = $contactNumber;
                    $sms->recipient_message = $welcome . " \nDO NOT REPLY";
                    $sms->save();

                    $blaster->user_id       =  $check_user_contact_number->user_id;
                    $blaster->phone_number  =  $contactNumber;
                    $blaster->otp_code      =  $otp;
                    $blaster->sms_trans_id  =  $sms->trans_id;
                    $blaster->otp_type      =  "RESET";
                    $blaster->sms_status    =  "SAVED";
                    $blaster->save();

                    return response()->json(["message" => "success", "code" => 200], 200);
                } catch (\Exception $e) {
                    $blaster->sms_status =  "NOT SAVED: " . $e;
                    $blaster->save();

                    return response()->json("Not Send", 404);
                }
            }
        }
    }

    public function show(Request $request)
    {
        $db = NumberMessageModel::where('phone_number', $request->phone_number)->where('otp_code', $request->otp)->where('is_verified', 0)->exists();

        if ($db) {
            // The record exists  
            $tot = NumberMessageModel::where('phone_number', $request->phone_number)
                ->where('otp_code', $request->otp)
                ->where('is_verified', 0)
                ->get(); // or ->first() if you expect only one record


            if ($tot->count() > 0) {
                $record = $tot->first();
                $record->is_verified = 1;
                $record->save();

                return response()->json([
                    'status' => 200,
                    'message' => 'Updated Successfully',
                    'error' => $db,
                    'number' => base64_encode($request->phone_number),
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'Description' => 'Data not Found',
                ]);
            }
        } else {
            // The record does not exist
            return response()->json([
                'error' => $db,
            ]);
        }
    }

    public function verify_otp(Request $content)
    {
        try {
            $request = json_decode($content->getContent());

            $verify = NumberMessageModel::where('phone_number', $request->contact_number)
                ->where('otp_code', $request->otp)
                ->latest() // latest() returns the latest data
                ->first(); // Use first() to actually execute the query

            if ($verify) {
                $user = User::where('user_id',  $verify->user_id)
                    ->first();

                $user->api_token = Str::random(16) . $user->user_id;
                $user->save();
                $token = Crypt::encryptString($user->api_token);

                return response()->json(['message' => 'Verified. Proceed to login.', 'code' => 200, 'token' => $token], 200);
                // return $this->new_password($content);
            } else {
                return response()->json(['message' => 'Invalid OTP code.', 'code' => 404], 404);
            }
        } catch (\Exception $e) {
            // return response()->json(['error' => 'Something went wrong.', 'code' => 404], 404);
            return response()->json($e->getMessage());
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

    public function new_password(Request $content)
    {
        try {
            $request = json_decode($content->getContent());

            if ($this->checkToken($request->token)) {
                $user = User::where('user_id', $this->user->user_id)
                    ->first();

                $user->update([
                    'password'  =>  Hash::make($request->password)
                ]);

                return response()->json(['message' => 'Your password has been changed successfully.', 'code' => 200], 200);
            } else {
                return response()->json(['error' => 'User not found.', 'code' => 404], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong.', 'code' => 404], 404);
            // return response()->json($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    // public function show(NumberMessageModel $numberMessageModel)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NumberMessageModel $numberMessageModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, NumberMessageModel $numberMessageModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NumberMessageModel $numberMessageModel)
    {
        //
    }
}
