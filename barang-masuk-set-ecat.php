<?php
$page = 'br-masuk';
$page2 = 'br-masuk-set-ecat';
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
            <h1>Data Update Stock Set E-Cat</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                    <li class="breadcrumb-item active">Data update stock set E-Cat</li>
                </ol>
            </nav>
        </div>
        <!-- End Page Title -->
        <section>
            <!-- SWEET ALERT -->
            <div class="info-data" data-infodata="<?php if (isset($_SESSION['info'])) { echo $_SESSION['info']; } unset($_SESSION['info']); ?>"></div>
            <!-- END SWEET ALERT -->
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body p-3">
                        <a href="input-set-in-ecat.php" class="btn btn-primary btn-md"><i class="bi bi-plus-circle"></i> Tambah data</a>
                        <div class="table-responsive mt-3">
                            <table class="table table-striped table-bordered" id="table1">
                                <thead>
                                    <tr class="text-white" style="background-color: #051683;">
                                        <td class="text-center p-3" style="width: 50px">No</td>
                                        <td class="text-center p-3" style="width: 120px">Kode Produk Set</td>
                                        <td class="text-center p-3" style="width: 250px">Nama Set Produk </td>
                                        <td class="text-center p-3" style="width: 100px">Merk</td>
                                        <td class="text-center p-3" style="width: 80px">Qty</td>
                                        <td class="text-center p-3" style="width: 100px">Aksi</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    include "koneksi.php";
                                    $no = 1;
                                    $sql = "SELECT tsm.*, tpsm.nama_set_ecat, tpsm.kode_set_ecat, tpsm.id_merk, mr.nama_merk
                                            FROM tr_set_ecat AS tsm
                                            LEFT JOIN tb_produk_set_ecat tpsm ON(tsm.id_set_ecat = tpsm.id_set_ecat)
                                            LEFT JOIN tb_merk mr ON(tpsm.id_merk = mr.id_merk)
                                            ORDER BY tsm.created_date";
                                    $query = mysqli_query($connect, $sql);
                                    while ($data = mysqli_fetch_array($query)) {
                                    ?>
                                        <tr>
                                            <td class="text-center"><?php echo $no; ?></td>
                                            <td><?php echo $data['kode_set_ecat'] ?></td>
                                            <td><?php echo $data['nama_set_ecat'] ?></td>
                                            <td class="text-center"><?php echo $data['nama_merk'] ?></td>
                                            <td class="text-end"><?php echo $data['qty'] ?></td>
                                            <td class="text-center">
                                                <!-- Hapus Data -->
                                                <a href="proses/proses-update-stock-set-ecat.php?hapus=<?php echo base64_encode($data['id_tr_set_ecat']); ?>" class="btn btn-danger btn-sm delete-data"><i class="bi bi-trash"></i></a>
                                            </td>
                                        </tr>
                                        <?php $no++; ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
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