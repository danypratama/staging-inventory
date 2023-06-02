<?php
session_start();
include "../koneksi.php";

if (isset($_POST['simpan'])) {
    // Mendapatkan data yang dikirimkan melalui form
    $id_transaksi = $_POST['id_transaksi'];
    $id_user = $_POST['id_user'];
    $id_spk_reg = $_POST['id_spk_reg'];
    $id_produk = $_POST['id_produk'];
    $harga = $_POST['harga'];
    $qty = $_POST['qty'];
    $created = $_POST['created'];

    mysqli_begin_transaction($connect);

    try {
        // Melakukan perulangan untuk menyimpan setiap data
        for ($i = 0; $i < count($id_transaksi); $i++) {
            $id_trx = $id_transaksi[$i];
            $user = $id_user[$i];
            $spk_reg = $id_spk_reg[$i];
            $produk = $id_produk[$i];
            $hrg = str_replace(',', '', $harga[$i]); // Menghapus tanda ribuan (,)
            $hrg = intval($hrg); // Mengubah string harga menjadi integer
            $jumlah = $qty[$i];
            $tanggal = $created;

            // Query INSERT
            $sql = "INSERT INTO transaksi_produk_reg (id_transaksi, id_user, id_spk, id_produk, harga, qty) VALUES ('$id_trx', '$user', '$spk_reg', '$produk', '$hrg', '$jumlah')";
            $query1 = mysqli_query($connect, $sql);

            // Query DELETE
            $id_spk = $id_spk_reg[$i]; // Mengambil nilai id_spk untuk setiap iterasi
            $id_spk_encode = base64_encode($id_spk_reg[$i]);
            $sql_delete = "DELETE FROM tmp_produk_spk WHERE id_spk = '$id_spk'";
            $query2 = mysqli_query($connect, $sql_delete);

            // Periksa apakah query1 dan query2 berhasil dijalankan
            if (!$query1 || !$query2) {
                throw new Exception("Terjadi kesalahan saat menyimpan data.");
            }
        }

        // Jika tidak terjadi kesalahan, commit transaksi
        mysqli_commit($connect);
        $_SESSION['info'] = 'Disimpan';
        header("Location:../detail-produk-spk-reg.php?id='$id_spk_encode'");
    } catch (Exception $e) {
        // Jika terjadi kesalahan, rollback transaksi
        mysqli_rollback($connect);
        $_SESSION['info'] = 'Silahkan Ulangi Kembali';
        header("Location:../detail-produk-spk-reg.php?id='$id_spk_encode'");
    }
}
