<?php
$page = 'br-masuk';
$page2 = 'br-masuk-import';
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
                        <h5 class="text-center mt-3">Data Barang Masuk Import</h5>
                        <a href="barang-masuk-reg.php" class="btn btn-md btn-secondary text-end"><i class="bi bi-arrow-left"></i> Kembali</a>
                        <?php  
                            if ($data_role['role'] == "Super Admin" || $data_role['role'] == "Manager Gudang" ) { 
                                ?>
                                    <a href="input-inv-br-in-import.php" class="btn btn-primary btn-md"><i class="bi bi-plus-circle"></i> Tambah Data</a>
                                <?php
                            }
                        ?>
                        <div class="table-responsive pt-3">
                            <table class="table table-striped table-bordered" id="table1">
                                <thead>
                                    <tr class="text-white" style="background-color: navy;">
                                        <td class="text-center p-3" style="width: 30px">No</td>
                                        <td class="text-center p-3" style="width: 100px">No. Invoice</td>
                                        <td class="text-center p-3" style="width: 150px">Supplier</td>
                                        <td class="text-center p-3" style="width: 100px">Shipping by</td>
                                        <td class="text-center p-3" style="width: 100px">Est. Tiba</td>
                                        <td class="text-center p-3" style="width: 150px">Status</td>
                                        <td class="text-center p-3" style="width: 150px">Keterangan</td>
                                        <td class="text-center p-3" style="width: 50px">Aksi</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    include "koneksi.php";
                                    $sql = "SELECT ibi.*, ibi.created_date AS created, sp.nama_sp, uc.nama_user as user_created
                                            FROM inv_br_import AS ibi
                                            LEFT JOIN user uc ON (ibi.id_user = uc.id_user)
                                            LEFT JOIN tb_supplier sp ON (ibi.id_supplier = sp.id_sp)
                                            ORDER BY created";
                                    $query = mysqli_query($connect, $sql);
                                    while ($data = mysqli_fetch_array($query)) {
                                        $tanggal_est_str = $data['tgl_est'];
                                        $tanggal_terima_str = $data['tgl_terima'];
                                    ?>
                                        <tr>
                                            <td class="text-center"><?php echo $no ?></td>
                                            <td><?php echo $data['no_inv']; ?></td>
                                            <td><?php echo $data['nama_sp']; ?></td>
                                            <td class="text-center"><?php echo ($data['shipping_by']); ?></td>
                                            <td class="text-center"><?php echo $data['tgl_est']; ?></td>
                                            <td class="text-center">
                                                <?php  
                                                    if($data['status_pengiriman'] != ''){
                                                        echo $data['status_pengiriman'];
                                                        echo '<br>';
                                                        echo ($data['tgl_terima']);
                                                    }
                                                ?>
                                            </td>
                                            <td><?php echo $data['keterangan']; ?></td>
                                            <td class ="text-center text-nowrap">
                                                <?php  
                                                    if ($data_role['role'] == "Super Admin" || $data_role['role'] == "Manager Gudang" ) { 
                                                        ?>
                                                            <button type="button" class="btn btn-warning btn-sm status" data-bs-toggle="modal" data-bs-target="#modalStatus" data-id="<?php echo $data['id_inv_br_import']; ?>" data-estimasi="<?php echo $data['tgl_est']; ?>" data-status="<?php echo $data['status_pengiriman']; ?>" title="Ubah Status">
                                                                <i class="bi bi-repeat"></i>
                                                            </button>
                                                        <?php
                                                    }
                                                ?>
                                                <button type="button" class="btn btn-info btn-detail btn-sm" data-no-inv="<?php echo $data['no_inv'] ?>" data-tgl-inv="<?php echo $data['tgl_inv']; ?>" data-no-order="<?php echo $data['no_order']; ?>" data-tgl-order="<?php echo $data['tgl_order'] ?>" data-ship="<?php echo $data['shipping_by'] ?>" data-awb="<?php echo $data['no_awb'] ?>" data-tgl-kirim="<?php echo $data['tgl_kirim'] ?>" data-tgl-est="<?php echo $data['tgl_est'] ?>" data-status="<?php echo $data['status_pengiriman']; ?>" data-tgl-terima="<?php echo $data['tgl_terima']; ?>" data-tgl-create="<?php echo $data['created'] ?>" data-user-create="<?php echo $data['user_created'] ?>" data-keterangan="<?php echo $data['keterangan']; ?>" title="Detail">
                                                    <i class="bi bi-info"></i>
                                                </button>
                                                <a class="btn btn-secondary btn-sm" href="tampil-br-import.php?id=<?php echo base64_encode($data['id_inv_br_import']) ?>" title="Lihat Isi">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <?php  
                                                    if ($data_role['role'] == "Super Admin" || $data_role['role'] == "Manager Gudang" ) { 
                                                        ?>
                                                           <p></p>
                                                            <a class="btn btn-primary btn-sm" href="edit-inv-br-in-import.php?id=<?php echo base64_encode($data['id_inv_br_import']) ?>" title="Edit Data">
                                                                <i class="bi bi-pencil"></i>
                                                            </a>
                                                            <a class="btn btn-danger btn-sm delete-data" href="proses/proses-br-in-import.php?id=<?php echo base64_encode($data['id_inv_br_import']) ?>" title="Hapus Data">
                                                                <i class="bi bi-trash"></i>
                                                            </a>
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

    <!-- Modal Status -->
    <div class="modal fade" id="modalStatus" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Update Status</h1>
                </div>
                <form action="proses/proses-br-in-import.php" method="post">
                    <div class="modal-body">
                        <input type="hidden" id="id" name="id_inv_br_import">
                        <input type="hidden" id="estimasiTgl" name="tgl_est">
                        <div class="mb-3">
                            <label>Status Pengiriman Saat Ini</label>
                            <input type="text" class="form-control" id="statusPengiriman" readonly>
                        </div>
                        <div class="mb-3">
                            <label>Ubah Status Pengiriman</label>
                            <select class="form-select" name="status" id="status">
                                <option value="">Pilih...</option>
                                <option value="Sudah Diterima">Sudah Diterima</option>
                                <option value="Masih Dalam Perjalanan">Masih Dalam Perjalanan</option>
                                <option value="Belum Dikirim">Belum Dikirim</option>
                                <option value="Kendala Di Pelabuhan">Kendala Di Pelabuhan</option>
                            </select>
                        </div>
                        <input type="hidden" id="tgl_terima_hidden" name="tgl_terima">
                        <div class="mb-3" style="display: none;" id="tanggal">
                            <label>Diterima tanggal</label>
                            <input type="text" class="form-control" id="tgl_terima" name="tgl_terima" autocomplete="off">
                        </div>
                        <div class="mb-3" style="display: none;" id="divKeterangan">
                            <label>Keterangan</label>
                            <input type="text" class="form-control" id="ket" name="keterangan">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" name="update-status" id="simpan" disabled>Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="tutupButton">Tutup</button>
                    </div>
                </form>
            </div>
        </div>
        <script>
            // Mengambil elemen dengan ID "status"
            var statusElement = document.getElementById("status");

            // Mengambil elemen tombol "Simpan"
            var simpanButton = document.getElementById("simpan");

            // Menambahkan event listener untuk memeriksa perubahan pada elemen "status"
            statusElement.addEventListener("change", function() {
                // Memeriksa apakah elemen "status" memiliki nilai yang tidak kosong
                if (statusElement.value !== "") {
                    // Mengaktifkan tombol "Simpan"
                    simpanButton.disabled = false;
                } else {
                    // Menonaktifkan tombol "Simpan"
                    simpanButton.disabled = true;
                }
            });
        </script>
    </div>

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
                                            <td class="col-3">Status Pengiriman</td>
                                            <td id="statusKirim"></td>
                                        </tr>
                                        <tr>
                                            <td class="col-3">Tanggal Terima</td>
                                            <td id="tglTerima"></td>
                                        </tr>
                                        <tr>
                                            <td class="col-3">Keterangan</td>
                                            <td id="ketVal"></td>
                                        </tr>
                                        <tr>
                                            <td class="col-3">Dibuat Oleh</td>
                                            <td id="userCreate"></td>
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
<!-- Modal Detail -->
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
            var statusKirim = $(this).data('status');
            var tglTerima = $(this).data('tgl-terima');
            var ketVal = $(this).data('keterangan')
            var tglCreate = $(this).data('tgl-create');
            var userCreate = $(this).data('user-create');

            $('#noInv').html(noInv);
            $('#tglInv').html(tglInv);
            $('#noOrder').html(noOrder);
            $('#tglOrder').html(tglOrder);
            $('#ship').html(ship);
            $('#awb').html(awb);
            $('#tglKirim').html(tglKirim);
            $('#tglEst').html(tglEst);
            $('#statusKirim').html(statusKirim);
            $('#tglTerima').html(tglTerima);
            $('#ketVal').html(ketVal);
            $('#tglCreate').html(tglCreate);
            $('#userCreate').html(userCreate);
            $('#modalDetail').modal('show');
        });
    });
</script>

<!-- Enable input tanggal ketika barang sudah diterima -->
<script>
    const dropdownItems = document.querySelectorAll('.status');

    dropdownItems.forEach(function(item) {
        item.addEventListener('click', function() {
            // Mengambil data dengan atribut
            const id = item.getAttribute('data-id');
            const estimasiTgl = item.getAttribute('data-estimasi');
            const statusPengiriman = item.getAttribute('data-status');

            // Menyimpan Data Untuk ditampilkan
            const idInv = document.getElementById('id');
            const estTgl = document.getElementById('estimasiTgl');
            const pengirimanStatusOption = document.getElementById('statusPengiriman');

            // Menampilkan Data Pada Form Input
            idInv.setAttribute('value', id);
            estTgl.setAttribute('value', estimasiTgl);
            pengirimanStatusOption.setAttribute('value', statusPengiriman);
            // pengirimanStatusOption.innerText = statusPengiriman;
        });
    });


    // Inisialisasi Flatpickr
    flatpickr("#tgl_terima", {
        dateFormat: "d/m/Y",
        allowInput: true,
    });


    $(document).ready(function() {
        const status = document.getElementById('status');
        const tutupButton = document.getElementById('tutupButton');

        status.addEventListener('change', function() {
            const pilih = "";
            const cekStatus = "Sudah Diterima";
            const cekStatusKet = "Kendala Di Pelabuhan";
            const divTanggal = document.getElementById('tanggal');
            const tanggalInput = document.getElementById('tgl_terima');
            const divKeterangan = document.getElementById('divKeterangan');
            const ketInput = document.getElementById('ket');
            const selectedStatus = status.options[status.selectedIndex].value;

            if (selectedStatus === cekStatus) {
                divTanggal.style.display = 'block';
                tanggalInput.setAttribute('required', 'true');
                divKeterangan.style.display = 'none';
                ketInput.removeAttribute('required');
                ketInput.value = '';
            } else if (selectedStatus === cekStatusKet) {
                divKeterangan.style.display = 'block';
                ketInput.setAttribute('required', 'true');
                divTanggal.style.display = 'none';
                tanggalInput.removeAttribute('required');
                tanggalInput.value = '';
            } else {
                divTanggal.style.display = 'none';
                tanggalInput.removeAttribute('required');
                tanggalInput.value = '';
                divKeterangan.style.display = 'none';
                ketInput.removeAttribute('required');
                ketInput.value = '';
            }
            console.log(selectedStatus);

            // Tangani klik tombol tutup
            tutupButton.addEventListener('click', function() {
                // Hapus nilai selected status (pilih elemen default atau tanpa status terpilih)
                divTanggal.style.display = 'none';
                tanggalInput.removeAttribute('required');
                divKeterangan.style.display = 'none';
                ketInput.removeAttribute('required');
                status.selectedIndex = '';
                ketInput.value = '';
                tanggalInput.value = '';
            });
        });
    });

</script>