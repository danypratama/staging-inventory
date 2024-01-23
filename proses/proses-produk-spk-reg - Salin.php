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
            $newQtyInt = str_replace(',', '', $qty[$i]); // Menghapus tanda ribuan (,)
            $newQtyInt = intval($newQtyInt); // Mengubah string harga menjadi integer
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
        header("Location:../detail-produk-spk-reg.php?id='$id_spk_encode'");
    } catch (Exception $e) {
        // Jika terjadi kesalahan, rollback transaksi
        mysqli_rollback($connect);
        header("Location:../detail-produk-spk-reg.php?id='$id_spk_encode'");
    }
} else if (isset($_POST['simpan-trx'])) {
    // Mendapatkan data yang dikirimkan melalui form
    $id_transaksi = $_POST['id_transaksi'];
    $id_spk_reg = $_POST['id_spk_reg'];
    $id_produk = $_POST['id_produk'];
    $nama_produk = $_POST['id_produk'];
    $harga = $_POST['harga'];
    $qty = $_POST['qty'];
    $created_date = $_POST['created_date'];

    mysqli_begin_transaction($connect);

    try {
        // Melakukan perulangan untuk menyimpan setiap data
        for ($i = 0; $i < count($id_transaksi); $i++) {
            $id_trx = $id_transaksi[$i];
            $spk_reg = $id_spk_reg[$i];
            $produk = $id_produk[$i];
            $hrg = str_replace(',', '', $harga[$i]); // Menghapus tanda ribuan (,)
            $hrg = intval($hrg); // Mengubah string harga menjadi integer
            $jml =  str_replace(',', '', $qty[$i]);
            $jml = intval($jml);
            $total_harga = $hrg * $jml;
            $created = $created_date[$i];

            // Query INSERT
            $sql = "INSERT INTO transaksi_produk_reg (id_transaksi, id_spk, id_produk, harga, qty, total_harga, created_date) VALUES ('$id_trx', '$spk_reg', '$produk', '$hrg', '$jml', '$total_harga', '$created')";
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
        header("Location:../spk-reg.php");
    } catch (Exception $e) {
        // Jika terjadi kesalahan, rollback transaksi
        mysqli_rollback($connect);
        header("Location:../spk-reg.php");
    }
} else if (isset($_POST['edit'])) {
    $id_tmp = $_POST['id_tmp'];
    $id_spk = $_POST['id_spk'];
    $qty_edit = $_POST['qty_edit'];
    $qty =  str_replace(',', '', $qty_edit);
    $qty = intval($qty);
    $id_spk_encode = base64_encode($id_spk);

    $update = mysqli_query($connect, "UPDATE tmp_produk_spk SET qty = '$qty' WHERE id_tmp = '$id_tmp'");
    if ($update) {
        header("Location:../detail-produk-spk-reg.php?id='$id_spk_encode'");
    }
} else if (isset($_GET['hapus_tmp'])) {
    $idh = base64_decode($_GET['hapus_tmp']);
    $id_spk = $_GET['id_spk'];

    $update = mysqli_query($connect, "DELETE FROM tmp_produk_spk WHERE id_tmp = '$idh'");
    header("Location:../detail-produk-spk-reg.php?id='$id_spk'");

    // hapus produk trx
} else if (isset($_GET['hapus_trx'])) {
    $idh = base64_decode($_GET['hapus_trx']);
    $id_spk = $_GET['id_spk'];

    $update = mysqli_query($connect, "DELETE FROM transaksi_produk_reg WHERE id_transaksi = '$idh'");

    $_SESSION['info'] = 'Dihapus';
    header("Location:../detail-produk-spk-reg-dalam-proses.php?id='$id_spk'");

    // cancel pesanan
} else if (isset($_POST['cancel-belum-diproses'])) {
    date_default_timezone_set('Asia/Jakarta');
    $id_spk = $_POST['id_spk'];
    $alasan = $_POST['alasan'];
    $menu_cancel = 'Belum Diproses';
    $user = $_SESSION['tiket_user'];
    $time = date('d/m/Y, H:i:s');

    mysqli_begin_transaction($connect);

    try {
        $insert = mysqli_query($connect, "INSERT INTO trx_cancel (id_trx_cancel, id_spk, id_produk, qty) SELECT id_tmp, id_spk, id_produk, qty FROM tmp_produk_spk WHERE id_spk ='$id_spk'");

        $delete = mysqli_query($connect, "DELETE FROM tmp_produk_spk WHERE id_spk = '$id_spk'");

        $update = mysqli_query($connect, "UPDATE spk_reg SET status_spk = 'Cancel Order', note = '$alasan', menu_cancel = '$menu_cancel', user_cancel = '$user', date_cancel = '$time' WHERE id_spk_reg = '$id_spk'");

        if (!$insert || !$delete || !$update) {
            throw new Exception("Terjadi kesalahan saat menyimpan data.");
        }

        // Jika tidak terjadi kesalahan, commit transaksi
        mysqli_commit($connect);
        $_SESSION['info'] = 'Dicancel';
        header("Location:../spk-reg.php?sort=baru");
    } catch (Exception $e) {
        // Jika terjadi kesalahan, rollback transaksi
        mysqli_rollback($connect);
        $_SESSION['info'] = 'Silahkan Ulangi Kembali';
        header("Location:../spk-reg.php?sort=baru");
    }
} else if (isset($_POST['cancel-dalam-proses'])) {
    date_default_timezone_set('Asia/Jakarta');
    $id_spk = $_POST['id_spk'];
    $alasan = $_POST['alasan'];
    $menu_cancel = 'Dalam Proses';
    $user = $_SESSION['tiket_user'];
    $time = date('d/m/Y, H:i:s');

    mysqli_begin_transaction($connect);

    try {
        $insert = mysqli_query($connect, "INSERT INTO trx_cancel (id_trx_cancel, id_spk, id_produk, harga, qty, disc, total_harga) SELECT id_transaksi, id_spk, id_produk, harga, qty, disc, total_harga FROM transaksi_produk_reg WHERE id_spk ='$id_spk'");

        $delete = mysqli_query($connect, "DELETE FROM transaksi_produk_reg WHERE id_spk = '$id_spk'");

        $update = mysqli_query($connect, "UPDATE spk_reg SET status_spk = 'Cancel Order', note = '$alasan', menu_cancel = '$menu_cancel', user_cancel = '$user', date_cancel = '$time' WHERE id_spk_reg = '$id_spk'");

        if (!$insert || !$delete || !$update) {
            throw new Exception("Terjadi kesalahan saat menyimpan data.");
        }
        // Jika tidak terjadi kesalahan, commit transaksi
        mysqli_commit($connect);
        $_SESSION['info'] = 'Dicancel';
        header("Location:../spk-dalam-proses.php?sort=baru");
    } catch (Exception $e) {
        // Jika terjadi kesalahan, rollback transaksi
        mysqli_rollback($connect);
        $_SESSION['info'] = 'Silahkan Ulangi Kembali';
        header("Location:../spk-dalam-proses.php?sort=baru");
    }

} else if (isset($_POST['cancel-siap-kirim'])) {
    date_default_timezone_set('Asia/Jakarta');
    $id_spk = $_POST['id_spk'];
    $alasan = $_POST['alasan'];
    $menu_cancel = 'Siap Kirim';
    $user = $_SESSION['tiket_user'];
    $time = date('d/m/Y, H:i:s');

    mysqli_begin_transaction($connect);

    try {
        $insert = mysqli_query($connect, "INSERT INTO trx_cancel (id_trx_cancel, id_spk, id_produk, harga, qty, disc, total_harga) SELECT id_transaksi, id_spk, id_produk, harga, qty, disc, total_harga FROM transaksi_produk_reg WHERE id_spk ='$id_spk'");

        $delete = mysqli_query($connect, "DELETE FROM transaksi_produk_reg WHERE id_spk = '$id_spk'");

        $update = mysqli_query($connect, "UPDATE spk_reg SET status_spk = 'Cancel Order', note = '$alasan', menu_cancel = '$menu_cancel', user_cancel = '$user', date_cancel = '$time' WHERE id_spk_reg = '$id_spk'");

        if (!$insert || !$delete || !$update) {
            throw new Exception("Terjadi kesalahan saat menyimpan data.");
        }
        // Jika tidak terjadi kesalahan, commit transaksi
        mysqli_commit($connect);
        $_SESSION['info'] = 'Dicancel';
        header("Location:../spk-siap-kirim.php?sort=baru");
    } catch (Exception $e) {
        // Jika terjadi kesalahan, rollback transaksi
        mysqli_rollback($connect);
        $_SESSION['info'] = 'Silahkan Ulangi Kembali';
        header("Location:../spk-dalam-proses.php?sort=baru");
    }
    // ===========================================================================================================================

    // Proses Siap Kirim
} else if (isset($_POST['siap-kirim'])) {
    $id_spk_reg = $_POST['id_spk_reg'];
    $petugas = $_POST['petugas'];
    $id_spk_encode = base64_encode($id_spk_reg);
    $sql_spk = "UPDATE spk_reg SET status_spk = 'Siap Kirim', petugas = '$petugas' WHERE id_spk_reg = '$id_spk_reg'";
    $query_spk = mysqli_query($connect, $sql_spk);

    header("Location:../spk-dalam-proses.php?sort=baru");
}
