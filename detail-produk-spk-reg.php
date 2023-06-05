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

    <style type="text/css">
        @media only screen and (max-width: 500px) {
            body {
                font-size: 10px;
            }
        }
    </style>
</head>

<body>
    <!-- nav header -->
    <?php include "page/nav-header.php" ?>
    <!-- end nav header -->

    <!-- sidebar  -->
    <?php include "page/sidebar.php"; ?>
    <!-- end sidebar -->


    <main id="main" class="main">
        <section>
            <div class="container-fluid">
                <div class="card shadow p-2">
                    <div class="card-header text-center">
                        <h5><strong>DETAIL PRODUK SPK</strong></h5>
                    </div>
                    <?php
                    include "koneksi.php";
                    $id_spk = base64_decode($_GET['id']);
                    $sql = "SELECT sr.*, cs.nama_cs, cs.alamat, ordby.order_by, sl.nama_sales 
                    FROM spk_reg AS sr
                    JOIN tb_customer cs ON(sr.id_customer = cs.id_cs)
                    JOIN tb_orderby ordby ON(sr.id_orderby = ordby.id_orderby)
                    JOIN tb_sales sl ON(sr.id_sales = sl.id_sales)
                    WHERE sr.id_spk_reg = '$id_spk'";
                    $query = mysqli_query($connect, $sql);
                    $data = mysqli_fetch_array($query);
                    ?>
                    <div class="card-body">
                        <div class="row mt-3">
                            <div class="col-sm-6">
                                <div class="card-body p-3 border">
                                    <div class="row">
                                        <div class="col-5">
                                            <p style="float: left;">No. SPK</p>
                                            <p style="float: right;">:</p>
                                        </div>
                                        <div class="col-7">
                                            <?php echo $data['no_spk'] ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-5">
                                            <p style="float: left;">Tanggal SPK</p>
                                            <p style="float: right;">:</p>
                                        </div>
                                        <div class="col-7">
                                            <?php echo $data['tgl_spk'] ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-5">
                                            <p style="float: left;">No. PO</p>
                                            <p style="float: right;">:</p>
                                        </div>
                                        <div class="col-7">
                                            <?php
                                            if ($data['no_po'] != '') {
                                                echo $data['no_po'];
                                            } else {
                                                echo '-';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-5">
                                            <p style="float: left;">Tanggal Pesanan</p>
                                            <p style="float: right;">:</p>
                                        </div>
                                        <div class="col-7">
                                            <?php echo $data['tgl_pesanan'] ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-5">
                                            <p style="float: left;">Order Via</p>
                                            <p style="float: right;">:</p>
                                        </div>
                                        <div class="col-7">
                                            <?php echo $data['order_by'] ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="card-body p-3 border" style="min-height: 234px;">
                                    <div class="row">
                                        <div class="col-5">
                                            <p style="float: left;">Sales</p>
                                            <p style="float: right;">:</p>
                                        </div>
                                        <div class="col-7">
                                            <?php echo $data['nama_sales'] ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-5">
                                            <p style="float: left;">Pelanggan</p>
                                            <p style="float: right;">:</p>
                                        </div>
                                        <div class="col-7">
                                            <?php echo $data['nama_cs'] ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-5">
                                            <p style="float: left;">Alamat</p>
                                            <p style="float: right;">:</p>
                                        </div>
                                        <div class="col-7">
                                            <?php echo $data['alamat'] ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-5">
                                            <p style="float: left;">Note</p>
                                            <p style="float: right;">:</p>
                                        </div>
                                        <div class="col-7">
                                            <?php
                                            if ($data['note'] != '') {
                                                echo $data['note'];
                                            } else {
                                                echo '-';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Tampil data -->
                <div class="card shadow">
                    <div class="card-body p-3">
                        <div class="table-responsive">
                            <form action="proses/proses-produk-spk-reg.php" method="POST">
                                <div class="text-start mb-3">
                                    <a href="spk-reg.php?sort=baru" class="btn btn-warning btn-detail">
                                        <i class="bi bi-arrow-left"></i> Halaman Sebelumnya
                                    </a>
                                    <a class="btn btn-primary btn-detail" data-spk="<?php echo $data['id_spk_reg'] ?>" data-bs-toggle="modal" data-bs-target="#modalBarang">
                                        <i class="bi bi-plus-circle"></i> Tambah Produk
                                    </a>
                                    <?php
                                    $id_spk_decode = base64_decode($_GET['id']);
                                    $sql_thead = "SELECT sr.*, tps.*, spr.stock, tpr.nama_produk, tpr.harga_produk, mr.* 
                                        FROM spk_reg AS sr
                                        JOIN tmp_produk_spk tps ON(sr.id_spk_reg = tps.id_spk)
                                        JOIN stock_produk_reguler spr ON(tps.id_produk = spr.id_produk_reg)
                                        JOIN tb_produk_reguler tpr ON(tps.id_produk = tpr.id_produk_reg)
                                        JOIN tb_merk mr ON (tpr.id_merk = mr.id_merk)
                                        WHERE sr.id_spk_reg = '$id_spk_decode' AND tps.status_tmp = '1'";
                                    $query_thead = mysqli_query($connect, $sql_thead);
                                    $totalRows = mysqli_num_rows($query_thead);
                                    if ($totalRows != 0) {
                                        echo '<button type="submit" class="btn btn-secondary" name="simpan-trx"><i class="bi bi-send"></i> Proses Pesanan</button>';
                                    }
                                    ?>

                                </div>
                                <table class="table table-striped table-bordered">
                                    <?php
                                    $id_spk_decode = base64_decode($_GET['id']);
                                    $sql_thead = "SELECT sr.*, tps.*, spr.stock, tpr.nama_produk, tpr.harga_produk, mr.* 
                                        FROM spk_reg AS sr
                                        JOIN tmp_produk_spk tps ON(sr.id_spk_reg = tps.id_spk)
                                        JOIN stock_produk_reguler spr ON(tps.id_produk = spr.id_produk_reg)
                                        JOIN tb_produk_reguler tpr ON(tps.id_produk = tpr.id_produk_reg)
                                        JOIN tb_merk mr ON (tpr.id_merk = mr.id_merk)
                                        WHERE sr.id_spk_reg = '$id_spk_decode' AND tps.status_tmp = '1'";
                                    $query_thead = mysqli_query($connect, $sql_thead);
                                    $totalRows = mysqli_num_rows($query_thead);
                                    if ($totalRows != 0) {
                                        echo ' 
                                        <thead>
                                            <tr class="text-white" style="background-color: #051683;">
                                                <th class="text-center p-3" style="width:20px">No</th>
                                                <th class="text-center p-3" style="width:300px">Nama Produk</th>
                                                <th class="text-center p-3" style="width:100px">Merk</th>
                                                <th class="text-center p-3" style="width:100px">Harga</th>
                                                <th class="text-center p-3" style="width:80px">Qty Order</th>
                                                <th class="text-center p-3" style="width:80px">Aksi</th>
                                            </tr>
                                        </thead>  ';
                                    }
                                    ?>
                                    <tbody>
                                        <?php
                                        include "koneksi.php";
                                        $year = date('y');
                                        $day = date('d');
                                        $month = date('m');
                                        $id_spk_decode = base64_decode($_GET['id']);
                                        $no = 1;
                                        $sql_trx = "SELECT sr.*, tps.*, spr.stock, tpr.nama_produk, tpr.harga_produk, mr.* 
                                                FROM spk_reg AS sr
                                                JOIN tmp_produk_spk tps ON(sr.id_spk_reg = tps.id_spk)
                                                JOIN stock_produk_reguler spr ON(tps.id_produk = spr.id_produk_reg)
                                                JOIN tb_produk_reguler tpr ON(tps.id_produk = tpr.id_produk_reg)
                                                JOIN tb_merk mr ON (tpr.id_merk = mr.id_merk)
                                                WHERE sr.id_spk_reg = '$id_spk_decode' AND tps.status_tmp = '1'";
                                        $trx_produk_reg = mysqli_query($connect, $sql_trx);
                                        while ($data_trx = mysqli_fetch_array($trx_produk_reg)) {
                                            $uuid = generate_uuid();
                                            $stock_edit = $data_trx['qty'] + $data_trx['stock'];
                                        ?>
                                            <tr>
                                                <input type="hidden" name="id_transaksi[]" id="id_<?php echo $data_trx['id_tmp'] ?>" value="TRX-<?php echo $year ?><?php echo $month ?><?php echo $uuid ?><?php echo $day ?>" readonly>
                                                <input type="hidden" name="id_user" value="<?php echo $_SESSION['tiket_id'] ?>">
                                                <input type="hidden" class="form-control" name="id_spk_reg[]" value="<?php echo $data_trx['id_spk'] ?>" readonly>
                                                <input type="hidden" class="form-control" name="id_produk[]" value="<?php echo $data_trx['id_produk'] ?>" readonly>
                                                <td><input type="text" class="form-control text-center" value="<?php echo $no; ?>" readonly></td>
                                                <td><input type="text" class="form-control" name="nama_produk[]" value="<?php echo $data_trx['nama_produk'] ?>" readonly></td>
                                                <td><input type="text" class="form-control text-center" value="<?php echo $data_trx['nama_merk'] ?>" readonly></td>
                                                <td><input type="text" class="form-control text-end" name="harga[]" value="<?php echo number_format($data_trx['harga_produk']) ?>" readonly></td>
                                                <td><input type="text" class="form-control text-end" name="qty[]" value="<?php echo number_format($data_trx['qty']) ?>" readonly></td>
                                                <td class="text-center">
                                                    <a href="#" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit" data-id="<?php echo $data_trx['id_tmp'] ?>" data-nama="<?php echo $data_trx['nama_produk'] ?>" data-merk="<?php echo $data_trx['nama_merk'] ?>" data-stock="<?php echo number_format($stock_edit) ?>" data-qty="<?php echo $data_trx['qty'] ?>"><i class="bi bi-pencil"></i></a>
                                                    <a href="" class="btn btn-danger btn-sm delete-data"><i class="bi bi-trash"></i></a>
                                                </td>
                                                <!-- Modal Edit -->
                                                <div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body p-2">
                                                                <form action="">
                                                                    <input type="hidden" id="idTmpValue" name="id_tmp" class="form-control">
                                                                    <div class="mb-3">
                                                                        <label class="text-start">Nama Produk</label>
                                                                        <input type="text" id="namaTmpValue" class="form-control bg-light" readonly>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label class="text-start">Merk Produk</label>
                                                                        <input type="text" id="merkTmpValue" class="form-control bg-light" readonly>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label class="text-start">Stock Tersedia</label>
                                                                        <input type="text" id="stockTmpValue" class="form-control bg-light" readonly>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label class="text-start">Qty Order</label>
                                                                        <input type="text" id="qtyTmpValue" class="form-control">
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                        <button type="button" class="btn btn-primary">Save changes</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- End Modal Edit -->
                                            </tr>
                                            <?php $no++; ?>
                                        <?php } ?>
                                    </tbody>
                                </table>

                                <div class="container">
                                    <?php
                                    $id_spk_reg = $data['id_spk_reg'];
                                    $sql = "SELECT sr.*, tps.*, spr.stock, tpr.nama_produk, tpr.harga_produk, mr.* 
                                        FROM spk_reg AS sr
                                        JOIN tmp_produk_spk tps ON(sr.id_spk_reg = tps.id_spk)
                                        JOIN stock_produk_reguler spr ON(tps.id_produk = spr.id_produk_reg)
                                        JOIN tb_produk_reguler tpr ON(tps.id_produk = tpr.id_produk_reg)
                                        JOIN tb_merk mr ON (tpr.id_merk = mr.id_merk)
                                        WHERE sr.id_spk_reg = '$id_spk_reg' AND tps.status_tmp = '0'";
                                    $query = mysqli_query($connect, $sql);
                                    $totalRows = mysqli_num_rows($query);
                                    if ($totalRows != 0) {
                                        echo '<h5 class="text-center">Tambah Produk Pesanan</h5>';
                                    }
                                    ?>
                                </div>
                                <?php
                                $no = 1;
                                $id_spk_reg = $data['id_spk_reg'];
                                $sql = "SELECT sr.*, tps.*, spr.stock, tpr.nama_produk, tpr.harga_produk, mr.* 
                                    FROM spk_reg AS sr
                                    JOIN tmp_produk_spk tps ON(sr.id_spk_reg = tps.id_spk)
                                    JOIN stock_produk_reguler spr ON(tps.id_produk = spr.id_produk_reg)
                                    JOIN tb_produk_reguler tpr ON(tps.id_produk = tpr.id_produk_reg)
                                    JOIN tb_merk mr ON (tpr.id_merk = mr.id_merk)
                                    WHERE sr.id_spk_reg = '$id_spk_reg' AND tps.status_tmp = '0'";
                                $query = mysqli_query($connect, $sql);
                                $isEmpty = true; // Tambahkan variabel pengecekan apakah data kosong
                                while ($data = mysqli_fetch_array($query)) {
                                    $uuid = generate_uuid();
                                    $isEmpty = false; // Setel variabel pengecekan menjadi false jika ada data
                                ?>
                                    <div class="card-body border p-2">
                                        <div class="row">
                                            <div class="col-1">
                                                <input type="text" class="form-control text-center" value="<?php echo $no; ?>">
                                                <?php $no++ ?>
                                            </div>
                                            <div class="col-sm-4">
                                                <input type="hidden" name="id_tmp[]" id="id_<?php echo $data['id_tmp'] ?>" value="<?php echo $data['id_tmp'] ?>" readonly>
                                                <input type="hidden" class="form-control" name="id_spk_reg_tmp[]" value="<?php echo $id_spk_reg ?>" readonly>
                                                <input type="hidden" class="form-control" name="id_produk_tmp[]" value="<?php echo $data['id_produk'] ?>" readonly>
                                                <input type="text" class="form-control bg-light" value="<?php echo $data['nama_produk'] ?>" readonly>
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control bg-light text-center" value="<?php echo $data['nama_merk'] ?>" readonly>
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control bg-light text-end" value="<?php echo number_format($data['harga_produk']) ?>" readonly>
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control bg-light text-end" name="stock" id="stock_<?php echo $data['id_tmp'] ?>" value="<?php echo number_format($data['stock']) ?>" readonly>
                                            </div>
                                            <div class="col-sm-1">
                                                <input type="text" class="form-control text-end" name="qty_tmp[]" id="qtyInput_<?php echo $data['id_tmp'] ?>" oninput="checkStock('<?php echo $data['id_tmp'] ?>')" required>
                                            </div>
                                        </div>
                                    </div>

                                <?php } ?>
                                <?php if ($isEmpty) { // Cek apakah data kosong 
                                ?>
                                <?php } else { // Jika ada data, tampilkan tombol simpan 
                                ?>

                                <?php } ?>
                                <div class="card-body mt-3 text-end">
                                    <?php
                                    $sql = "SELECT sr.*, tps.*, spr.stock, tpr.nama_produk, tpr.harga_produk, mr.* 
                                        FROM spk_reg AS sr
                                        JOIN tmp_produk_spk tps ON(sr.id_spk_reg = tps.id_spk)
                                        JOIN stock_produk_reguler spr ON(tps.id_produk = spr.id_produk_reg)
                                        JOIN tb_produk_reguler tpr ON(tps.id_produk = tpr.id_produk_reg)
                                        JOIN tb_merk mr ON (tpr.id_merk = mr.id_merk)
                                        WHERE sr.id_spk_reg = '$id_spk_reg' AND tps.status_tmp = '0'";
                                    $query = mysqli_query($connect, $sql);
                                    $totalRows = mysqli_num_rows($query);
                                    if ($totalRows != 0) {
                                        echo '<button type="submit" class="btn btn-primary" name="simpan-tmp" id="simpan-data"><i class="bi bi-save"></i> Simpan</button>';
                                    }
                                    ?>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main><!-- End #main -->


    <!-- Modal Barang -->
    <div class="modal fade" id="modalBarang" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <form method="post" action=""> <!-- Tambahkan form dengan method POST -->
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Data Barang</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="table2">
                                <thead>
                                    <tr class="text-white" style="background-color: #051683;">
                                        <td class="text-center p-3" style="width: 50px">No</td>
                                        <td class="text-center p-3" style="width: 350px">Nama Produk</td>
                                        <td class="text-center p-3" style="width: 100px">Merk</td>
                                        <td class="text-center p-3" style="width: 100px">Stock</td>
                                        <td class="text-center p-3" style="width: 100px">Aksi</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    include "koneksi.php";
                                    $id = $_GET['id'];
                                    $selected_produk = [];
                                    $id_spk = $id_spk_reg;
                                    $no = 1;

                                    // Mengambil data produk yang ada dalam tmp_produk_spk untuk id_spk yang sedang aktif
                                    $query_selected_produk = mysqli_query($connect, "SELECT id_produk FROM tmp_produk_spk WHERE id_spk = '$id_spk'");
                                    while ($selected_data = mysqli_fetch_array($query_selected_produk)) {
                                        $selected_produk[] = $selected_data['id_produk'];
                                    }

                                    $sql = "SELECT pr.nama_produk, pr.id_merk, pr.harga_produk, mr.nama_merk, spr.stock, spr.id_produk_reg
                                            FROM stock_produk_reguler AS spr
                                            LEFT JOIN tb_produk_reguler AS pr ON spr.id_produk_reg = pr.id_produk_reg
                                            LEFT JOIN tb_merk AS mr ON pr.id_merk = mr.id_merk
                                            ORDER BY pr.nama_produk ASC";

                                    $query = mysqli_query($connect, $sql);

                                    while ($data = mysqli_fetch_array($query)) {
                                        $id_produk = $data['id_produk_reg'];
                                        $isChecked = in_array($id_produk, $selected_produk);
                                        $isDisabled = false;

                                        if ($data['stock'] == 0) {
                                            $isDisabled = true; // Jika stock = 0, maka tombol pilih akan menjadi disabled
                                        }
                                    ?>
                                        <tr>
                                            <td class="text-center"><?php echo $no; ?></td>
                                            <td><?php echo $data['nama_produk']; ?></td>
                                            <td class="text-center"><?php echo $data['nama_merk']; ?></td>
                                            <td class="text-center"><?php echo number_format($data['stock']); ?></td>
                                            <td class="text-center">
                                                <button class="btn-pilih btn btn-primary btn-sm" data-id="<?php echo $id_produk; ?>" data-spk="<?php echo $id_spk; ?>" <?php echo ($isChecked || $isDisabled) ? 'disabled' : ''; ?>>Pilih</button>
                                            </td>
                                        </tr>
                                        <?php $no++; ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="refreshPage()">Close</button>
                    </div>
                </form> <!-- Akhir dari form -->
            </div>
        </div>
    </div>
    <!-- End Modal -->


    <!-- Footer -->
    <?php include "page/footer.php" ?>
    <!-- End Footer -->
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <?php include "page/script.php" ?>
</body>

</html>

<!-- Generat UUID -->
<?php
function generate_uuid()
{
    return sprintf(
        '%04x%04x%04x',
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0x0fff) | 0x4000,
        mt_rand(0, 0x3fff) | 0x8000,
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff)
    );
}
?>
<!-- End Generate UUID -->

<script>
    function refreshPage() {
        location.reload();
    }
</script>

<script>
    $(document).ready(function() {
        $('.btn-detail').click(function() {
            var idSpk = $(this).data('spk');
            $('#spk').text(idSpk);

            $('button.btn-pilih').attr('data-spk', idSpk);

            $('#modalBarang').modal('show');
        });

        $(document).on('click', '.btn-pilih', function(event) {
            event.preventDefault();
            event.stopPropagation();

            var id = $(this).data('id');
            var spk = $(this).attr('data-spk');

            saveData(id, spk);
        });

        function saveData(id, spk) {
            $.ajax({
                url: 'simpan-data-spk.php',
                type: 'POST',
                data: {
                    id: id,
                    spk: spk
                },
                success: function(response) {
                    console.log('Data berhasil disimpan.');
                    $('button[data-id="' + id + '"]').prop('disabled', true);
                },
                error: function(xhr, status, error) {
                    console.error('Terjadi kesalahan saat menyimpan data:', error);
                }
            });
        }
    });
</script>

<!-- Clock js -->
<script>
    function inputDateTime() {
        // Get current date and time
        let currentDate = new Date();

        // Format date and time as yyyy-mm-ddThh:mm:ss
        let year = currentDate.getFullYear();
        let month = (currentDate.getMonth() + 1).toString().padStart(2, '0');
        let day = currentDate.getDate().toString().padStart(2, '0');
        let hours = currentDate.getHours();
        let minutes = currentDate.getMinutes().toString().padStart(2, '0');
        let seconds = currentDate.getSeconds().toString().padStart(2, '0');
        let formattedDateTime = `${day}/${month}/${year}, ${hours}:${minutes}`;

        // Set value of input field to current date and time
        document.getElementById("datetime-input").setAttribute('value', formattedDateTime);

    }
    // Call updateDateTime function every second
    setInterval(inputDateTime, 1000);
</script>

<!-- Kode Untuk Qty   -->
<script>
    function formatNumber(number) {
        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    function formatInputValue(value) {
        return value.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    function checkStock(inputId) {
        var stock = parseInt(document.getElementById('stock_' + inputId).value.replace(/,/g, '')); // Menggunakan ID yang sesuai untuk elemen stock
        var qtyInput = document.getElementById('qtyInput_' + inputId); // Menggunakan ID yang sesuai untuk elemen qtyInput
        var qty = qtyInput.value.replace(/,/g, '');

        qtyInput.value = formatInputValue(qty);

        if (parseInt(qty) > stock) {
            qtyInput.value = formatNumber(stock);
        }

        var simpanButton = document.getElementById('simpan');
        if (parseInt(qty) > 0) {
            simpanButton.disabled = false;
        } else {
            simpanButton.disabled = true;
        }
    }
</script>

<!-- Fungsi menonaktifkan kerboard enter -->
<script>
    document.addEventListener("keydown", function(event) {
        if (event.key === "Enter") {
            event.preventDefault();
            document.getElementById("simpan-data").click();
        }
    });
</script>

<!-- Edit Data -->
<script>
    $(document).ready(function() {
        $('#modalEdit').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Tombol yang membuka modal
            var idTmp = button.data('id'); // Mengambil data-id dari atribut data
            var namaTmp = button.data('nama'); // Mengambil data-nama dari atribut data
            var merkTmp = button.data('merk'); // Mengambil data-merk dari atribut data
            var qtyTmp = button.data('qty'); // Mengambil data-qty dari atribut data
            var stockTmp = button.data('stock'); // Mengambil data-stock dari atribut data

            // Mengisi nilai idTmp ke dalam elemen dengan id "idTmpValue"
            $('#idTmpValue').val(idTmp);
            $('#namaTmpValue').val(namaTmp);
            $('#merkTmpValue').val(merkTmp);
            $('#stockTmpValue').val(stockTmp);

            // Mengisi nilai qtyTmp ke dalam elemen dengan id "qtyTmpValue" dengan format angka
            var formattedQty = numberWithCommas(qtyTmp);
            $('#qtyTmpValue').val(formattedQty);
        });
    });
</script>