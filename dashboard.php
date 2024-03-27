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
        print_r($_SESSION);
      ?>
      <br>
      <?php
        // Mendapatkan informasi CPU
        $cpu_info = shell_exec("wmic cpu get Name, NumberOfCores, NumberOfLogicalProcessors /format:list");

        // Mendapatkan informasi Nama PC
        $pc_name = shell_exec("wmic computersystem get Name /format:value");

        // Mendapatkan informasi ID perangkat
        $device_id = shell_exec("wmic csproduct get UUID /format:value");

        // Menampilkan informasi CPU, Nama PC, dan ID perangkat
        echo "<h2>Spesifikasi Perangkat</h2>";
        echo "<h3>CPU</h3>";
        echo "<pre>$cpu_info</pre>";
        echo "<h3>Nama PC</h3>";
        echo "<pre>$pc_name</pre>";
        echo "<h3>ID Perangkat</h3>";
        echo "<pre>$device_id</pre>";
      ?>


    </section>

  </main><!-- End #main -->

  <!-- Footer -->
  <?php include "page/footer.php" ?>
  <!-- End Footer -->
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  <?php include "page/script.php"; ?>
 
</body>

</html>