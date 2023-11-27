<?php
include "akses.php";
include "function/class-spk.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <title>Inventory KMA</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <link rel="stylesheet" href="assets/css/cetak-sph.css">
  <style>
    .col-content-1 {
        width: 25%;
    }

    .col-content-2 {
        width: 75%;
    }
    .col-content-ttd-1 {
        width: 7%;
    }
    .col-content-ttd-2 {
        width: 75%;
    }
  </style>
</head>

<body style="font-size: 18px;">
  <div class="sph">
    <?php
        include "koneksi.php";
        $id_spk = base64_decode($_GET['id']);
        $sql = " SELECT 
                    sr.no_spk, 
                    sr.no_po, 
                    DATE_FORMAT(STR_TO_DATE(sr.tgl_spk, '%d/%m/%Y, %H:%i'), '%d %M %Y') AS tgl_spk, -- Mengubah format tgl_spk
                    sr.note, 
                    cs.nama_cs, 
                    cs.alamat, 
                    ordby.order_by, 
                    sl.nama_sales  
                  FROM spk_reg AS sr
                  JOIN tb_customer cs ON(sr.id_customer = cs.id_cs)
                  JOIN tb_orderby ordby ON(sr.id_orderby = ordby.id_orderby)
                  JOIN tb_sales sl ON(sr.id_sales = sl.id_sales)
                  WHERE sr.id_spk_reg = '$id_spk'";
        $query = mysqli_query($connect, $sql);
        $data = mysqli_fetch_array($query);
        // Tampilkan tanggal dengan nama bulan dalam bahasa Indonesia
        // Tampilkan tanggal dengan nama bulan dalam bahasa Indonesia menggunakan fungsi kustom
        $tanggal_spk = $data['tgl_spk'];
        $tanggal_spk_indonesia = formatTanggal($tanggal_spk);

        // Fungsi untuk mengonversi nama bulan dalam bahasa Inggris menjadi bahasa Indonesia
        function formatTanggal($englishDate) {
            $bulan = [
                'January' => 'Januari',
                'February' => 'Februari',
                'March' => 'Maret',
                'April' => 'April',
                'May' => 'Mei',
                'June' => 'Juni',
                'July' => 'Juli',
                'August' => 'Agustus',
                'September' => 'September',
                'October' => 'Oktober',
                'November' => 'November',
                'December' => 'Desember'
            ];

            $timestamp = strtotime($englishDate);
            $day = date('d', $timestamp);
            $month = $bulan[date('F', $timestamp)];
            $year = date('Y', $timestamp);

            return "$day $month $year";
        }
    ?>
    <div class="sph-img">
        <br>
        <h1><b>SURAT PERINTAH KERJA</b></h1>
    </div>
    <div class="sph-content mt-3">
      <div class="row">
          <div class="col text-left">
            <div class="row">
              <div class="col-content-1">No. Spk</div>
              <div class="col-content-2">: <?php echo $data['no_spk'] ?></div>
            </div>
            <div class="row">
              <div class="col-content-1">No. PO</div>
              <div class="col-content-2">: <?php echo $data['no_po'] ?></div>
            </div>
            <div class="row">
              <div class="col-content-1">Customer</div>
              <div class="col-content-2">: <?php echo $data['nama_cs'] ?></div>
            </div>
            <div class="row">
              <div class="col-content-1">Sales</div>
              <div class="col-content-2">: <?php echo $data['nama_sales'] ?></div>
            </div>
            <div class="row">
              <div class="col-content-1">Order By</div>
              <div class="col-content-2">: <?php echo $data['order_by'] ?></div>
            </div>
          </div>
          <div class="col text-right">
            <div class="col-content-3">Bekasi, <?php echo $tanggal_spk_indonesia; ?></div>
          </div>
      </div> <!-- Kepada Yth -->

      <!-- Table -->
      <div class="table-reponsive mt-3">
        <table class="table">
            <thead>
                <tr>
                    <td class="text-center p-3 text-nowrap" style="width: 50px">No</td>
                    <td class="text-center p-3 text-nowrap" style="width: 350px">Nama Produk</td>
                    <td class="text-center p-3 text-nowrap" style="width: 100px">Satuan</td>
                    <td class="text-center p-3 text-nowrap" style="width: 100px">Merk</td>
                    <td class="text-center p-3 text-nowrap" style="width: 100px">Qty Order</td>
                </tr>
            </thead>
            <tbody>
                <?php
                include "koneksi.php";
                $year = date('y');
                $day = date('d');
                $month = date('m');
                $id_spk_decode = base64_decode($_GET['id']);
                $no = 1;
                $sql_trx = "SELECT 
                                sr.id_spk_reg,
                                sr.id_inv,
                                tps.id_tmp,
                                tps.id_produk,
                                tps.qty,
                                tps.status_tmp, 
                                spr.stock, 
                                tpr.nama_produk, 
                                tpr.satuan,
                                tpr.harga_produk,
                                mr_produk.nama_merk AS merk_produk, -- Nama merk untuk produk reguler
                                tpsm.nama_set_marwa,
                                tpsm.harga_set_marwa,
                                mr_set.nama_merk AS merk_set -- Nama merk untuk produk set
                            FROM tmp_produk_spk AS tps
                            LEFT JOIN spk_reg sr ON sr.id_spk_reg = tps.id_spk
                            LEFT JOIN stock_produk_reguler spr ON tps.id_produk = spr.id_produk_reg
                            LEFT JOIN tb_produk_reguler tpr ON tps.id_produk = tpr.id_produk_reg
                            LEFT JOIN tb_produk_set_marwa tpsm ON tps.id_produk = tpsm.id_set_marwa
                            LEFT JOIN tb_merk mr_produk ON tpr.id_merk = mr_produk.id_merk -- JOIN untuk produk reguler
                            LEFT JOIN tb_merk mr_set ON tpsm.id_merk = mr_set.id_merk -- JOIN untuk produk set
                            WHERE sr.id_spk_reg = '$id_spk' AND tps.status_tmp = '1'";
                $trx_produk_reg = mysqli_query($connect, $sql_trx);
                $total_rows = mysqli_num_rows($trx_produk_reg);
                while ($data_trx = mysqli_fetch_array($trx_produk_reg)) {
                    $id_produk = $data_trx['id_produk'];
                    $satuan = $data_trx['satuan'];
                    $stock_edit = $data_trx['qty'] + $data_trx['stock'];
                    $namaProduk = detailSpk::getDetail($data_trx['nama_produk'], $data_trx['nama_set_marwa']);
                    $nama_merk = detailSpk::getMerk($data_trx['merk_produk'], $data_trx['merk_set']);
                    $harga = detailSpk::getHarga($data_trx['harga_produk'], $data_trx['harga_set_marwa']);
                    $satuan_produk = '';
                    $id_produk_substr = substr($id_produk, 0, 2);
                    if ($id_produk_substr == 'BR') {
                        $satuan_produk = $satuan;
                    } else {
                        $satuan_produk = 'Set';
                    }
                ?>
                    <tr>
                        <td class="text-nowrap"><?php echo $no; ?></td>
                        <td class="text-left"><?php echo $namaProduk ?></td>
                        <td class="text-center text-nowrap"><?php echo $satuan_produk ?></td>
                        <td class="text-nowrap"><?php echo $nama_merk ?></td>
                        <td class="text-nowrap"><?php echo number_format($data_trx['qty']) ?></td>
                    </tr>
                    <?php $no++; ?>
                <?php } ?>
            </tbody>
        </table>
        <?php  
          if($total_rows > 0) {
              $update = mysqli_query($connect, "UPDATE spk_reg SET status_cetak = 1 WHERE id_spk_reg = '$id_spk'");
          }
        ?>
      </div>
      <div class="content-alamat text-left">
        <b>Note :</b>
      </div>
      <div class="content-alamat text-left">
        <?php
            $note = $data['note'];

            $items = explode("\n", trim($note));

            foreach ($items as $notes) {
                echo trim($notes) . '<br>';
            }
        ?>
      </div>
      <br>
      <div class="sph-content mt-3">
        <!-- TTD -->
        <div class="row">
            <div class="col">
                <div class="content-hormat text-left">
                    Mengetahui,<br>
                </div>
                <div class="content-img-ttd text-left">
                    <br><br><br>
                </div>
                <div class="content-hormat text-left">
                    <b style="text-decoration: underline;">
                    Purwono
                    </b><br>
                    Kepala Gudang
                </div>
            </div>
            <div class="col">
                <div class="content-hormat text-left">
                    Mengetahui,<br>
                </div>
                <div class="content-img-ttd text-left">
                    <br><br><br>
                </div>
                <div class="content-hormat text-left">
                    <b style="text-decoration: underline;">
                    Lisa
                    </b><br>
                    Penanggung Jawab Teknis
                </div>
            </div>
            <div class="col" style="border: 1px solid black; padding: 10px;">
                <div class="content-hormat text-left">
                    <b>Nama Petugas :</b><br>
                </div>
                <div class="content-hormat text-left">
                    <!-- <ol>
                      <li></li>
                    </ol> -->
                </div>
            </div>
        </div>
      </div>
    </div>
    <br><br>
  </div>
</body>

</html>