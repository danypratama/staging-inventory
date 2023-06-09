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
                font-size: 14px;
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
        <!-- SWEET ALERT -->
        <section>
            <div class="card shadow p-2">
                <div class="card-header text-center">
                    <h5><strong>DETAIL INVOICE BUM</strong></h5>
                </div>
                <?php
                include "koneksi.php";
                $id_inv = base64_decode($_GET['id']);
                $sql = "SELECT 
                            bum.*, 
                            sr.id_user, sr.id_customer, sr.id_inv, sr.no_spk, sr.no_po, sr.tgl_pesanan,
                            cs.nama_cs, cs.alamat, ordby.order_by, sl.nama_sales 
                            FROM inv_bum AS bum
                            JOIN spk_reg sr ON (bum.id_inv_bum = sr.id_inv)
                            JOIN tb_customer cs ON(sr.id_customer = cs.id_cs)
                            JOIN tb_orderby ordby ON(sr.id_orderby = ordby.id_orderby)
                            JOIN tb_sales sl ON(sr.id_sales = sl.id_sales)
                            WHERE bum.id_inv_bum = '$id_inv'";
                $query = mysqli_query($connect, $sql);
                $data = mysqli_fetch_array($query);
                ?>
                <div class="row mt-3">
                    <div class="col-sm-6">
                        <div class="card-body p-3 border">
                            <div class="row">
                                <div class="col-5">
                                    <p style="float: left;">Tgl. Pesanan</p>
                                    <p style="float: right;">:</p>
                                </div>
                                <div class="col-7">
                                    <?php echo $data['tgl_pesanan'] ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-5">
                                    <p style="float: left;">No. SPK</p>
                                    <p style="float: right;">:</p>
                                </div>
                                <div class="col-7">
                                    <?php
                                    include "koneksi.php";
                                    $id_inv = base64_decode($_GET['id']);
                                    $no = 1;
                                    $sql = "SELECT 
                                                    bum.*, 
                                                    sr.id_user, sr.id_customer, sr.id_inv, sr.no_spk, sr.no_po, sr.tgl_pesanan,
                                                    cs.nama_cs, cs.alamat, ordby.order_by, sl.nama_sales 
                                                    FROM inv_bum AS bum
                                                    JOIN spk_reg sr ON (bum.id_inv_bum = sr.id_inv)
                                                    JOIN tb_customer cs ON(sr.id_customer = cs.id_cs)
                                                    JOIN tb_orderby ordby ON(sr.id_orderby = ordby.id_orderby)
                                                    JOIN tb_sales sl ON(sr.id_sales = sl.id_sales)
                                                    WHERE bum.id_inv_bum = '$id_inv'";
                                    $query = mysqli_query($connect, $sql);
                                    $totalData = mysqli_num_rows($query);

                                    while ($data2 = mysqli_fetch_array($query)) {
                                        $id_inv = $data2['id_inv_bum'];
                                        $kat_inv = $data2['kategori_inv'];
                                        $id_cs = $data2['id_customer'];
                                    ?>
                                        <p><?php echo $no; ?>. (<?php echo $data2['tgl_pesanan'] ?>) / <?php if (!empty($data2['no_po'])) {
                                                                                                            echo "(" . $data2['no_po'] . ")/";
                                                                                                        } ?> (<?php echo $data2['no_spk'] ?>)</p>
                                        <?php $no++; ?>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-5">
                                    <p style="float: left;">No. Invoice</p>
                                    <p style="float: right;">:</p>
                                </div>
                                <div class="col-7">
                                    <?php echo $data['no_inv'] ?>
                                </div>
                            </div>
                            <?php
                               if ($data['no_po'] != '') {
                                    echo '
                                    <div class="row">
                                        <div class="col-5">
                                            <p style="float: left;">No. PO</p>
                                            <p style="float: right;">:</p>
                                        </div>
                                        <div class="col-7">
                                            ' . $data['no_po'] . '
                                        </div>
                                    </div>';
                                }
                            ?>
                            <div class="row">
                                <div class="col-5">
                                    <p style="float: left;">Tgl. Invoice</p>
                                    <p style="float: right;">:</p>
                                </div>
                                <div class="col-7">
                                    <?php echo $data['tgl_inv'] ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-5">
                                    <p style="float: left;">Jenis Invoice</p>
                                    <p style="float: right;">:</p>
                                </div>
                                <div class="col-7">
                                    <?php echo $data['kategori_inv'] ?>
                                </div>
                            </div>
                            <?php
                            if ($data['kategori_inv'] == 'Spesial Diskon') {
                                echo '<div class="row">
                                                <div class="col-5">
                                                    <p style="float: left;">Spesial Diskon</p>
                                                    <p style="float: right;">:</p>
                                                </div>
                                                <div class="col-7">
                                                    ' . $data['sp_disc'] . ' %
                                                </div>
                                            </div>';
                            }
                            ?>
                            <div class="row">
                                <div class="col-5">
                                    <p style="float: left;">Order Via</p>
                                    <p style="float: right;">:</p>
                                </div>
                                <div class="col-7">
                                    <?php echo $data['order_by'] ?>
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
                                    <?php echo $data['nama_sales'] ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-5">
                                    <p style="float: left;">Pelanggan</p>
                                    <p style="float: right;">:</p>
                                </div>
                                <div class="col-7">
                                    <?php echo $data['nama_cs'] ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-5">
                                    <p style="float: left;">Pelanggan Inv</p>
                                    <p style="float: right;">:</p>
                                </div>
                                <div class="col-7">
                                    <?php echo $data['cs_inv'] ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-5">
                                    <p style="float: left;">Alamat</p>
                                    <p style="float: right;">:</p>
                                </div>
                                <div class="col-7">
                                    <?php echo $data['alamat'] ?>
                                </div>
                            </div>
                            <?php
                               if ($data['note_inv'] != '') {
                                    echo '
                                    <div class="row">
                                        <div class="col-5">
                                            <p style="float: left;">Note</p>
                                            <p style="float: right;">:</p>
                                        </div>
                                        <div class="col-7">
                                            ' . $data['note_inv'] . '
                                        </div>
                                    </div>';
                                }
                            ?>
                            <?php
                                if ($data['ongkir'] != 0) {
                                    echo '
                                    <div class="row">
                                        <div class="col-5">
                                            <p style="float: left;">Ongkir</p>
                                            <p style="float: right;">:</p>
                                        </div>
                                        <div class="col-7">
                                            ' . number_format($data['ongkir']) . '
                                        </div>
                                    </div>';
                                }
                            ?>
                            <div class="row">
                                <div class="col-5">
                                <?php  
                                        $status_kirim = mysqli_query($connect, "SELECT jenis_pengiriman, dikirim_ekspedisi, dikirim_driver FROM status_kirim WHERE id_inv = '$id_inv'");
                                        $data_status_kirim = mysqli_fetch_array($status_kirim);
                                        $jenis_pengiriman =  $data_status_kirim['jenis_pengiriman'];
                                        $ekspedisi = $data_status_kirim['dikirim_ekspedisi'];
                                        $driver = $data_status_kirim['dikirim_driver'];


                                        $ekspedisi_kirim =  mysqli_query($connect, "SELECT sk.jenis_pengiriman, sk.dikirim_ekspedisi, ex.nama_ekspedisi
                                                                                    FROM status_kirim AS sk
                                                                                    JOIN ekspedisi ex ON (sk.dikirim_ekspedisi = ex.id_ekspedisi)
                                                                                    WHERE sk.dikirim_ekspedisi = '$ekspedisi'");
                                        $data_ekspedisi_kirim = mysqli_fetch_array($ekspedisi_kirim);
                                        
                                        $driver_kirim =  mysqli_query($connect, "SELECT sk.jenis_pengiriman, sk.dikirim_driver, us.nama_user 
                                                                                    FROM status_kirim AS sk
                                                                                    JOIN user us ON (sk.dikirim_driver = us.id_user)
                                                                                    WHERE sk.dikirim_driver = '$driver'");
                                        $data_driver_kirim = mysqli_fetch_array($driver_kirim);
                                    ?>
                                    <p style="float: left;">Jenis Pengiriman</p>
                                    <p style="float: right;">:</p>
                                </div>
                                <div class="col-7">
                                    <?php  
                                        if($jenis_pengiriman == 'Ekspedisi'){
                                            echo $jenis_pengiriman . " ( " . $data_ekspedisi_kirim['nama_ekspedisi']. " )";
                                        } else {
                                            echo $jenis_pengiriman . " ( " . $data_driver_kirim['nama_user']. " )";
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- Tampil data -->
            <div class="card shadow">
                <div class="card-body p-3">
                    <div class="table-responsive">
                        <div class="text-start mb-3">
                            <a href="invoice-reguler-diterima.php" class="btn btn-warning btn-detail mb-2">
                                <i class="bi bi-arrow-left"></i> Halaman Sebelumnya
                            </a>
                            <!-- Button modal Bukti Terima -->
                            <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#bukti">
                                <i class="bi bi-file-earmark-image"></i> Bukti Terima
                            </button>
                            <!-- End Button Modal Bukti Terima -->
                            
                            <!-- Trx Selesai -->
                            <button type="button" class="btn btn-secondary mb-2" data-bs-toggle="modal" data-bs-target="#trxSelesai">
                                <i class="bi bi-check2-circle"></i> Transaksi Selesai
                            </button>
                            <!-- End Trx Selesai -->  


                            <?php
                            $id_inv_bum = base64_decode($_GET['id']);
                            $sql_cek = "SELECT 
                                        bum.id_inv_bum, kategori_inv,
                                        sr.id_inv, sr.no_spk,
                                        trx.*, 
                                        spr.stock, 
                                        tpr.nama_produk, 
                                        tpr.harga_produk, mr.* 
                                        FROM inv_bum AS bum
                                        JOIN spk_reg sr ON (bum.id_inv_bum = sr.id_inv)
                                        JOIN transaksi_produk_reg trx ON(sr.id_spk_reg = trx.id_spk)
                                        JOIN stock_produk_reguler spr ON(trx.id_produk = spr.id_produk_reg)
                                        JOIN tb_produk_reguler tpr ON(trx.id_produk = tpr.id_produk_reg)
                                        JOIN tb_merk mr ON (tpr.id_merk = mr.id_merk)
                                        WHERE bum.id_inv_bum = '$id_inv_bum' AND status_trx = '1' ORDER BY no_spk ASC";
                            $query_cek = mysqli_query($connect, $sql_cek);
                            $data_cek = mysqli_fetch_array($query_cek);
                            $total_data = mysqli_num_rows($query_cek);
                            ?>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <?php
                            if ($total_data != 0) {
                                if ($data_cek['kategori_inv'] != 'Diskon') {
                                    echo '
                                        <thead>
                                            <tr class="text-white" style="background-color: #051683;">
                                                <th class="text-center text-nowrap p-3" style="width:20px">No</th>
                                                <th class="text-center text-nowrap p-3" style="width:80px">No. SPK</th>
                                                <th class="text-center text-nowrap p-3" style="width:200px">Nama Produk</th>
                                                <th class="text-center text-nowrap p-3" style="width:100px">Merk</th>
                                                <th class="text-center text-nowrap p-3" style="width:100px">Harga</th>
                                                <th class="text-center text-nowrap p-3" style="width:80px">Qty Order</th>
                                                <th class="text-center text-nowrap p-3" style="width:80px">Total</th>
                                            </tr>
                                        </thead>';
                                } else {
                                    echo '
                                        <thead>
                                            <tr class="text-white" style="background-color: #051683;">
                                                <th class="text-center text-nowrap p-3" style="width:20px">No</th>
                                                <th class="text-center text-nowrap p-3" style="width:100px">No. SPK</th>
                                                <th class="text-center text-nowrap p-3" style="width:200px">Nama Produk</th>
                                                <th class="text-center text-nowrap p-3" style="width:100px">Merk</th>
                                                <th class="text-center text-nowrap p-3" style="width:100px">Harga</th>
                                                <th class="text-center text-nowrap p-3" style="width:100px">Diskon</th>
                                                <th class="text-center text-nowrap p-3" style="width:80px">Qty Order</th>
                                                <th class="text-center text-nowrap p-3" style="width:80px">Total</th>
                                            </tr>
                                        </thead>';
                                }
                            }
                            ?>
                            <tbody>
                                <?php
                                include "koneksi.php";
                                $year = date('y');
                                $day = date('d');
                                $month = date('m');
                                $id_bum_decode = base64_decode($_GET['id']);
                                $no = 1;
                                $sql_trx = "SELECT 
                                                    bum.id_inv_bum,
                                                    sr.id_inv, sr.no_spk,
                                                    trx.*, 
                                                    spr.stock, 
                                                    tpr.nama_produk, 
                                                    tpr.harga_produk, mr.* 
                                                    FROM inv_bum AS bum
                                                    JOIN spk_reg sr ON (bum.id_inv_bum = sr.id_inv)
                                                    JOIN transaksi_produk_reg trx ON(sr.id_spk_reg = trx.id_spk)
                                                    JOIN stock_produk_reguler spr ON(trx.id_produk = spr.id_produk_reg)
                                                    JOIN tb_produk_reguler tpr ON(trx.id_produk = tpr.id_produk_reg)
                                                    JOIN tb_merk mr ON (tpr.id_merk = mr.id_merk)
                                                    WHERE bum.id_inv_bum = '$id_bum_decode' AND status_trx = '1' ORDER BY no_spk ASC";
                                $trx_produk_reg = mysqli_query($connect, $sql_trx);
                                while ($data_trx = mysqli_fetch_array($trx_produk_reg)) {
                                    $disc = $data_trx['disc'];
                                    $id_spk = $data_trx['id_spk'];
                                ?>
                                    <tr>
                                        <td class="text-center"><?php echo $no; ?></td>
                                        <td class="text-center"><?php echo $data_trx['no_spk']; ?></td>
                                        <td class="text-nowrap"><?php echo $data_trx['nama_produk'] ?></td>
                                        <td class="text-center"><?php echo $data_trx['nama_merk'] ?></td>
                                        <td class="text-end"><?php echo number_format($data_trx['harga']) ?></td>
                                        <?php
                                        if ($total_data != 0) {
                                            if ($data_cek['kategori_inv'] == 'Diskon') {
                                                echo "<td class='text-end'>" . $disc . "</td>";
                                            }
                                        }
                                        ?>
                                        <td class="text-end"><?php echo number_format($data_trx['qty']) ?></td>
                                        <td class="text-end"><?php echo number_format($data_trx['total_harga']) ?></td>
                                    </tr>
                                    <?php $no++; ?>
                                <?php } ?>
                            </tbody>
                            <!-- Modal -->
                        </table>
                    </div>

                </div>
                <div class="container">
                    <?php
                    if ($total_data == 0) {
                        echo '<h5 class="text-center">Cek Harga Produk</h5>';
                    }
                    ?>
                </div>
                <form action="proses/proses-invoice-bum.php" method="POST">
                    <?php
                    $no = 1;
                    $id_bum_decode = base64_decode($_GET['id']);
                    $sql_cek_harga = "SELECT 
                                        bum.id_inv_bum, kategori_inv,
                                        sr.id_inv, sr.no_spk,
                                        trx.*, 
                                        spr.stock, 
                                        tpr.nama_produk, 
                                        tpr.harga_produk, mr.* 
                                        FROM inv_bum AS bum
                                        JOIN spk_reg sr ON (bum.id_inv_bum = sr.id_inv)
                                        JOIN transaksi_produk_reg trx ON(sr.id_spk_reg = trx.id_spk)
                                        JOIN stock_produk_reguler spr ON(trx.id_produk = spr.id_produk_reg)
                                        JOIN tb_produk_reguler tpr ON(trx.id_produk = tpr.id_produk_reg)
                                        JOIN tb_merk mr ON (tpr.id_merk = mr.id_merk)
                                        WHERE bum.id_inv_bum = '$id_bum_decode' AND status_trx = '0' ORDER BY no_spk ASC";
                    $query_cek_harga = mysqli_query($connect, $sql_cek_harga);
                    $total_cek_harga = mysqli_num_rows($query_cek_harga);
                    while ($data_cek_harga = mysqli_fetch_array($query_cek_harga)) {
                    ?>
                        <div class="card-body border p-2">
                            <div class="row">
                                <div class="col-1">
                                    <input type="text" class="form-control text-center" value="<?php echo $no; ?>">
                                    <?php $no++ ?>
                                </div>
                                <div class="col-sm-4">
                                    <input type="hidden" name="id_inv" value="<?php echo $data_cek_harga['id_inv_bum'] ?>" readonly>
                                    <input type="hidden" name="id_trx[]" id="id_<?php echo $data_cek_harga['id_transaksi'] ?>" value="<?php echo $data_cek_harga['id_transaksi'] ?>" readonly>
                                    <input type="text" class="form-control bg-light" value="<?php echo $data_cek_harga['nama_produk'] ?>" readonly>
                                </div>
                                <div class="col-sm-1">
                                    <input type="text" class="form-control bg-light text-center" value="<?php echo $data_cek_harga['nama_merk'] ?>" readonly>
                                </div>
                                <div class="col-sm-2">
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">Rp</span>
                                        <input type="text" class="form-control text-end harga_produk" name="harga_produk[]" value="<?php echo number_format($data_cek_harga['harga']) ?>" required>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <?php
                                    if ($total_cek_harga != 0) {
                                        if ($data_cek_harga['kategori_inv'] == 'Diskon') {
                                            echo '  <div class="input-group">
                                                                <input type="text" class="form-control text-end" name="disc[]" value="' . number_format($data_cek_harga['disc']) . '" required>
                                                                <span class="input-group-text" id="basic-addon1">%</span>
                                                            </div>';
                                        } else {
                                            echo '  <div class="input-group">
                                                                <input type="text" class="form-control text-end bg-light" name="disc[]" value="' . number_format($data_cek_harga['disc']) . '" readonly>
                                                                <span class="input-group-text" id="basic-addon1">%</span>
                                                            </div>';
                                        }
                                    }
                                    ?>

                                </div>
                                <div class="col-sm-2">
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">Qty</span>
                                        <input type="text" class="form-control bg-light text-end" name="qty[]" value="<?php echo number_format($data_cek_harga['qty']) ?>" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php } ?>
                    <div class="card-body mt-3 text-end">
                        <?php
                        if ($total_data == 0) {
                            echo '<button type="submit" class="btn btn-primary" name="simpan-cek-harga" id="simpan-data"><i class="bi bi-save"></i> Simpan</button>';
                        }
                        ?>
                    </div>
                </form>
            </div>
            <!-- Modal  Bukti Terima-->
            <div class="modal fade" id="bukti" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Bukti Terima</h1>
                        </div>
                        <div class="modal-body">
                            <div class="card-body">
                            <?php
                            include "koneksi.php";
                            $sql_bukti = "SELECT ibt.*, ip.id_inv, ip.nama_penerima, ip.tgl_terima, sk.jenis_penerima, sk.dikirim_ekspedisi, sk.no_resi, ex.nama_ekspedisi
                                            FROM inv_bukti_terima AS ibt
                                            LEFT JOIN inv_penerima ip ON (ibt.id_inv = ip.id_inv)
                                            LEFT JOIN status_kirim sk ON (ibt.id_inv = sk.id_inv)
                                            LEFT JOIN ekspedisi ex ON (ex.id_ekspedisi = sk.dikirim_ekspedisi) 
                                            WHERE ibt.id_inv = '$id_inv'";
                            $query_bukti = mysqli_query($connect, $sql_bukti);
                            $data_bukti = mysqli_fetch_array($query_bukti);
                            $gambar1 = $data_bukti['bukti_satu'];
                            $gambar_bukti1 = "gambar/bukti1/$gambar1";
                            $gambar2 = $data_bukti['bukti_dua'];
                            $gambar_bukti2 = "gambar/bukti2/$gambar2";
                            $gambar3 = $data_bukti['bukti_tiga'];
                            $gambar_bukti3 = "gambar/bukti3/$gambar3";
                            $jenis_penerima = $data_bukti['jenis_penerima'];
                            $no_resi = $data_bukti['no_resi'];
                            ?>
                            <div class="mb-3">
                                <h6>Nama Penerima : <?php echo $data_bukti['nama_penerima'] ?></h6>
                                <?php if ($jenis_penerima == 'Ekspedisi') {
                                    echo'
                                        <h6>No. Resi :' . $no_resi . '</h6> 
                                    ';
                                }
                                ?>
                                <h6>Tgl. Terima : <?php echo date('d/m/Y', strtotime($data_bukti['created_date']))?></h6>
                            </div>
                            <div id="carouselExample" class="carousel slide">
                                <div class="carousel-inner">
                                    <?php if (!empty($gambar1)) : ?>
                                        <div class="carousel-item active">
                                            <img src="<?php echo $gambar_bukti1 ?>" class="d-block w-100">
                                            <div class="text-center mt-3">
                                                <h5>Bukti Terima 1</h5>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!empty($gambar2)) : ?>
                                        <div class="carousel-item">
                                            <img src="<?php echo $gambar_bukti2 ?>" class="d-block w-100">
                                            <div class="text-center mt-3">
                                                <h5>Bukti Terima 2</h5>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!empty($gambar3)) : ?>
                                        <div class="carousel-item">
                                            <img src="<?php echo $gambar_bukti3 ?>" class="d-block w-100">
                                            <div class="text-center mt-3">
                                                <h5>Bukti Terima 3</h5>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Modal Bukti Terima -->
        </section>
    </main><!-- End #main -->

    <!-- Footer -->
    <?php include "page/footer.php" ?>
    <!-- End Footer -->
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <?php include "page/script.php" ?>

</body>

</html>

<!-- Modal Trx Selesai -->
<div class="modal fade" id="trxSelesai" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
            </div>
            <div class="modal-body">
                <h5>Apakah anda yakin ingin menyelesaikan pesanan ini?</h5>
            </div>
            <div class="modal-footer">
                <a href="proses/proses-trx-selesai.php?id_inv_bum=<?php echo $id_inv ?>" class="btn btn-primary mb-2">
                    <i class="bi bi-check2-circle"></i> Ya, Saya yakin
                </a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Trx Selesai -->


<!-- Generat UUID -->
<?php
function generate_uuid()
{
    return sprintf(
        '%04x%04x%04x',
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0x0fff) | 0x4000,
        mt_rand(0, 0x3fff) | 0x8000,
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff)
    );
}
?>
<!-- End Generate UUID -->

<script>
    function refreshPage() {
        location.reload();
    }
</script>

<script>
    $(document).ready(function() {
        $('.btn-detail').click(function() {
            var idSpk = $(this).data('spk');
            $('#spk').text(idSpk);

            $('button.btn-pilih').attr('data-spk', idSpk);

            $('#modalBarang').modal('show');
        });

        $(document).on('click', '.btn-pilih', function(event) {
            event.preventDefault();
            event.stopPropagation();

            var id = $(this).data('id');
            var spk = $(this).attr('data-spk');

            saveData(id, spk);
        });

        function saveData(id, spk) {
            $.ajax({
                url: 'simpan-data-spk.php',
                type: 'POST',
                data: {
                    id: id,
                    spk: spk
                },
                success: function(response) {
                    console.log('Data berhasil disimpan.');
                    $('button[data-id="' + id + '"]').prop('disabled', true);
                },
                error: function(xhr, status, error) {
                    console.error('Terjadi kesalahan saat menyimpan data:', error);
                }
            });
        }
    });
</script>

<!-- Fungsi menonaktifkan kerboard enter -->
<script>
    document.addEventListener("keydown", function(event) {
        if (event.key === "Enter") {
            event.preventDefault();
            document.getElementById("simpan-data").click();
        }
    });
</script>

<!-- Number format untuk harga -->

<script>
    // Mendapatkan referensi elemen input
    var hargaProdukInputs = document.querySelectorAll('.harga_produk');

    // Menambahkan event listener untuk memformat angka saat nilai berubah
    hargaProdukInputs.forEach(function(input) {
        input.addEventListener('input', function() {
            formatNumber(input);
        });
    });

    // Fungsi untuk memformat angka dengan pemisah ribuan
    function formatNumber(input) {
        var hargaProdukValue = input.value.replace(/[^0-9.-]+/g, '');

        if (hargaProdukValue !== '') {
            var formattedNumber = numberFormat(hargaProdukValue);
            input.value = formattedNumber;
        }
    }

    // Fungsi untuk memformat angka dengan pemisah ribuan
    function numberFormat(number) {
        return new Intl.NumberFormat('en-US').format(number);
    }
</script>
<!-- Edit Harga -->
<script>
    $('#edit-diskon').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var idTrx = button.data('id');
        var harga = button.data('hargadisc');
        var diskon = button.data('diskon');
        var qty = button.data('qty');

        $('#id_trxdisc').val(idTrx);
        $('#harga_produk_disc').val(harga);
        $('#discc').val(diskon);
        $('#qtydisc').val(qty);
    });

    $('#edit').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var idTrx = button.data('id');
        var harga = button.data('harga');
        var qty = button.data('qty');

        $('#id_trx').val(idTrx);
        $('#harga_produk').val(harga);
        $('#qty').val(qty);
    });
</script>