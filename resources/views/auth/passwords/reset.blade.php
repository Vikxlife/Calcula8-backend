<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>

    <style>
        body { background-color: #f4f4f9;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .formstyle{
            padding: 1rem 3rem;
        }

        .container {
            width: 90%;
            max-width: 400px;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .password-reset-form {
            width: 100%;
        }

        .password-reset-form h2 {
            font-size: 2rem;
            margin-bottom: 1rem;
            text-align: center;
            color: #333;
        }

        .password-reset-form .form-group {
            margin-bottom: 1.5rem;
        }

        .password-reset-form .form-group label {
            font-weight: bold;
            display: block;
            margin-bottom: 0.5rem;
            color: #333;
        }

        .password-reset-form .form-control {
            width: 100%;
            padding: 10px;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: none;
            outline: none;
        }

        .password-reset-form .form-control:focus {
            border-color: #007bff;
        }

        .btn-submit {
            width: 100%;
            padding: 10px;
            font-size: 1rem;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            display: inline-block;
        }

        .btn-submit:hover {
            background-color: #0056b3;
        }

        @media (max-width: 575.98px) {
            .container {
                padding: 15px;
            }

            .password-reset-form h2 {
                font-size: 1.5rem;
            }
        }
    </style>

</head>


<body>
    <h1>Reset Password</h1>

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div>
            <input type="email" name="email" value="{{ $email }}" hidden required>
        </div>

        <div>
            <label>Password</label>
            <input type="password" name="password" required>
        </div>

        <div>
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" required>
        </div>

        <button type="submit">Reset Password</button>
    </form>
</body> 
</html>
