<?php
session_start();
include "../koneksi.php";

if (isset($_POST['diterima'])) {
    $uuid = generate_uuid();
    $year = date('y');
    $day = date('d');
    $month = date('m');
    $id_inv_penerima = "PNMR" . $year . " " . $uuid . " " . $day;
    $id_inv = $_POST['id_inv'];
    $alamat = $_POST['alamat'];
    $diterima = $_POST['diterima'];

    // // Mendapatkan informasi file bukti terima 1
    $nama_file = $_FILES["fileku"]["name"];
    $tipe_file = $_FILES["fileku"]["type"];
    $ukuran_file = $_FILES["fileku"]["size"];
    $tmp_file = $_FILES["fileku"]["tmp_name"];

    echo $nama_file;

    // // Mendapatkan informasi file bukti terima 2
    // $file2_name = $_FILES['fileku2']['name'];
    // $file2_tmp = $_FILES['fileku2']['tmp_name'];
    // $file2_destination = "../gambar/bukti1" . $file2_name;

    // // Mendapatkan informasi file bukti terima 3
    // $file3_name = $_FILES['fileku3']['name'];
    // $file3_tmp = $_FILES['fileku3']['tmp_name'];
    // $file3_destination = "../gambar/bukti1" . $file3_name;

    // // Pindahkan file bukti terima ke lokasi tujuan
    // move_uploaded_file($file1_tmp, $file1_destination);
    // move_uploaded_file($file2_tmp, $file2_destination);
    // move_uploaded_file($file3_tmp, $file3_destination);

    // $query1 = mysqli_query($connect, "INSERT INTO inv_bukti_terima (id_inv, bukti_satu, bukti_dua, bukti_tiga) VALUES ('$id_inv', $fileName1, $fileName2, $fileName3)");

    // $query2 = mysqli_query($connect, "INSERT INTO inv_penerima (id_inv_penerima, id_inv, nama_penerima, alamat) VALUES ('$id_inv_penerima', '$id_inv', '$diterima_oleh', '$alamat')");

    // $query3 = mysqli_query($connect, "UPDATE INTO inv_nonppn SET status_transaksi = 'Diterima' WHERE id_inv_nonppn = '$id_inv'");
}
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