<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\VerifyUser;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

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
    protected $redirectTo = RouteServiceProvider::HOME;

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
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'numeric'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    // create a record for user table from request and send email
    public function register (Request $request) {
        $data = $request->all();
        // return $data;
        $status = '';

        $verify_code = Str::uuid();

        $user = User::create([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'verify_code' => $verify_code,
            'password' => Hash::make($data['password']),
        ]);

        // send mail
        Mail::to($data['email'])->send(new VerifyUser ($verify_code));

        if (!Mail::failures()) {
            $status = 'We have sent an authentication link to your email. Please check and confirm your account.';
        } else {
            return back()->withInput()->withErrors(['errors' => 'Sorry your email was error we can not send verify email for you!']);
        }

        return view('auth.verify', ['status' => $status]);
    }

    public function verify ($verify_code) {
        $user = User::where('verify_code', $verify_code)->firstOrFail()->update(['verify_code' => null]);
        return 'Your account was verified. Please click link below to go home <br><a href = "' . route('home') .'">' . route('home') . '</a>';
    }
}
