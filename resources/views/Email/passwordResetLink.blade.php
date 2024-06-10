{{--<a href="localhost:5173/setNewPassword">Verify Email</a>--}}
<html>
<head>
    <title>Reset Password Email</title>
</head>

<body style="max-width: 600px;  background-color: rgb(236, 236, 236); margin: auto; padding: 3%;">
<h1 style="width: 80%; border-radius: 10px 10px 0px 0px; color: white; background-color: #15141F; margin: auto; text-align: center; padding: 6%;">
    Reset Password</h1>
<div style="background-color:white; padding: 6%; width: 80%; margin: auto;">
    <p style="margin-bottom: 6%;text-align:center;">It's normal to forget passwords, that is why we got you covered!</p>
    <p style="margin-bottom: 6%;text-align:center;">Please click on the button below to reset your password</p>
    <div style="width:20%;margin:0px auto;">
        <a href="{{ route('password.reset', $token) }}" style="border-radius: 9px; text-decoration: none; padding: 5%; box-sizing:border-box; color:black; background-color: #F1C51A;width:100%;display:block;text-align:center;">Reset</a>
    </div>
    <p style="text-align:center;"> Or copy the link below and paste in a tab of your browser</p>
    <a style="text-align:left; display:block;"
       href="{{ route('password.reset', $token) }}">{{ route('password.reset', $token) }}</a>
</div>
<p style="width: 100%; text-align: center; color: rgba(24, 130, 228, 0.4); font-size: medium;">Sent
    by {{ config('app.name') }}</p>
<p style="width: 100%; text-align: center; color: rgba(0, 0, 0, 0.4);">Copyright @2023 {{ config('app.name') }}</p>
</body>
