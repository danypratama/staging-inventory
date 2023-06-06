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
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body mt-3">
                        <a href="form-create-spk-reg.php" class="btn btn-primary btn-sm p-2"><i class="bi bi-plus-circle"></i> Buat SPK Reguler</a>
                        <a href="form-create-spk-ecat.php" class="btn btn-success btn-sm p-2"><i class="bi bi-plus-circle"></i> Buat SPK E-cat</a>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body mt-3">
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
                        <ul class="nav nav-tabs d-flex" role="tablist" id="myTab" role="tablist">
                            <li class="nav-item flex-fill" role="presentation">
                                <a class="nav-link" href="spk-reg.php">Belum Diproses</a>
                            </li>
                            <li class="nav-item flex-fill" role="presentation">
                                <a class="nav-link" href="spk-dalam-proses.php">Dalam Proses</a>
                            </li>
                            <li class="nav-item flex-fill" role="presentation">
                                <a class="nav-link" href="spk-siap-kirim.php?sort=baru">Siap Kirim</a>
                            </li>
                            <li class="nav-item flex-fill" role="presentation">
                                <button class="nav-link" id="dicetak-tab" data-bs-toggle="tab" data-bs-target="#dicetak-tab-pane" type="button" role="tab" aria-controls="dicetak-tab-pane" aria-selected="false">Invoice Sudah Dicetak</button>
                            </li>
                            <li class="nav-item flex-fill" role="presentation">
                                <button class="nav-link" id="dikirim-tab" data-bs-toggle="tab" data-bs-target="#dikirim-tab-pane" type="button" role="tab" aria-controls="dikirim-tab-pane" aria-selected="false">Dikirim</button>
                            </li>
                            <li class="nav-item flex-fill" role="presentation">
                                <button class="nav-link" id="diterima-tab" data-bs-toggle="tab" data-bs-target="#diterima-tab-pane" type="button" role="tab" aria-controls="diterima-tab-pane" aria-selected="false">Diterima</button>
                            </li>
                            <li class="nav-item flex-fill" role="presentation">
                                <button class="nav-link" id="transaksi-selesai-tab" data-bs-toggle="tab" data-bs-target="#transaksi-selesai-tab-pane" type="button" role="tab" aria-controls="transaksi-selesai-tab-pane" aria-selected="false">Transaksi Selesai</button>
                            </li>
                            <li class="nav-item flex-fill" role="presentation">
                                <a class="nav-link active" href="transaksi-cancel.php">Transaksi Cancel</a>
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
                                                <th class="text-center p-3" style="width: 150px">Aksi</th>
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
                                            $sql = "SELECT sr.*, cs.nama_cs, cs.alamat
                                                            FROM spk_reg AS sr
                                                            JOIN tb_customer cs ON(sr.id_customer = cs.id_cs)
                                                            WHERE status_spk = 'Cancel Order'  $filter";
                                            $query = mysqli_query($connect, $sql);
                                            while ($data = mysqli_fetch_array($query)) {
                                            ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $no; ?></td>
                                                    <td><?php echo $data['no_spk'] ?></td>
                                                    <td><?php echo $data['tgl_spk'] ?></td>
                                                    <td><?php echo $data['no_po'] ?></td>
                                                    <td><?php echo $data['nama_cs'] ?></td>
                                                    <td><?php echo $data['note'] ?></td>
                                                    <td class="text-center">
                                                        <a href="detail-produk-spk-reg-dalam-proses.php?id=<?php echo base64_encode($data['id_spk_reg']) ?>" class="btn btn-primary btn-sm mb-2"><i class="bi bi-eye-fill"></i> Lihat Produk</a>
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