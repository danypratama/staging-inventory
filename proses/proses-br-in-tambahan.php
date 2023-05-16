<?php
session_start();
include "../koneksi.php";

if (isset($_POST['simpan'])) {
    $id = $_POST['id_br'];
    $id_produk = $_POST['id_produk'];
    $qty = $_POST['qty'];
    $id_user = $_POST['id_user'];
    $created = $_POST['created'];

    $qty = intval(preg_replace("/[^0-9]/", "", $qty));

    $cek_data = mysqli_query($connect, "SELECT id_isi_br_tambahan FROM isi_br_tambahan WHERE id_isi_br_tambahan = '$id'");

    if ($cek_data->num_rows > 0) {
        $_SESSION['info'] = 'Data Sudah Ada';
        header("Location:../barang-masuk-tambahan.php");
    } else {
        $simpan = mysqli_query($connect, "INSERT INTO isi_br_tambahan
                                            (id_isi_br_tambahan, id_user, id_produk_reg, qty, created_date)
                                            VALUES
                                            ('$id', '$id_user', '$id_produk', '$qty', '$created')");
        $_SESSION['info'] = 'Disimpan';
        header("Location:../barang-masuk-tambahan.php");
    }
}
