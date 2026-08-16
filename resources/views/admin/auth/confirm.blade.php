<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Akses Admin - Bacadulu</title>
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins&display=swap">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        :root {
            --primary-color: #8b96a3;
            --second-color: #ffffff;
            --black-color: #1c1917;
        }

        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(160deg, #3a4350 0%, #5c6b7a 50%, #8b96a3 100%);
            color: var(--second-color);
        }

        .login_box {
            width: 450px;
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(30px) saturate(160%);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 15px;
            padding: 2.5em;
            box-shadow: 0px 20px 45px rgba(0, 0, 0, 0.45);
        }

        .login-header {
            text-align: center;
            margin-bottom: 1.5em;
        }

        .login-header span {
            font-size: 22px;
            font-weight: 700;
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
            margin: 20px 0;
        }

        .input-field {
            width: 100%;
            height: 50px;
            font-size: 15px;
            padding: 0 20px;
            background: rgba(255, 255, 255, 0.08);
            color: var(--second-color);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 30px;
            outline: none;
        }

        .input-field::placeholder {
            color: rgba(255, 255, 255, 0.6);
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
        }

        .input-submit:hover {
            background: var(--second-color);
        }

        p.info {
            font-size: 13px;
            text-align: center;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 15px;
            line-height: 1.5;
        }
    </style>
</head>
<body>
    <div class="login_box">
        <div class="login-header">
            <span>Konfirmasi Akses Final</span>
        </div>

        <p class="info">Ketik ulang Email dan Password kamu untuk menyelesaikan proses autentikasi berlapis.</p>

        @if($errors->any())
            <div class="error-box">
                {{ $errors->first() }}
            </div>
        @endif

        @if(session('error'))
            <div class="error-box">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.confirm.submit') }}">
            @csrf

            <div class="input_box">
                <input type="email" name="email" class="input-field" placeholder="Email Admin" required autofocus>
            </div>

            <div class="input_box">
                <input type="password" name="password" class="input-field" placeholder="Password Admin" required>
            </div>

            <div class="input_box" style="margin-top: 25px;">
                <button type="submit" class="input-submit">Masuk ke Dashboard</button>
            </div>
        </form>
    </div>
</body>
</html>