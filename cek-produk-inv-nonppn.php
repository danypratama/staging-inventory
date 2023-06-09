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
        /* Menghilangkan garis pada input */
        input {
            border: none;
            outline: none;
            background: none;
            width: 100%;
        }

        @media only screen and (max-width: 500px) {
            body {
                font-size: 14px;
            }

            .mobile {
                display: none;
            }

            .mobile-text {
                text-align: left !important;
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
            <div class="container-fluid">
                <div class="card shadow p-2">
                    <div class="card-header text-center">
                        <h5><strong>DETAIL INVOICE NONPPN</strong></h5>
                    </div>
                    <?php
                    include "koneksi.php";
                    $id_inv = base64_decode($_GET['id']);
                    $sql = "SELECT 
                            nonppn.*, 
                            sr.id_user, sr.id_customer, sr.id_inv, sr.no_spk, sr.no_po, sr.tgl_pesanan,
                            cs.nama_cs, cs.alamat, ordby.order_by, sl.nama_sales 
                            FROM inv_nonppn AS nonppn
                            JOIN spk_reg sr ON (nonppn.id_inv_nonppn = sr.id_inv)
                            JOIN tb_customer cs ON(sr.id_customer = cs.id_cs)
                            JOIN tb_orderby ordby ON(sr.id_orderby = ordby.id_orderby)
                            JOIN tb_sales sl ON(sr.id_sales = sl.id_sales)
                            WHERE nonppn.id_inv_nonppn = '$id_inv'";
                    $query = mysqli_query($connect, $sql);
                    $data = mysqli_fetch_array($query);
                    $ongkir = $data['ongkir'];
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
                                                    nonppn.*, 
                                                    sr.id_user, sr.id_customer, sr.id_inv, sr.no_spk, sr.no_po, sr.tgl_pesanan,
                                                    cs.nama_cs, cs.alamat, ordby.order_by, sl.nama_sales 
                                                    FROM inv_nonppn AS nonppn
                                                    JOIN spk_reg sr ON (nonppn.id_inv_nonppn = sr.id_inv)
                                                    JOIN tb_customer cs ON(sr.id_customer = cs.id_cs)
                                                    JOIN tb_orderby ordby ON(sr.id_orderby = ordby.id_orderby)
                                                    JOIN tb_sales sl ON(sr.id_sales = sl.id_sales)
                                                    WHERE nonppn.id_inv_nonppn = '$id_inv'";
                                        $query = mysqli_query($connect, $sql);
                                        $totalData = mysqli_num_rows($query);

                                        while ($data2 = mysqli_fetch_array($query)) {
                                            $id_inv = $data2['id_inv_nonppn'];
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
                                                    <p style="float: left;">Sp. Diskon</p>
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
                                                    <p style="float: left;">Note Invoice</p>
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
                        </div>
                        <div class="text-center mt-3 mb-3">
                            <button class="btn btn-info btn-md" data-bs-toggle="modal" data-bs-target="#editPelanggan"><i class="bi bi-pencil"></i> Edit Pelanggan Invoice</button>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="editPelanggan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Pelanggan Invoice</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                   <form action="proses/proses-invoice-nonppn.php" method="POST">
                                        <input type="hidden" name="id_inv" value="<?php echo $id_inv ?>">
                                        <input type="text" class="form-control" name="cs_inv" value="<?php echo $data['cs_inv'] ?>">
                                        <div class="modal-footer">
                                            <button type="submit" name="ubah-cs-inv" class="btn btn-primary">Ubah Data</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                   </form>
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
                                <a href="invoice-reguler.php?sort=baru" class="btn btn-warning btn-detail mb-2">
                                    <i class="bi bi-arrow-left"></i> Halaman Sebelumnya
                                </a>
                                <button class="btn btn-info btn-detail mb-2" data-bs-toggle="modal" data-bs-target="#ubahKat">
                                    <i class="bi bi-arrow-left-right"></i> Ubah Kategori Invoice
                                </button>
                                <a href="#" class="btn btn-primary btn-detail mb-2" data-bs-toggle="modal" data-bs-target="#addSpk">
                                    <i class="bi bi-plus-circle"></i> Tambah SPK
                                </a>
                                <?php
                                $id_inv_nonppn = base64_decode($_GET['id']);
                                $sql_cek = "SELECT 
                                            nonppn.id_inv_nonppn, kategori_inv,
                                            sr.id_inv, sr.no_spk,
                                            trx.*, 
                                            spr.stock, 
                                            tpr.nama_produk, 
                                            tpr.harga_produk, mr.* 
                                            FROM inv_nonppn AS nonppn
                                            JOIN spk_reg sr ON (nonppn.id_inv_nonppn = sr.id_inv)
                                            JOIN transaksi_produk_reg trx ON(sr.id_spk_reg = trx.id_spk)
                                            JOIN stock_produk_reguler spr ON(trx.id_produk = spr.id_produk_reg)
                                            JOIN tb_produk_reguler tpr ON(trx.id_produk = tpr.id_produk_reg)
                                            JOIN tb_merk mr ON (tpr.id_merk = mr.id_merk)
                                            WHERE nonppn.id_inv_nonppn = '$id_inv_nonppn' AND status_trx = '1' ORDER BY no_spk ASC";
                                $query_cek = mysqli_query($connect, $sql_cek);
                                $data_cek = mysqli_fetch_array($query_cek);
                                $total_data = mysqli_num_rows($query_cek);
                                ?>
                                <?php
                                if ($kat_inv == 'Spesial Diskon') {
                                    echo '
                                        <button class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#inputSpdisc"><i class="bi bi-percent"></i> Spesial Diskon</button>';
                                }
                                ?>
                                <?php
                                // Eksekusi query SQL
                                $result = mysqli_query($connect, "SELECT 
                                                        nonppn.id_inv_nonppn,
                                                        sr.id_inv, sr.no_spk,
                                                        trx.*
                                                        FROM inv_nonppn AS nonppn
                                                        JOIN spk_reg sr ON (nonppn.id_inv_nonppn = sr.id_inv)
                                                        JOIN transaksi_produk_reg trx ON(sr.id_spk_reg = trx.id_spk)
                                                        WHERE nonppn.id_inv_nonppn = '$id_inv_nonppn'  ORDER BY no_spk ASC");
                                $tombolDitampilkan = false;
                                // Inisialisasi variabel untuk status kosong
                                while ($row = mysqli_fetch_array($result)) {
                                    $status_trx = $row['status_trx'];
                                ?>
                                    <?php
                                    if ($total_data != 0 && $status_trx != 0 && !$tombolDitampilkan) {
                                        echo '  <button class="btn btn-primary btn-detail mb-2" data-bs-toggle="modal" data-bs-target="#ongkir">
                                                    <i class="bi bi-truck"></i> Tambah Ongkir
                                                </button>
                                                <button class="btn btn-warning btn-detail mb-2" data-bs-toggle="modal" data-bs-target="#Dikirim">
                                                    <i class="bi bi-send"></i> Proses Dikirim
                                                </button> 
                                                <input type="hidden" name="id_spk_reg" value="' . base64_encode($id_inv_nonppn) . '">
                                                <a href="cetak-inv-nonppn-reg.php?id=' . base64_encode($id_inv_nonppn) . '" class="btn btn-secondary mb-2"><i class="bi bi-printer-fill"></i> Cetak Invoice</a>';

                                        // Set variabel $tombolDitampilkan menjadi true
                                        $tombolDitampilkan = true;
                                    }
                                    ?>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <!-- Modal Input SPdisc Inv -->
                    <div class="modal fade" id="inputSpdisc" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Ubah Kategori</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="proses/proses-invoice-nonppn.php" method="POST">
                                        <?php
                                        $id_inv_kat = $id_inv;
                                        $sql_kat = "SELECT 
                                                            nonppn.*, 
                                                            sr.id_customer, sr.id_inv, sr.no_spk, sr.no_po, sr.tgl_pesanan
                                                            FROM inv_nonppn AS nonppn
                                                            JOIN spk_reg sr ON (nonppn.id_inv_nonppn = sr.id_inv)
                                                            WHERE nonppn.id_inv_nonppn = '$id_inv_kat'";
                                        $query_kat = mysqli_query($connect, $sql_kat);
                                        $data_kat = mysqli_fetch_array($query_kat);
                                        ?>
                                        <input type="hidden" name="id_inv" value="<?php echo $id_inv_kat ?>" readonly>
                                        <div class="mb-3">
                                            <label>Spesial Diskon (%)</label>
                                            <input type="number" step="any" class="form-control" name="spdisc" required>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary" name="ubah-sp">Update Kategori</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Modal -->
                    <div class="table-responsive p-3">
                        <table class="table table-striped table-bordered" id="table3">
                            <?php
                            if ($total_data != 0) {
                                if ($data_cek['kategori_inv'] != 'Diskon') {
                                    echo '
                                        <thead>
                                            <tr class="text-white" style="background-color: #051683;">
                                                <th class="text-center p-3 text-nowrap" style="width:20px">No</th>
                                                <th class="text-center p-3 text-nowrap" style="width:80px">No. SPK</th>
                                                <th class="text-center p-3 text-nowrap" style="width:200px">Nama Produk</th>
                                                <th class="text-center p-3 text-nowrap" style="width:100px">Merk</th>
                                                <th class="text-center p-3 text-nowrap" style="width:100px">Harga</th>
                                                <th class="text-center p-3 text-nowrap" style="width:80px">Qty Order</th>
                                                <th class="text-center p-3 text-nowrap" style="width:80px">Total</th>
                                                <th class="text-center p-3 text-nowrap" style="width:80px">Aksi</th>
                                            </tr>
                                        </thead>';
                                } else {
                                    echo '
                                        <thead>
                                            <tr class="text-white" style="background-color: #051683;">
                                                <th class="text-center p-3 text-nowrap" style="width:20px">No</th>
                                                <th class="text-center p-3 text-nowrap" style="width:100px">No. SPK</th>
                                                <th class="text-center p-3 text-nowrap" style="width:200px">Nama Produk</th>
                                                <th class="text-center p-3 text-nowrap" style="width:100px">Merk</th>
                                                <th class="text-center p-3 text-nowrap" style="width:100px">Harga</th>
                                                <th class="text-center p-3 text-nowrap" style="width:100px">Diskon</th>
                                                <th class="text-center p-3 text-nowrap" style="width:80px">Qty Order</th>
                                                <th class="text-center p-3 text-nowrap" style="width:80px">Total</th>
                                                <th class="text-center p-3 text-nowrap" style="width:80px">Aksi</th>
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
                                $id_nonppn_decode = base64_decode($_GET['id']);
                                $no = 1;
                                $sql_trx = "SELECT 
                                                    nonppn.id_inv_nonppn,
                                                    sr.id_inv, sr.no_spk,
                                                    trx.*, 
                                                    spr.stock, 
                                                    tpr.nama_produk, 
                                                    tpr.harga_produk, mr.* 
                                                    FROM inv_nonppn AS nonppn
                                                    JOIN spk_reg sr ON (nonppn.id_inv_nonppn = sr.id_inv)
                                                    JOIN transaksi_produk_reg trx ON(sr.id_spk_reg = trx.id_spk)
                                                    JOIN stock_produk_reguler spr ON(trx.id_produk = spr.id_produk_reg)
                                                    JOIN tb_produk_reguler tpr ON(trx.id_produk = tpr.id_produk_reg)
                                                    JOIN tb_merk mr ON (tpr.id_merk = mr.id_merk)
                                                    WHERE nonppn.id_inv_nonppn = '$id_nonppn_decode' AND status_trx = '1' ORDER BY no_spk ASC";
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
                                        <td class="text-end text-nowrap"><?php echo number_format($data_trx['harga']) ?></td>
                                        <?php
                                        if ($total_data != 0) {
                                            if ($data_cek['kategori_inv'] == 'Diskon') {
                                                echo "<td class='text-end'>" . $disc . "</td>";
                                            }
                                        }
                                        ?>
                                        <td class="text-end text-nowrap"><?php echo number_format($data_trx['qty']) ?></td>
                                        <td class="text-end text-nowrap"><?php echo number_format($data_trx['total_harga']) ?></td>
                                        <td class="text-center text-nowrap">
                                            <?php
                                            if ($total_data != 0) {
                                                if ($data_cek['kategori_inv'] == 'Diskon') {
                                                    echo '<button class="btn btn-warning btn-sm" data-id="' . $data_trx['id_transaksi'] . '" data-hargadisc="' . number_format($data_trx['harga']) . '" data-diskon="' . $data_trx['disc'] . '" data-qty="' . number_format($data_trx['qty']) . '" data-bs-toggle="modal" data-bs-target="#edit-diskon"><i class="bi bi-pencil"></i></button>';
                                                } else {
                                                    echo '<button class="btn btn-warning btn-sm" data-id="' . $data_trx['id_transaksi'] . '" data-harga="' . number_format($data_trx['harga']) . '" data-qty="' . number_format($data_trx['qty']) . '" data-bs-toggle="modal" data-bs-target="#edit"><i class="bi bi-pencil"></i></button>';
                                                }
                                            }
                                            ?>

                                        </td>
                                    </tr>
                                    <?php $no++; ?>
                                <?php } ?>
                            </tbody>
                            <!-- Modal -->
                            <div class="modal fade" id="edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Harga</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="proses/proses-invoice-nonppn.php" method="POST">
                                                <input type="hidden" name="id_trx" id="id_trx" readonly>
                                                <input type="hidden" name="id_inv" value="<?php echo $id_nonppn_decode ?>" readonly>
                                                <div class="mb-3">
                                                    <label><strong>Harga</strong></label>
                                                    <div class="input-group">
                                                        <span class="input-group-text" id="basic-addon1">Rp</span>
                                                        <input type="text" class="form-control text-end harga_produk" name="harga_produk" id="harga_produk" required>
                                                        <input type="hidden" class="form-control text-end harga_produk" name="qty" id="qty" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary" name="update-harga">Update Harga</button>
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="edit-diskon" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Harga</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="proses/proses-invoice-nonppn.php" method="POST">
                                                <input type="hidden" name="id_trx" id="id_trxdisc" readonly>
                                                <input type="hidden" name="id_inv" value="<?php echo $id_nonppn_decode ?>" readonly>
                                                <div class="mb-3">
                                                    <label><strong>Harga</strong></label>
                                                    <div class="input-group">
                                                        <span class="input-group-text" id="basic-addon1">Rp</span>
                                                        <input type="text" class="form-control text-end harga_produk" name="harga_produk" id="harga_produk_disc" required>
                                                        <input type="hidden" class="form-control text-end harga_produk" name="qty" id="qtydisc" required>
                                                    </div>
                                                </div>
                                                <div class="col-mb3">
                                                    <label><b>Diskon</b></label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control text-end harga_produk" name="disc" id="discc" required>
                                                        <span class="input-group-text" id="basic-addon1">%</span>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary" name="update-harga-diskon">Update Harga</button>
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                <form action="proses/proses-invoice-nonppn.php" method="POST">
                    <?php
                    $no = 1;
                    $id_nonppn_decode = base64_decode($_GET['id']);
                    $sql_cek_harga = "SELECT 
                                    nonppn.id_inv_nonppn, kategori_inv,
                                    sr.id_inv, sr.no_spk,
                                    trx.*, 
                                    spr.stock, 
                                    tpr.nama_produk, 
                                    tpr.harga_produk, mr.* 
                                    FROM inv_nonppn AS nonppn
                                    JOIN spk_reg sr ON (nonppn.id_inv_nonppn = sr.id_inv)
                                    JOIN transaksi_produk_reg trx ON(sr.id_spk_reg = trx.id_spk)
                                    JOIN stock_produk_reguler spr ON(trx.id_produk = spr.id_produk_reg)
                                    JOIN tb_produk_reguler tpr ON(trx.id_produk = tpr.id_produk_reg)
                                    JOIN tb_merk mr ON (tpr.id_merk = mr.id_merk)
                                    WHERE nonppn.id_inv_nonppn = '$id_nonppn_decode' AND status_trx = '0' ORDER BY no_spk ASC";
                    $query_cek_harga = mysqli_query($connect, $sql_cek_harga);
                    $total_cek_harga = mysqli_num_rows($query_cek_harga);
                    while ($data_cek_harga = mysqli_fetch_array($query_cek_harga)) {
                    ?>
                        <div class="card-body border p-3 mb-3">
                            <div class="row">
                                <div class="col-1 mb-2">
                                    <input type="text" class="form-control text-center mobile bg-light" value="<?php echo $no; ?>" readonly>
                                    <?php $no++ ?>
                                </div>
                                <div class="col-sm-4 mb-2">
                                    <input type="hidden" name="id_inv" value="<?php echo $data_cek_harga['id_inv_nonppn'] ?>" readonly>
                                    <input type="hidden" name="id_trx[]" id="id_<?php echo $data_cek_harga['id_transaksi'] ?>" value="<?php echo $data_cek_harga['id_transaksi'] ?>" readonly>
                                    <input type="text" class="form-control bg-light mobile-text" value="<?php echo $data_cek_harga['nama_produk'] ?>" readonly>
                                </div>
                                <div class="col-sm-1 mb-2">
                                    <input type="text" class="form-control bg-light text-center mobile-text" value="<?php echo $data_cek_harga['nama_merk'] ?>" readonly>
                                </div>
                                <div class="col-sm-2 mb-2">
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">Rp</span>
                                        <input type="text" class="form-control text-end harga_produk  mobile-text" name="harga_produk[]" value="<?php echo number_format($data_cek_harga['harga']) ?>" required>
                                    </div>
                                </div>
                                <div class="col-sm-2 mb-2">
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
                                <div class="col-sm-2 mb-2">
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">Qty</span>
                                        <input type="text" class="form-control bg-light text-end  mobile-text" name="qty[]" value="<?php echo number_format($data_cek_harga['qty']) ?>" readonly>
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
            </div>
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
                            <form action="proses/proses-invoice-nonppn.php" method="POST">
                                <?php
                                $id_inv_kat = $id_inv;
                                $sql_kat = "SELECT 
                                            nonppn.*, 
                                            sr.id_customer, sr.id_inv, sr.no_spk, sr.no_po, sr.tgl_pesanan
                                            FROM inv_nonppn AS nonppn
                                            JOIN spk_reg sr ON (nonppn.id_inv_nonppn = sr.id_inv)
                                            WHERE nonppn.id_inv_nonppn = '$id_inv_kat'";
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
<!-- Modal Add Ongkir-->
<div class="modal fade" id="ongkir" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Biaya Ongkir</h1>
            </div>
            <form action="proses/proses-invoice-nonppn.php" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <input type="hidden" name="id_inv" value="<?php echo $id_inv ?>">
                        <label>Masukkan Biaya Ongkir (Rp)</label>
                        <input type="text" class="form-control" name="ongkir" value="<?php echo number_format($ongkir); ?>" id="ongkir" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" name="update-ongkir" id="update" disabled><i class="bi bi-arrow-left-right"></i> Update Ongkir</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancel"><i class="bi bi-x-circle"></i> Cancel</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        // Mendapatkan elemen input teks berdasarkan nama
        const ongkirInput = document.querySelector('input[name="ongkir"]');

        // Event listener saat nilai input berubah
        ongkirInput.addEventListener('input', function(event) {
            // Hapus tanda ribuan dari nilai saat ini
            const currentValue = event.target.value.replace(/,/g, '');

            // Format nilai dengan tanda ribuan
            const formattedValue = new Intl.NumberFormat().format(currentValue);

            // Update nilai input dengan versi terformat
            event.target.value = formattedValue;
            // Mendapatkan tombol "Update Ongkir" berdasarkan ID
            const updateButton = document.getElementById('update');

            // Simpan nilai awal input
            const initialValue = '<?php echo number_format($ongkir); ?>';

            // Fungsi untuk mengatur status tombol "Update Ongkir"
            function toggleUpdateButton() {
                // console.log('Current Value:', (ongkirInput.value));
                // console.log('Initial Value:', (initialValue));

                if (ongkirInput.value !== initialValue) {
                    updateButton.removeAttribute('disabled');
                    console.log('Button enabled');
                } else {
                    updateButton.setAttribute('disabled', 'disabled');
                    console.log('Button disabled');
                }
            }

            // Fungsi untuk memformat angka dengan pemisah ribuan
            function formatNumber(number) {
                return new Intl.NumberFormat().format(number);
            }

            // Panggil fungsi toggleUpdateButton saat halaman dimuat
            toggleUpdateButton();

            // Mendapatkan tombol "Cancel" berdasarkan ID
            const cancelButton = document.getElementById('cancel');

            // Fungsi untuk mengatur ulang input teks dan tombol
            function resetInput() {
                ongkirInput.value = '<?php echo number_format($ongkir); ?>';
                updateButton.setAttribute('disabled', 'disabled');
            }

            // Event listener saat tombol "Cancel" ditekan
            cancelButton.addEventListener('click', function() {
                resetInput();
            });
        });
    </script>
</div>

<!-- Modal Dikirim-->
<div class="modal fade" id="Dikirim" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-body">
                <div class="card-header">
                    <h1 class="text-center fs-5" id="exampleModalLabel">Ubah Status</h1>
                </div>
                <div class="card-body">
                    <?php
                    $uuid = generate_uuid();
                    $year = date('y');
                    $day = date('d');
                    $month = date('m');
                    ?>
                    <form action="proses/proses-invoice-nonppn.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id_status" value="STATUS-<?php echo $year ?><?php echo $month ?><?php echo $uuid ?><?php echo $day ?>">
                        <input type="hidden" name="id_inv" value="<?php echo $id_inv ?>">
                        <div class="mb-3">
                            <label>Jenis Pengiriman</label>
                            <select id="jenis-pengiriman" name="jenis_pengiriman" class="form-select" required>
                                <option value="">Pilih...</option>
                                <option value="Driver">Driver</option>
                                <option value="Ekspedisi">Ekspedisi</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label id="labelDriver" style="display: none;">Pilih Driver</label>
                            <select id="pengirim" name="pengirim" class="form-select" style="display: none;">
                                <option value="">Pilih...</option>
                                <?php
                                include "koneksi.php";
                                $sql_driver = mysqli_query($connect, "SELECT us.id_user_role, us.id_user, us.nama_user, rl.role FROM user AS us JOIN user_role rl ON (us.id_user_role = rl.id_user_role) WHERE rl.role = 'Driver'");
                                while ($data_driver = mysqli_fetch_array($sql_driver)) {
                                ?>
                                    <option value="<?php echo $data_driver['id_user'] ?>"><?php echo $data_driver['nama_user'] ?></option>
                                <?php } ?>
                            </select>
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
                        <div class="mb-3 preview-image" id="imagePreview" style="display: none;"></div>

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
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" name="ubah-dikirim" id="dikirim" disabled><i class="bi bi-arrow-left-right"></i> Ubah Status</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancelDikirim"><i class="bi bi-x-circle"> Cancel</i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- kode JS Dikirim -->
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
        const jenisPengirimanSelect = document.getElementById('jenis-pengiriman');
        const pengirimSelect = document.getElementById('pengirim');
        const labelDriver = document.getElementById('labelDriver');
        const ekspedisiSelect = document.getElementById('ekspedisi');
        const labelEkspedisi = document.getElementById('labelEkspedisi');
        const labelResi = document.getElementById('labelResi')
        const resiSelect = document.getElementById('resi');
        const dikirim = document.getElementById('dikirim');
        const labelBukti1 = document.getElementById('labelBukti1');
        const labelBukti2 = document.getElementById('labelBukti2');
        const labelBukti3 = document.getElementById('labelBukti3');
        const file1 = document.getElementById('fileku1');
        const file2 = document.getElementById('fileku2');
        const file3 = document.getElementById('fileku3');
        const imagePreview = document.getElementById('imagePreview');
        const imagePreview2 = document.getElementById('imagePreview2');
        const imagePreview3 = document.getElementById('imagePreview3');

        let isModalShown = false;

        jenisPengirimanSelect.addEventListener('change', function() {
            if (this.value === 'Driver') {
                labelDriver.style.display = 'block'; // Menampilkan form input
                pengirimSelect.style.display = 'block'; // Menampilkan form input
                pengirimSelect.setAttribute('required', 'true');
                labelEkspedisi.style.display = 'none'; // Menyembunyikan form input
                ekspedisiSelect.style.display = 'none'; // Menyembunyikan form input
                resiSelect.style.display = 'none'; // Menyembunyikan form input
                ekspedisiSelect.value = ''; // Mengatur ulang nilai menjadi kosong
                ekspedisiSelect.removeAttribute('required');
                resiSelect.value = ''; // Mengatur ulang nilai menjadi kosong
                resiSelect.removeAttribute('required');
                labelResi.style.display = 'none'; // Menyembunyikan form input
                labelBukti1.style.display = 'none'; // Menyembunyikan form input
                labelBukti2.style.display = 'none'; // Menyembunyikan form input
                labelBukti3.style.display = 'none'; // Menyembunyikan form input
                file1.style.display = 'none'; // Menyembunyikan form input
                file2.style.display = 'none'; // Menyembunyikan form input
                file3.style.display = 'none'; // Menyembunyikan form input
                file1.value = ''; // Mengatur ulang nilai menjadi kosong
                file1.removeAttribute('required');
                file2.value = ''; // Mengatur ulang nilai menjadi kosong
                file3.value = ''; // Mengatur ulang nilai menjadi kosong
                imagePreview.innerHTML = ''; // Menghapus konten di dalam elemen "imagePreview"
                imagePreview2.innerHTML = ''; // Menghapus konten di dalam elemen "imagePreview2"
                imagePreview3.innerHTML = ''; // Menghapus konten di dalam elemen "imagePreview3"
                dikirim.disabled = false;
            } else if (this.value === 'Ekspedisi') {
                pengirimSelect.value = ''; // Mengatur ulang nilai menjadi kosong
                labelDriver.style.display = 'none'; // Menyembunyikan form input
                pengirimSelect.style.display = 'none'; // Menyembunyikan form input
                pengirimSelect.removeAttribute('required');
                labelEkspedisi.style.display = 'block'; // Menampilkan form input
                ekspedisiSelect.style.display = 'block'; // Menampilkan form input
                ekspedisiSelect.setAttribute('required', 'true');
                labelResi.style.display = 'block';
                resiSelect.style.display = 'block';
                resiSelect.setAttribute('required', 'true');
                labelBukti1.style.display = 'block'; // Menampilkan form input
                labelBukti2.style.display = 'block'; // Menampilkan form input
                labelBukti3.style.display = 'block'; // Menampilkan form input
                file1.style.display = 'block'; // Menampilkan form input
                file1.setAttribute('required', 'true');
                file2.style.display = 'block'; // Menampilkan form input
                file3.style.display = 'block'; // Menampilkan form input
                imagePreview.style.display = 'block'; // Menampilkan konten di dalam elemen "imagePreview"
                imagePreview2.style.display = 'block'; // Menampilkan konten di dalam elemen "imagePreview2"
                imagePreview3.style.display = 'block'; // Menampilkan konten di dalam elemen "imagePreview3"
                dikirim.disabled = false;
            } else if (this.value === '') {
                pengirimSelect.value = ''; // Mengatur ulang nilai menjadi kosong
                ekspedisiSelect.value = ''; // Mengatur ulang nilai menjadi kosong
                resiSelect.value = ''; // Mengatur ulang nilai menjadi kosong
                labelDriver.style.display = 'none'; // Menyembunyikan form input
                pengirimSelect.style.display = 'none'; // Menyembunyikan form input
                labelEkspedisi.style.display = 'none'; // Menyembunyikan form input
                ekspedisiSelect.style.display = 'none'; // Menyembunyikan form input
                labelResi.style.display = 'none'; // Menyembunyikan form input
                file1.style.display = 'none'; // Menyembunyikan form input
                file2.style.display = 'none'; // Menyembunyikan form input
                file3.style.display = 'none'; // Menyembunyikan form input
                ekspedisiSelect.style.display = 'none'; // Menyembunyikan form input
                pengirimSelect.style.display = 'none'; // Menyembunyikan form input
                resiSelect.style.display = 'none'; // Menyembunyikan form input
                labelBukti1.style.display = 'none'; // Menyembunyikan form input
                labelBukti2.style.display = 'none'; // Menyembunyikan form input
                labelBukti3.style.display = 'none'; // Menyembunyikan form input
                file1.style.display = 'none'; // Menyembunyikan form input
                file2.style.display = 'none'; // Menyembunyikan form input
                file3.style.display = 'none'; // Menyembunyikan form input
                dikirim.disabled = true;
            }
            dikirim.addEventListener('shown.bs.modal', function() {
                // Mengatur properti display menjadi 'none' untuk menyembunyikan elemen file
                file1.style.display = 'none'; // Menyembunyikan form input
                file2.style.display = 'none'; // Menyembunyikan form input
                file3.style.display = 'none'; // Menyembunyikan form input
                dikirim.disabled = true;
            });

            // Refresh halaman modal
            if (isModalShown) {
                $('#Dikirim').modal('hide'); // Menyembunyikan modal
                location.reload(); // Melakukan refresh halaman
                $('#Dikirim').modal('show')
            }

            // Mendapatkan tombol "Cancel" berdasarkan ID
            const cancelButton = document.getElementById('cancelDikirim');

            // Fungsi untuk mengatur ulang input teks dan tombol
            // Event listener saat tombol "Cancel" ditekan
            cancelButton.addEventListener('click', function() {
                jenisPengirimanSelect.value = '';
                pengirimSelect.value = ''; // Mengatur ulang nilai menjadi kosong
                ekspedisiSelect.value = ''; // Mengatur ulang nilai menjadi kosong
                resiSelect.value = ''; // Mengatur ulang nilai menjadi kosong
                file1.value = ''; // Mengatur ulang nilai menjadi kosong
                file2.value = ''; // Mengatur ulang nilai menjadi kosong
                file3.value = ''; // Mengatur ulang nilai menjadi kosong
                imagePreview.innerHTML = ''; // Menghapus konten di dalam elemen "imagePreview"
                imagePreview2.innerHTML = ''; // Menghapus konten di dalam elemen "imagePreview2"
                imagePreview3.innerHTML = ''; // Menghapus konten di dalam elemen "imagePreview3"
                labelEkspedisi.style.display = 'none'; // Menyembunyikan form input
                ekspedisiSelect.style.display = 'none'; // Menyembunyikan form input
                labelEkspedisi.style.display = 'none'; // Menyembunyikan form input
                labelDriver.style.display = 'none'; // Menyembunyikan form input
                pengirimSelect.style.display = 'none'; // Menyembunyikan form input
                labelResi.style.display = 'none'; // Menyembunyikan form input
                resiSelect.style.display = 'none'; // Menyembunyikan form input
                labelBukti1.style.display = 'none'; // Menyembunyikan form input
                labelBukti2.style.display = 'none'; // Menyembunyikan form input
                labelBukti3.style.display = 'none'; // Menyembunyikan form input
                file1.style.display = 'none'; // Menyembunyikan form input
                file2.style.display = 'none'; // Menyembunyikan form input
                file3.style.display = 'none'; // Menyembunyikan form input
                dikirim.disabled = true;
            });
        });
    </script>
    <!-- End JS Dikirim -->
    <style>
        .preview-image {
            max-width: 100%;
            height: auto;
        }
    </style>
</div>
<!-- End Modal Dikirim -->

<!-- Modal Add SPK-->
<div class="modal fade" id="addSpk" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <?php
                    include "koneksi.php";
                    $id_inv = base64_decode($_GET['id']);
                    $no = 1;
                    $sql = "SELECT * FROM spk_reg WHERE id_inv = '$id_inv'";
                    $query = mysqli_query($connect, $sql);
                    $totalData = mysqli_num_rows($query);
                    ?>
                    <form action="proses/proses-invoice-nonppn.php" method="POST">
                        <table class="table table-bordered table-striped" id="table2">
                            <thead>
                                <tr class="text-white" style="background-color: navy;">
                                    <th class="text-center p-3" style="width: 20px">Pilih</th>
                                    <th class="text-center p-3" style="width: 30px">No</th>
                                    <th class="text-center p-3" style="width: 150px">No. SPK</th>
                                    <th class="text-center p-3" style="width: 150px">Tgl. SPK</th>
                                    <th class="text-center p-3" style="width: 150px">No. PO</th>
                                    <th class="text-center p-3" style="width: 200px">Nama Customer</th>
                                    <th class="text-center p-3" style="width: 150px">Note</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include "koneksi.php";
                                $no = 1;
                                $sql_inv = "SELECT sr.*, cs.nama_cs, cs.alamat
                                                                        FROM spk_reg AS sr
                                                                        JOIN tb_customer cs ON(sr.id_customer = cs.id_cs)
                                                                        WHERE status_spk = 'Siap Kirim' AND id_cs = '$id_cs'";
                                $query_inv = mysqli_query($connect, $sql_inv);
                                while ($data_inv = mysqli_fetch_array($query_inv)) {
                                ?>
                                    <tr>
                                        <input type="hidden" name="id_inv" value="<?php echo $id_inv ?>">
                                        <td class="text-center"><input type="checkbox" name="id_spk[]" value="<?php echo $data_inv['id_spk_reg'] ?>"></td>
                                        <td class="text-center"><?php echo $no; ?></td>
                                        <td><?php echo $data_inv['no_spk'] ?></td>
                                        <td><?php echo $data_inv['tgl_spk'] ?></td>
                                        <td><?php echo $data_inv['no_po'] ?></td>
                                        <td><?php echo $data_inv['nama_cs'] ?></td>
                                        <td><?php echo $data_inv['note'] ?></td>
                                    </tr>
                                    <?php $no++ ?>
                                <?php } ?>
                            </tbody>
                        </table>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-x-circle"></i> Close</button>
                            <button type="submit" class="btn btn-primary" name="add-spk" id="add" disabled><i class="bi bi-plus-circle"></i> Add SPK</button>
                        </div>
                    </form>
                    <script>
                        // Mendapatkan checkbox SPK
                        const spkCheckboxes = document.querySelectorAll('input[name="id_spk[]"]');

                        // Mendapatkan tombol
                        const addButton = document.getElementById("add");


                        // Mendapatkan jumlah total checkbox yang dipilih
                        function getSelectedCheckboxCount() {
                            let count = 0;
                            spkCheckboxes.forEach(function(checkbox) {
                                if (checkbox.checked) {
                                    count++;
                                }
                            });
                            return count;
                        }

                        // Fungsi untuk mengaktifkan/menonaktifkan tombol berdasarkan jumlah checkbox yang dipilih
                        function toggleButton() {
                            if (getSelectedCheckboxCount() > 0) {
                                addButton.disabled = false;
                            } else {
                                addButton.disabled = true;
                            }
                        }

                        // Event listener untuk setiap checkbox
                        spkCheckboxes.forEach(function(checkbox) {
                            checkbox.addEventListener('change', toggleButton);
                        });

                        // Event listener untuk setiap checkbox
                        spkCheckboxes.forEach(function(checkbox) {
                            checkbox.addEventListener('change', function() {
                                // console.log("Total Data: " + <?php echo $totalData; ?>);
                                // console.log("Total Checkbox: " + getSelectedCheckboxCount());

                                const totalData = <?php echo $totalData; ?>;
                                const maxAllowed = 5;

                                if (totalData + getSelectedCheckboxCount() > maxAllowed) {
                                    const message = "Data Anda saat ini: " + totalData + " Anda hanya bisa menambahkan " + (maxAllowed - totalData) + " data.";
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Data melebihi batasan maksimum',
                                        text: message,
                                        didOpen: () => {
                                            // Mengatur ulang semua checkbox menjadi tidak dipilih
                                            spkCheckboxes.forEach(function(checkbox) {
                                                checkbox.checked = false;
                                            });
                                        }
                                    });
                                }
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Add SPK -->

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