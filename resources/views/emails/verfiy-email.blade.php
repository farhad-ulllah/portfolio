<!DOCTYPE html>
<html>

<head>
    <title>Verify Email Address</title>
    <style>
        /* CSS styles for the email template */
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }

        h1 {
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
        }

        p {
            color: #666;
            font-size: 16px;
            line-height: 1.5;
            margin-bottom: 10px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .logo {
            display: block;
            max-width: 150px;
            margin-bottom: 20px;
        }

        .signature {
            font-style: italic;
            color: #888;
        }
    </style>
</head>

<body>
    <div class="container">
        <img class="logo" src="path_to_your_logo" alt="Your Logo">
        <h1>Verify Your Email Address</h1>
        <p>You have successfully created an account with us. Please use the link below to verify your email.</p>
        <p><a class="btn" href="{{ $verificationUrl }}">Verify Account</a></p>
        <p>This link is only valid for the next 24 hours.</p>
        <p>Please never share this link with anyone. If you haven't registered with us, please ignore this email.</p>
        <p class="signature">Thanks,<br>Team</p>
    </div>
</body>

</html>
