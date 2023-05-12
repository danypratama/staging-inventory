<?php
$page = 'dashboard';
include "akses.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Inventory KMA</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <?php include "page/head.php"; ?>
</head>

<body>
  <!-- nav header -->
  <?php include "page/nav-header.php" ?>
  <!-- end nav header -->

  <!-- sidebar  -->
  <?php include "page/sidebar.php"; ?>
  <!-- end sidebar -->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <?php
      // Memulai session
      session_start();

      // Jika belum ada array untuk menampung session, buat array kosong
      if (!isset($_SESSION['login_sessions'])) {
        $_SESSION['login_sessions'] = array();
        $id_history = $_SESSION['encoded_id'];
        $id_history = array();
      }

      // Menambahkan session ke array jika belum ada
      $ip = $_SERVER['REMOTE_ADDR'];
      if (!in_array($ip, $_SESSION['login_sessions'])) {
        $_SESSION['login_sessions'][] = $ip;
      }

      // Cek semua session yang sedang login
      foreach ($_SESSION['login_sessions'] as $ip) {
        // Lakukan aksi untuk session dengan IP $ip
        // Misalnya, tampilkan pesan atau berikan opsi untuk logout
        echo "User dengan IP $ip sedang login.<br>";
      }
      ?>

    </section>

  </main><!-- End #main -->

  <!-- Footer -->
  <?php include "page/footer.php" ?>
  <!-- End Footer -->
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <?php include "page/script.php" ?>
</body>

</html>