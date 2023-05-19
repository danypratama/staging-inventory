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
        <div class="loader loader">
            <div class="loading">
                <img src="img/loading.gif" width="200px" height="auto">
            </div>
        </div>
        <!-- ENd Loading -->
        <section>
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body p-3">
                        <form action="" method="POST">
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <label>Nama Set</label>
                                        <input type="text" class="form-control" nama="id_set" id="idSet" required>
                                        <input type="text" class="form-control bg-light" name="nama_set" id="namaSet" data-bs-toggle="modal" data-bs-target="#modalSet" readonly>
                                    </div>
                                    <div class="col-5 mb-3">
                                        <label>Merk</label>
                                        <input type="text" class="form-control bg-light" id="merkSet" readonly>
                                    </div>
                                    <div class="col-1 mb-3">
                                        <label>Qty</label>
                                        <input type="text" class="form-control" name="qty" id="qty" required>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 text-end">
                                <a href="#" class="btn btn-primary btn-md btn-confirm" data-bs-toggle="modal" data-bs-target="#confirm"><i class="bi bi-save"></i> Confirm</a>
                                <a href="barang-masuk-set-reg.php" class="btn btn-secondary btn-md"><i class="bi bi-x"></i> Tutup</a>
                            </div>
                        </form>
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

    <!-- Modal Produk Set -->
    <div class="modal fade" id="modalSet" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Pilih Data</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table table-responsive">
                        <table class="table table-bordered table-striped" id="table2">
                            <thead>
                                <tr class="bg-primary text-white">
                                    <th class="text-center" style="width: 50px">No</th>
                                    <th class="text-center" style="width: 100px">Kode Barang</th>
                                    <th class="text-center" style="width: 300px">Nama Set</th>
                                    <th class="text-center" style="width: 80px">Merk</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                include "koneksi.php";
                                $sql = mysqli_query($connect, "SELECT tpsm.*, mr.* FROM tb_produk_set_marwa AS tpsm
                                                             LEFT JOIN tb_merk mr ON tpsm.id_merk = mr.id_merk");
                                while ($data = mysqli_fetch_array($sql)) {
                                ?>
                                    <tr data-id=<?php echo $data['id_set_marwa'] ?> data-nama=<?php echo $data['nama_set_marwa'] ?> data-merk=<?php echo $data['nama_merk'] ?>>
                                        <td class="text-center"><?php echo $no ?></td>
                                        <td><?php echo $data['kode_set_marwa'] ?></td>
                                        <td><?php echo $data['nama_set_marwa'] ?></td>
                                        <td class="text-center"><?php echo $data['nama_merk'] ?></td>
                                    </tr>
                                    <?php $no++ ?>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->

    <!-- Confirm Simpan Set -->
    <div class="modal fade" id="confirm" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Confirmation</h5>
                </div>
                <div class="modal-body">
                    <?php
                    $modalIdSet = "Contoh Nilai"; // Nilai yang ingin ditampilkan pada elemen <span>
                    ?>

                    <span id="modalIdSet"><?php echo $modalIdSet; ?></span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->

    <!-- Select Data -->
    <script>
        // Fngsi Untuk membuat form input Qty menjadi enabled
        // select Produk Reguler
        $(document).on('click', '#table2 tbody tr', function(e) {
            $('#idSet').val($(this).data('id'));
            $('#namaSet').val($(this).data('nama'));
            $('#merkSet').val($(this).data('merk'));
            $('#modalSet').modal('hide');
        });
    </script>

    <script>
        // $(document).ready(function() {
        //     $('.btn-confirm').click(function() {
        //         var idNew = $(this).data('id-new');

        //         console.log(idNew);

        //         $('#idNew').html(idNew);
        //         $('#confirm').modal('show');
        //     });
        // });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var confirmButton = document.querySelector('.btn-confirm');
            var idSetInput = document.getElementById('idSet');
            var modalIdSet = document.getElementById('modalIdSet');

            confirmButton.addEventListener('click', function() {
                var idSetValue = idSetInput.value;
                modalIdSet.textContent = idSetValue;
            });
        });
    </script>
</body>

</html>