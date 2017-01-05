<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h2>Reset Your account password</h2>

        <div>
            Please follow the link below to reset your password
            <a href="{{route('reset-password-form',$confirmation_code)}}">{{route('reset-password-form',$confirmation_code)}}</a>.<br/>

        </div>

    </body>
</html>