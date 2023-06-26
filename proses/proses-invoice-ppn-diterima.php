<?php
session_start();
include "../koneksi.php";

// Memulai transaksi
$connect->begin_transaction();

try {
    if (isset($_POST['diterima'])) {
        $uuid = generate_uuid();
        $year = date('y');
        $day = date('d');
        $month = date('m');
        $id_inv_penerima = "BKTI" . $year . "" . $uuid . "" . $day;
        $id_inv_penerima2 = "PNMR" . $year . "" . $uuid . "" . $day;
        $id_inv = $_POST['id_inv'];
        $alamat = $_POST['alamat'];
        $diterima_oleh = $_POST['diterima_oleh'];

        // Mendapatkan informasi file bukti terima 1
        $file1_name = $_FILES['fileku1']['name'];
        $file1_tmp = $_FILES['fileku1']['tmp_name'];
        $file1_destination = "../gambar/bukti1/" . $file1_name;

        // Mendapatkan informasi file bukti terima 2
        $file2_name = $_FILES['fileku2']['name'];
        $file2_tmp = $_FILES['fileku2']['tmp_name'];
        $file2_destination = "../gambar/bukti2/" . $file2_name;

        // Mendapatkan informasi file bukti terima 3
        $file3_name = $_FILES['fileku3']['name'];
        $file3_tmp = $_FILES['fileku3']['tmp_name'];
        $file3_destination = "../gambar/bukti3/" . $file3_name;

        // Pindahkan file bukti terima ke lokasi tujuan
        move_uploaded_file($file1_tmp, $file1_destination);
        move_uploaded_file($file2_tmp, $file2_destination);
        move_uploaded_file($file3_tmp, $file3_destination);

        // Query-insert pertama
        $query1 = mysqli_query($connect, "INSERT INTO inv_bukti_terima (id_bukti_terima, id_inv, bukti_satu, bukti_dua, bukti_tiga) VALUES ('$id_inv_penerima', '$id_inv', '$file1_name', '$file2_name', '$file3_name')");

        // Query-insert kedua
        $query2 = mysqli_query($connect, "INSERT INTO inv_penerima (id_inv_penerima, id_inv, nama_penerima, alamat) VALUES ('$id_inv_penerima2', '$id_inv', '$diterima_oleh', '$alamat')");

        // Query-update
        $query3 = mysqli_query($connect, "UPDATE inv_ppn SET status_transaksi = 'Diterima' WHERE id_inv_ppn = '$id_inv'");

        if ($query1 && $query2 && $query3) {
            // Commit transaksi
            $connect->commit();
            header("Location:../invoice-reguler.php?sort=baru");
        }
    }
} catch (Exception $e) {
    // Rollback transaksi jika terjadi exception
    $connect->rollback();
    $error_message = "Terjadi kesalahan saat melakukan transaksi: " . $e->getMessage();
    echo <<<HTML
        <!-- Sweet Alert -->
        <link rel="stylesheet" href="assets/sweet-alert/dist/sweetalert2.min.css">
        <script src="assets/sweet-alert/dist/sweetalert2.all.min.js"></script>
        <script>
            swal({
                title: "Error!",
                text: "{$error_message}",
                icon: "error",
            }).then(function() {
                window.location.href = "../invoice-reguler.php?sort=baru";
            });
        </script>
    HTML;
}

// Tutup koneksi database
$connect->close();
?>


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