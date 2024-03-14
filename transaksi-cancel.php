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
            <h1>Data SPK</h1>
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
                                                no_spk,
                                                no_inv
                                            FROM (
                                                SELECT 
                                                    sr.no_spk,
                                                    '' AS no_inv  
                                                FROM spk_reg AS sr
                                                JOIN tb_customer cs ON(sr.id_customer = cs.id_cs)
                                                WHERE sr.status_spk = 'Cancel Order' AND sr.id_inv = ''
                                                UNION
                                                SELECT 
                                                    GROUP_CONCAT(CONCAT(sr.no_spk, ', ') SEPARATOR '') AS no_spk,
                                                    COALESCE(nonppn.no_inv, ppn.no_inv, bum.no_inv) AS no_inv
                                                FROM spk_reg AS sr
                                                LEFT JOIN tb_customer cs ON sr.id_customer = cs.id_cs
                                                LEFT JOIN inv_nonppn nonppn ON sr.id_inv = nonppn.id_inv_nonppn
                                                LEFT JOIN inv_ppn ppn ON sr.id_inv = ppn.id_inv_ppn
                                                LEFT JOIN inv_bum bum ON sr.id_inv = bum.id_inv_bum
                                                WHERE sr.status_spk = 'Cancel Order' AND sr.id_inv != ''
                                                GROUP BY COALESCE(nonppn.no_inv, ppn.no_inv, bum.no_inv)
                                            ) AS subquery";
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
                                            <th class="text-center p-3" style="width: 100px">No. SPK</th>
                                            <th class="text-center p-3" style="width: 150px">Tgl. SPK</th>
                                            <th class="text-center p-3" style="width: 250px">Nama Customer</th>
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
                                                $filter = "ORDER BY no_spk DESC";
                                            } elseif ($_GET['sort'] == "lama") {
                                                $filter = "ORDER BY no_spk ASC";
                                            }
                                        }
                                        $sql = "SELECT 
                                                    id_spk_reg,
                                                    no_spk,
                                                    tgl_spk,
                                                    no_po,
                                                    menu_cancel,
                                                    user_cancel,
                                                    note,
                                                    nama_cs, 
                                                    alamat,
                                                    no_inv
                                                FROM (
                                                    SELECT 
                                                        sr.id_spk_reg,
                                                        sr.no_spk,
                                                        sr.tgl_spk,   
                                                        sr.no_po,
                                                        sr.menu_cancel,
                                                        sr.user_cancel,
                                                        sr.note,
                                                        cs.nama_cs, 
                                                        cs.alamat,
                                                        '' AS no_inv  
                                                    FROM spk_reg AS sr
                                                    JOIN tb_customer cs ON(sr.id_customer = cs.id_cs)
                                                    WHERE sr.status_spk = 'Cancel Order' AND sr.id_inv = ''
                                                    UNION
                                                    SELECT 
                                                        MAX(sr.id_spk_reg) AS id_spk_reg,
                                                        GROUP_CONCAT(CONCAT(sr.no_spk, ', ') SEPARATOR '') AS no_spk,
                                                        MAX(sr.tgl_spk) AS tgl_spk,
                                                        MAX(sr.no_po) AS no_po,
                                                        MAX(sr.menu_cancel) AS menu_cancel,
                                                        MAX(sr.user_cancel) AS user_cancel,
                                                        MAX(sr.note) AS note,
                                                        MAX(cs.nama_cs) AS nama_cs, 
                                                        MAX(cs.alamat) AS alamat,
                                                        COALESCE(nonppn.no_inv, ppn.no_inv, bum.no_inv) AS no_inv
                                                    FROM spk_reg AS sr
                                                    LEFT JOIN tb_customer cs ON sr.id_customer = cs.id_cs
                                                    LEFT JOIN inv_nonppn nonppn ON sr.id_inv = nonppn.id_inv_nonppn
                                                    LEFT JOIN inv_ppn ppn ON sr.id_inv = ppn.id_inv_ppn
                                                    LEFT JOIN inv_bum bum ON sr.id_inv = bum.id_inv_bum
                                                    WHERE sr.status_spk = 'Cancel Order' AND sr.id_inv != ''
                                                    GROUP BY COALESCE(nonppn.no_inv, ppn.no_inv, bum.no_inv)
                                                ) AS subquery
                                                $filter";
                                        $query = mysqli_query($connect, $sql);
                                        while ($data = mysqli_fetch_array($query)) {
                                            // Hilangkan tanda koma di bagian akhir data
                                            $no_spk_result = $data['no_spk'];
                                            // Menghilangkan tanda koma di akhir
                                            $no_spk_formatted = trim($no_spk_result, ', ');

                                            // Pisahkan data berdasarkan koma
                                            $no_spk_array = explode(', ', $no_spk_formatted);

                                            // Tentukan jumlah data yang diinginkan untuk perbarisannya
                                            $jumlah_data_per_baris = 2;

                                            // Inisialisasi variabel untuk menyimpan hasil
                                            $no_spk_final = '';

                                            // Loop melalui array data
                                            for ($i = 0; $i < count($no_spk_array); $i++) {
                                                // Tambahkan data ke hasil dengan tanda koma
                                                $no_spk_final .= $no_spk_array[$i];

                                                // Tambahkan <br> jika jumlah data mencapai batas tertentu dan bukan data terakhir
                                                if (($i + 1) % $jumlah_data_per_baris == 0 && $i < count($no_spk_array) - 1) {
                                                    $no_spk_final .= "<br>";
                                                } else {
                                                    // Tambahkan koma dan spasi setelah data, kecuali untuk data terakhir
                                                    $no_spk_final .= ($i < count($no_spk_array) - 1) ? ', ' : '';
                                                }
                                            }
                                        ?>
                                            <tr>
                                                <td class="text-center"><?php echo $no; ?></td>
                                                <td class="text-center text-nowrap">
                                                    <?php echo $no_spk_final ?><br>
                                                    <?php
                                                        if($data['no_inv'] != ''){
                                                            echo '<b>(' .$data['no_inv'] .')</b>';
                                                        }
                                                    ?>
                                                </td>
                                                <td class="text-center text-nowrap"><?php echo $data['tgl_spk'] ?></td>
                                                <td><?php echo $data['nama_cs'] ?></td>
                                                <td><?php echo $data['note'] ?></td>
                                                <td>
                                                    <?php echo $data['menu_cancel'] ?><br>
                                                    (<?php echo $data['user_cancel'] ?>)
                                                </td>
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