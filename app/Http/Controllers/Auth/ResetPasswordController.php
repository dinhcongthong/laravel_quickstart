<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PasswordReset;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function showResetForm ($token = '') {
        $password_reset = PasswordReset::whereToken($token)->firstOrFail();
        return view('auth.passwords.reset', ['token' => $token]);
    }

    public function reset (Request $request) {
        $data = $request->except('_token');

        $password_reset = PasswordReset::where('token', $data['token'])->first();
        if (is_null($password_reset)) {
            return back()->withInput()->withErrors(['password' => 'Sorry! Your account is not available']);
        }

        // update new password
        $new_password = Hash::make($data['password']);
        $user = User::whereEmail($password_reset->email)->update(['password' => $new_password]);
        // delete record of password_resets table
        $password_reset->delete();

        return 'Your password was changed successfully!. Please click link below to go home <br><a href = "' . route('home') .'">' . route('home') . '</a>';
    }
}
