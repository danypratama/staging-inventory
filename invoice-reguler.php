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

    <style>
        @media (max-width: 767px) {

            /* Tambahkan aturan CSS khusus untuk tampilan mobile di bawah 767px */
            .col-12.col-md-2 {
                /* Contoh: Mengatur tinggi elemen select pada tampilan mobile */
                height: 50px;
            }
        }

        .btn.active {
            background-color: black;
            color: white;
            border-color: 1px solid white;
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
        <!-- Loading -->
        <div class="loader loader">
            <div class="loading">
                <img src="img/loading.gif" width="200px" height="auto">
            </div>
        </div>
        <!-- ENd Loading -->
        <div class="pagetitle">
            <h1>Data SPK</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                    <li class="breadcrumb-item active">SPK</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section>
            <div class="card">
                <div class="mt-4">
                    <ul class="nav nav-tabs d-flex ms-3 me-3 justify-content-between" role="tablist" id="myTab" role="tablist">
                        <li class="nav-item flex-fill" role="presentation">
                            <?php
                            $sql_belum_diproses = " SELECT sr.*, cs.nama_cs, cs.alamat
                                        FROM spk_reg AS sr
                                        JOIN tb_customer cs ON(sr.id_customer = cs.id_cs)
                                        WHERE status_spk = 'Belum Diproses'";
                            $query_belum_diproses = mysqli_query($connect, $sql_belum_diproses);
                            $total_data_belum_diproses = mysqli_num_rows($query_belum_diproses);
                            ?>
                            <a class="nav-link" href="spk-reg.php">
                                Belum Diproses &nbsp;
                                <?php if ($total_data_belum_diproses != 0) {
                                    echo '<span class="badge text-bg-secondary">' . $total_data_belum_diproses . '</span>';
                                }
                                ?>
                            </a>
                        </li>
                        <li class="nav-item flex-fill" role="presentation">
                            <?php
                            $sql_dalam_proses = " SELECT sr.*, cs.nama_cs, cs.alamat
                                        FROM spk_reg AS sr
                                        JOIN tb_customer cs ON(sr.id_customer = cs.id_cs)
                                        WHERE status_spk = 'Dalam Proses'";
                            $query_dalam_proses = mysqli_query($connect, $sql_dalam_proses);
                            $total_data_dalam_proses = mysqli_num_rows($query_dalam_proses);
                            ?>
                            <a class="nav-link" href="spk-dalam-proses.php">
                                Dalam Proses &nbsp;
                                <?php if ($total_data_dalam_proses != 0) {
                                    echo '<span class="badge text-bg-secondary">' . $total_data_dalam_proses . '</span>';
                                }
                                ?>
                            </a>
                        </li>
                        <li class="nav-item flex-fill" role="presentation">
                            <?php
                            include "koneksi.php";
                            $sql_siap_kirim = " SELECT sr.*, cs.nama_cs, cs.alamat
                                    FROM spk_reg AS sr
                                    JOIN tb_customer cs ON(sr.id_customer = cs.id_cs)
                                    WHERE status_spk = 'Siap Kirim'";
                            $query_siap_kirim = mysqli_query($connect, $sql_siap_kirim);
                            $total_data_siap_kirim = mysqli_num_rows($query_siap_kirim);
                            ?>
                            <a class="nav-link" href="spk-siap-kirim.php?sort=baru">
                                Siap Kirim &nbsp;
                                <?php if ($total_data_siap_kirim != 0) {
                                    echo '<span class="badge text-bg-secondary">' . $total_data_siap_kirim . '</span>';
                                }
                                ?>
                            </a>
                        </li>
                        <li class="nav-item flex-fill" role="presentation">
                            <?php
                            $sql_inv = "SELECT nonppn.*, sr.id_inv, sr.id_customer, sr.no_po, cs.nama_cs, cs.alamat
                                FROM inv_nonppn AS nonppn
                                LEFT JOIN spk_reg sr ON(nonppn.id_inv_nonppn = sr.id_inv)
                                JOIN tb_customer cs ON(sr.id_customer = cs.id_cs)
                                WHERE status_transaksi = 'Belum Dikirim' GROUP BY no_inv";
                            $query_inv = mysqli_query($connect, $sql_inv);
                            $total_inv_nonppn = mysqli_num_rows($query_inv);
                            ?>
                            <?php
                            $sql_inv_ppn = "SELECT ppn.*, sr.id_inv, sr.id_customer, sr.no_po, cs.nama_cs, cs.alamat
                                FROM inv_ppn AS ppn
                                LEFT JOIN spk_reg sr ON(ppn.id_inv_ppn = sr.id_inv)
                                JOIN tb_customer cs ON(sr.id_customer = cs.id_cs)
                                WHERE status_transaksi = 'Belum Dikirim' GROUP BY no_inv";
                            $query_inv_ppn = mysqli_query($connect, $sql_inv_ppn);
                            $total_inv_ppn = mysqli_num_rows($query_inv_ppn);
                            ?>
                            <?php
                            $sql_inv_bum = "SELECT bum.*, sr.id_inv, sr.id_customer, sr.no_po, cs.nama_cs, cs.alamat
                                FROM inv_bum AS bum
                                LEFT JOIN spk_reg sr ON(bum.id_inv_bum = sr.id_inv)
                                JOIN tb_customer cs ON(sr.id_customer = cs.id_cs)
                                WHERE status_transaksi = 'Belum Dikirim' GROUP BY no_inv";
                            $query_inv_bum = mysqli_query($connect, $sql_inv_bum);
                            $total_inv_bum = mysqli_num_rows($query_inv_bum);
                            $hasil = $total_inv_nonppn + $total_inv_ppn + $total_inv_bum;
                            ?>
                            <a class="nav-link active">
                                Invoice Sudah Dicetak &nbsp;
                                <?php if ($hasil != 0) {
                                    echo '<span class="badge text-bg-secondary">' . $hasil . '</span>';
                                }
                                ?>
                            </a>
                        </li>
                        <li class="nav-item flex-fill" role="presentation">
                            <?php
                            $sql_inv_dikirim = "SELECT nonppn.*, sr.id_inv, sr.id_customer, sr.no_po, cs.nama_cs, cs.alamat
                                FROM inv_nonppn AS nonppn
                                LEFT JOIN spk_reg sr ON(nonppn.id_inv_nonppn = sr.id_inv)
                                JOIN tb_customer cs ON(sr.id_customer = cs.id_cs)
                                WHERE status_transaksi = 'Dikirim' GROUP BY no_inv";
                            $query_inv_dikirim = mysqli_query($connect, $sql_inv_dikirim);
                            $total_inv_nonppn_dikirim = mysqli_num_rows($query_inv_dikirim);
                            ?>
                            <?php
                            $sql_inv_ppn_dikirim = "SELECT ppn.*, sr.id_inv, sr.id_customer, sr.no_po, cs.nama_cs, cs.alamat
                                FROM inv_ppn AS ppn
                                LEFT JOIN spk_reg sr ON(ppn.id_inv_ppn = sr.id_inv)
                                JOIN tb_customer cs ON(sr.id_customer = cs.id_cs)
                                WHERE status_transaksi = 'Dikirim' GROUP BY no_inv";
                            $query_inv_ppn_dikirim = mysqli_query($connect, $sql_inv_ppn_dikirim);
                            $total_inv_ppn_dikirim = mysqli_num_rows($query_inv_ppn_dikirim);
                            ?>
                            <?php
                            $sql_inv_bum_dikirim = "SELECT bum.*, sr.id_inv, sr.id_customer, sr.no_po, cs.nama_cs, cs.alamat
                                FROM inv_bum AS bum
                                LEFT JOIN spk_reg sr ON(bum.id_inv_bum = sr.id_inv)
                                JOIN tb_customer cs ON(sr.id_customer = cs.id_cs)
                                WHERE status_transaksi = 'Dikirim' GROUP BY no_inv";
                            $query_inv_bum_dikirim = mysqli_query($connect, $sql_inv_bum_dikirim);
                            $total_inv_bum_dikirim = mysqli_num_rows($query_inv_bum_dikirim);
                            $hasil_dikirim = $total_inv_nonppn_dikirim + $total_inv_ppn_dikirim + $total_inv_bum_dikirim;
                            ?>
                            <a class="nav-link" href="invoice-reguler-dikirim.php?sort=baru">
                                Dikirim &nbsp;
                                <?php if ($hasil_dikirim != 0) {
                                    echo '<span class="badge text-bg-secondary">' . $hasil_dikirim . '</span>';
                                }
                                ?>
                            </a>
                        </li>
                        <li class="nav-item flex-fill" role="presentation">
                            <?php
                            $sql_inv_diterima = "SELECT nonppn.*, sr.id_inv, sr.id_customer, sr.no_po, cs.nama_cs, cs.alamat
                                FROM inv_nonppn AS nonppn
                                LEFT JOIN spk_reg sr ON(nonppn.id_inv_nonppn = sr.id_inv)
                                JOIN tb_customer cs ON(sr.id_customer = cs.id_cs)
                                WHERE status_transaksi = 'diterima' GROUP BY no_inv";
                            $query_inv_diterima = mysqli_query($connect, $sql_inv_diterima);
                            $total_inv_nonppn_diterima = mysqli_num_rows($query_inv_diterima);
                            ?>
                            <?php
                            $sql_inv_ppn_diterima = "SELECT ppn.*, sr.id_inv, sr.id_customer, sr.no_po, cs.nama_cs, cs.alamat
                                FROM inv_ppn AS ppn
                                LEFT JOIN spk_reg sr ON(ppn.id_inv_ppn = sr.id_inv)
                                JOIN tb_customer cs ON(sr.id_customer = cs.id_cs)
                                WHERE status_transaksi = 'diterima' GROUP BY no_inv";
                            $query_inv_ppn_diterima = mysqli_query($connect, $sql_inv_ppn_diterima);
                            $total_inv_ppn_diterima = mysqli_num_rows($query_inv_ppn_diterima);
                            ?>
                            <?php
                            $sql_inv_bum_diterima = "SELECT bum.*, sr.id_inv, sr.id_customer, sr.no_po, cs.nama_cs, cs.alamat
                                FROM inv_bum AS bum
                                LEFT JOIN spk_reg sr ON(bum.id_inv_bum = sr.id_inv)
                                JOIN tb_customer cs ON(sr.id_customer = cs.id_cs)
                                WHERE status_transaksi = 'diterima' GROUP BY no_inv";
                            $query_inv_bum_diterima = mysqli_query($connect, $sql_inv_bum_diterima);
                            $total_inv_bum_diterima = mysqli_num_rows($query_inv_bum_diterima);
                            $hasil_diterima = $total_inv_nonppn_diterima + $total_inv_ppn_diterima + $total_inv_bum_diterima;
                            ?>
                            <a class="nav-link" href="invoice-reguler-diterima.php?sort=baru">
                                Diterima &nbsp;
                                <?php if ($hasil_diterima != 0) {
                                    echo '<span class="badge text-bg-secondary">' . $hasil_diterima . '</span>';
                                }
                                ?>
                            </a>
                        </li>
                        <li class="nav-item flex-fill" role="presentation">
                        <?php
                            $sql_inv_selesai = "SELECT nonppn.*, sr.id_inv, sr.id_customer, sr.no_po, cs.nama_cs, cs.alamat
                                FROM inv_nonppn AS nonppn
                                LEFT JOIN spk_reg sr ON(nonppn.id_inv_nonppn = sr.id_inv)
                                JOIN tb_customer cs ON(sr.id_customer = cs.id_cs)
                                WHERE status_transaksi = 'Transaksi Selesai' GROUP BY no_inv";
                            $query_inv_selesai = mysqli_query($connect, $sql_inv_selesai);
                            $total_inv_nonppn_selesai = mysqli_num_rows($query_inv_selesai);
                            ?>
                            <?php
                            $sql_inv_ppn_selesai = "SELECT ppn.*, sr.id_inv, sr.id_customer, sr.no_po, cs.nama_cs, cs.alamat
                                FROM inv_ppn AS ppn
                                LEFT JOIN spk_reg sr ON(ppn.id_inv_ppn = sr.id_inv)
                                JOIN tb_customer cs ON(sr.id_customer = cs.id_cs)
                                WHERE status_transaksi = 'Transaksi Selesai' GROUP BY no_inv";
                            $query_inv_ppn_selesai = mysqli_query($connect, $sql_inv_ppn_selesai);
                            $total_inv_ppn_selesai = mysqli_num_rows($query_inv_ppn_selesai);
                            ?>
                            <?php
                            $sql_inv_bum_selesai = "SELECT bum.*, sr.id_inv, sr.id_customer, sr.no_po, cs.nama_cs, cs.alamat
                                FROM inv_bum AS bum
                                LEFT JOIN spk_reg sr ON(bum.id_inv_bum = sr.id_inv)
                                JOIN tb_customer cs ON(sr.id_customer = cs.id_cs)
                                WHERE status_transaksi = 'Transaksi Selesai' GROUP BY no_inv";
                            $query_inv_bum_selesai = mysqli_query($connect, $sql_inv_bum_selesai);
                            $total_inv_bum_selesai = mysqli_num_rows($query_inv_bum_selesai);
                            $hasil_selesai = $total_inv_nonppn_selesai + $total_inv_ppn_selesai + $total_inv_bum_selesai;
                            ?>
                            <a class="nav-link" href="invoice-reguler-selesai.php?sort=baru">
                                Transaksi Selesai &nbsp;
                                <?php if ($hasil_selesai != 0) {
                                    echo '<span class="badge text-bg-secondary">' . $hasil_selesai . '</span>';
                                }
                                ?>
                            </a>
                        </li>
                        <li class="nav-item flex-fill" role="presentation">
                            <?php
                                $sql_cancel = " SELECT 
                                                    sr.id_spk_reg,
                                                    sr.no_spk,
                                                    sr.tgl_spk,
                                                    sr.no_po,
                                                    sr.menu_cancel,
                                                    sr.note,
                                                    cs.nama_cs, cs.alamat
                                                FROM spk_reg AS sr
                                                JOIN tb_customer cs ON(sr.id_customer = cs.id_cs)
                                                WHERE status_spk = 'Cancel Order'";
                                 $query_cancel = mysqli_query($connect, $sql_cancel);
                                $total_query_cancel = mysqli_num_rows($query_cancel);
                            ?>
                            <a class="nav-link" href="transaksi-cancel.php?sort=baru">
                                Transaksi Cancel &nbsp;
                                <?php if ($total_query_cancel != 0) {
                                    echo '<span class="badge text-bg-secondary">' . $total_query_cancel . '</span>';
                                }
                                ?>
                            </a>
                        </li>
                    </ul>
                    <div class="card-body bg-body rounded mt-3">
                        <a class="btn btn-outline-dark <?php if ($activeButton == 'nonppn') echo 'active'; ?> mb-3" data-bs-toggle="collapse" href="#nonppn" role="button" aria-expanded="false" aria-controls="collapseExample">
                            Invoice Non PPN &nbsp;
                            <?php if ($total_inv_nonppn != 0) {
                                echo '<span class="badge text-bg-secondary">' . $total_inv_nonppn . '</span>';
                            } ?>
                        </a>

                        <a class="btn btn-outline-dark <?php if ($activeButton == 'ppn') echo 'active'; ?> mb-3" data-bs-toggle="collapse" href="#ppn" role="button" aria-expanded="false" aria-controls="collapseExample">
                            Invoice PPN &nbsp;
                            <?php if ($total_inv_ppn != 0) {
                                echo '<span class="badge text-bg-secondary">' . $total_inv_ppn . '</span>';
                            } ?>
                        </a>
                        <a class="btn btn-outline-dark <?php if ($activeButton == 'bum') echo 'active'; ?> mb-3" data-bs-toggle="collapse" href="#bum" role="button" aria-expanded="false" aria-controls="collapseExample">
                            Invoice BUM &nbsp;
                            <?php if ($total_inv_bum != 0) {
                                echo '<span class="badge text-bg-secondary">' . $total_inv_bum . '</span>';
                            } ?>
                        </a>
                        <div class="collapse <?php if ($activeButton == 'nonppn') echo 'show'; ?>" id="nonppn" data-bs-parent="#accordion">
                            <div class="table-responsive" id="filteredData">
                                <form id="invoiceForm" name="proses" method="POST">
                                    <div class="row mb-3 mt-4">
                                        <div class="col-md-2">
                                            <form action="" method="GET">
                                                <select name="sort" class="form-select" id="select" aria-label="Default select example" onchange="filterData()">
                                                    <option value="baru" <?php if (isset($_GET['sort']) && $_GET['sort'] == "baru") {
                                                                                echo "selected";
                                                                            } ?>>Paling Baru</option>
                                                    <option value="lama" <?php if (isset($_GET['sort']) && $_GET['sort'] == "lama") {
                                                                                echo "selected";
                                                                            } ?>>Paling Lama</option>
                                                </select>
                                            </form>
                                        </div>
                                    </div>
                                    <table class="table table-bordered table-striped" id="table2">
                                        <thead>
                                            <tr class="text-white" style="background-color: navy;">
                                                <th class="text-center p-3 text-nowrap" style="width: 30px">No</th>
                                                <th class="text-center p-3 text-nowrap" style="width: 150px">No. Invoice</th>
                                                <th class="text-center p-3 text-nowrap" style="width: 150px">Tgl. Invoice</th>
                                                <th class="text-center p-3 text-nowrap" style="width: 150px">No. PO</th>
                                                <th class="text-center p-3 text-nowrap" style="width: 250px">Nama Customer</th>
                                                <th class="text-center p-3 text-nowrap" style="width: 100px">Kat. Inv</th>
                                                <th class="text-center p-3 text-nowrap" style="width: 100px">Note</th>
                                                <th class="text-center p-3 text-nowrap" style="width: 80px">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            include "koneksi.php";
                                            $no = 1;
                                            $filter = '';
                                            if (isset($_GET['sort'])) {
                                                if ($_GET['sort'] == "baru") {
                                                    $filter = "ORDER BY tgl_inv DESC";
                                                } elseif ($_GET['sort'] == "lama") {
                                                    $filter = "ORDER BY tgl_inv ASC";
                                                }
                                            }
                                            $sql = "SELECT 
                                                        nonppn.id_inv_nonppn,
                                                        nonppn.no_inv,
                                                        nonppn.tgl_inv,
                                                        nonppn.kategori_inv,
                                                        nonppn.note_inv,
                                                        sr.id_inv, 
                                                        sr.id_customer, 
                                                        sr.no_po, 
                                                        cs.nama_cs, 
                                                        cs.alamat
                                                    FROM inv_nonppn AS nonppn
                                                    LEFT JOIN spk_reg sr ON(nonppn.id_inv_nonppn = sr.id_inv)
                                                    JOIN tb_customer cs ON(sr.id_customer = cs.id_cs)
                                                    WHERE status_transaksi = 'Belum Dikirim' GROUP BY no_inv  $filter";
                                            $query = mysqli_query($connect, $sql);
                                            while ($data = mysqli_fetch_array($query)) {

                                            ?>
                                                <tr>
                                                    <td class="text-center text-nowrap"><?php echo $no; ?></td>
                                                    <td class="text-center text-nowrap"><?php echo $data['no_inv'] ?></td>
                                                    <td class="text-center text-nowrap"><?php echo $data['tgl_inv'] ?></td>
                                                    <td class="text-center text-nowrap">
                                                        <?php 
                                                            if(!empty($data['no_po'])){
                                                                echo $data['no_po'];
                                                            } else {
                                                                echo '-';
                                                            }
                                                        ?>
                                                    </td>
                                                    <td class="text-nowrap"><?php echo $data['nama_cs'] ?></td>
                                                    <td class="text-center text-nowrap"><?php echo $data['kategori_inv'] ?></td>
                                                    <td class="text-nowrap">
                                                        <?php
                                                            $note = $data['note_inv'];

                                                            $items = explode("\n", trim($note));

                                                            if(!empty($note)){
                                                                foreach ($items as $notes) {
                                                                    echo trim($notes) . '<br>';
                                                                }
                                                            }else{
                                                                echo 'Tidak Ada';
                                                            }
                                                        ?>
                                                    </td>
                                                    <td class="text-center text-nowrap">
                                                        <a href="cek-produk-inv-nonppn.php?id=<?php echo base64_encode($data['id_inv_nonppn']) ?>" class="btn btn-primary btn-sm mb-2" title="Lihat Produk"><i class="bi bi-eye-fill"></i></a>
                                                    </td>
                                                </tr>
                                                <?php $no++ ?>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                        </div>
                        <div class="collapse <?php if ($activeButton == 'ppn') echo 'show'; ?>" id="ppn" data-bs-parent="#accordion">
                            <div class="table-responsive" id="filteredDataPpn">
                                <form id="invoiceForm" name="proses" method="POST">
                                    <div class="row mb-3 mt-4">
                                        <div class="col-md-2">
                                            <form action="" method="GET">
                                                <select name="sort" class="form-select" id="select_ppn" aria-label="Default select example" onchange="filterDataPpn()">
                                                    <option value="baru" <?php if (isset($_GET['sort']) && $_GET['sort'] == "baru") {
                                                                                echo "selected";
                                                                            } ?>>Paling Baru</option>
                                                    <option value="lama" <?php if (isset($_GET['sort']) && $_GET['sort'] == "lama") {
                                                                                echo "selected";
                                                                            } ?>>Paling Lama</option>
                                                </select>

                                            </form>
                                        </div>
                                    </div>
                                    <table class="table table-bordered table-striped" id="tableppn">
                                        <thead>
                                            <tr class="text-white text-nowrap" style="background-color: navy;">
                                                <th class="text-center p-3 text-nowrap" style="width: 30px">No</th>
                                                <th class="text-center p-3 text-nowrap" style="width: 150px">No. Invoice</th>
                                                <th class="text-center p-3 text-nowrap" style="width: 150px">Tgl. Invoice</th>
                                                <th class="text-center p-3 text-nowrap" style="width: 150px">No. PO</th>
                                                <th class="text-center p-3 text-nowrap" style="width: 250px">Nama Customer</th>
                                                <th class="text-center p-3 text-nowrap" style="width: 100px">Kat. Inv</th>
                                                <th class="text-center p-3 text-nowrap" style="width: 100px">Note</th>
                                                <th class="text-center p-3 text-nowrap" style="width: 80px">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            include "koneksi.php";
                                            $no = 1;
                                            $filter = '';
                                            if (isset($_GET['sort'])) {
                                                if ($_GET['sort'] == "baru") {
                                                    $filter = "ORDER BY tgl_inv DESC";
                                                } elseif ($_GET['sort'] == "lama") {
                                                    $filter = "ORDER BY tgl_inv ASC";
                                                }
                                            }
                                            $sql = "SELECT 
                                                        ppn.id_inv_ppn,
                                                        ppn.no_inv,
                                                        ppn.tgl_inv,
                                                        ppn.kategori_inv,
                                                        ppn.note_inv,
                                                        sr.id_inv, 
                                                        sr.id_customer, 
                                                        sr.no_po, 
                                                        cs.nama_cs, 
                                                        cs.alamat
                                                    FROM inv_ppn AS ppn
                                                    LEFT JOIN spk_reg sr ON(ppn.id_inv_ppn = sr.id_inv)
                                                    JOIN tb_customer cs ON(sr.id_customer = cs.id_cs)
                                                    WHERE status_transaksi = 'Belum Dikirim' GROUP BY no_inv  $filter";
                                            $query = mysqli_query($connect, $sql);
                                            while ($data = mysqli_fetch_array($query)) {
                                            ?>
                                                <tr>
                                                    <td class="text-center text-nowrap"><?php echo $no; ?></td>
                                                    <td class="text-center text-nowrap"><?php echo $data['no_inv'] ?></td>
                                                    <td class="text-center text-nowrap"><?php echo $data['tgl_inv'] ?></td>
                                                    <td class="text-center text-nowrap">
                                                        <?php 
                                                            if(!empty($data['no_po'])){
                                                                echo $data['no_po'];
                                                            } else {
                                                                echo '-';
                                                            }
                                                        ?>
                                                    </td>
                                                    <td class="text-nowrap"><?php echo $data['nama_cs'] ?></td>
                                                    <td class="text-center text-nowrap"><?php echo $data['kategori_inv'] ?></td>
                                                    <td class="text-nowrap">
                                                        <?php
                                                            $note = $data['note_inv'];

                                                            $items = explode("\n", trim($note));

                                                            if(!empty($note)){
                                                                foreach ($items as $notes) {
                                                                    echo trim($notes) . '<br>';
                                                                }
                                                            }else{
                                                                echo 'Tidak Ada';
                                                            }
                                                        ?>
                                                    </td>
                                                    <td class="text-center text-nowrap">
                                                        <a href="cek-produk-inv-ppn.php?id=<?php echo base64_encode($data['id_inv_ppn']) ?>" class="btn btn-primary btn-sm mb-2" title="Lihat Produk"><i class="bi bi-eye-fill"></i></a>
                                                    </td>
                                                </tr>
                                                <?php $no++ ?>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                        </div>
                        <div class="collapse <?php if ($activeButton == 'bum') echo 'show'; ?>" id="bum" data-bs-parent="#accordion">
                            <div class="table-responsive" id="filteredDataBum">
                                <form id="invoiceForm" name="proses" method="POST">
                                    <div class="row mb-3 mt-4">
                                        <div class="col-md-2">
                                            <form action="" method="GET">
                                                <select name="sort" class="form-select" id="select_bum" aria-label="Default select example" onchange="filterDataBum()">
                                                    <option value="baru" <?php if (isset($_GET['sort']) && $_GET['sort'] == "baru") {
                                                                                echo "selected";
                                                                            } ?>>Paling Baru</option>
                                                    <option value="lama" <?php if (isset($_GET['sort']) && $_GET['sort'] == "lama") {
                                                                                echo "selected";
                                                                            } ?>>Paling Lama</option>
                                                </select>

                                            </form>
                                        </div>
                                    </div>
                                    <table class="table table-bordered table-striped" id="tablebum">
                                        <thead>
                                            <tr class="text-white text-nowrap" style="background-color: navy;">
                                                <th class="text-center p-3 text-nowrap" style="width: 30px">No</th>
                                                <th class="text-center p-3 text-nowrap" style="width: 150px">No. Invoice</th>
                                                <th class="text-center p-3 text-nowrap" style="width: 150px">Tgl. Invoice</th>
                                                <th class="text-center p-3 text-nowrap" style="width: 150px">No. PO</th>
                                                <th class="text-center p-3 text-nowrap" style="width: 250px">Nama Customer</th>
                                                <th class="text-center p-3 text-nowrap" style="width: 100px">Kat. Inv</th>
                                                <th class="text-center p-3 text-nowrap" style="width: 100px">Note</th>
                                                <th class="text-center p-3 text-nowrap" style="width: 80px">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            include "koneksi.php";
                                            $no = 1;
                                            $filter = '';
                                            if (isset($_GET['sort'])) {
                                                if ($_GET['sort'] == "baru") {
                                                    $filter = "ORDER BY tgl_inv DESC";
                                                } elseif ($_GET['sort'] == "lama") {
                                                    $filter = "ORDER BY tgl_inv ASC";
                                                }
                                            }
                                            $sql = "SELECT 
                                                        bum.id_inv_bum,
                                                        bum.no_inv,
                                                        bum.tgl_inv,
                                                        bum.kategori_inv,
                                                        bum.note_inv,
                                                        sr.id_inv, 
                                                        sr.id_customer, 
                                                        sr.no_po, 
                                                        cs.nama_cs, 
                                                        cs.alamat
                                                    FROM inv_bum AS bum
                                                    LEFT JOIN spk_reg sr ON(bum.id_inv_bum = sr.id_inv)
                                                    JOIN tb_customer cs ON(sr.id_customer = cs.id_cs)
                                                    WHERE status_transaksi = 'Belum Dikirim' GROUP BY no_inv  $filter";
                                            $query = mysqli_query($connect, $sql);
                                            while ($data = mysqli_fetch_array($query)) {
                                            ?>
                                                <tr>
                                                    <td class="text-center text-nowrap"><?php echo $no; ?></td>
                                                    <td class="text-center text-nowrap"><?php echo $data['no_inv'] ?></td>
                                                    <td class="text-center text-nowrap"><?php echo $data['tgl_inv'] ?></td>
                                                    <td class="text-center text-nowrap">
                                                        <?php 
                                                            if(!empty($data['no_po'])){
                                                                echo $data['no_po'];
                                                            } else {
                                                                echo '-';
                                                            }
                                                        ?>
                                                    </td>
                                                    <td class="text-nowrap"><?php echo $data['nama_cs'] ?></td>
                                                    <td class="text-center text-nowrap"><?php echo $data['kategori_inv'] ?></td>
                                                    <td class="text-nowrap">
                                                        <?php
                                                            $note = $data['note_inv'];

                                                            $items = explode("\n", trim($note));

                                                            if(!empty($note)){
                                                                foreach ($items as $notes) {
                                                                    echo trim($notes) . '<br>';
                                                                }
                                                            }else{
                                                                echo 'Tidak Ada';
                                                            }
                                                        ?>
                                                    </td>
                                                    <td class="text-center text-nowrap">
                                                        <a href="cek-produk-inv-bum.php?id=<?php echo base64_encode($data['id_inv_bum']) ?>" class="btn btn-primary btn-sm mb-2" title="Lihat Produk"><i class="bi bi-eye-fill"></i> Lihat</a>
                                                    </td>
                                                </tr>
                                                <?php $no++ ?>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                        </div>
                        <script>
                            // Filter Non PPN
                            // Fungsi untuk mengirim permintaan AJAX
                            function filterData() {
                                // Ambil nilai filter dari elemen select
                                var sortValue = document.getElementById('select').value;

                                // Buat objek XMLHttpRequest
                                var xhttp = new XMLHttpRequest();

                                // Atur callback function untuk menangani perubahan status permintaan
                                xhttp.onreadystatechange = function() {
                                    if (this.readyState == 4 && this.status == 200) {
                                        // Update elemen filteredData dengan hasil filter yang diterima dari server
                                        document.getElementById('filteredData').innerHTML = this.responseText;
                                        // Inisialisasi ulang DataTable setelah mengganti isi tabel
                                        $('#table5').DataTable({
                                            "lengthChange": false,
                                            "ordering": false,
                                            "autoWidth": false
                                        });
                                    }
                                };

                                // Buat permintaan GET ke file PHP yang akan memproses filter
                                xhttp.open('GET', 'filter-data-nonppn.php?sort=' + sortValue, true);
                                xhttp.send();
                            }

                            // Filter PPN
                            // Fungsi untuk mengirim permintaan AJAX
                            function filterDataPpn() {
                                // Ambil nilai filter dari elemen select
                                var sortValue = document.getElementById('select_ppn').value;

                                // Buat objek XMLHttpRequest
                                var xhttp = new XMLHttpRequest();

                                // Atur callback function untuk menangani perubahan status permintaan
                                xhttp.onreadystatechange = function() {
                                    if (this.readyState == 4 && this.status == 200) {
                                        // Update elemen filteredData dengan hasil filter yang diterima dari server
                                        document.getElementById('filteredDataPpn').innerHTML = this.responseText;
                                        $('#table6').DataTable({
                                            "lengthChange": false,
                                            "ordering": false,
                                            "autoWidth": false
                                        });
                                    }
                                };

                                // Buat permintaan GET ke file PHP yang akan memproses filter
                                xhttp.open('GET', 'filter-data-ppn.php?sort=' + sortValue, true);
                                xhttp.send();
                            }


                            // Filter PPN
                            // Fungsi untuk mengirim permintaan AJAX
                            function filterDataBum() {
                                // Ambil nilai filter dari elemen select
                                var sortValue = document.getElementById('select_bum').value;

                                // Buat objek XMLHttpRequest
                                var xhttp = new XMLHttpRequest();

                                // Atur callback function untuk menangani perubahan status permintaan
                                xhttp.onreadystatechange = function() {
                                    if (this.readyState == 4 && this.status == 200) {
                                        // Update elemen filteredData dengan hasil filter yang diterima dari server
                                        document.getElementById('filteredDataBum').innerHTML = this.responseText;
                                        $('#table7').DataTable({
                                            "lengthChange": false,
                                            "ordering": false,
                                            "autoWidth": false
                                        });
                                    }
                                };

                                // Buat permintaan GET ke file PHP yang akan memproses filter
                                xhttp.open('GET', 'filter-data-bum.php?sort=' + sortValue, true);
                                xhttp.send();
                            }
                        </script>

                        <script>
                            var collToggle = document.querySelectorAll('[data-bs-toggle="collapse"]');
                            var collTargets = document.querySelectorAll('.collapse');

                            collToggle.forEach(function(toggle) {
                                toggle.addEventListener('click', function() {
                                    var target = toggle.getAttribute('href');
                                    var targetCollapse = document.querySelector(target);
                                    var isExpanded = targetCollapse.classList.contains('show');

                                    collTargets.forEach(function(collapse) {
                                        if (collapse !== targetCollapse) {
                                            collapse.classList.remove('show');
                                        }
                                    });

                                    collToggle.forEach(function(toggle) {
                                        if (toggle !== this) {
                                            toggle.classList.remove('active');
                                        }
                                    });

                                    if (!isExpanded) {
                                        targetCollapse.classList.add('show');
                                        toggle.classList.add('active');
                                    } else {
                                        targetCollapse.classList.remove('show');
                                        toggle.classList.remove('active');
                                    }
                                });
                            });
                        </script>



                    </div>
                    <!-- End Dalam Proses -->
                    <!-- ================================================ -->
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

<script>
    $(document).ready(function() {
        $("#select").change(function() {
            var open = $(this).data("isopen");
            if (open) {
                window.location.href = $(this).val();
            }
            //set isopen to opposite so next time when user clicks select box
            //it won't trigger this event
            $(this).data("isopen", !open);
        });
    });
</script>

<script>
    $(document).ready(function() {
        var table = $('#tableppn').DataTable({
            "lengthChange": false,
            "ordering": false,
            "autoWidth": false
        });
    });
    $(document).ready(function() {
        var table = $('#tablebum').DataTable({
            "lengthChange": false,
            "ordering": false,
            "autoWidth": false
        });
    });
</script>