<?php
    $page  = 'transaksi';
    $page2 = 'spk';
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

  <style type="text/css">
    @media only screen and (max-width: 500px) {
        body {
          font-size: 10px;
        }
      }
  </style>
</head>

<body>
  <!-- nav header -->
  <?php include "page/nav-header.php" ?>
  <!-- end nav header -->
  
  <!-- sidebar  -->
  <?php include "page/sidebar.php"; ?>
  <!-- end sidebar -->
  

  <main id="main" class="main">
    <section>
      <div class="container-fluid">
        <div class="card shadow p-2">
          <div class="card-header text-center"><h5><strong>INPUT PRODUK SPK</strong></h5></div>
          <form action="input-produk-spk.php" method="POST">
            <?php 
              date_default_timezone_set('Asia/Jakarta');
            ?>
            <div class="card-body">
              <div class="row mt-3">
                <div class="col-sm-6">  
                  <div class="card-body p-3 border">
                    <div class="row">
                      <div class="col-5">
                        <p style="float: left;">No. SPK</p>
                        <p style="float: right;">:</p>
                      </div>
                      <div class="col-7">
                        SPK/001/1/2023
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-5">
                        <p style="float: left;">Tanggal SPK</p>
                        <p style="float: right;">:</p>
                      </div>
                      <div class="col-7">
                        01 Januari 2023
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-5">
                        <p style="float: left;">No. PO</p>
                        <p style="float: right;">:</p>
                      </div>
                      <div class="col-7">
                        PO-001
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-5">
                        <p style="float: left;">Tanggal Pesanan</p>
                        <p style="float: right;">:</p>
                      </div>
                      <div class="col-7">
                        01 Januari 2023
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-5">
                        <p style="float: left;">Order Via</p>
                        <p style="float: right;">:</p>
                      </div>
                      <div class="col-7">
                        Whatsapp
                      </div>
                    </div>  
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="card-body p-3 border" style="min-height: 234px;">
                    <div class="row">
                      <div class="col-5">
                        <p style="float: left;">Sales</p>
                        <p style="float: right;">:</p>
                      </div>
                      <div class="col-7">
                        Annas
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-5">
                        <p style="float: left;">Pelanggan</p>
                        <p style="float: right;">:</p>
                      </div>
                      <div class="col-7">
                        Ibu Melly
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-5">
                        <p style="float: left;">Alamat</p>
                        <p style="float: right;">:</p>
                      </div>
                      <div class="col-7">
                        Jakarta
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-5">
                        <p style="float: left;">Note</p>
                        <p style="float: right;">:</p>
                      </div>
                      <div class="col-7">
                        Dikirim Hari Ini
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-body">
              <a href="#" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Tambah Produk</a>
            </div>
          </form>
          </div>
        </div>
      </div>
    </section>
  </main><!-- End #main -->

  <!-- Footer -->
  <?php include "page/footer.php" ?>
  <!-- End Footer -->
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <?php include "page/script.php" ?>
</body>
</html>