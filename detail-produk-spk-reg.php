<?php
$page  = 'transaksi';
$page2 = 'spk';
include "akses.php";
include "function/class-spk.php";
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
        <section>
            <!-- SWEET ALERT -->
            <div class="info-data" data-infodata="<?php if (isset($_SESSION['info'])) {
                                                        echo $_SESSION['info'];
                                                    }
                                                    unset($_SESSION['info']); ?>"></div>
            <!-- END SWEET ALERT -->
            <div class="card shadow p-2">
                <div class="card-header text-center">
                    <h5><strong>DETAIL PRODUK SPK</strong></h5>
                </div>
                <?php
                include "koneksi.php";
                $id_spk = base64_decode($_GET['id']);
                $sql = "SELECT sr.*, cs.nama_cs, cs.alamat, ordby.order_by, sl.nama_sales 
                    FROM spk_reg AS sr
                    JOIN tb_customer cs ON(sr.id_customer = cs.id_cs)
                    JOIN tb_orderby ordby ON(sr.id_orderby = ordby.id_orderby)
                    JOIN tb_sales sl ON(sr.id_sales = sl.id_sales)
                    WHERE sr.id_spk_reg = '$id_spk'";
                $query = mysqli_query($connect, $sql);
                $data = mysqli_fetch_array($query);
                ?>
                <div class="row mt-3">
                    <div class="col-sm-6">
                        <div class="card-body p-3 border">
                            <div class="row">
                                <div class="col-5">
                                    <p style="float: left;">No. SPK</p>
                                    <p style="float: right;">:</p>
                                </div>
                                <div class="col-7">
                                    <?php echo $data['no_spk'] ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-5">
                                    <p style="float: left;">Tgl. SPK</p>
                                    <p style="float: right;">:</p>
                                </div>
                                <div class="col-7">
                                    <?php echo $data['tgl_spk'] ?>
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
                                    <p style="float: left;">Tgl. Pesanan</p>
                                    <p style="float: right;">:</p>
                                </div>
                                <div class="col-7">
                                    <?php echo $data['tgl_pesanan'] ?>
                                </div>
                            </div>
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
                        <div class="card-body p-3 border">
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
                            <?php
                                $note = $data['note'];

                                $items = explode("\n", trim($note));
                                if (!empty($note)) {
                                    echo '
                                        <div class="row">
                                            <div class="col-5">
                                                <p style="float: left;">Note</p>
                                                <p style="float: right;">:</p>
                                            </div>
                                            <div class="col-7">
                                    ';

                                    foreach ($items as $notes) {
                                        echo trim($notes).'<br>';
                                    }
                                    echo '
                                            </div>
                                        </div>';
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Tampil data -->
            <div class="card shadow">
                <div class="card-body p-3">
                    <div class="table-responsive">
                        <form action="proses/proses-produk-spk-reg.php" method="POST">
                            <div class="row mt-3">
                                <div class="mb-2 p-2 ms-1" style="width: 235px;">
                                    <a href="spk-reg.php?sort=baru" class="btn btn-warning btn-detail">
                                        <i class="bi bi-arrow-left"></i> Halaman Sebelumnya
                                    </a>
                                </div>
                                <div class="mb-2 p-2 ms-1" style="width: 190px;">
                                    <a class="btn btn-primary btn-detail" data-spk="<?php echo $data['id_spk_reg'] ?>" data-bs-toggle="modal" data-bs-target="#modalBarang">
                                        <i class="bi bi-plus-circle"></i> Tambah Produk
                                    </a>
                                </div>
                                <?php  
                                    include 'koneksi.php';
                                    $sql_cetak = "  SELECT 
                                                        spk.id_spk_reg, tmp.id_spk, SUM(tmp.status_tmp) AS sum_status 
                                                    FROM spk_reg AS spk
                                                    JOIN tmp_produk_spk tmp ON (spk.id_spk_reg = tmp.id_spk) 
                                                    WHERE spk.id_spk_reg = '$id_spk'";
                                    $query_cetak = mysqli_query($connect, $sql_cetak);
                                    $data_cetak = mysqli_fetch_array($query_cetak);
                                    $total_query_cetak = mysqli_num_rows($query_cetak);
                                    $status_tmp = $data_cetak['sum_status'];

                                    if($total_query_cetak != 0 && $status_tmp != 0){
                                        ?>
                                            <div class="mb-2 p-2 ms-1" style="width: 150px;">
                                                <a class="btn btn-info btn-detail mb-3" href="cetak-spk.php?id=<?php echo base64_encode($id_spk) ?>">
                                                    <i class="bi bi-plus-circle"></i> Cetak SPK
                                                </a>  
                                            </div> 
                                        <?php
                                    }
                                ?>
                                <div class="mb-2 p-2 ms-1" style="width: 190px;">
                                    <?php
                                        $id_spk_decode = base64_decode($_GET['id']);
                                        $sql_thead = "SELECT 
                                                        sr.id_spk_reg,
                                                        sr.status_cetak,
                                                        tps.status_tmp
                                                    FROM spk_reg AS sr
                                                    JOIN tmp_produk_spk AS tps ON sr.id_spk_reg = tps.id_spk
                                                    WHERE sr.id_spk_reg = '$id_spk_decode' AND tps.status_tmp = '1'";

                                        $query_thead = mysqli_query($connect, $sql_thead);
                                        $data_thead = mysqli_fetch_array($query_thead);

                                        $totalRows = mysqli_num_rows($query_thead); // Menampilkan total baris hasil kueri

                                        if (!empty($data_thead) && $data_thead['status_cetak'] == 1) {
                                            // Button Hide and show
                                            echo '<button type="submit" class="btn btn-secondary" name="simpan-trx"><i class="bi bi-send"></i> Proses Pesanan</button>';
                                        }
                                    ?>
                                </div>
                            </div>
                            <table class="table table-striped table-bordered" id="table2">
                                <?php
                                if ($totalRows != 0) {
                                    echo ' 
                                        <thead>
                                            <tr class="text-white" style="background-color: #051683;">
                                                <th class="text-center p-3 text-nowrap" style="width:20px">No</th>
                                                <th class="text-center p-3 text-nowrap" style="width:300px">Nama Produk</th>
                                                <th class="text-center p-3 text-nowrap" style="width:100px">Satuan</th>
                                                <th class="text-center p-3 text-nowrap" style="width:100px">Merk</th>
                                                <th class="text-center p-3 text-nowrap" style="width:100px">Harga</th>
                                                <th class="text-center p-3 text-nowrap" style="width:80px">Qty Order</th>
                                                <th class="text-center p-3 text-nowrap" style="width:80px">Aksi</th>
                                            </tr>
                                        </thead>  ';
                                }
                                ?>
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
                                                WHERE sr.id_spk_reg = '$id_spk_decode' AND tps.status_tmp = '1'";
                                    $trx_produk_reg = mysqli_query($connect, $sql_trx);
                                    while ($data_trx = mysqli_fetch_array($trx_produk_reg)) {
                                        $uuid = generate_uuid();
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
                                            <input type="hidden" name="id_inv[]" value="<?php echo $data_trx['id_inv'] ?>" readonly>
                                            <input type="hidden" name="id_transaksi[]" id="id_<?php echo $data_trx['id_tmp'] ?>" value="TRX-<?php echo $year ?><?php echo $month ?><?php echo $uuid ?><?php echo $day ?>" readonly>
                                            <input type="hidden" name="id_user" value="<?php echo $_SESSION['tiket_id'] ?>">
                                            <input type="hidden" class="form-control" name="id_spk_reg[]" value="<?php echo $id_spk_decode ?>" readonly>
                                            <input type="hidden" class="form-control" name="id_produk[]" value="<?php echo $data_trx['id_produk'] ?>" readonly>
                                            <td class="text-nowrap"><input type="text" class="text-center" value="<?php echo $no; ?>" readonly></td>
                                            <td class="text-nowrap"><?php echo $namaProduk ?></td>
                                            <td class="text-center text-nowrap"><?php echo $satuan_produk ?></td>
                                            <td class="text-nowrap"><input type="text" class="text-center" value="<?php echo $nama_merk ?>" readonly></td>
                                            <td class="text-nowrap"><input type="text" class="text-end" name="harga[]" value="<?php echo number_format($harga) ?>" readonly></td>
                                            <td class="text-nowrap"><input type="text" class="text-end" name="qty[]" value="<?php echo number_format($data_trx['qty']) ?>" readonly></td>
                                            <td class="text-center text-nowrap">
                                                <a href="#" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit" data-id="<?php echo $data_trx['id_tmp'] ?>" data-spk="<?php echo $id_spk_decode ?>" data-nama="<?php echo $namaProduk ?>" data-merk="<?php echo $nama_merk ?>" data-stock="<?php echo $stock_edit ?>" data-qty="<?php echo $data_trx['qty'] ?>"><i class="bi bi-pencil"></i></a>
                                                <a href="proses/proses-produk-spk-reg.php?hapus_tmp=<?php echo base64_encode($data_trx['id_tmp']) ?>&&id_spk=<?php echo base64_encode($id_spk_decode) ?>" class="btn btn-danger btn-sm delete-data"><i class="bi bi-trash"></i></a>
                                            </td>
                                            <!-- Modal Edit -->
                                            <div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Data</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body p-2">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <form action="proses/proses-produk-spk-reg.php" method="POST">
                                                                        <input type="hidden" id="idTmpValue" name="id_tmp" class="form-control">
                                                                        <input type="hidden" id="spkTmpValue" name="id_spk" class="form-control">
                                                                        <div class="mb-3">
                                                                            <label class="text-start">Nama Produk</label>
                                                                            <input type="text" id="namaTmpValue" class="form-control bg-light" readonly>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label class="text-start">Merk Produk</label>
                                                                            <input type="text" id="merkTmpValue" class="form-control bg-light" readonly>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label class="text-start">Stock Tersedia</label>
                                                                            <input type="text" id="stockTmpValue" class="form-control bg-light" readonly>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label class="text-start">Qty Order</label>
                                                                            <input type="text" id="qtyTmpValue" name="qty_edit" class="form-control">
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                                            <button type="submit" class="btn btn-primary" id="edit" name="edit" disabled>Simpan Perubahan</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Modal Edit -->
                                        </tr>
                                        <?php $no++; ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <div class="card">
                                <?php
                                $id_spk_reg = $data['id_spk_reg'];
                                $no = 1;
                                $sql = "SELECT 
                                            sr.id_spk_reg,
                                            tps.id_tmp,
                                            tps.id_produk,
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
                                        WHERE sr.id_spk_reg = '$id_spk_reg' AND tps.status_tmp = '0'";
                                $query = mysqli_query($connect, $sql);
                                $totalRows = mysqli_num_rows($query);
                                if ($totalRows != 0) {
                                    ?>
                                    <h5 class="text-center">Tambah Produk Pesanan</h5>
                                    <?php
                                } else {

                                }

                                while ($data = mysqli_fetch_array($query)) {
                                    $id_spk = $data['id_spk_reg'];
                                    $id_produk = $data['id_produk'];
                                    $namaProduk = detailSpk::getDetail($data['nama_produk'], $data['nama_set_marwa']);
                                    $satuan = $data['satuan'];
                                    $nama_merk = detailSpk::getMerk($data['merk_produk'], $data['merk_set']);
                                    $harga = detailSpk::getHarga($data['harga_produk'], $data['harga_set_marwa']);
                                    $uuid = generate_uuid();
                                    $isEmpty = false; // Setel variabel pengecekan menjadi false jika ada data
                                    $satuan_produk = '';
                                    $id_produk_substr = substr($id_produk, 0, 2);
                                    if ($id_produk_substr == 'BR') {
                                        $satuan_produk = $satuan;
                                    } else {
                                        $satuan_produk = 'Set';
                                    }
                                ?>
                                    <div class="card-body p-2">
                                        <div class="row p-1">
                                            <div class="col-sm-1 mb-2">
                                                <input type="text" class="form-control text-center bg-light mobile" value="<?php echo $no; ?>" readonly>
                                                <?php $no++ ?>
                                            </div>
                                            <div class="col-sm-3 mb-2">
                                                <input type="hidden" name="id_tmp[]" id="id_<?php echo $data['id_tmp'] ?>" value="<?php echo $data['id_tmp'] ?>" readonly>
                                                <input type="hidden" class="form-control" name="id_spk_reg_tmp[]" value="<?php echo $id_spk_reg ?>" readonly>
                                                <input type="hidden" class="form-control" name="id_produk_tmp[]" value="<?php echo $data['id_produk'] ?>" readonly>
                                                <input type="text" class="form-control bg-light" value="<?php echo $namaProduk; ?>" readonly>
                                            </div>
                                            <div class="col-sm-1 mb-2">
                                                <input type="text" class="form-control bg-light text-center mobile-text" value="<?php echo $satuan_produk; ?>" readonly>
                                            </div>
                                            <div class="col-sm-2 mb-2">
                                                <input type="text" class="form-control bg-light text-center mobile-text" value="<?php echo $nama_merk ?>" readonly>
                                            </div>
                                            <div class="col-sm-2 mb-2">
                                                <input type="text" class="form-control bg-light text-end mobile-text" value="<?php echo number_format($harga) ?>" readonly>
                                            </div>
                                            <div class="col-sm-1 mb-2">
                                                <input type="text" class="form-control bg-light text-end mobile-text" name="stock" id="stock_<?php echo $data['id_tmp'] ?>" value="<?php echo number_format($data['stock']) ?>" readonly>
                                            </div>
                                            <div class="col-sm-1 mb-2">
                                                <input type="text" class="form-control text-end mobile-text" name="qty_tmp[]" id="qtyInput_<?php echo $data['id_tmp'] ?>" oninput="checkStock('<?php echo $data['id_tmp'] ?>')" required>
                                            </div>
                                            <div class="col-sm-1 mb-2 text-center">
                                                <a href="proses/proses-produk-spk-reg.php?hapus_tmp=<?php echo base64_encode($data['id_tmp']) ?>&&id_spk=<?php echo base64_encode($id_spk) ?>" class="btn btn-danger btn-sm delete-data"><i class="bi bi-trash"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="card-body mt-3 text-end">
                                    <?php  
                                        if ($totalRows != 0) {
                                            echo '<button type="submit" class="btn btn-primary" name="simpan-tmp" id="simpan-data"><i class="bi bi-save"></i> Simpan</button>';
                                        }
                                    ?>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main><!-- End #main -->

    <!-- Modal Barang -->
    <div class="modal fade" id="modalBarang" data-bs-backdrop="static"  tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <form method="post" action=""> <!-- Tambahkan form dengan method POST -->
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Data Barang</h1>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="table3">
                                <thead>
                                    <tr class="text-white" style="background-color: #051683;">
                                        <td class="text-center p-3 text-nowrap" style="width: 50px">No</td>
                                        <td class="text-center p-3 text-nowrap" style="width: 350px">Nama Produk</td>
                                        <td class="text-center p-3 text-nowrap" style="width: 100px">Satuan</td>
                                        <td class="text-center p-3 text-nowrap" style="width: 100px">Merk</td>
                                        <td class="text-center p-3 text-nowrap" style="width: 100px">Stock</td>
                                        <td class="text-center p-3 text-nowrap" style="width: 100px">Aksi</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    include "koneksi.php";
                                    $id = $_GET['id'];
                                    $selected_produk = [];
                                    $id_spk = $id_spk_reg;
                                    $no = 1;

                                    // Mengambil data produk yang ada dalam tmp_produk_spk untuk id_spk yang sedang aktif
                                    $query_selected_produk = mysqli_query($connect, "SELECT id_produk FROM tmp_produk_spk WHERE id_spk = '$id_spk'");
                                    while ($selected_data = mysqli_fetch_array($query_selected_produk)) {
                                        $selected_produk[] = $selected_data['id_produk'];
                                    }

                                    $sql = "SELECT 
                                                COALESCE(tpr.id_produk_reg, tpsm.id_set_marwa) AS id_produk,
                                                COALESCE(tpr.nama_produk, tpsm.nama_set_marwa) AS nama_produk,
                                                COALESCE(mr_tpr.nama_merk, mr_tpsm.nama_merk) AS nama_merk,
                                                tpr.satuan,
                                                spr.id_stock_prod_reg,
                                                spr.stock,
                                                tkp.min_stock, 
                                                tkp.max_stock
                                            FROM stock_produk_reguler AS spr
                                            LEFT JOIN tb_produk_reguler AS tpr ON (tpr.id_produk_reg = spr.id_produk_reg)
                                            LEFT JOIN tb_kat_penjualan AS tkp ON (tkp.id_kat_penjualan = spr.id_kat_penjualan)
                                            LEFT JOIN tb_produk_set_marwa AS tpsm ON (tpsm.id_set_marwa = spr.id_produk_reg)
                                            LEFT JOIN tb_merk AS mr_tpr ON (tpr.id_merk = mr_tpr.id_merk)
                                            LEFT JOIN tb_merk AS mr_tpsm ON (tpsm.id_merk = mr_tpsm.id_merk)
                                            ORDER BY nama_produk ASC";

                                    $query = mysqli_query($connect, $sql);

                                    while ($data = mysqli_fetch_array($query)) {
                                        $id_produk = $data['id_produk'];
                                        $id_produk_substr = substr($id_produk, 0, 2);
                                        $isChecked = in_array($id_produk, $selected_produk);
                                        $isDisabled = false;

                                        if ($data['stock'] == 0) {
                                            $isDisabled = true; // Jika stock = 0, maka tombol pilih akan menjadi disabled
                                        }
                                    ?>
                                        <tr>
                                            <td class="text-center text-nowrap"><?php echo $no; ?></td>
                                            <td class="text-nowrap"><?php echo $data['nama_produk']; ?></td>
                                            <td class="text-center text-nowrap">
                                                <?php 
                                                if($id_produk_substr == 'BR'){
                                                    echo $data['satuan'];
                                                } else {
                                                    echo "Set";
                                                }
                                                ?>
                                            </td>
                                            <td class="text-center text-nowrap"><?php echo $data['nama_merk']; ?></td>
                                            <td class="text-center text-nowrap"><?php echo number_format($data['stock']); ?></td>
                                            <td class="text-center text-nowrap">
                                                <button class="btn-pilih btn btn-primary btn-sm" data-id="<?php echo $id_produk; ?>"  data-spk="<?php echo $id_spk; ?>" <?php echo ($isChecked || $isDisabled) ? 'disabled' : ''; ?>>Pilih</button>
                                            </td>
                                        </tr>
                                        <?php $no++; ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="refreshPage()">Close</button>
                    </div>
                </form> <!-- Akhir dari form -->
            </div>
        </div>
    </div>
    <!-- End Modal -->


    <!-- Footer -->
    <?php include "page/footer.php" ?>
    <!-- End Footer -->
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <?php include "page/script.php" ?>
</body>

</html>

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

<!-- Kode Untuk Qty   -->
<script>
    function formatNumber(number) {
        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    function formatInputValue(value) {
        return value.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    function checkStock(inputId) {
        var stock = parseInt(document.getElementById('stock_' + inputId).value.replace(/,/g, '')); // Menggunakan ID yang sesuai untuk elemen stock
        var qtyInput = document.getElementById('qtyInput_' + inputId); // Menggunakan ID yang sesuai untuk elemen qtyInput
        var qty = qtyInput.value.replace(/,/g, '');

        qtyInput.value = formatInputValue(qty);

        if (parseInt(qty) > stock) {
            qtyInput.value = formatNumber(stock);
        }
    }
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

<!-- Edit Data -->
<script>
    $(document).ready(function() {
        var initialQty = null;

        $('#modalEdit').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var idTmp = button.data('id');
            var spkTmp = button.data('spk');
            var namaTmp = button.data('nama');
            var merkTmp = button.data('merk');
            var qtyTmp = button.data('qty');
            var stockTmp = button.data('stock');

            initialQty = qtyTmp;

            // Format angka qty dengan ribuan separator
            var formattedQty = numberWithCommas(qtyTmp);

            // Format angka stock dengan ribuan separator
            var formattedStock = numberWithCommas(stockTmp);

            $('#idTmpValue').val(idTmp);
            $('#spkTmpValue').val(spkTmp);
            $('#namaTmpValue').val(namaTmp);
            $('#merkTmpValue').val(merkTmp);
            $('#stockTmpValue').val(formattedStock);
            $('#qtyTmpValue').val(formattedQty);
        });

        // Fungsi untuk menambahkan separator ribuan pada angka
        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        // Validasi saat nilai qty berubah
        $('#qtyTmpValue').on('input', function() {
            var qtyValue = parseFloat($(this).val().replace(/,/g, ''));
            var stockValue = parseFloat($('#stockTmpValue').val().replace(/,/g, ''));

            if (isNaN(qtyValue)) {
                qtyValue = 0;
            }

            if (qtyValue > stockValue) {
                qtyValue = stockValue;
            }

            // Format angka qty dengan ribuan separator
            var formattedQty = numberWithCommas(qtyValue);

            $(this).val(formattedQty);

            // Cek apakah nilai qty berubah dari nilai awal
            if (qtyValue !== initialQty) {
                $('#edit').prop('disabled', false);
            } else {
                $('#edit').prop('disabled', true);
            }
        });
    });
</script>