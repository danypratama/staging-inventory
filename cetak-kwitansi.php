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
        border-collapse: collapse;
    }

    th.col-3, td.col-3 {
        width: 18%; /* Adjust the value based on your design */
    }

    th.col-1, td.col-1 {
        width: 1%; /* Adjust the value based on your design */
    }

    .parallelogram {
        width: 300px;
        height: 75px;
        border: 2px solid black;
        transform: skew(-20deg);
        margin: 20px;
        color: black;
        font-weight: bold;
        padding: 5px;
        box-sizing: border-box;
        line-height: 50px;
        display: flex; /* Menambahkan display flex */
        justify-content: center; /* Menengahkan secara horizontal */
        align-items: center; /* Menengahkan secara vertikal */
    }

  </style>
</head>

<body>
    <div class="card-body p-2">
        <?php  
            $id_inv = base64_decode($_GET['id_inv']);

           
            $id_inv_substr = substr($id_inv, 0, 3);

            include 'koneksi.php';
            $sql_surat_jalan = " SELECT
                                    sk.tgl_kirim, 
                                    COALESCE(nonppn.cs_inv, ppn.cs_inv, bum.cs_inv) AS cs_inv,
                                    COALESCE(nonppn.no_inv, ppn.no_inv, bum.no_inv) AS no_inv,
                                    COALESCE(nonppn.total_inv, ppn.total_inv, bum.total_inv) AS total_inv,
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
            $total_inv = $data_surat_jalan['total_inv'];
            $total_inv_terbilang = terbilang($total_inv);
        ?>
        <div class="row p-3">
            <div class="col-sm-8">
                <?php  
                    if ($id_inv_substr == 'PPN'){
                        ?>
                            <img class="img-fluid" src="assets/img/header-kma.jpg">
                        <?php
                    }
                ?>
            </div>
            <div class="col-sm-4 border border-dark">
                <p class="text-center mt-3" style="font-size: 27px;">
                    <b>KWITANSI</b>
                </p>
            </div>
        </div>
        <div class="row p-3">
            <div class="col-sm-12" style="font-size: 18px;">
                <table>
                    <tr>
                        <th class="col-3 p-1">Telah Terima Dari</th>
                        <th class="col-1 p-1 text-end">:</th>
                        <th class="col-8 p-1"><?php echo $cs_inv ?></th>
                    </tr>
                    <tr>
                        <th class="col-3 p-1">Alamat</th>
                        <th class="col-1 p-1 text-end">:</th>
                        <th class="col-8 p-1"><?php echo $alamat ?></th>
                    </tr>
                    <tr>
                        <th class="col-3 p-1">Sebesar</th>
                        <th class="col-1 p-1 text-end">:</th>
                        <th class="col-8 p-1"><?php echo ucfirst($total_inv_terbilang) ?> rupiah</th>
                    </tr>
                    <tr>
                        <th class="col-3 p-1">Untuk Pembayaran</th>
                        <th class="col-1 p-1 text-end">:</th>
                        <th class="col-8 p-1">No. Invoice : <?php echo $no_inv ?></th>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-sm-1"></div>
            <div class="col-sm-3">
                <div class="parallelogram">
                    <p>Jumlah : Rp. <?php echo number_format($total_inv,0,'.','.') ?></p>
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

    <?php
        function terbilang($angka) {
            $angka = floatval(preg_replace("/[^0-9]/", "", $angka)); // Menghilangkan karakter non-digit seperti titik atau koma
        
            $bilangan = array(
                '',
                'satu',
                'dua',
                'tiga',
                'empat',
                'lima',
                'enam',
                'tujuh',
                'delapan',
                'sembilan',
            );
        
            $temp = "";
            if ($angka < 10) {
                $temp = $bilangan[$angka];
            } elseif ($angka < 100) {
                $temp = ($angka < 20) ? 'sebelas' : $bilangan[floor($angka / 10)] . ' puluh ' . $bilangan[$angka % 10];
            } elseif ($angka < 200) {
                $temp = 'seratus ' . terbilang($angka - 100);
            } elseif ($angka < 1000) {
                $temp = $bilangan[floor($angka / 100)] . ' ratus ' . terbilang($angka % 100);
            } elseif ($angka < 1000000) {
                $temp = terbilang(floor($angka / 1000)) . ' ribu ' . terbilang($angka % 1000);
            } elseif ($angka < 1000000000) {
                $temp = terbilang(floor($angka / 1000000)) . ' juta ' . terbilang($angka % 1000000);
            } elseif ($angka < 1000000000000) {
                $temp = terbilang(floor($angka / 1000000000)) . ' milyar ' . terbilang($angka % 1000000000);
            } elseif ($angka < 1000000000000000) {
                $temp = terbilang(floor($angka / 1000000000000)) . ' triliun ' . terbilang($angka % 1000000000000);
            }
        
            return $temp;
        }

        $total_inv = $data_surat_jalan['total_inv'];
        $total_terbilang = terbilang($total_inv);

        // Menampilkan hasil
        // echo "Terbilang: " . ucfirst($total_terbilang) . " rupiah";
    ?>
    <?php include "page/script.php" ?>
</body>

</html>