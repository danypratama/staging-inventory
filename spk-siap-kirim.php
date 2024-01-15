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
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                    <li class="breadcrumb-item active">SPK</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section>
             <!-- SWEET ALERT -->
             <div class="info-data" data-infodata="<?php if (isset($_SESSION['info'])) {
                                                        echo $_SESSION['info'];
                                                    }
                                                    unset($_SESSION['info']); ?>"></div>
            <!-- END SWEET ALERT -->
            <div class="card">
                <div class="mt-4">
                    <ul class="nav nav-tabs d-flex ms-3 me-3 justify-content-between" role="tablist" id="myTab"
                        role="tablist">
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
                            <button class="nav-link active">
                                Siap Kirim &nbsp;
                                <?php if ($total_data_siap_kirim != 0) {
                                    echo '<span class="badge text-bg-secondary">' . $total_data_siap_kirim . '</span>';
                                }
                                ?>
                            </button>
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
                            <a class="nav-link" href="invoice-reguler.php?sort=baru">
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
                            $hasil_dikirim = $total_inv_nonppn_dikirim + $total_inv_ppn_dikirim +  $total_inv_bum_dikirim;
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
                            <a class="nav-link" href="invoice-reguler-selesai.php">
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
                        <div class="tab-content">
                            <div class="card p-3 pt-5">
                                <form id="invoiceForm" name="proses" method="POST">
                                    <div class="table-responsive">
                                        <div class="row mb-3">
                                            <div class="row mb-3">
                                                <div class="col-12 col-md-2 mb-2">
                                                    <form action="" method="GET">
                                                        <select name="sort" class="form-select" id="select"
                                                            aria-label="Default select example"
                                                            onchange='if(this.value != 0) { this.form.submit(); }'>
                                                            <option value="baru" <?php if (isset($_GET['sort']) && $_GET['sort'] == "baru") {
                                                                                        echo "selected";
                                                                                    } ?>>Paling Baru</option>
                                                            <option value="lama" <?php if (isset($_GET['sort']) && $_GET['sort'] == "lama") {
                                                                                        echo "selected";
                                                                                    } ?>>Paling Lama</option>
                                                        </select>
                                                    </form>
                                                </div>
                                                <?php  
                                                    include "koneksi.php";
                                                    $id_role = $_SESSION['tiket_role'];
                                                    $sql_role = "SELECT * FROM user_role WHERE id_user_role='$id_role'";
                                                    $query_role = mysqli_query($connect, $sql_role) or die(mysqli_error($connect));
                                                    $data_role = mysqli_fetch_array($query_role);
                                                    if ($data_role['role'] == "Super Admin" || $data_role['role'] == "Admin Penjualan") {
                                                        ?>
                                                            <div class="col-6">
                                                                <div class="row">
                                                                    <div class="mb-3" style="width: 220px;">
                                                                        <input id="nonPpnButton" type="button" name="inv-nonppn"
                                                                            class="btn btn-primary btn-md"
                                                                            value="Buat Invoice Non PPN"
                                                                            onclick="submitForm('form-invoice-nonppn.php')">
                                                                    </div>
                                                                    <div class="mb-3" style="width: 190px;">
                                                                        <input id="ppnButton" type="button"
                                                                            class="btn btn-secondary btn-md"
                                                                            value="Buat Invoice PPN"
                                                                            onclick="submitForm('form-invoice-ppn.php')">
                                                                    </div>
                                                                    <div class="mb-3" style="width: 200px;">
                                                                        <input id="bumButton" type="button" id="Invoice-BUM"
                                                                            class="btn btn-warning btn-md" value="Buat Invoice BUM"
                                                                            onclick="submitForm('form-invoice-bum.php')">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php
                                                    }
                                                ?>
                                            </div>
                                            <table class="table table-bordered table-striped" id="table2">
                                                <thead>
                                                    <tr class="text-white" style="background-color: navy;">
                                                        <?php  
                                                            if ($data_role['role'] == "Super Admin" || $data_role['role'] == "Admin Penjualan") {
                                                                ?>
                                                                    <th class="text-center p-3 text-nowrap" style="width: 20px">Pilih</th>
                                                                <?php
                                                            }
                                                        ?>
                                                        <th class="text-center p-3 text-nowrap" style="width: 30px">No</th>
                                                        <th class="text-center p-3 text-nowrap" style="width: 150px">No.SPK</th>
                                                        <th class="text-center p-3 text-nowrap" style="width: 150px">Tgl. SPK</th>
                                                        <th class="text-center p-3 text-nowrap" style="width: 150px">No.PO</th>
                                                        <th class="text-center p-3 text-nowrap" style="width: 200px">Nama Customer</th>
                                                        <th class="text-center p-3 text-nowrap" style="width: 150px">Total SPK</th>
                                                        <th class="text-center p-3 text-nowrap" style="width: 150px">Note SPK</th>
                                                        <th class="text-center p-3 text-nowrap" style="width: 70px">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    include "koneksi.php";
                                                    $no = 1;
                                                    $filter = '';
                                                    if (isset($_GET['sort'])) {
                                                        if ($_GET['sort'] == "baru") {
                                                            $filter = "ORDER BY tgl_spk DESC";
                                                        } elseif ($_GET['sort'] == "lama") {
                                                            $filter = "ORDER BY tgl_spk ASC";
                                                        }
                                                    }
                                                    $sql = "SELECT 
                                                                sr.id_spk_reg, 
                                                                sr.no_spk, 
                                                                sr.tgl_spk, 
                                                                sr.no_po,
                                                                sr.total_spk,
                                                                sr.note, 
                                                                cs.nama_cs, 
                                                                cs.alamat
                                                            FROM spk_reg AS sr
                                                            JOIN tb_customer cs ON(sr.id_customer = cs.id_cs)
                                                            WHERE status_spk = 'Siap Kirim'  $filter";
                                                    $query = mysqli_query($connect, $sql);
                                                    while ($data = mysqli_fetch_array($query)) {
                                                    ?>
                                                    <tr>
                                                        <?php  
                                                            if ($data_role['role'] == "Super Admin" || $data_role['role'] == "Admin Penjualan") {
                                                                ?>
                                                                   <td class="text-center text-nowrap"><input type="checkbox"
                                                                name="spk_id[]" id="spk"
                                                                value="<?php echo $data['id_spk_reg'] ?>"
                                                                data-customer="<?php echo $data['nama_cs'] ?>"></td>
                                                                <?php
                                                            }
                                                        ?>
                                                        <td class="text-center text-nowrap"><?php echo $no; ?></td>
                                                        <td class="text-center text-nowrap"><?php echo $data['no_spk'] ?></td>
                                                        <td class="text-center text-nowrap"><?php echo $data['tgl_spk'] ?></td>
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
                                                        <td class="text-nowrap text-end"><?php echo number_format($data['total_spk'],0,'.','.') ?></td>
                                                        <td class="text-nowrap">
                                                            <?php
                                                                $note = $data['note'];

                                                                $items = explode("\n", trim($note));

                                                                if(!empty($note = $data['note'])){
                                                                    foreach ($items as $notes) {
                                                                        echo trim($notes) . '<br>';
                                                                    }
                                                                }else{
                                                                    echo 'Tidak Ada';
                                                                }
                                                            ?>
                                                        </td>
                                                        <?php  
                                                            if ($data_role['role'] == "Super Admin" || $data_role['role'] == "Admin Penjualan") {
                                                                ?>
                                                                   <td class="text-center text-nowrap">
                                                                        <a href="detail-produk-spk-reg-siap-kirim.php?id=<?php echo base64_encode($data['id_spk_reg']) ?>"
                                                                            class="btn btn-primary btn-sm mb-2" title="Lihat Produk">
                                                                            <i class="bi bi-eye-fill"></i>
                                                                        </a>
                                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#cancelModal" class="btn btn-danger btn-sm mb-2" title="Cancel Order" data-id="<?php echo $data['id_spk_reg']; ?>" data-nama="<?php echo $data['no_spk']; ?>" data-cs ="<?php echo $data['nama_cs'] ?>">
                                                                            <i class="bi bi-x-circle"></i>
                                                                        </a>
                                                                    </td>
                                                                <?php
                                                            } else {
                                                                ?>
                                                                    <td class="text-center text-nowrap">
                                                                        <a href="detail-produk-spk-reg-siap-kirim.php?id=<?php echo base64_encode($data['id_spk_reg']) ?>"
                                                                            class="btn btn-primary btn-sm mb-2" title="Lihat Produk">
                                                                            <i class="bi bi-eye-fill"></i>
                                                                        </a>
                                                                    </td>
                                                                <?php
                                                            }
                                                        ?>
                                                        <!-- Modal Cancel -->
                                                        <div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4><strong>Silahkan Isi Alasan</strong></h4>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form action="proses/proses-produk-spk-reg.php" method="POST">
                                                                        <p>Apakah Anda Yakin Ingin Cancel <br>No.SPK : <b id="no_spk"></b> (<b id="cs"></b>) ?</p>
                                                                        <div class="mb-3">
                                                                            <input type="hidden" name="id_spk" id="id_spk">
                                                                            <Label>Alasan Cancel</Label>
                                                                            <input type="text" class="form-control" name="alasan" required>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="submit" class="btn btn-primary" name="cancel-siap-kirim" id="cancel">Ya, Cancel Transaksi</button>
                                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </tr>
                                                    <?php $no++ ?>
                                                    <?php } ?>
                                                </tbody>    
                                            </table>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
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
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <?php include "page/script.php" ?>

</body>

</html>

<script>
    $('#cancelModal').on('show.bs.modal', function(event) {
        // Mendapatkan data dari tombol yang ditekan
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var nama = button.data('nama');
        var cs = button.data('cs');
        
        var modal = $(this);
        var simpanBtn = modal.find('.modal-footer #cancel');
        var namaInput = modal.find('.modal-body #no_spk');
        var csInput = modal.find('.modal-body #cs');

        // Menampilkan data
        modal.find('.modal-body #id_spk').val(id);
        namaInput.text(nama);
        csInput.text(cs);
    });
</script>

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
    const form = document.getElementById("invoiceForm");
    const checkboxes = document.querySelectorAll('input[type="checkbox"][id^="spk"]');
    const nonPpnButton = document.getElementById("nonPpnButton");
    const ppnButton = document.getElementById("ppnButton");
    const bumButton = document.getElementById("bumButton");

    form.addEventListener("submit", function(event) {
        event.preventDefault();

        // Jika SPK yang dipilih sesuai dengan pelanggan yang dipilih, lanjutkan proses invoice
        if (selectedSpk) {
            console.log("Data Pelanggan:");
            console.log("Nama Customer:", selectedCustomer);
            console.log("SPK yang Dipilih:");
            checkboxes.forEach(function(checkbox) {
                if (checkbox.checked && checkbox.getAttribute("data-customer") === selectedCustomer) {
                    console.log("ID SPK:", checkbox.value);
                }
            });
            // Lakukan tindakan selanjutnya, seperti mengirim data ke server atau melakukan tindakan lainnya
        }
    });

    function updateButtonState() {
        let selectedCustomer = null;
        let checkedCustomers = new Set(); // Menyimpan nama pelanggan yang dipilih

        checkboxes.forEach(function(checkbox) {
            if (checkbox.checked) {
                checkedCustomers.add(checkbox.getAttribute(
                    "data-customer")); // Tambahkan nama pelanggan yang dipilih ke dalam Set
            }
        });

        if (checkedCustomers.size <= 5) { // Cek apakah jumlah data yang dicentang tidak melebihi 5
            if (checkedCustomers.size === 1) {
                selectedCustomer = checkedCustomers.values().next().value; // Ambil nama pelanggan dari Set

                nonPpnButton.disabled = false;
                ppnButton.disabled = false;
                bumButton.disabled = false;
            } else {
                nonPpnButton.disabled = true;
                ppnButton.disabled = true;
                bumButton.disabled = true;
            }
        } else {
            // Jika jumlah data yang dicentang melebihi 5, nonaktifkan tombol dan tampilkan peringatan
            nonPpnButton.disabled = true;
            ppnButton.disabled = true;
            bumButton.disabled = true;
        }
    }

    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener("change", function(event) {
            updateButtonState();

            // Membatasi pemilihan data hingga maksimal 5
            let checkedCount = 0;
            checkboxes.forEach(function(checkbox) {
                if (checkbox.checked) {
                    checkedCount++;
                    if (checkedCount > 5) {
                        checkbox.checked = false;
                        Swal.fire({
                            title: '<strong>Batas Maksimum Pemilihan</strong>',
                            icon: 'info',
                            html: 'Anda hanya dapat memilih maksimal 5 data.',
                            confirmButtonText: 'OK'
                        })
                    }
                }
            });

            updateButtonState();
        });
    });




    function checkInitialCheckbox() {
        checkboxes.forEach(function(checkbox) {
            if (checkbox.getAttribute("data-customer") === "agung") {
                checkbox.checked = true;
            }
        });
        updateButtonState();
    }

    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener("change", updateButtonState);
    });

    checkInitialCheckbox();
</script>
<script>
function submitForm(action) {
    document.getElementById("invoiceForm").action = action;
    document.getElementById("invoiceForm").submit();
}
</script>