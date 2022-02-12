<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function logout() {
        Auth::logout();
        // clear all session
        session()->flush();
        return redirect()->route('home');
    }

    public function login (Request $request) {
        // get all data from request except _token
        $data = $request->except('_token');

        // check email
        $user = User::where('email', $data['email'])->first();
        if (!is_null($user->verify_code)) {
            return back()->withInput()->withErrors(['errors' => 'Sorry! Your email was not verified. Please check again']);
        }

        // check remember me and set remember data for user
        $request->has('remember') ? $data['remember'] = true : $data['remember'] = false;

        $auth = Auth::guard('web')->attempt([
            'email'  => $data['email'],
            'password'  => $data['password']
        ], $data['remember']);

        if (!$auth) {
            return back()->withInput()->withErrors(['errors' => 'Sorry! Your email or password incorrect. Please try again']);
        }

        return redirect()->route('home');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:email'],
            'password' => ['required', 'string', 'min:6', 'confirmed']
        ]);
    }
}
