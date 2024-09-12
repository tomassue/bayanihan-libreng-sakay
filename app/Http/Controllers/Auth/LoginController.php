<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException; // Import the ValidationException class

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/np/registration'; // Redirect to new process temporarily

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // The following methods validates the user login if the status column is 1.
    protected function credentials(Request $request)
    {
        return [
            $this->username() => $request->input($this->username()),
            'password' => $request->input('password'),
            'status' => 1, // Only allow login if the user's status is 1
            'id_account_type' => ['admin', '1'], // Allow login when the column has values admin or 1.
            'default_password' => ($request->input('password') == 'password' ? session(['default_password' => 'default_password']) : NULL)
        ];
    }

    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            $this->credentials($request),
            $request->filled('remember')
        );
    }

    // Override the default logout method
    public function logout(Request $request)
    {
        $request->session()->forget('default_password'); # Forget the session that will be made if the user's password used to log in is the default password.

        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect('/login'); // Specify your custom redirect path here after logout.
    }
}
