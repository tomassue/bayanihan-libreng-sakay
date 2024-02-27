<?php

namespace App\Http\Controllers;

use App\Models\NumberMessageModel;
use App\Models\SmsSenderModel;
use Illuminate\Http\Request;
use SmsSender;

class NumberMessageModelController extends Controller
{
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $generator = "1357902468";
        $result = "";

        for ($i = 1; $i <= 6; $i++) {
            $result .= substr($generator, (rand() % (strlen($generator))), 1);
        }

        $otp = $result;

        if ($request->phone_number) {
            try {
                $sms = new SmsSenderModel();
                $blaster = new NumberMessageModel();

                $welcome = "BAYANIHAN LIBRENG SAKAY INFO: YOUR SECRET OTP IS: " . $otp;
                $sms->trans_id = time() . '-' . mt_rand();
                $sms->received_id = "BAYANIHAN-LIBRENG-SAKAY-OTP";
                $sms->recipient = $request->phone_number;
                $sms->recipient_message = $welcome . " \nDO NOT REPLY";
                $sms->save();

                $blaster->phone_number  =  $request->phone_number;
                $blaster->otp_code      =  $otp;
                $blaster->sms_trans_id  =  $sms->trans_id;
                $blaster->otp_type      =  "RESET";
                $blaster->sms_status    =  "SAVED";
                $blaster->save();

                return response()->json(["message" => "success", "code" => 1]);
            } catch (\Exception $e) {
                $blaster->sms_status =  "NOT SAVED: " . $e;
                $blaster->save();

                return response()->json("Not Send", 404);
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(NumberMessageModel $numberMessageModel)
    {
        //
    }

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
