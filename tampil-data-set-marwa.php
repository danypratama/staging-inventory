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
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="table-responsive">
                            <form action="proses/proses-update-stock-set-marwa.php" method="POST">
                                <?php
                                // Koneksi ke database
                                include 'koneksi.php';
                                $UUID = generate_uuid();
                                $month = date('m');
                                $year = date('y');
                                // Menerima nilai dari permintaan
                                $id = $_POST['id_set'];
                                $qty = $_POST['qty'];

                                $sql = mysqli_query($connect, "SELECT tpsm.*, mr.* FROM tb_produk_set_marwa tpsm LEFT JOIN tb_merk mr ON (tpsm.id_merk = mr.id_merk) WHERE tpsm.id_set_marwa = '$id'");
                                $row = mysqli_fetch_array($sql);
                                ?>
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col">
                                            <label for="">Nama Set Marwa</label>
                                            <input type="text" name="id_tr_set" class="form-control" value="TR-SET-MRW-<?php echo $year ?><?php echo $UUID ?><?php echo $month ?>" readonly>
                                            <input type="hidden" name="id_set" class="form-control" value="<?php echo $id ?>" readonly>
                                            <input type="text" class="form-control" value="<?php echo $row['nama_set_marwa'] ?>" readonly>
                                        </div>
                                        <div class="col">
                                            <label for="">Nama Set</label>
                                            <input type="text" class="form-control" value="<?php echo $row['nama_merk'] ?>" readonly>
                                        </div>
                                        <div class="col">
                                            <label for="">Jumlah Set</label>
                                            <input type="text" class="form-control" name="qty_set" value="<?php echo $qty ?>" readonly>
                                        </div>
                                    </div>
                                </div>

                                <table class="table">
                                    <thead>
                                        <tr class="bg-primary text-white">
                                            <th class="text-center p-3" style="width: 50px;">No</th>
                                            <th class="text-center p-3" style="width: 150px;">Kode Produk</th>
                                            <th class="text-center p-3" style="width: 300px;">Nama Produk</th>
                                            <th class="text-center p-3" style="width: 100px;">Merk Set</th>
                                            <th class="text-center p-3" style="width: 100px;">Qty</th>
                                            <th class="text-center p-3" style="width: 100px;">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Koneksi ke database
                                        include 'koneksi.php';
                                        // Menerima nilai dari permintaan
                                        $no = 1;
                                        $id = $_POST['id_set'];
                                        $qty = $_POST['qty'];

                                        $sql = mysqli_query($connect, "SELECT ipsm.*, tpsm.*, tpr.*, mr.* FROM isi_produk_set_marwa ipsm 
                                                                        LEFT JOIN tb_produk_reguler tpr ON (ipsm.id_produk = tpr.id_produk_reg)
                                                                        LEFT JOIN tb_produk_set_marwa tpsm ON (ipsm.id_set_marwa = tpsm.id_set_marwa)
                                                                        LEFT JOIN tb_merk mr ON (tpr.id_merk = mr.id_merk)
                                                                        WHERE ipsm.id_set_marwa = '$id'");
                                        while ($data = mysqli_fetch_array($sql)) {
                                            $total = $data['qty'] * $qty;
                                        ?>
                                            <tr>
                                                <input type="hidden" name="id_set_isi[]" class="form-control bg-light text-center" value="<?php echo $id ?>" readonly>
                                                <input type="hidden" name="id_produk[]" class="form-control bg-light text-center" value="<?php echo $data['id_produk'] ?>" readonly>
                                                <td><input type="text" class="form-control bg-light text-center" value="<?php echo $no ?>" readonly></td>
                                                <td><input type="text" class="form-control bg-light" value="<?php echo $data['kode_produk']; ?>" readonly></td>
                                                <td><input type="text" class="form-control bg-light" value="<?php echo $data['nama_produk']; ?>" readonly></td>
                                                <td><input type="text" class="form-control bg-light" value="<?php echo $data['nama_merk']; ?>" readonly></td>
                                                <td><input type="text" class="form-control bg-light text-end" value="<?php echo $data['qty']; ?>" readonly></td>
                                                <td><input type="text" class="form-control bg-light text-end" value="<?php echo $total; ?>" readonly></td>
                                                </td>
                                            </tr>
                                            <?php $no++; ?>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <div class="mb-3 mt-3 text-end">
                                    <input type="hidden" name="id_user" value="<?php echo $_SESSION['tiket_id'] ?>">
                                    <input type="hidden" class="form-control" name="created" id="datetime-input">
                                    <button type="submit" class="btn btn-primary btn-md" name="simpan"><i class="bi bi-save"></i> Simpan Data</button>
                                    <a href="barang-masuk-set-reg.php" class="btn btn-secondary btn-md"><i class="bi bi-x"></i> Tutup</a>
                                </div>
                            </form>
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

<!-- Generate UUID -->
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