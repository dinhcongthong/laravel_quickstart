<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h2>Reset Your Password</h2>

        <div>
            Please click this link to reset your password and don't share for anyone this is your security link<br>
            {{ route('password.reset', $token) }} 
        </div>

    </body>
</html>