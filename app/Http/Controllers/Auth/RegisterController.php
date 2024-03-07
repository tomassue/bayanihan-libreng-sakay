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

use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

use App\Rules\ReCaptchaV3;


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
    protected $redirectTo = '/success-page';

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
                'contactNumber'         => ['required', 'numeric', 'digits:11', 'unique:users'],

                'email'                 => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/',
                    'confirmed'
                ],

                'g-recaptcha-response' => ['required', new ReCaptchaV3('submitRegistration')],
            ]);
        } elseif ($data['accountType'] == '2') {
            // INDIVIDUAL
            return Validator::make($data, [
                'accountType'           => ['required', 'string', 'max:1'],
                'lastName'              => ['required', 'string'],
                'firstName'             => ['required', 'string'],
                'middleName'            => ['string', 'nullable'],
                'contactNumber'         => ['required', 'numeric', 'digits:11', 'unique:users'],
                'address'               => ['required'],
                'organization'          => ['required'],

                'email'                 => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/',
                    'confirmed'
                ],

                'g-recaptcha-response' => ['required', new ReCaptchaV3('submitRegistration')],
            ]);
        } elseif ($data['accountType'] == '3') {
            // dd('WAKA WAKA 3');
            // CLIENT
            return Validator::make($data, [
                'accountType'           => ['required', 'string', 'max:1'],
                'userType'              => ['required', 'string'],
                'lastName'              => ['required', 'string'],
                'firstName'             => ['required', 'string'],
                'middleName'            => ['string', 'nullable'],
                'birthday'              => ['required'],
                'contactNumber'         => ['required', 'numeric', 'digits:11', 'unique:users'],
                'address'               => ['required'],
                'school'                => ['required'],
                'guardianName'          => ['required'],
                'guardianNumber'        => ['required', 'numeric', 'digits:11', 'unique:users'],

                'email'                 => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/',
                    'confirmed'
                ],

                'g-recaptcha-response' => ['required', new ReCaptchaV3('submitRegistration')],
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
        $user_id = strtoupper($timestamp . $randomString);

        // SAVE to organization information if the account type is 1.
        if ($data['accountType'] == '1') {

            $user = User::create([
                'user_id'           =>      $user_id,
                'email'             =>      $data['email'],
                'contactNumber'     =>      $data['contactNumber'],
                'id_account_type'   =>      $data['accountType'],
                'password'          =>      Hash::make($data['password']),
            ]);

            OrganizationInformationModel::create([
                'user_id'               =>          $user_id,
                'organization_name'     =>          $data['organizationName'],
                'date_established'      =>          $data['dateEstablished'],
                'address'               =>          $data['address'],
            ]);
            // SAVE to individual information if the account type is 2.
        } elseif ($data['accountType'] == '2') {

            $user = User::create([
                'user_id'           =>      $user_id,
                'email'             =>      $data['email'],
                'contactNumber'     =>      $data['contactNumber'],
                'id_account_type'   =>      $data['accountType'],
                'password'          =>      Hash::make($data['password']),
            ]);

            IndividualInformationModel::create([
                'user_id'               => $user_id,
                'last_name'             => $data['lastName'],
                'first_name'            => $data['firstName'],
                'middle_name'           => $data['middleName'],
                'sex'                   => $data['sex'],
                'ext_name'              => $data['extensionName'],
                'address'               => $data['address'],
                'id_organization'       => $data['organization'],
            ]);
            // SAVE to client information if the account type is 3.
        } elseif ($data['accountType'] == '3') {

            $user = User::create([
                'user_id'           =>      $user_id,
                'email'             =>      $data['email'],
                'contactNumber'     =>      $data['contactNumber'],
                'id_account_type'   =>      $data['accountType'],
                'password'          =>      Hash::make($data['password']),
                'status'            =>      1,
            ]);

            ClientInformationModel::create([
                'user_id'                  => $user_id,
                'user_type'                => $data['userType'],
                'last_name'                => $data['lastName'],
                'first_name'               => $data['firstName'],
                'middle_name'              => $data['middleName'],
                'ext_name'                 => $data['extensionName'],
                'birthday'                 => $data['birthday'],
                'address'                  => $data['address'],
                'id_school'                => $data['school'],
                'guardian_name'            => $data['guardianName'],
                'guardian_contact_number'  => $data['guardianNumber'],
            ]);
        }
        return $user;
    }

    /**
     * Handle a registration request for the application.
     * 
     * Overwrites the default behavior of after registration. In this new method, the user after registration will be redirected to a certain page but won't create auth sessions.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        // Validate the incoming request
        $this->validator($request->all())->validate();

        // Create the user instance without logging them in
        $user = $this->create($request->all());

        // Fire the Registered event
        event(new Registered($user));

        if ($request['accountType'] == '3') {
            // dd($user->id);

            return redirect()->route('qr', ['ClientUserID' => encrypt($user->user_id)]);

            // After registration, I retrieved the user_id (from users) of the recent saved data under client's category. I'll send this data to the controller where it will find the id from client_information and perform the encryption and generation of QR code.
            // return redirect()->route('get-my-qr', ['ClientUserID' => encrypt($user->user_id)]);
        } else {
            // Optionally, you can add a flash message here or perform any other actions
            session()->flash('status', 'Registered successfully.');

            // Redirect the user to the desired page after registration
            return redirect('/login');
        }
    }
}
