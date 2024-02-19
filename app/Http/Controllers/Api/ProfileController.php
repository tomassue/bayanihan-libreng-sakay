<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Client\Request;
use App\Models\TransactionModel;
use Illuminate\Support\Facades\Crypt;
use App\Models\User;
use Exception;

class ProfileController extends Controller
{
    public $user;
    public $user_id = null, $user_data = null;

    public function index($token)
    {
        try {
            if ($this->checkToken($token)) {
                $totalTrip = TransactionModel::join('event_organization_riders', 'transactions.id_event_organization_riders', '=', 'event_organization_riders.id')
                    ->where('event_organization_riders.id_individual', 3)
                    ->count();

                return response()->json($totalTrip);
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

            if ($is_auth) {
                $this->user = $is_auth;
                $this->user_id = $is_auth->user_id;
                return true;
            }
            return false;
        } catch (\Exception $e) {
            return false;
        }
    }
}
