<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Inventory KMA</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <?php include "page/head.php"; ?>
  <style>
    body{
        width: 1000px;
        margin: 0 auto;
        margin-top: 20px;
        background-color: white;
        font-family: Arial, Helvetica, sans-serif;
        color: black;
        letter-spacing: 0.5px;
    }
    table{
        font-size: 18px;
        color: black !important;
    }
    .parallelogram {
            width: 200px;
            height: 75px;
            background-color: #3498db;
            transform: skew(-20deg);
            margin: 20px;
            color: #fff;
            padding: 10px;
            box-sizing: border-box;
            line-height: 50px; /* Sesuaikan dengan tinggi kotak */
    }
  </style>
</head>

<body>
    <div class="card-body p-2">
        <?php  
            $id_inv = $_GET['id_inv'];

            include 'koneksi.php';
            $sql_surat_jalan = " SELECT
                                    sk.tgl_kirim, 
                                    COALESCE(nonppn.cs_inv, ppn.cs_inv, bum.cs_inv) AS cs_inv,
                                    COALESCE(nonppn.no_inv, ppn.no_inv, bum.no_inv) AS no_inv,
                                    spk.no_po,
                                    spk.id_inv,
                                    cs.alamat
                                FROM spk_reg AS spk
                                LEFT JOIN inv_nonppn nonppn ON spk.id_inv = nonppn.id_inv_nonppn
                                LEFT JOIN inv_ppn ppn ON spk.id_inv = ppn.id_inv_ppn
                                LEFT JOIN inv_bum bum ON spk.id_inv = bum.id_inv_bum
                                LEFT JOIN status_kirim sk ON spk.id_inv = sk.id_inv
                                LEFT JOIN tb_customer cs ON spk.id_customer = cs.id_cs
                                WHERE spk.id_inv = '$id_inv'";
            $query_surat_jalan = mysqli_query($connect, $sql_surat_jalan);
            $data_surat_jalan = mysqli_fetch_array($query_surat_jalan);
            $tgl_kirim = $data_surat_jalan['tgl_kirim'];
            $cs_inv = $data_surat_jalan['cs_inv'];
            $alamat = $data_surat_jalan['alamat'];
            $no_po = $data_surat_jalan['no_po'];
            $no_inv = $data_surat_jalan['no_inv'];
        ?>
        <div class="row p-3">
            <div class="col-sm-8">
                <img class="img-fluid" src="assets/img/header-kma.jpg">
            </div>
            <div class="col-sm-4 border border-dark">
                <p class="text-center mt-3" style="font-size: 27px;">
                    <b>KWITANSI</b>
                </p>
            </div>
        </div>
        <div class="row p-3">
            <div class="col-sm-7" style="font-size: 18px;">
                <table>
                    <tr>
                        <th class="col-5">Telah Terima Dari :</th>
                        <th class="col-7">&nbsp;<?php echo $cs_inv ?></th>
                    </tr>
                    <tr>
                        <th class="col-5"></th>
                        <th class="col-7">&nbsp;<?php echo $alamat ?></th>
                    </tr>
                    <tr>
                        <th class="col-5">Sebesar :</th>
                        <th class="col-7">&nbsp;<?php echo $alamat ?></th>
                    </tr>
                    <tr>
                        <th class="col-5">Untuk Pembayaran :</th>
                        <th class="col-7">&nbsp;No. Invoice : <?php echo $no_inv ?></th>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-sm-1"></div>
            <div class="col-sm-3">
                <div class="parallelogram">
                    <p>Jumlah : Rp.43.122.335</p>
                </div>
                <p class="text-center">
                   
                </p>
            </div>
            <div class="col-sm-4"></div>
            <div class="col-sm-3 border border-dark">
                <p class="text-center mt-1">
                    <b>Diterima Oleh :</b>
                </p>
                <br><br><br>
                <p class="text-center">
                    
                </p>
            </div>
            <div class="col-sm-1"></div>
        </div>
    </div>
   

    <?php include "page/script.php" ?>
</body>

</html>