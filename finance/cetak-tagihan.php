<?php
include "akses.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <title>Inventory KMA</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <style>
    body{
      font-size: 16px;
      font-family: 'Maiandra GD';
    }
    .sph {
        width: 100%;
        max-width: 1000px;
        margin: 0 auto;
        background-color: #ffffff;
        text-align: center;
        padding: 0; /* Hapus padding */
        font-size: 13px;
        font-family: 'Maiandra GD';
    }

    .sph-img {
        margin-top: 0.2cm;
        margin-left: 0.5cm; /* Tambahkan jarak kiri */
        margin-right: 0.5cm; /* Tambahkan jarak kanan */
    }

    .sph-content {
        margin-left: 0.5cm; /* Tambahkan jarak kiri */
        margin-right: 0.5cm; /* Tambahkan jarak kanan */
    }

    .col-sm-6 {
      flex: 0 0 50%;
      max-width: 50%;
      padding: 0 15px;
    }

    .col-10 {
      width: 100%;
    }

    img {
        max-width: 100%;
        display: block;
        margin: 0 auto;
    }
    .table-custom {
      border-collapse: collapse;
      width: 100%;
    }

    .table-custom th, .table-custom td {  
        border: 1px black solid;
        text-align: left;
        padding: 3px;
    }

    .table-custom tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    .table-custom tr:hover {
        background-color: #ddd;
    }
  </style>
  <?php include "page/head.php" ?>
  <?php include "function/tanggal-indo.php" ?>
</head>

<body style="color: black;">
  <div class="sph">
    <?php 
      include "koneksi.php";        
      $id_bill = base64_decode($_GET['id']);
      $no = 1;
      $sql_data = "SELECT DISTINCT
                    spk.id_customer,  -- Menampilkan kolom id_customer dari tabel spk_reg
                    cs.nama_cs AS nama_cs,  -- Menampilkan kolom nama_cs dari tabel tb_customer
                    cs.alamat AS alamat_cs,  -- Menampilkan kolom alamat_cs dari tabel tb_customer
                    STR_TO_DATE(ft.tgl_tagihan, '%d/%m/%Y') AS tgl_tagihan,
                    ft.no_tagihan,
                    ft.jenis_faktur,
                    COALESCE(nonppn.id_inv_nonppn, ppn.id_inv_ppn, bum.id_inv_bum) AS id_inv,
                    COALESCE(nonppn.no_inv, ppn.no_inv, bum.no_inv) AS no_inv,
                    COALESCE(nonppn.cs_inv, ppn.cs_inv, bum.cs_inv) AS cs_inv,
                    COALESCE(nonppn.tgl_inv, ppn.tgl_inv, bum.tgl_inv) AS tgl_inv,
                    COALESCE(nonppn.total_inv, ppn.total_inv, bum.total_inv) AS total_inv
                  FROM spk_reg AS spk
                  LEFT JOIN inv_nonppn nonppn ON (spk.id_inv = nonppn.id_inv_nonppn)
                  LEFT JOIN inv_ppn ppn ON (spk.id_inv = ppn.id_inv_ppn)
                  LEFT JOIN inv_bum bum ON (spk.id_inv = bum.id_inv_bum)
                  LEFT JOIN finance fnc ON (spk.id_inv = fnc.id_inv)
                  LEFT JOIN finance_tagihan ft ON (fnc.id_tagihan = ft.id_tagihan)
                  LEFT JOIN tb_customer cs ON (spk.id_customer = cs.id_cs)
                  WHERE ft.id_tagihan = '$id_bill'";
      $query = mysqli_query($connect, $sql_data);
      $query_data = mysqli_query($connect, $sql_data);
      $data = mysqli_fetch_array($query);
      $id_inv = $data['id_inv'];
      $update_status_cetak = mysqli_query($connect, "UPDATE finance_tagihan SET status_cetak = '1' WHERE id_tagihan = '$id_bill'");
    ?>
    <?php  
      $id_inv_substr = substr($id_inv, 0,3);
      if( $id_inv_substr == "PPN"){
        ?>
          <div class="sph-img">
            <img src="assets/img/header-sph.jpg" class="card-img-top">
          </div>
        <?php
      }
    ?>
    <div class="sph-content mt-3">
      <div class="row">
        <div class="col-sm-6 p-3">
            <div class="col-10 border border-dark text-start p-2">
                Kepada, Yth<br>
                <b style="color: black;"><?php echo $data['nama_cs'] ?></b><br>
                <?php echo $data['alamat_cs'] ?>
            </div>
        </div>
        <div class="col-sm-6 p-3">
            <div class="col-10 border border-dark p-2 float-end">
               <b style="color: black;"><?php echo $data['jenis_faktur'] ?></b>
            </div>
            <br><br>
            <div class="col-10 border border-dark p-2 float-end text-start">
            <div class="row">
                <div class="col-5">Tanggal Tagihan</div>
                <div class="col-7">: <?php echo tgl_indo($data['tgl_tagihan']) ?></strong></div>
            </div>
            <div class="row">
                <div class="col-5">No. Tagihan</div>
                <div class="col-7">: <?php echo $data['no_tagihan'] ?></div>
            </div>
        </div>

        </div>
      </div>
      <!-- Table -->
      <p class="text-start">Berikut rincian nota nota untuk tukar faktur :</p>
      <div class="table-reponsive">
        <table class="table-custom">
          <thead>
            <tr>
              <th class="text-center">No</th>
              <th class="text-center text-nowrap">No Invoice</th>
              <th class="text-center text-nowrap">Tanggal Invoice</th>
              <th class="text-center text-nowrap">Nominal (Rp)</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $total_inv = 0;
              while ($data_inv = mysqli_fetch_array($query_data)){
                $total_inv += $data_inv['total_inv'];
            ?>
            <tr>
              <td class="text-center"><?php echo $no ?></td>
              <td class="text-start" style="max-width: 300px;"><?php echo $data_inv['no_inv']; ?></td>
              <td class="text-nowrap text-center"><?php echo $data_inv['tgl_inv']; ?></td>
              <td class="text-nowrap text-end"><?php echo number_format($data_inv['total_inv'],0,'.','.'); ?></td>
            </tr>
            <?php $no++ ?>
            <?php } ?>
            <tr>
              <td class="text-end" colspan="3">Total Nominal</td>
              <td class="text-end"><?php echo number_format($total_inv,0,'.','.'); ?></td>
            </tr> 
          </tbody>
        </table>
      </div>
      <p>
      <div class="row">
        <div class="col-7 ms-4 m-2 text-start">
          <br>
          <b>PT. Karsa Mandiri Alkesindo</b>
          <br><br><br><br>
          <b style="text-decoration: underline;">
          <?php echo $_SESSION['tiket_nama'] ?>
          </b><br>
          <?php echo 'Finance' ?>
        </div>
        <div class="col-4 m-2">
          <table class="table-custom">
            <tr>
              <th class="text-center" style="width: 200px;">Tanggal Kembali</th>
            </tr>
            <tr>
              <th><br></th>
            </tr>
          </table>
          <br><br><br>
          <p>(Paraf & Nama Penerima)</p>
        </div>
      </div>
    </div>
  </div>
  <br>
</body>

</html>