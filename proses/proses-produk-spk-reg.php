<?php
session_start();
include "../koneksi.php";

if (isset($_POST['simpan-tmp'])) {
    // Mendapatkan data yang dikirimkan melalui form
    $id_tmp = $_POST['id_tmp']; // Mengambil ID transaksi dari form
    $id_spk_reg = $_POST['id_spk_reg_tmp'];
    $qty = $_POST['qty_tmp']; // Mengambil nilai qty yang diperbarui

    mysqli_begin_transaction($connect);

    try {
        // Melakukan perulangan untuk menyimpan setiap data
        for ($i = 0; $i < count($id_tmp); $i++) {
            $id = $id_tmp[$i];
            $spk_reg = $id_spk_reg[$i];
            $newQty = $qty[$i];
            $newQtyInt = str_replace(',', '', $qty[$i]); // Menghapus tanda ribuan (,)
            $newQtyInt = intval($newQty); // Mengubah string harga menjadi integer
            $id_spk_encode = base64_encode($id_spk_reg[$i]);

            // Lakukan proses penyimpanan data qty ke dalam database sesuai dengan ID transaksi
            // Contoh: Lakukan kueri SQL untuk memperbarui data qty dalam tabel transaksi menggunakan ID transaksi
            $sql = "UPDATE tmp_produk_spk SET qty = '$newQtyInt', status_tmp = '1' WHERE id_tmp = '$id'";
            $query = mysqli_query($connect, $sql);

            // Periksa apakah query berhasil dijalankan
            if (!$query) {
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
} else if (isset($_POST['simpan-trx'])) {
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

            $sql_spk = "UPDATE spk_reg SET status_spk = 'Dalam Proses' WHERE id_spk_reg = '$spk_reg'";
            $query_spk = mysqli_query($connect, $sql_spk);

            // Query DELETE
            $id_spk = $id_spk_reg[$i]; // Mengambil nilai id_spk untuk setiap iterasi
            $id_spk_encode = base64_encode($id_spk_reg[$i]);
            $sql_delete = "DELETE FROM tmp_produk_spk WHERE id_spk = '$id_spk'";
            $query2 = mysqli_query($connect, $sql_delete);

            // Periksa apakah query1 dan query2 berhasil dijalankan
            if (!$query1 || !$query2 || !$query_spk) {
                throw new Exception("Terjadi kesalahan saat menyimpan data.");
            }
        }

        // Jika tidak terjadi kesalahan, commit transaksi
        mysqli_commit($connect);
        $_SESSION['info'] = 'Disimpan';
        header("Location:../spk-reg.php");
    } catch (Exception $e) {
        // Jika terjadi kesalahan, rollback transaksi
        mysqli_rollback($connect);
        $_SESSION['info'] = 'Silahkan Ulangi Kembali';
        header("Location:../spk-reg.php");
    }
}
