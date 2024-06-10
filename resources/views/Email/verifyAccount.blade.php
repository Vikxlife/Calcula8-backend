<html>
<head>
    <title>Verify Email</title>
</head>

<body style="max-width: 600px;  background-color: rgb(236, 236, 236); margin: auto; padding: 3%;">
<img src="../assets/images/logo.png" alt="" height="70px" style="margin-left: 44%;">
<h1 style="width: 80%; border-radius: 10px 10px 0px 0px; color: white; background-color: #15141F; margin: auto; text-align: center; padding: 6%;">
    Welcome to Calcul8!</h1>
<div style="background-color:white; padding: 6%; width: 80%; margin: auto;">
    <h3 style="text-align:center;">Thank you for registering with us.</h3>
    <p style="margin-bottom: 6%;text-align:center;">Your otp is:</p>
    <h2 style="text-align:center;">{{ $token }}</h2>
    <p style="margin-bottom: 6%;text-align:center;">Please make use of it within 5 minutes!</p>
</div>
<p style="width: 100%; text-align: center; color: rgba(24, 130, 228, 0.4); font-size: medium;">{{ config('app.name') }}</p>
<p style="width: 100%; text-align: center; color: rgba(0, 0, 0, 0.4);">Copyright @2023 {{ config('app.name') }}</p>
</body>
