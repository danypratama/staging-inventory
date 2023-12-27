<?php
    $page = 'br-masuk';
    $page2 = 'br-masuk-tambahan';
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
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-center mt-3">Data Barang Masuk Tambahan</h5>
                        <a href="barang-masuk-reg.php" class="btn btn-md btn-secondary text-end"><i class="bi bi-arrow-left"></i> Kembali</a>
                        <a href="input-br-in-tambahan.php" class="btn btn-primary btn-md"><i class="bi bi-plus-circle"></i> Tambah Data</a>
                        <div class="table-responsive pt-3">
                            <table class="table table-striped table-bordered" id="table1">
                                <thead>
                                    <tr class="text-white" style="background-color: navy;">
                                        <td class="text-center p-3" style="width: 30px">No</td>
                                        <td class="text-center p-3" style="width: 200px">Nama Produk</td>
                                        <td class="text-center p-3" style="width: 80px">Merk</td>
                                        <td class="text-center p-3" style="width: 80px">Qty</td>
                                        <td class="text-center p-3" style="width: 150px">Keterangan</td>
                                        <td class="text-center p-3" style="width: 100px">Dibuat Oleh</td>
                                        <td class="text-center p-3" style="width: 100px">Dibuat Tanggal</td>
                                        <td class="text-center p-3" style="width: 50px">Aksi</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    include "koneksi.php";
                                    $sql = "SELECT  
                                                ibt.id_isi_br_tambahan,
                                                ibt.qty,
                                                ibt.created_date AS created, 
                                                COALESCE(pr.nama_produk, ecat.nama_produk) AS nama_produk,
                                                mr.nama_merk, 
                                                us.nama_user, 
                                                ket.ket_in
                                            FROM isi_br_tambahan AS ibt
                                            LEFT JOIN tb_produk_reguler pr ON(ibt.id_produk_reg = pr.id_produk_reg)
                                            LEFT JOIN tb_produk_ecat ecat ON(ibt.id_produk_reg = ecat.id_produk_ecat)
                                            LEFT JOIN tb_merk mr ON(mr.id_merk = pr.id_merk OR mr.id_merk = ecat.id_merk)
                                            LEFT JOIN user us ON(ibt.id_user = us.id_user)
                                            LEFT JOIN keterangan_in ket ON(ibt.id_ket_in = ket.id_ket_in)";
                                    $query = mysqli_query($connect, $sql);
                                    while ($data = mysqli_fetch_array($query)) {
                                    ?>
                                        <tr>
                                            <td class="text-center"><?php echo $no ?></td>
                                            <td><?php echo $data['nama_produk'] ?></td>
                                            <td class="text-center"><?php echo $data['nama_merk'] ?></td>
                                            <td class="text-end"><?php echo number_format($data['qty']) ?></td>
                                            <td><?php echo $data['ket_in'] ?></td>
                                            <td><?php echo $data['nama_user'] ?></td>
                                            <td><?php echo $data['created'] ?></td>
                                            <td class="text-center">
                                                <a href="edit-br-in-tambahan.php?id=<?php echo base64_encode($data['id_isi_br_tambahan']) ?>" class="btn btn-warning btn-sm rounded"><i class="bi bi-pencil" style="font-size: 14px;"></i></a>
                                                <a href="proses/proses-br-in-tambahan.php?hapus=<?php echo base64_encode($data['id_isi_br_tambahan']) ?>" class="btn btn-danger btn-sm rounded delete-data"><i class="bi bi-trash" style="font-size: 14px;"></i></a>
                                            </td>
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
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <?php include "page/script.php" ?>
</body>

</html>