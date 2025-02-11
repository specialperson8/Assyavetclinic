
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assyavet Clinic</title>
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/loginregis.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div class="container">
        <div class="form-box login">
          <form method="POST" action="{{ route('loginuser') }}">
                @csrf
                <h1>Masuk</h1>
                <div class="input-box">
                    <input type="email" placeholder="Email" name="email" required>
                    <i class='bx bxs-user'></i>
                </div>
                <div class="input-box">
                  <input type="password" placeholder="Password" name="password" id="password_login" required>
                  <i class='bx bxs-lock-alt' id="togglePassword_login" style="cursor: pointer;"></i>
              </div>              
                <button type="submit" class="btn">Masuk</button>
            </form>
        </div>

        <div class="form-box register">
          <form action="{{ route('storeakunkaryawan') }}" method="POST">
                @csrf
                <h1>Daftar</h1>
                <div class="input-box">
                    <input type="text" placeholder="Username" name="nama" required>
                    <i class='bx bxs-user'></i>
                </div>
                <div class="input-box">
                    <input type="email" placeholder="Email" name="email" required>
                    <i class='bx bxs-envelope' ></i>
                </div>
                <div class="input-box">
                  <input type="password" placeholder="Password" name="password" id="password_register" required>
                  <i class='bx bxs-lock-alt' id="togglePassword_register" style="cursor: pointer;"></i>
              </div>
              <input type="text" name="role" value="user" hidden>
                <button type="submit" class="btn">Daftar</button>
            </form>
        </div>

        <div class="toggle-box">
            <div class="toggle-panel toggle-left">
                <h1>Assyavet Clinic</h1>
                <p>Apakah kamu belum punya akun?</p>
                <button class="btn register-btn">Daftar</button>
            </div>

            <div class="toggle-panel toggle-right">
                <h1>Assyavet Clinic</h1>
                <p>Apakah kamu sudah punya akun?</p>
                <button class="btn login-btn">Masuk</button>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/frontend/js/loginregis.js') }}"></script>
</body>
</html>