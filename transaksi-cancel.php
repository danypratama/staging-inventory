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
            <h1>Dashboard</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                    <li class="breadcrumb-item active">SPK</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section>
            <div class="card">
                <div class="mt-3">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-7">
                                <nav>
                                    <ol class="breadcrumb" style="font-size: 15px;">
                                        <li class="breadcrumb-item active">SPK Reguler</li>
                                        <li class="breadcrumb-item"><a style="color: blue;" href="spk-ecat.php">SPK E-Cat</a></li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
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
                        <a class="nav-link" href="invoice-reguler.php?sort=baru">
                            Invoice Sudah Dicetak &nbsp;
                            <?php if ($hasil != 0) {
                                echo '<span class="badge text-bg-secondary">' . $hasil . '</span>';
                            }
                            ?>
                        </a>
                    </li>
                    <li class=" nav-item flex-fill" role="presentation">
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
                        <a class="nav-link" href="invoice-reguler-dikirim.php">
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
                        $month = date('m');
                        $sql_inv_selesai = "SELECT nonppn.no_inv, STR_TO_DATE(nonppn.tgl_inv, '%d/%m/%Y') AS tgl_inv, nonppn.status_transaksi
                                            FROM inv_nonppn AS nonppn
                                            WHERE status_transaksi = 'Transaksi Selesai' AND MONTH(STR_TO_DATE(nonppn.tgl_inv, '%d/%m/%Y')) = '$month' GROUP BY no_inv";
                        $query_inv_selesai = mysqli_query($connect, $sql_inv_selesai);
                        $total_inv_nonppn_selesai = mysqli_num_rows($query_inv_selesai);
                        ?>
                        <?php
                        $sql_inv_ppn_selesai = "SELECT ppn.no_inv, STR_TO_DATE(ppn.tgl_inv, '%d/%m/%Y') AS tgl_inv, ppn.status_transaksi
                                                FROM inv_ppn AS ppn
                                                WHERE status_transaksi = 'Transaksi Selesai' AND MONTH(STR_TO_DATE(ppn.tgl_inv, '%d/%m/%Y')) = '$month' GROUP BY no_inv";
                        $query_inv_ppn_selesai = mysqli_query($connect, $sql_inv_ppn_selesai);
                        $total_inv_ppn_selesai = mysqli_num_rows($query_inv_ppn_selesai);
                        ?>
                        <?php
                        $sql_inv_bum_selesai = "SELECT bum.no_inv, STR_TO_DATE(bum.tgl_inv, '%d/%m/%Y') AS tgl_inv, bum.status_transaksi
                                                FROM inv_bum AS bum
                                                WHERE status_transaksi = 'Transaksi Selesai' AND MONTH(STR_TO_DATE(bum.tgl_inv, '%d/%m/%Y')) = '$month' GROUP BY no_inv";
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
                        <a class="nav-link active" href="#">
                            Transaksi Cancel &nbsp;
                            <?php if ($total_query_cancel != 0) {
                                echo '<span class="badge text-bg-secondary">' . $total_query_cancel . '</span>';
                            }
                            ?>
                        </a>
                    </li>
                </ul>
                    <div class="card-body bg-body rounded mt-3">
                        <div class="card-body pt-3">
                            <div class="row mb-3">
                                <div class="col-2">
                                    <form action="" method="GET">
                                        <select name="sort" class="form-select" id="select" aria-label="Default select example" onchange='if(this.value != 0) { this.form.submit(); }'>
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
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="table2">
                                    <thead>
                                        <tr class="text-white" style="background-color: navy;">
                                            <th class="text-center p-3" style="width: 30px">No</th>
                                            <th class="text-center p-3" style="width: 150px">No. SPK</th>
                                            <th class="text-center p-3" style="width: 150px">Tgl. SPK</th>
                                            <th class="text-center p-3" style="width: 150px">No. PO</th>
                                            <th class="text-center p-3" style="width: 200px">Nama Customer</th>
                                            <th class="text-center p-3" style="width: 150px">Alasan</th>
                                            <th class="text-center p-3" style="width: 150px">Posisi Transaksi</th>
                                            <th class="text-center p-3" style="width: 80px">Aksi</th>
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
                                                    sr.menu_cancel,
                                                    sr.note,
                                                    cs.nama_cs, cs.alamat
                                                FROM spk_reg AS sr
                                                JOIN tb_customer cs ON(sr.id_customer = cs.id_cs)
                                                WHERE status_spk = 'Cancel Order'  $filter";
                                        $query = mysqli_query($connect, $sql);
                                        while ($data = mysqli_fetch_array($query)) {
                                        ?>
                                            <tr>
                                                <td class="text-center"><?php echo $no; ?></td>
                                                <td class="text-center text-nowrap"><?php echo $data['no_spk'] ?></td>
                                                <td class="text-center text-nowrap"><?php echo $data['tgl_spk'] ?></td>
                                                <td class="text-center text-nowrap"><?php echo $data['no_po'] ?></td>
                                                <td><?php echo $data['nama_cs'] ?></td>
                                                <td><?php echo $data['note'] ?></td>
                                                <td><?php echo $data['menu_cancel'] ?></td>
                                                <td class="text-center">
                                                    <a href="detail-transaksi-cancel.php?id=<?php echo base64_encode($data['id_spk_reg']) ?>" class="btn btn-primary btn-sm mb-2" title="Lihat Produk"><i class="bi bi-eye-fill"></i></a>
                                                </td>
                                            </tr>
                                            <?php $no++ ?>
                                        <?php } ?>
                                    </tbody>
                                </table>
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