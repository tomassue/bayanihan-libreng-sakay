<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EventOrganizationRidersModel;
use App\Models\EventOrganizationsModel;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    // Individual
    public $user;
    public $user_id, $user_data, $full_name, $contact_number, $indi_id, $id_org;

    public function index($token)
    {
        try {
            if ($this->checkToken($token)) {
                $id = $this->indi_id;

                $listOfEvent = EventOrganizationsModel::join('organization_information', 'event_organizations.id_organization', '=', 'organization_information.id')
                    ->join('events', 'event_organizations.id_event', '=', 'events.id')
                    ->where('events.tag', 0)
                    ->where('event_organizations.id_organization', $this->id_org)
                    ->select("event_organizations.id", "events.event_date", "events.event_name")
                    ->whereNotExists(function ($query) use ($id) {
                        $query->select(DB::raw(1))
                            ->from('event_organization_riders')
                            ->whereRaw('event_organization_riders.id_event_organization = event_organizations.id')
                            ->where('event_organization_riders.id_individual', $id);
                    })
                    ->get();

                // return response()->json($id);
                return response()->json($listOfEvent);
            } else {
                return response()->json(["error" => 'User not found.'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong.'], 500);
            // return response()->json($e->getMessage());
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

    public function joinEvent(Request $content)
    {
        $request = json_decode($content->getContent());

        try {
            if ($this->checkToken($request->token)) {
                // Save to event_organization_riders
                $event_organization_riders                           = new EventOrganizationRidersModel();
                $event_organization_riders->id_event_organization    = $request->event->id;
                $event_organization_riders->id_individual            = $this->indi_id;
                $event_organization_riders->save();
            } else {
                return response()->json(['error' => 'User not found.'], 500);
            }
        } catch (\Exception $e) {
            // return response()->json(['error' => 'Something went wrong.'], 500);
            return response()->json($e->getMessage(), 500);
        }
    }

    public function joinedEvents($token)
    {
        try {
            if ($this->checkToken($token)) {
                $id = $this->indi_id;

                $listofJoinedEvents = EventOrganizationRidersModel::join('event_organizations', 'event_organization_riders.id_event_organization', '=', 'event_organizations.id')
                    ->join('organization_information', 'event_organizations.id_organization', '=', 'organization_information.id')
                    ->join('events', 'event_organizations.id_event', '=', 'events.id')
                    ->where('events.tag', 0)
                    ->where('event_organizations.id_organization', $this->id_org)
                    ->where('event_organization_riders.id_individual', $id)
                    ->select('event_organization_riders.id AS id', "events.event_date", "events.event_name")
                    ->get();

                return response()->json($listofJoinedEvents);
            } else {
            }
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }
}
