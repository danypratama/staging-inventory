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
                                        <p><?php echo $no; ?>. (<?php echo $data2['tgl_pesanan'] ?>) / (<?php echo $data2['no_po'] ?>) / (<?php echo $data2['no_spk'] ?>)</p>
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

                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card-body p-3 border" style="min-height: 234px;">
                            <div class="row">
                                <div class="col-5">
                                    <p style="float: left;">Order Via</p>
                                    <p style="float: right;">:</p>
                                </div>
                                <div class="col-7">
                                    <?php echo $data['order_by'] ?>
                                </div>
                            </div>
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
                                    <p style="float: left;">Alamat</p>
                                    <p style="float: right;">:</p>
                                </div>
                                <div class="col-7">
                                    <?php echo $data['alamat'] ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-5">
                                    <p style="float: left;">Note</p>
                                    <p style="float: right;">:</p>
                                </div>
                                <div class="col-7">
                                    <?php
                                    if ($data['note_inv'] != '') {
                                        echo $data['note_inv'];
                                    } else {
                                        echo '-';
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="row">
                                <?php
                                if ($data['ongkir'] != 0) {
                                    echo '<div class="row">
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
                            </div>
                            <div class="row">
                                <div class="col-5">
                                    <?php  
                                        $status_kirim = mysqli_query($connect, "SELECT jenis_pengiriman FROM status_kirim WHERE id_inv = '$id_inv'");
                                        $data_status_kirim = mysqli_fetch_array($status_kirim);
                                        $jenis_pengiriman =  $data_status_kirim['jenis_pengiriman'];
                                    ?>
                                    <p style="float: left;">Jenis Pengiriman</p>
                                    <p style="float: right;">:</p>
                                </div>
                                <div class="col-7">
                                    <?php echo $data_status_kirim['jenis_pengiriman'] ?>
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
                            <a href="invoice-reguler-dikirim.php?sort=baru" class="btn btn-warning btn-detail mb-2">
                                <i class="bi bi-arrow-left"></i> Halaman Sebelumnya
                            </a>
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
                            <button class="btn btn-secondary btn-detail mb-2" data-bs-toggle="modal" data-bs-target="#Diterima">
                                <i class="bi bi-send"></i> Diterima
                            </button>
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
                                        <td class="text-center text-nowrap"><?php echo $no; ?></td>
                                        <td class="text-center text-nowrap"><?php echo $data_trx['no_spk']; ?></td>
                                        <td class="text-nowrap"><?php echo $data_trx['nama_produk'] ?></td>
                                        <td class="text-center text-nowrap"><?php echo $data_trx['nama_merk'] ?></td>
                                        <td class="text-end"><?php echo number_format($data_trx['harga']) ?></td>
                                        <?php
                                        if ($total_data != 0) {
                                            if ($data_cek['kategori_inv'] == 'Diskon') {
                                                echo "<td class='text-end'>" . $disc . "</td>";
                                            }
                                        }
                                        ?>
                                        <td class="text-end text-nowrap"><?php echo number_format($data_trx['qty']) ?></td>
                                        <td class="text-end text-nowrap"><?php echo number_format($data_trx['total_harga']) ?></td>
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
            <!-- Modal Kategori Inv -->
            <div class="modal fade" id="ubahKat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Ubah Kategori</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="proses/proses-invoice-bum.php" method="POST">
                                <?php
                                $id_inv_kat = $id_inv;
                                $sql_kat = "SELECT 
                                            bum.*, 
                                            sr.id_customer, sr.id_inv, sr.no_spk, sr.no_po, sr.tgl_pesanan
                                            FROM inv_bum AS bum
                                            JOIN spk_reg sr ON (bum.id_inv_bum = sr.id_inv)
                                            WHERE bum.id_inv_bum = '$id_inv_kat'";
                                $query_kat = mysqli_query($connect, $sql_kat);
                                $data_kat = mysqli_fetch_array($query_kat);
                                ?>
                                <input type="hidden" name="id_inv" value="<?php echo $id_inv_kat ?>" readonly>
                                <div class="mb-3">
                                    <select name="kat_inv" class="form-select">
                                        <?php
                                        $kategori_inv = $data_kat['kategori_inv'];
                                        $pilihan_sisa = array('Reguler', 'Diskon', 'Spesial Diskon');
                                        foreach ($pilihan_sisa as $pilihan) {
                                            if ($pilihan != $kategori_inv) {
                                                echo '<option value="' . $pilihan . '">' . $pilihan . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>

                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary" name="ubah-kategori">Update Kategori</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Modal -->
        </section>
    </main><!-- End #main -->

    <!-- Footer -->
    <?php include "page/footer.php" ?>
    <!-- End Footer -->
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <?php include "page/script.php" ?>
</body>

</html>

<!-- Modal Diterima-->
<div class="modal fade" id="Diterima" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Ubah Status</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <form action="proses/proses-invoice-bum-diterima.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id_inv" value="<?php echo $data_cek['id_inv']; ?>">
                        <input type="hidden" name="alamat" value="<?php echo $data['alamat']; ?>">
                        <div class="mb-3">
                            <label id="labelJenisPenerima" style="display:none;">Diterima Oleh</label>
                            <select name="diterima_oleh" id="jenis-penerima" class="form-select" style="display:none;">
                                <option value="">Pilih...</option>
                                <option value="Customer">Customer</option>
                                <option value="Ekspedisi">Ekspedisi</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label style="display: none;" id="labelPenerima">Nama Penerima</label>
                            <input type="text" class="form-control" name="nama_penerima" id="penerima" style="display: none;">
                        </div>
                        <div class="mb-3">
                            <label id="labelEkspedisi" style="display: none;">Pilih Ekspedisi</label>
                            <select id="ekspedisi" name="ekspedisi" class="form-select" style="display: none;">
                                <option value="">Pilih...</option>
                                <?php
                                include "koneksi.php";
                                $sql_ekspedisi = mysqli_query($connect, "SELECT * FROM ekspedisi");
                                while ($data_ekspedisi = mysqli_fetch_array($sql_ekspedisi)) {
                                ?>
                                    <option value="<?php echo $data_ekspedisi['id_ekspedisi'] ?>"><?php echo $data_ekspedisi['nama_ekspedisi'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label style="display: none;" id="labelResi">No. Resi</label>
                            <input type="text" class="form-control" name="resi" id="resi" style="display: none;">
                        </div>
                        <div class="mb-3">
                            <label id="labelDate">Tanggal</label>
                            <input type="text" style="background-color:white;" class="bg-white form-control" name="tgl" id="date" required>
                        </div>
                        <div class="mb-3">
                            <label id="labelBukti1" style="display: none;">Bukti Terima 1</label>
                            <input type="file" name="fileku1" id="fileku1" accept="image/*" onchange="compressAndPreviewImage(event)" style="display: none;">
                        </div>
                        <div class="mb-3" id="imagePreview" style="display: none;"></div>

                        <div class="mb-3">
                            <label id="labelBukti2" style="display: none;">Bukti Terima 2</label>
                            <input type="file" name="fileku2" id="fileku2" accept="image/*" onchange="compressAndPreviewImage2(event)" style="display: none;">
                        </div>
                        <div class="mb-3" id="imagePreview2" style="display: none;"></div>
                        <div class="mb-3">
                            <label id="labelBukti3" for="fileku" style="display: none;">Bukti Terima 3</label>
                            <input type="file" name="fileku3" id="fileku3" accept="image/*" onchange="compressAndPreviewImage3(event)" style="display: none;">
                        </div>
                        <div class="mb-3" id="imagePreview3" style="display: none;"></div>
                        <?php
                        if ($jenis_pengiriman == 'Driver') {
                            echo '
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary" name="diterima_driver" id="diterima" onclick="checkFileName()" disabled><i class="bi bi-arrow-left-right"></i> Ubah Status</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancelDriver"><i class="bi bi-x-circle"></i> Cancel</button>
                                </div>';
                        } else {
                            echo '
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" name="diterima_ekspedisi" id="diterima" onclick="checkFileName()"><i class="bi bi-arrow-left-right"></i> Ubah Status</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancelEkspedisi"><i class="bi bi-x-circle"></i> Cancel</button>
                            </div>';
                        }
                        ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php include "page/upload-img.php";  ?>
    <!-- kode JS Dikirim -->
    <script>
        var input = document.getElementById('resi');

        input.addEventListener('input', function() {
            var sanitizedValue = input.value.replace(/[^A-Za-z0-9]/g, '');
            input.value = sanitizedValue;
        });
    </script>
    <script>
        function checkFileName() {
            var file1 = document.getElementById('fileku1').value;
            var file2 = document.getElementById('fileku2').value;
            var file3 = document.getElementById('fileku3').value;

            if (file1 === file2 && file2 !== "") {
                alert("Nama file ke 2 harus berbeda!");
                document.getElementById('fileku2').value = "";
                document.getElementById('imagePreview2').innerHTML = "";
            }

            if (file1 === file3 && file3 !== "") {
                alert("Nama file ke 3 harus berbeda!");
                document.getElementById('fileku3').value = "";
                document.getElementById('imagePreview3').innerHTML = "";
            }

            if (file2 === file3 && file3 !== "") {
                alert("Nama file ke 3 harus berbeda!");
                document.getElementById('fileku3').value = "";
                document.getElementById('imagePreview3').innerHTML = "";
            }
        }
    </script>
    <script>
        const jenisPenerima = <?php echo json_encode($jenis_pengiriman); ?>;
        const labeljenisPenerima = document.getElementById('labelJenisPenerima');
        const jenisPenerimaSelect = document.getElementById('jenis-penerima');
        const labelPenerima = document.getElementById('labelPenerima');
        const penerima = document.getElementById('penerima');
        const labelEkspedisi = document.getElementById('labelEkspedisi');
        const ekspedisiSelect = document.getElementById('ekspedisi');
        const labelResi = document.getElementById('labelResi');
        const resi = document.getElementById('resi');
        const labelBukti1 = document.getElementById('labelBukti1');
        const labelBukti2 = document.getElementById('labelBukti2');
        const labelBukti3 = document.getElementById('labelBukti3'); 
        const file1 = document.getElementById('fileku1');
        const file2 = document.getElementById('fileku2');
        const file3 = document.getElementById('fileku3');
        const imagePreview = document.getElementById('imagePreview');
        const imagePreview2 = document.getElementById('imagePreview2');
        const imagePreview3 = document.getElementById('imagePreview3');
        const diterima = document.getElementById('diterima');

        if (jenisPenerima === 'Driver') { 
            labelJenisPenerima.style.display = 'block'; // Menampilkan Form Input
            jenisPenerimaSelect.style.display = 'block'; // Menampilkan Form Input
            jenisPenerimaSelect.setAttribute('required', 'true');
            diterima.disabled = false;
            
            //Membuat event listener saat select data
            jenisPenerimaSelect.addEventListener('change', function(){
                if (this.value === 'Customer'){
                    labelPenerima.style.display = 'block'; // Menampilkan Form Input
                    penerima.style.display = 'block'; // Menampilkan Form Input
                    penerima.setAttribute('required', 'true'); // Membuat Atribut Required
                    labelEkspedisi.style.display = 'none'; // Menyembunyikan Form Input
                    ekspedisiSelect.style.display = 'none'; // Menyembunyikan Form Input
                    ekspedisiSelect.value = ''; // Reset Value
                    labelResi.style.display = 'none'; // Menyembunyikan Form Input
                    resi.style.display = 'none'; // Menyembunyikan Form Input
                    resi.value = ''; // Reset Value
                    labelBukti1.style.display = 'block'; // Menampilkan form input
                    labelBukti2.style.display = 'block'; // Menampilkan form input
                    labelBukti3.style.display = 'block'; // Menampilkan form input
                    file1.style.display = 'block'; // Menampilkan form input
                    file1.setAttribute('required', 'true');// Membuat Atribut Required
                    file2.style.display = 'block'; // Menampilkan form input
                    file3.style.display = 'block'; // Menampilkan form input
                    imagePreview.style.display = 'block'; // Menampilkan konten di dalam elemen "imagePreview"
                    imagePreview2.style.display = 'block'; // Menampilkan konten di dalam elemen "imagePreview2"
                    imagePreview3.style.display = 'block'; // Menampilkan konten di dalam elemen "imagePreview3"
                    file1.value = ''; // Mengatur ulang nilai menjadi kosong
                    file2.value = ''; // Mengatur ulang nilai menjadi kosong
                    file3.value = ''; // Mengatur ulang nilai menjadi kosong
                    imagePreview.innerHTML = ''; // Menghapus konten di dalam elemen "imagePreview"
                    imagePreview2.innerHTML = ''; // Menghapus konten di dalam elemen "imagePreview2"
                    imagePreview3.innerHTML = ''; // Menghapus konten di dalam elemen "imagePreview3"
                    ekspedisiSelect.removeAttribute('required', 'true'); // Membuat Atribut Required
                    resi.removeAttribute('required', 'true'); // Membuat Atribut Required
                } else if (this.value === 'Ekspedisi'){
                    labelPenerima.style.display = 'none'; // Menyembunyikan Form Input
                    penerima.style.display = 'none'; // Menyembunyikan Form Input
                    penerima.value = ''; // Reset Value
                    penerima.removeAttribute('required', 'true'); // Membuat Atribut Required
                    labelEkspedisi.style.display = 'block'; // Menampilkan Form Input
                    ekspedisiSelect.style.display = 'block'; // Menampilkan Form Input
                    ekspedisiSelect.setAttribute('required', 'true'); // Membuat Atribut Required
                    labelResi.style.display = 'block'; // Menampilkan Form Input
                    resi.style.display = 'block'; // Menampilkan Form Input
                    resi.setAttribute('required', 'true'); // Membuat Atribut Required
                    labelBukti1.style.display = 'block'; // Menampilkan form input
                    labelBukti2.style.display = 'block'; // Menampilkan form input
                    labelBukti3.style.display = 'block'; // Menampilkan form input
                    file1.style.display = 'block'; // Menampilkan form input
                    file1.setAttribute('required', 'true');// Membuat Atribut Required
                    file2.style.display = 'block'; // Menampilkan form input
                    file3.style.display = 'block'; // Menampilkan form input
                    imagePreview.style.display = 'block'; // Menampilkan konten di dalam elemen "imagePreview"
                    imagePreview2.style.display = 'block'; // Menampilkan konten di dalam elemen "imagePreview2"
                    imagePreview3.style.display = 'block'; // Menampilkan konten di dalam elemen "imagePreview3"
                } else if (this.value === ''){
                    labelPenerima.style.display = 'none'; // Menyembunyikan Form Input
                    penerima.style.display = 'none'; // Menyembunyikan Form Input
                    penerima.value = ''; // Reset Value
                    labelEkspedisi.style.display = 'none'; // Menyembunyikan Form Input
                    ekspedisiSelect.style.display = 'none'; // Menyembunyikan Form Input
                    ekspedisiSelect.value = ''; // Reset Value
                    labelResi.style.display = 'none'; // Menyembunyikan Form Input
                    resi.style.display = 'none'; // Menyembunyikan Form Input
                    resi.value = ''; // Reset Value
                }
            });

        } else if (jenisPenerima === 'Ekspedisi') {
            labelPenerima.style.display = 'block'; // Menampilkan Form Input
            penerima.style.display = 'block'; // Menampilkan Form Input
            penerima.setAttribute('required', 'true'); // Membuat Atribut Required
        } else {
            console.log("Nilai jenis Penerima tidak valid");
        }

        // membuat refresh halaman modal tanpa menutup modal dialog
        let isModalShown = false;
        // Refresh halaman modal
        if (isModalShown) {
            $('#Diterima').modal('hide'); // Menyembunyikan modal
            location.reload(); // Melakukan refresh halaman
            $('#Diterima').modal('show'); // Menampilkan modal kembali
        }

        // Mendapatkan tombol "Cancel" berdasarkan ID
        const cancelDriver = document.getElementById('cancelDriver');
        if (cancelDriver) {
            cancelDriver.addEventListener('click', function() {
            jenisPenerimaSelect.value = ''; // Mengatur ulang nilai menjadi kosong
            penerima.value = ''; // Mengatur ulang nilai menjadi kosong
            ekspedisiSelect.value = ''; // Mengatur ulang nilai menjadi kosong
            resi.value = ''; // Mengatur ulang nilai menjadi kosong
            file1.value = ''; // Mengatur ulang nilai menjadi kosong
            file2.value = ''; // Mengatur ulang nilai menjadi kosong
            file3.value = ''; // Mengatur ulang nilai menjadi kosong
            imagePreview.innerHTML = ''; // Menghapus konten di dalam elemen "imagePreview"
            imagePreview2.innerHTML = ''; // Menghapus konten di dalam elemen "imagePreview2"
            imagePreview3.innerHTML = ''; // Menghapus konten di dalam elemen "imagePreview3"
            labelPenerima.style.display = 'none'; // Menyembunyikan form input
            penerima.style.display = 'none'; // Menyembunyikan form input
            labelEkspedisi.style.display = 'none'; // Menyembunyikan form input
            ekspedisiSelect.style.display = 'none'; // Menyembunyikan form input
            labelResi.style.display = 'none'; // Menyembunyikan form input
            resi.style.display = 'none'; // Menyembunyikan form input
            labelBukti1.style.display = 'none'; // Menyembunyikan form input
            labelBukti2.style.display = 'none'; // Menyembunyikan form input
            labelBukti3.style.display = 'none'; // Menyembunyikan form input
            file1.style.display = 'none'; // Menyembunyikan form input
            file2.style.display = 'none'; // Menyembunyikan form input
            file3.style.display = 'none'; // Menyembunyikan form input
        });
        } else {
            console.log("Button Cancel Driver Sedang Aktif");
        }

         // Mendapatkan tombol "Cancel" berdasarkan ID
        const cancelEkspedisi = document.getElementById('cancelEkspedisi');
        if (cancelEkspedisi) {
            cancelEkspedisi.addEventListener('click', function() {
                penerima.value = ''; // Mengatur ulang nilai menjadi kosong
            });
        } else {
            console.log("Button Cancel Ekspedisi Sedang Aktif");
        }
    </script>
    <!-- End JS Dikirim -->
    <style>
        .preview-image {
            max-width: 100%;
            height: auto;
        }
    </style>
</div>
<!-- End Modal Diterima  -->

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

<!-- date picker with flatpick -->
<script type="text/javascript">
    flatpickr("#date", {
        dateFormat: "d/m/Y",
    });

    flatpickr("#tempo", {
        dateFormat: "d/m/Y",
    });

    // untuk menampilkan tanggal hari ini
    var dateInput = document.getElementById('date');

    // Membuat objek tanggal hari ini
    var today = new Date();

    // Mendapatkan hari, bulan, dan tahun dari tanggal hari ini
    var day = String(today.getDate()).padStart(2, '0');
    var month = String(today.getMonth() + 1).padStart(2, '0');
    var year = today.getFullYear();

    // Mengatur nilai default input dengan format yang diinginkan
    dateInput.value = day + '/' + month + '/' + year;
</script>
<!-- end date picker -->