<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin Bacadulu</title>
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins&display=swap">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        :root {
            --primary-color: #8b96a3;
            --primary-dark: #5f6b78;
            --second-color: #ffffff;
            --black-color: #1c1917;
        }

        html, body {
            width: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
            background: linear-gradient(160deg, #3a4350 0%, #5c6b7a 50%, #8b96a3 100%);
        }

        body::before,
        body::after {
            content: "";
            position: absolute;
            border-radius: 50%;
            filter: blur(110px);
            z-index: 0;
        }

        body::before {
            width: 500px;
            height: 500px;
            top: -150px;
            left: -100px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.25) 0%, transparent 70%);
        }

        body::after {
            width: 600px;
            height: 600px;
            bottom: -200px;
            right: -150px;
            background: radial-gradient(circle, rgba(139, 150, 163, 0.4) 0%, transparent 70%);
        }

        .wrapper {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 40px 20px;
            position: relative;
            z-index: 1;
        }

        a {
            text-decoration: none;
            color: var(--second-color);
        }

        a:hover {
            text-decoration: underline;
        }

        .login_box {
            position: relative;
            width: 450px;
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(30px) saturate(160%);
            -webkit-backdrop-filter: blur(30px) saturate(160%);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 15px;
            padding: 2.5em;
            color: var(--second-color);
            box-shadow: 0px 20px 45px rgba(0, 0, 0, 0.45);
        }

        .login-header {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            margin-bottom: 1.5em;
        }

        .login-header span {
            font-size: 24px;
            font-weight: 700;
            color: var(--second-color);
            text-align: center;
        }

        .error-box {
            margin-bottom: 20px;
            border-radius: 10px;
            background-color: rgba(255, 255, 255, 0.85);
            color: #b91c1c;
            padding: 10px 15px;
            font-size: 14px;
        }

        .input_box {
            position: relative;
            display: flex;
            flex-direction: column;
            margin: 20px 0;
        }

        .input-field {
            width: 100%;
            height: 50px;
            font-size: 15px;
            background: rgba(255, 255, 255, 0.08);
            color: var(--second-color);
            padding-inline: 20px 50px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 30px;
            outline: none;
        }

        .input-field::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        #user {
            margin-bottom: 10px;
        }

        .label {
            position: absolute;
            top: 15px;
            left: 20px;
            transition: 0.2s;
            pointer-events: none;
        }

        .input-field:focus ~ .label,
        .input-field:valid ~ .label {
            top: -10px;
            left: 20px;
            font-size: 14px;
            background-color: var(--primary-color);
            border-radius: 30px;
            color: var(--black-color);
            padding: 0 10px;
        }

        .icon {
            position: absolute;
            top: 15px;
            right: 25px;
            font-size: 20px;
            color: rgba(255, 255, 255, 0.7);
        }

        .toggle-password {
            cursor: pointer;
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 13px;
            margin-bottom: 20px;
            color: rgba(255, 255, 255, 0.85);
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .remember-me input[type="checkbox"] {
            accent-color: var(--primary-color);
        }

        .input-submit {
            width: 100%;
            height: 48px;
            background: #ececec;
            color: #1c1917;
            font-size: 16px;
            font-weight: 600;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            transition: 0.3s;
            letter-spacing: 0.5px;
        }

        .input-submit:hover {
            background: var(--second-color);
        }

        @media only screen and (max-width: 564px) {
            .wrapper {
                padding: 20px;
            }

            .login_box {
                padding: 2.5em 1.5em;
            }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="login_box">
            <div class="login-header">
                <span>Hai Adminbaca!</span>
            </div>

            @if($errors->any())
                <div class="error-box">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login') }}">
                @csrf

                <div class="input_box">
                    <input type="email" name="email" id="user" class="input-field" value="{{ old('email') }}" required>
                    <label for="user" class="label">Email</label>
                    <i class='bx bx-user icon'></i>
                </div>

                <div class="input_box">
                    <input type="password" name="password" id="pass" class="input-field" required>
                    <label for="pass" class="label">Password</label>
                    <i class='bx bx-hide icon toggle-password' id="togglePass" onclick="togglePassword()"></i>
                </div>

                <div class="remember-forgot">
                    <div class="remember-me">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember">Remember me</label>
                    </div>
                </div>

                <div class="input_box" style="margin-top: 20px;">
                     <button type="submit" class="input-submit" style="cursor: pointer; position: relative; z-index: 99;">Login Sekarang</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passField = document.getElementById('pass');
            const toggleIcon = document.getElementById('togglePass');

            if (passField.type === 'password') {
                passField.type = 'text';
                toggleIcon.classList.remove('bx-hide');
                toggleIcon.classList.add('bx-show');
            } else {
                passField.type = 'password';
                toggleIcon.classList.remove('bx-show');
                toggleIcon.classList.add('bx-hide');
            }
        }
    </script>
</body>
</html>