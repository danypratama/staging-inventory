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

      <br>

      <?php
function generateBrowserFingerprint() {
    $fingerprint = '';

    // Menambahkan user-agent string
    if (isset($_SERVER['HTTP_USER_AGENT'])) {
        $fingerprint .= $_SERVER['HTTP_USER_AGENT'];
    }

    // Menambahkan IP address pengguna
    if (isset($_SERVER['REMOTE_ADDR'])) {
        $fingerprint .= $_SERVER['REMOTE_ADDR'];
    }

    // Menambahkan HTTP accept header
    if (isset($_SERVER['HTTP_ACCEPT'])) {
        $fingerprint .= $_SERVER['HTTP_ACCEPT'];
    }

    // Menambahkan HTTP accept language header
    if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
        $fingerprint .= $_SERVER['HTTP_ACCEPT_LANGUAGE'];
    }

    // Menambahkan HTTP accept encoding header
    if (isset($_SERVER['HTTP_ACCEPT_ENCODING'])) {
        $fingerprint .= $_SERVER['HTTP_ACCEPT_ENCODING'];
    }

    // Menambahkan HTTP connection header
    if (isset($_SERVER['HTTP_CONNECTION'])) {
        $fingerprint .= $_SERVER['HTTP_CONNECTION'];
    }

    // Menambahkan HTTP cache control header
    if (isset($_SERVER['HTTP_CACHE_CONTROL'])) {
        $fingerprint .= $_SERVER['HTTP_CACHE_CONTROL'];
    }

    // Menambahkan HTTP pragma header
    if (isset($_SERVER['HTTP_PRAGMA'])) {
        $fingerprint .= $_SERVER['HTTP_PRAGMA'];
    }

    // Menambahkan HTTP referer header
    if (isset($_SERVER['HTTP_REFERER'])) {
        $fingerprint .= $_SERVER['HTTP_REFERER'];
    }

    // Menambahkan HTTP host header
    if (isset($_SERVER['HTTP_HOST'])) {
        $fingerprint .= $_SERVER['HTTP_HOST'];
    }

    // Melakukan hashing pada fingerprint
    $fingerprint = md5($fingerprint);

    return $fingerprint;
}

// Menghasilkan dan menampilkan fingerprint browser
echo "Browser Fingerprint: " . generateBrowserFingerprint();
?>



<h1>ID Perangkat (Browser Fingerprint)</h1>
    <div id="device_id"></div>

    <script>
        (async () => {
            // Membuat fingerprint browser
            const device_id = await new Promise(resolve => {
                if (window.requestIdleCallback) {
                    requestIdleCallback(() => resolve(getDeviceId()));
                } else {
                    setTimeout(() => resolve(getDeviceId()), 500);
                }
            });

            // Menampilkan ID perangkat di dalam browser
            document.getElementById('device_id').innerText = device_id;

            // Fungsi untuk membuat fingerprint browser
            function getDeviceId() {
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');
                const txt = 'Browser Fingerprint';
                ctx.textBaseline = "top";
                ctx.font = "14px 'Arial'";
                ctx.textBaseline = "alphabetic";
                ctx.fillStyle = "#f60";
                ctx.fillRect(125,1,62,20);
                ctx.fillStyle = "#069";
                ctx.fillText(txt, 2, 15);
                ctx.fillStyle = "rgba(102, 204, 0, 0.7)";
                ctx.fillText(txt, 4, 17);
                const b64 = canvas.toDataURL().replace("data:image/png;base64,","");
                const bin = atob(b64);
                return bin2hex(bin.slice(-16,-12));
            }

            // Fungsi konversi biner ke heksadesimal
            function bin2hex(s) {
                let i, l, o = '', n;
                s += '';
                for (i = 0, l = s.length; i < l; i++) {
                    n = s.charCodeAt(i).toString(16);
                    o += n.length < 2 ? '0' + n : n;
                }
                return o;
            }
        })();
    </script>


    </section>

  </main><!-- End #main -->

  <!-- Footer -->
  <?php include "page/footer.php" ?>
  <!-- End Footer -->
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  <?php include "page/script.php"; ?>
 
</body>

</html>