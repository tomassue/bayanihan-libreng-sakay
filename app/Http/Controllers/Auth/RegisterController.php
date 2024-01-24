<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\IndividualInformationModel;
use App\Models\User;
use App\Models\OrganizationInformationModel;
use App\Models\ClientInformationModel;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str; //THIS IS FOR THE str::random()


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        if ($data['accountType'] == '1') {
            // ORGANIZATION
            return Validator::make($data, [
                'accountType'           => ['required', 'string', 'max:1'],
                'organizationName'      => ['required', 'string', 'max:255'],
                'dateEstablished'       => ['required'],
                'address'               => ['required', 'string'],
                'contactNumber'         => ['required', 'string', 'max:11'],

                'email'                 => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password'              => ['required', 'string', 'min:8', 'confirmed'],
            ]);
        } elseif ($data['accountType'] == '2') {
            // INDIVIDUAL
            return Validator::make($data, [
                'accountType'           => ['required', 'string', 'max:1'],
                'lastName'              => ['required', 'string'],
                'firstName'             => ['required', 'string'],
                'middleName'            => ['string', 'nullable'],
                'contactNumber'         => ['required'],
                'address'               => ['required'],
                'organization'          => ['required'],

                'email'                 => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password'              => ['required', 'string', 'min:8', 'confirmed'],
            ]);
        } elseif ($data['accountType'] == '3') {
            // dd('WAKA WAKA 3');
            // CLIENT
            return Validator::make($data, [
                'accountType'           => ['required', 'string', 'max:1'],
                'lastName'              => ['required', 'string'],
                'firstName'             => ['required', 'string'],
                'middleName'            => ['string', 'nullable'],
                'birthday'              => ['required'],
                'contactNumber'         => ['required'],
                'address'               => ['required'],
                'school'                => ['required'],
                'guardianName'          => ['required'],
                'guardianNumber'        => ['required'],

                'email'                 => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password'              => ['required', 'string', 'min:8', 'confirmed'],
            ]);
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        // Generate random letters and numbers for doctype_code
        $timestamp = now()->timestamp;
        $randomString = Str::random(10);
        $user_id = $timestamp . $randomString;

        // SAVE to organization information if the account type is 1.
        if ($data['accountType'] == '1') {

            // dd($data['accountType']);

            $user = User::create([
                'user_id'           =>      $user_id,
                'email'             =>      $data['email'],
                'id_account_type'   =>      $data['accountType'],
                'password'          =>      Hash::make($data['password']),
            ]);

            OrganizationInformationModel::create([
                'user_id'               =>          $user_id,
                'organization_name'     =>          $data['organizationName'],
                'date_established'      =>          $data['dateEstablished'],
                'address'               =>          $data['address'],
                'contact_number'        =>          $data['contactNumber'],
            ]);
            // SAVE to individual information if the account type is 2.
        } elseif ($data['accountType'] == '2') {

            $user = User::create([
                'user_id'           =>      $user_id,
                'email'             =>      $data['email'],
                'id_account_type'   =>      $data['accountType'],
                'password'          =>      Hash::make($data['password']),
            ]);

            IndividualInformationModel::create([
                'user_id'               => $user_id,
                'last_name'             => $data['lastName'],
                'first_name'            => $data['firstName'],
                'middle_name'           => $data['middleName'],
                'ext_name'              => $data['extensionName'],
                'contact_number'        => $data['contactNumber'],
                'address'               => $data['address'],
                'id_organization'       => $data['organization'],
            ]);
            // SAVE to client information if the account type is 3.
        } elseif ($data['accountType'] == '3') {

            $user = User::create([
                'user_id'           =>      $user_id,
                'email'             =>      $data['email'],
                'id_account_type'   =>      $data['accountType'],
                'password'          =>      Hash::make($data['password']),
            ]);

            ClientInformationModel::create([
                'user_id'                  => $user_id,
                'last_name'                => $data['lastName'],
                'first_name'               => $data['firstName'],
                'middle_name'              => $data['middleName'],
                'ext_name'                 => $data['extensionName'],
                'birthday'                 => $data['birthday'],
                'contact_number'           => $data['contactNumber'],
                'address'                  => $data['address'],
                'id_school'                => $data['school'],
                'guardian_name'            => $data['guardianName'],
                'guardian_contact_number'  => $data['guardianNumber'],
            ]);
        }
        return $user;
    }
}
