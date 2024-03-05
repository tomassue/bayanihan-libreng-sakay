<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ClientInformationModel;
use App\Models\SchoolInformationModel;
use App\Models\User;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegistrationController extends Controller
{

    /**
     * IMPORTANT ASPECTS TO CONSIDER:
     * 
     * 1. Error Handling: You catch Exception but you're not doing anything with it. If you're planning to handle specific exceptions, you should have more specific exception handling or at least log the exceptions for debugging purposes.
     * 2. Response Handling: After validation, you need to define what happens next. Typically, you would create a new user if validation passes, or return validation errors if it fails.
     * 3. Dependency Injection: It's recommended to type-hint the Validator class in your validator method instead of using ::make directly. This allows for easier testing and potential future changes in how the validation is handled.
     * 4. Namespace and Use Statements: Ensure that the namespace App\Http\Controllers\Api; matches the directory structure where this controller resides. Also, ensure that you have imported necessary classes such as Validator, Request, and Exception.
     * 5. Error Reporting: When validation fails, you should return an appropriate response with validation errors. Laravel provides convenient methods for this purpose like withErrors() or response()->json() depending on your use case.
     */

    protected $validator;

    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    protected function validator(array $data)
    {
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
            'password'              => [
                'required',
                'string',
                'min:8',
                'regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/',
                'confirmed'
            ],
        ]);
    }

    public function register(Request $content)
    {
        $request = json_decode($content->getContent());
        // return $request->userType;
        try {
            // // Validate the incoming request data
            // $validator = $this->validator($request->all());

            // // Check if validation fails
            // if ($validator->fails()) {
            //     // Return validation errors with status code 422
            //     return response()->json(['errors' => $validator->errors()], 422);
            // }

            // Generate random letters and numbers for doctype_code
            $timestamp = now()->timestamp;
            $randomString = Str::random(10);
            $user_id = strtoupper($timestamp . $randomString);

            // Create the client (user) credentials
            $user_cred                  = new User();
            $user_cred->user_id         = $user_id;
            $user_cred->email           = $request->email;
            $user_cred->contactNumber   = $request->contactNumber;

            $user_cred->id_account_type = 3;
            $user_cred->password        = Hash::make($request->password);
            $user_cred->status          = 1;
            $user_cred->save();

            // Create client's other information
            $client_info                           = new ClientInformationModel();
            $client_info->user_id                  = $user_id;
            $client_info->user_type                = $request->userType;
            $client_info->last_name                = $request->lastName;
            $client_info->first_name               = $request->firstName;
            $client_info->middle_name              = $request->middleName;
            $client_info->ext_name                 = $request->extensionName;
            $client_info->birthday                 = $request->birthday;
            $client_info->address                  = $request->address;
            $client_info->id_school                = $request->school;
            $client_info->guardian_name            = $request->guardianName;
            $client_info->guardian_contact_number  = $request->guardianNumber;
            $client_info->save();

            // Return success prompt
            return response()->json(['message' => 'Client registered successfully', 'code' => 200], 200);
        } catch (\Exception $e) {

            // Handle exception, log it, or return an error response
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getSchool(Request $request)
    {
        $school = SchoolInformationModel::all();
        return response()->json($school);
    }
}
