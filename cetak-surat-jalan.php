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
  </style>
</head>

<body>
    <div class="card-body p-2">
        <?php  
            if(isset($_POST["cetak"])) {
                $id_inv = $_POST['id_inv'];
                $disetujui = $_POST['disetujui'];
            }

            include 'koneksi.php';
            $sql_surat_jalan = " SELECT
                                    sk.tgl_kirim, 
                                    COALESCE(nonppn.cs_inv, ppn.cs_inv, bum.cs_inv) AS cs_inv,
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
        ?>
        <div class="row p-3">
            <div class="col-sm-8">
                <img class="img-fluid" src="assets/img/header-kma.jpg">
            </div>
            <div class="col-sm-4 border border-dark">
                <p class="text-center" style="font-size: 23px; text-decoration: underline;">
                    <b>SURAT JALAN</b><br>
                </p>
                <p style="font-size: 18px;">Tanggal Kirim : <?php echo $tgl_kirim ?></p>
            </div>
        </div>
        <div class="row p-3">
            <div class="col-sm-7" style="font-size: 18px;">
                <b>Kepada :</b><br>
                <b><?php echo $cs_inv ?></b><br>
                <b>
                    <?php echo $alamat ?>		
                </b>
            </div>
            <div class="col-sm-1"></div>
            <div class="col-sm-4">
                <p class="border border-dark p-2" style="font-size: 18px;">
                    <b>No.PO : <?php echo $no_po ?></b>
                </p>
            </div>
        </div>
        <table class="table table-bordered border-dark">
            <thead>
                <tr>
                    <th class="text-center col-1">No</th>
                    <th class="text-center col-8">Nama Produk</th>
                    <th class="text-center col-3">Qty</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $no = 1;
                    $sql_trx = "SELECT 
                                    COALESCE(nonppn.id_inv_nonppn, ppn.id_inv_ppn, bum.id_inv_bum) AS id_inv,
                                    trx.id_transaksi,
                                    trx.id_produk,
                                    trx.nama_produk_spk,
                                    trx.qty,
                                    trx.status_trx,
                                    COALESCE(tpr.nama_produk, tpsm.nama_set_marwa) AS nama_produk,
                                    tpr.satuan
                                FROM spk_reg AS spk
                                LEFT JOIN inv_nonppn nonppn ON spk.id_inv = nonppn.id_inv_nonppn
                                LEFT JOIN inv_ppn ppn ON spk.id_inv = ppn.id_inv_ppn
                                LEFT JOIN inv_bum bum ON spk.id_inv = bum.id_inv_bum
                                LEFT JOIN transaksi_produk_reg trx ON trx.id_spk = spk.id_spk_reg
                                LEFT JOIN tb_produk_reguler tpr ON trx.id_produk = tpr.id_produk_reg
                                LEFT JOIN tb_produk_set_marwa tpsm ON trx.id_produk = tpsm.id_set_marwa
                                WHERE nonppn.id_inv_nonppn = '$id_inv' OR ppn.id_inv_ppn = '$id_inv' OR bum.id_inv_bum = '$id_inv' AND status_trx = '1' ORDER BY no_spk ASC";
                    $trx_produk_reg = mysqli_query($connect, $sql_trx);
                    while ($data_trx = mysqli_fetch_array($trx_produk_reg)) {
                        $id_produk = $data_trx['id_produk'];
                        $satuan = $data_trx['satuan'];
                        $id_produk_substr = substr($id_produk, 0, 2);
                        if ($id_produk_substr == 'BR') {
                            $satuan_produk = $satuan;
                        } else {
                            $satuan_produk = 'Set';
                        }
                ?>
                <tr>
                    <td class="text-center"><?php echo $no ?></td>
                    <td><?php echo $data_trx['nama_produk_spk'] ?></td>
                    <td class="text-center"><?php echo $data_trx['qty']. '&nbsp;' .$satuan_produk. '' ?></td>
                </tr>
                <?php $no++ ?>
                <?php } ?>
            </tbody>
        </table>
        <b style="font-size: 17px;">Keterangan :</b>
        <div class="col-sm-12 border border-dark p-1" style="font-size: 17px;">
            1. Barang tersebut diatas telah diterima dalam keadaan baik dan bagus <br>
            2. Barang tersebut di atas apabila  dikembalikan/retur dalam keadaan baik  dan berfungsi dalam waktu 7 hari terhitung dari tanggal penerimaan barang 
        </div>

        <div class="row mt-4">
            <div class="col-sm-1"></div>
            <div class="col-sm-3 border border-dark">
                <p class="text-center mt-1">
                    <b>Disetujui Oleh :</b>
                </p>
                <br><br><br>
                <p class="text-center">
                   <?php echo $disetujui ?>
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