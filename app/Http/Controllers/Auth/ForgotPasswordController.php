<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ForgotPassword;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */
    use SendsPasswordResetEmails;

    public function sendResetLinkEmail (Request $request) {
        // get token from request to check email
        $token = $request->_token;
        // get email from request
        $email = $request->email;
        $user = User::whereEmail($email)->first();
        if (is_null($user)) {
            return back()->withInput()->withErrors(['errors' => 'Sorry! Your email is not available. Please check again']);
        }

        // create a record for password reset table
        $password_reset_data = [
            'email' => $email,
            'token' => $token
        ];
        $password_reset = PasswordReset::create($password_reset_data);

        if (!$password_reset) {
            return back()->withInput()->withErrors(['errors' => 'Sorry! Some errors when proccessing. Please try again']);
        }
        
        // send mail
        Mail::to($email)->send(new ForgotPassword ($token));
        if (!Mail::failures()) {
            $status = 'We have sent an authentication link to your email. Please check and confirm your account.';
        } else {
            return back()->withInput()->withErrors(['errors' => 'Sorry your email was error we can not send verify email for you!']);
        }
        return view('auth.verify', ['status' => $status]);
    }
}
