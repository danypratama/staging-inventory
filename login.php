<?php
    session_start();// memulai sebuah sesi

    include "koneksi.php";

    if (isset($_POST['login'])) {
        // Ambil data dari formulir login
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Query untuk mencari data user dari database
        $query = "SELECT * FROM user WHERE username = '$username'";
        $result = mysqli_query($connect, $query);

        // Periksa apakah username ditemukan
        if (mysqli_num_rows($result) == 1) {
          // Ambil data password dari database
          $row = mysqli_fetch_assoc($result);
          $password_hash = $row['password'];

          // Verifikasi password
          if (password_verify($password, $password_hash)) {
            // Password benar, simpan data user ke session dan arahkan ke halaman dashboard
            //ambil data dari nama kolom operator
            $_SESSION['tiket_id'] = $row['id_user'];
            $_SESSION['tiket_user'] = $row['username'];
            $_SESSION['tiket_pass'] = $row['password'];
            $_SESSION['tiket_nama'] = $row['nama_user'];
            $_SESSION['tiket_role'] = $row['id_user_role'];
            $_SESSION['tiket_jenkel'] = $row['jenkel'];
            header("Location: dashboard.php");
          } else {
            // Password salah, kembali ke halaman login
            header("Location: login.php?gagal");
          }
        } else {
          // Username tidak ditemukan, kembali ke halaman login
          header("Location: login.php?gagal");
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Inventory KMA</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <link rel="stylesheet" href="assets/css/style-login.css">
  <link href="assets/img/logo-kma.png" rel="icon">
  <link href="assets/img/logo-kma.png" rel="apple-touch-icon">
</head>

<body>
  <div class="background">
      <div class="shape"></div>
      <div class="shape"></div>
  </div>
  <form action="" method="POST">
    <?php 
      if (isset($_GET["gagal"])) {?>
          <div class="alert alert-danger d-none" role="alert">
            Username atau password salah. Silakan coba lagi.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>  
    <?php unset($_GET["gagal"]); } ?>

    <script>
      if ( window.history.replaceState ) {
          window.history.replaceState( null, null, window.location.href.split('?')[0] );
      }
    </script>
    <h3>Login</h3>
    <label for="username">Username</label>
    <input type="text" name="username" placeholder="Masukan username" id="username">

    <label for="password">Password</label>
    <input type="password" name="password" class="form-password" placeholder="Masukan password">

    <div class="password-wrapper">
      <input type="checkbox" class="form-check-input me-2 form-checkbox" id="show-password">
      <label style="font-size: 18px;" for="show-password">Lihat Password</label>
    </div>

    <button name="login">Log In</button>
  </form>
</body>
</html>

<script>
    var checkbox = document.getElementById('show-password');
    var password = document.querySelector('.form-password');

    checkbox.addEventListener('change', function() {
        if (password.type === 'password') {
            password.type = 'text';
        } else {
            password.type = 'password';
        }
    });
</script>