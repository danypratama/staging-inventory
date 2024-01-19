<?php
$page = 'br-keluar';
$page2 = 'br-keluar-reg';
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
                    <div class="card-body">
                        <h5 class="text-center mt-3">Data Barang Keluar Reguler</h5>
                        <a href="input-br-out-reg.php" class="btn btn-primary btn-md"><i class="bi bi-plus-circle"></i>
                            Tambah Data</a>
                        <a href="barang-masuk-reg.php" class="btn btn-md btn-secondary text-end"><i
                                class="bi bi-arrow-left"></i> Kembali</a>
                        <div class="table-responsive pt-3">
                            <table class="table table-striped table-bordered" id="table1">
                                <thead>
                                    <tr class="text-white" style="background-color: navy;">
                                        <td class="text-center p-3" style="width: 30px">No</td>
                                        <td class="text-center p-3" style="width: 230px">Nama Produk</td>
                                        <td class="text-center p-3" style="width: 80px">Merk</td>
                                        <td class="text-center p-3" style="width: 50px">Qty</td>
                                        <td class="text-center p-3" style="width: 150px">Keterangan</td>
                                        <td class="text-center p-3" style="width: 100px">Dibuat Oleh</td>
                                        <td class="text-center p-3" style="width: 100px">Dibuat Tanggal</td>
                                        <?php  
                                            if ($data_role['role'] == "Super Admin" || $data_role['role'] == "Manager Gudang" ) { 
                                                ?>
                                                     <td class="text-center p-3" style="width: 50px">Aksi</td>
                                                <?php
                                            }
                                        ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    include "koneksi.php";
                                    $sql = "SELECT ibor.*, ibor.created_date AS created, pr.*, mr.*, us.nama_user, ket_out.*
                                            FROM isi_br_out_reg AS ibor
                                            LEFT JOIN tb_produk_reguler pr ON(ibor.id_produk_reg = pr.id_produk_reg)
                                            LEFT JOIN tb_merk mr ON(mr.id_merk = pr.id_merk)
                                            LEFT JOIN user us ON(ibor.id_user = us.id_user)
                                            LEFT JOIN keterangan_out ket_out ON(ibor.id_ket_out = ket_out.id_ket_out)";
                                    $query = mysqli_query($connect, $sql);
                                    while ($data = mysqli_fetch_array($query)) {
                                    ?>
                                    <tr>
                                        <td class="text-center"><?php echo $no ?></td>
                                        <td><?php echo $data['nama_produk'] ?></td>
                                        <td class="text-center"><?php echo $data['nama_merk'] ?></td>
                                        <td class="text-end"><?php echo number_format($data['qty']) ?></td>
                                        <td><?php echo $data['ket_out'] ?></td>
                                        <td><?php echo $data['nama_user'] ?></td>
                                        <td class="text-center"><?php echo $data['created'] ?></td>
                                        <?php  
                                            if ($data_role['role'] == "Super Admin" || $data_role['role'] == "Manager Gudang" ) { 
                                                ?>
                                                    <td class="text-center">
                                                        <a href="edit-br-out-reg.php?id=<?php echo base64_encode($data['id_isi_br_out_reg']) ?>"
                                                            class="btn btn-warning btn-sm rounded"><i class="bi bi-pencil"
                                                                style="font-size: 14px;"></i></a>
                                                        <a href="proses/proses-br-out-reg.php?hapus=<?php echo base64_encode($data['id_isi_br_out_reg']) ?>"
                                                            class="btn btn-danger btn-sm rounded delete-data"><i class="bi bi-trash"
                                                                style="font-size: 14px;"></i></a>
                                                    </td>
                                                <?php
                                            }
                                        ?>
                                    </tr>
                                    <?php $no++ ?>
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
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <?php include "page/script.php" ?>
</body>

</html>