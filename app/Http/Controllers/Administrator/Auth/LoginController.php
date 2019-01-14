<?php

namespace App\Http\Controllers\Administrator\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;
use App\Models\Administrator;
use Validator;
use Auth;

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
    protected $redirectTo = 'administrator/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function guard(){
        return Auth::guard('administrator');
    }

    public function loginForm(request $request){
        return view('administrator._loginpage.index', compact('request'));
    }

    public function loginAction(request $request){
        $email = $request->input('email');
        $password = $request->input('password');

        $message = [
          'email.required' => 'This field is required.',
          'email.email' => 'Email format not valid',
          'password.required' => 'This field is required.',
        ];

        $validator = Validator::make($request->all(), [
          'email' => 'required|email',
          'password' => 'required',
        ], $message);

        if($validator->fails())
        {
          return redirect()->route('adm.auth.login.from')->withErrors($validator)->withInput();
        }

        if (Auth::guard('administrator')->attempt(['email' => $email, 'password' => $password, 'confirmed'=>'Y' ]))
        {
            $set = Administrator::find(Auth::guard('administrator')->user()->id);
            $getCounter = $set->login_count;
            $set->login_count = $getCounter+1;
            $set->update();

            return redirect()->route('adm.mid.dashboard');
        }
        else
        {
            return redirect()->route('adm.auth.login.from')->with('status', 'Your account is not active or wrong password')->withInput();
        }
    }

    public function logout(){
        auth()->guard('administrator')->logout();
        return redirect()->route('adm.auth.login.from')->with('notif', 'Anda Telah Log Out...!');
    }
}
