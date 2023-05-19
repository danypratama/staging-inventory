<?php
session_start();
include "../koneksi.php";

if (isset($_POST['simpan'])) {
    $id = $_POST['id_br'];
    $id_produk = $_POST['id_produk'];
    $qty = $_POST['qty'];
    $ket = $_POST['keterangan'];
    $id_user = $_POST['id_user'];
    $created = $_POST['created'];

    $qty = intval(preg_replace("/[^0-9]/", "", $qty));

    $cek_data = mysqli_query($connect, "SELECT id_isi_br_tambahan FROM isi_br_tambahan WHERE id_isi_br_tambahan = '$id'");

    if ($cek_data->num_rows > 0) {
        $_SESSION['info'] = 'Data Sudah Ada';
        header("Location:../barang-masuk-tambahan.php");
    } else {
        $simpan = mysqli_query($connect, "INSERT INTO isi_br_tambahan
                                            (id_isi_br_tambahan, id_user, id_produk_reg, qty, id_ket_in, created_date)
                                            VALUES
                                            ('$id', '$id_user', '$id_produk', '$qty', '$ket', '$created')");
        $_SESSION['info'] = 'Disimpan';
        header("Location:../barang-masuk-tambahan.php");
    }
} else if (isset($_POST['edit'])) {
    $id = $_POST['id_br'];
    $id_produk = $_POST['id_produk'];
    $qty = $_POST['qty'];
    $ket = $_POST['keterangan'];

    $qty = intval(preg_replace("/[^0-9]/", "", $qty));

    $cek_data = mysqli_query($connect, "SELECT * FROM isi_br_tambahan WHERE id_isi_br_tambahan = '$id'");
    $data = mysqli_fetch_array($cek_data);

    echo $data['qty'];

    if ($data['id_produk_reg'] == $id_produk && $data['qty'] == $qty && $data['id_ket_in'] == $ket) {
        $_SESSION['info'] = "Tidak Ada Perubahan Data";
        header("Location:../barang-masuk-tambahan.php");
    } else {
        $update = mysqli_query($connect, "UPDATE isi_br_tambahan
                                          SET 
                                          id_produk_reg = '$id_produk',
                                          qty = '$qty',
                                          id_ket_in = '$ket'
                                          WHERE id_isi_br_tambahan  = '$id'");
        $_SESSION['info'] = "Diupdate";
        header("Location:../barang-masuk-tambahan.php");
    }
} else if (isset($_GET['hapus'])) {
    $idh = base64_decode($_GET['hapus']);

    $hapus_data = mysqli_query($connect, "DELETE FROM isi_br_tambahan WHERE id_isi_br_tambahan = '$idh'");

    if ($hapus_data) {
        $_SESSION['info'] = 'Dihapus';
        header("Location:../barang-masuk-tambahan.php");
    }
}
