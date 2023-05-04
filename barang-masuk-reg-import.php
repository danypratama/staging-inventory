<?php
$page = 'br-masuk';
$page2 = 'br-masuk-reg';
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
        <!-- <div class="loader loader">
      <div class="loading">
        <img src="img/loading.gif" width="200px" height="auto">
      </div>
    </div> -->
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
                        <h5 class="text-center mt-3">Data Barang Masuk Import</h5>
                        <a href="input-inv-br-in-import.php" class="btn btn-primary btn-md"><i class="bi bi-plus-circle"></i> Tambah Data</a>
                        <div class="table-responsive pt-3">
                            <table class="table table-striped table-bordered" id="table1">
                                <thead>
                                    <tr class="text-white" style="background-color: navy;">
                                        <td class="text-center p-3" style="width: 30px">No</td>
                                        <td class="text-center p-3" style="width: 100px">No. Invoice</td>
                                        <td class="text-center p-3" style="width: 200px">Supplier</td>
                                        <td class="text-center p-3" style="width: 100px">Shipping by</td>
                                        <td class="text-center p-3" style="width: 100px">Est. Tiba</td>
                                        <td class="text-center p-3" style="width: 50px">Aksi</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    include "koneksi.php";
                                    $sql = "SELECT ibi.*, ibi.created_date AS created, sp.*, uc.nama_user as user_created
                                            FROM inv_br_import AS ibi
                                            LEFT JOIN user uc ON (ibi.id_user = uc.id_user)
                                            LEFT JOIN tb_supplier sp ON (ibi.id_supplier = sp.id_sp)
                                            ORDER BY created";
                                    $query = mysqli_query($connect, $sql);
                                    while ($data = mysqli_fetch_array($query)) {
                                    ?>
                                        <tr>
                                            <td class="text-center"><?php echo $no ?></td>
                                            <td><?php echo $data['no_inv']; ?></td>
                                            <td><?php echo $data['nama_sp']; ?></td>
                                            <td class="text-center"><?php echo $data['shipping_by']; ?></td>
                                            <td><?php echo $data['tgl_est']; ?></td>
                                            <td class="text-center">
                                                <a href="#" class="btn btn-info btn-sm rounded btn-detail" data-no-inv="<?php echo $data['no_inv'] ?>" data-tgl-inv="<?php echo $data['tgl_inv']; ?>" data-no-order="<?php echo $data['no_order']; ?>" data-tgl-order="<?php echo $data['tgl_order'] ?>" data-ship="<?php echo $data['shipping_by'] ?>" data-awb="<?php echo $data['no_awb'] ?>" data-tgl-kirim="<?php echo $data['tgl_kirim'] ?>" data-tgl-est="<?php echo $data['tgl_est'] ?>" data-tgl-create="<?php echo $data['created'] ?>">
                                                    <i class="bi bi-info" style="font-size: 14px;"></i>
                                                </a>
                                                <a href="tampil-br-import.php?id=<?php echo $data['id_inv_br_import'] ?>" class="btn btn-primary btn-sm rounded"><i class="bi bi-eye" style="font-size: 14px;"></i></a>
                                                <a href="" class="btn btn-warning btn-sm rounded"><i class="bi bi-pencil" style="font-size: 14px;"></i></a>
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
    <!-- Modal Detail -->
    <div class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="card">
                        <div class="card-header text-center">
                            <h4><strong>Detail Produk Import</strong></h4>
                        </div>
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-12">
                                    <table class="table table-bordered table-striped">
                                        <tr>
                                            <td class="col-3">No. Invoice </td>
                                            <td id="noInv"></td>
                                        </tr>
                                        <tr>
                                            <td class="col-3">Tgl. Invoice</td>
                                            <td id="tglInv"></td>
                                        </tr>
                                        <tr>
                                            <td class="col-3">No. Order</td>
                                            <td id="noOrder"></td>
                                        </tr>
                                        <tr>
                                            <td class="col-3">Tgl. Order</td>
                                            <td id="tglOrder"></td>
                                        </tr>
                                        <tr>
                                            <td class="col-3">Shipping By</td>
                                            <td id="ship"></td>
                                        </tr>
                                        <tr>
                                            <td class="col-3">No. Awb</td>
                                            <td id="awb"></td>
                                        </tr>
                                        <tr>
                                            <td class="col-3">Tgl. Kirim</td>
                                            <td id="tglKirim"></td>
                                        </tr>
                                        <tr>
                                            <td class="col-3">Tgl. Estimasi</td>
                                            <td id="tglEst"></td>
                                        </tr>
                                        <tr>
                                            <td class="col-3">Dibuat Tanggal</td>
                                            <td id="tglCreate"></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include "page/footer.php" ?>
    <!-- End Footer -->
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <?php include "page/script.php" ?>
</body>

</html>

<script>
    $(document).ready(function() {
        $('.btn-detail').click(function() {
            var noInv = $(this).data('no-inv');
            var tglInv = $(this).data('tgl-inv');
            var noOrder = $(this).data('no-order');
            var tglOrder = $(this).data('tgl-order');
            var ship = $(this).data('ship');
            var awb = $(this).data('awb');
            var tglKirim = $(this).data('tgl-kirim');
            var tglEst = $(this).data('tgl-est');
            var tglCreate = $(this).data('tgl-create');

            console.log(noInv);
            console.log(awb);


            $('#noInv').html(noInv);
            $('#tglInv').html(tglInv);
            $('#noOrder').html(noOrder);
            $('#tglOrder').html(tglOrder);
            $('#ship').html(ship);
            $('#awb').html(awb);
            $('#tglKirim').html(tglKirim);
            $('#tglEst').html(tglEst);
            $('#tglCreate').html(tglCreate);
            $('#modalDetail').modal('show');
        });
    });
</script>