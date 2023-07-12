<!DOCTYPE html>
<html>
<head>
    <title>Password Reset</title>
</head>
<body>
    <h2>Reset Your Password</h2>
    <p>Hi {{ $users->name }},</p>
    <p>You are receiving this email because we received a password reset request for your account.</p>
    <p>Please click the following link to reset your password:</p>
    <a href="{{ route('password.reset', ['token' => $token]) }}">Reset Password</a>
    <p>If you did not request a password reset, no further action is required.</p>
    <p>Regards,</p>
    <p>Your Website Team</p>
</body>
</html>
