<?php
$page = 'br-masuk';
$page2 = 'br-masuk-set-reg';
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
            <h1>Data Update Stock Set Reguler</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                    <li class="breadcrumb-item active">Data update stock set reguler</li>
                </ol>
            </nav>
        </div>
        <!-- End Page Title -->
        <section>
            <!-- SWEET ALERT -->
            <div class="info-data" data-infodata="<?php if (isset($_SESSION['info'])) {
                                                        echo $_SESSION['info'];
                                                    }
                                                    unset($_SESSION['info']); ?>"></div>
            <!-- END SWEET ALERT -->
            <div class="container-fluid">
                <?php  
                    include "koneksi.php";
                    $id_role = $_SESSION['tiket_role'];
                    $sql_role = "SELECT * FROM user_role WHERE id_user_role='$id_role'";
                    $query_role = mysqli_query($connect, $sql) or die(mysqli_error($connect));
                    $data_role = mysqli_fetch_array($query_role);
                ?>
                <div class="card">
                    <div class="card-body p-3">
                        <?php  
                            if ($data_role['role'] == "Super Admin" || $data_role['role'] == "Manager Gudang" || $data_role['role'] == "Admin Gudang") { 
                                ?>
                                    <a href="input-set-in-reg.php" class="btn btn-primary btn-md"><i class="bi bi-plus-circle"></i> Tambah data</a>
                                <?php
                            }
                        ?>
                        <div class="table-responsive mt-3">
                            <table class="table table-striped table-bordered" id="table1">
                                <thead>
                                    <tr class="text-white" style="background-color: #051683;">
                                        <td class="text-center p-3" style="width: 50px">No</td>
                                        <td class="text-center p-3" style="width: 120px">Kode Produk Set</td>
                                        <td class="text-center p-3" style="width: 250px">Nama Set Produk </td>
                                        <td class="text-center p-3" style="width: 100px">Merk</td>
                                        <td class="text-center p-3" style="width: 80px">Qty</td>
                                        <td class="text-center p-3" style="width: 120px">Dibuat Oleh</td>
                                        <?php  
                                            if ($data_role['role'] == "Super Admin" || $data_role['role'] == "Manager Gudang" || $data_role['role'] == "Admin Gudang") { 
                                                ?>
                                                    <td class="text-center p-3" style="width: 100px">Aksi</td>
                                                <?php
                                            }
                                        ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    include "koneksi.php";
                                    $no = 1;
                                    $sql = "SELECT 
                                                tsm.*, tpsm.nama_set_marwa, tpsm.kode_set_marwa, tpsm.id_merk, mr.nama_merk, us.nama_user 
                                            FROM tr_set_marwa AS tsm 
                                            LEFT JOIN tb_produk_set_marwa tpsm ON(tsm.id_set_marwa = tpsm.id_set_marwa)
                                            LEFT JOIN tb_merk mr ON(tpsm.id_merk = mr.id_merk) 
                                            LEFT JOIN user us ON (tsm.id_user = us.id_user) 
                                            ORDER BY tsm.created_date;";
                                    $query = mysqli_query($connect, $sql);
                                    while ($data = mysqli_fetch_array($query)) {
                                    ?>
                                        <tr>
                                            <td class="text-center"><?php echo $no; ?></td>
                                            <td><?php echo $data['kode_set_marwa'] ?></td>
                                            <td><?php echo $data['nama_set_marwa'] ?></td>
                                            <td class="text-center"><?php echo $data['nama_merk'] ?></td>
                                            <td class="text-end"><?php echo $data['qty'] ?></td>
                                            <td class="text-end"><?php echo $data['nama_user'] ?></td>
                                            <?php  
                                                if ($data_role['role'] == "Super Admin" || $data_role['role'] == "Manager Gudang" || $data_role['role'] == "Admin Gudang") { 
                                                    ?>
                                                        <td class="text-center">
                                                            <!-- Hapus Data -->
                                                            <a href="proses/proses-update-stock-set-marwa.php?hapus=<?php echo base64_encode($data['id_tr_set_marwa']); ?>" class="btn btn-danger btn-sm delete-data"><i class="bi bi-trash"></i></a>
                                                        </td>
                                                    <?php
                                                }
                                            ?>
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