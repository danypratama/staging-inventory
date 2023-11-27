<?php
session_start();
include "../koneksi.php";

if (isset($_POST['simpan'])) {
    $id_tr_set = $_POST['id_tr_set'];
    $id_tr_set_isi = $_POST['id_tr_set_isi'];
    $id_set = $_POST['id_set'];
    $id_set_isi = $_POST['id_set_isi'];
    $qty_set = $_POST['qty_set'];
    $qty = $_POST['qty'];
    $id_produk = $_POST['id_produk'];
    $id_user = $_POST['id_user'];
    $created = $_POST['created'];
    $total_data = count($id_set_isi);

    // Memulai transaksi
    mysqli_begin_transaction($connect);

    try {
        $sql_tr_set = "INSERT INTO tr_set_marwa
                        (id_tr_set_marwa, id_set_marwa, qty, id_user, created_date)
                        VALUES
                        ('$id_tr_set', '$id_set', '$qty_set', '$id_user', '$created')";
        $query1 = mysqli_query($connect, $sql_tr_set);

        if (!$query1) {
            throw new Exception("Terjadi kesalahan saat menyimpan data.");
        }

        for ($i = 0; $i < $total_data; $i++) {
            $new_id_tr_set_isi = $id_tr_set_isi[$i];
            $new_id_set_isi = $id_set_isi[$i];
            $new_id_produk = $id_produk[$i];
            $new_qty = $qty[$i];
            $new_id_tr_set = $id_tr_set;

            $sql_tr_set_isi = "INSERT INTO tr_set_marwa_isi
                    (id_tr_set_marwa_isi, id_tr_set_marwa, id_set_marwa, id_produk_reg, qty, id_user, created_date)
                    VALUES
                    ('$new_id_tr_set_isi', '$new_id_tr_set', '$new_id_set_isi', '$new_id_produk', '$new_qty', '$id_user', '$created')";
            $query2 = mysqli_query($connect, $sql_tr_set_isi);

            if (!$query2) {
                throw new Exception("Terjadi kesalahan saat menyimpan data.");
            }
        }

        // Melakukan commit jika tidak ada kesalahan
        mysqli_commit($connect);
        $_SESSION['info'] = 'Disimpan';
        header("Location:../barang-masuk-set-reg.php");
    } catch (Exception $e) {
        // Rollback transaksi jika terjadi kesalahan
        mysqli_rollback($connect);
        $_SESSION['info'] = 'Silahkan Ulangi Kembali';
        header("Location:../barang-masuk-set-reg.php");
    }
} else if (isset($_GET['hapus'])) {
    $id_tr_set_marwa = base64_decode($_GET['hapus']);

    // Memulai transaksi
    mysqli_begin_transaction($connect);

    try {
        // Hapus data dari tabel tr_set_marwa_isi
        $sql_delete_tr_set_isi = "DELETE FROM tr_set_marwa_isi WHERE id_tr_set_marwa = '$id_tr_set_marwa'";
        $query_delete_tr_set_isi = mysqli_query($connect, $sql_delete_tr_set_isi);

        if (!$query_delete_tr_set_isi) {
            throw new Exception("Terjadi kesalahan saat menghapus data.");
        }

        // Hapus data dari tabel tr_set_marwa
        $sql_delete_tr_set = "DELETE FROM tr_set_marwa WHERE id_tr_set_marwa = '$id_tr_set_marwa'";
        $query_delete_tr_set = mysqli_query($connect, $sql_delete_tr_set);

        if (!$query_delete_tr_set) {
            throw new Exception("Terjadi kesalahan saat menghapus data.");
        }

        // Melakukan commit jika tidak ada kesalahan
        mysqli_commit($connect);
        $_SESSION['info'] = 'Dihapus';
        header("Location:../barang-masuk-set-reg.php");
    } catch (Exception $e) {
        // Rollback transaksi jika terjadi kesalahan
        mysqli_rollback($connect);
        $_SESSION['info'] = 'Data Gagal Dihapus';
        header("Location:../barang-masuk-set-reg.php");
    }
}
