<?php
session_start();
include "../koneksi.php";

if (isset($_POST['simpan-inv'])) {
    $id_spk = $_POST['id_spk'];
    $id_inv_nonppn = $_POST['id_inv_nonppn'];
    $no_inv_nonppn = $_POST['no_inv_nonppn'];
    $tgl_inv = $_POST['tgl_inv'];
    $cs = $_POST['cs'];
    $cs_inv = $_POST['cs_inv'];
    $jenis_inv = $_POST['jenis_inv'];
    $tgl_tempo = $_POST['tgl_tempo'];
    $sp_disc = $_POST['sp_disc'];
    $note_inv = $_POST['note_inv'];
    $ongkir = $_POST['ongkir'];
    $status_inv = 'Belum Dikirim';
    $status_spk = 'Invoice Sudah Diterbitkan';
    $user = $_SESSION['tiket_nama'];
    $id_inv_nonppn_encode = base64_encode($id_inv_nonppn);

    // Mulai transaksi
    // Mulai transaksi
    mysqli_begin_transaction($connect);

    try {
        $success = true;

        for ($i = 0; $i < count($id_spk); $i++) {
            $id_spk_array = $_POST['id_spk'][$i];
            $sql = mysqli_query($connect, "UPDATE spk_reg SET id_inv = '$id_inv_nonppn', status_spk = '$status_spk' WHERE id_spk_reg = '$id_spk_array'");

            if (!$sql) {
                $success = false;
                break;
            }

            $sql_inv = mysqli_query($connect, "INSERT INTO inv_nonppn 
                                            (id_inv_nonppn, no_inv, tgl_inv, cs_inv, tgl_tempo, sp_disc, note_inv, kategori_inv, ongkir, status_transaksi, user_created)
                                            VALUES
                                            ('$id_inv_nonppn', '$no_inv_nonppn', '$tgl_inv', '$cs_inv', '$tgl_tempo', '$sp_disc', '$note_inv', '$jenis_inv', '$ongkir', '$status_inv', '$user')");
            if (!$sql_inv) {
                $success = false;
                break;
            }
        }

        if ($success) {
            // Jika kedua query berhasil, lakukan commit
            mysqli_commit($connect);
            header("Location:../cek-produk-inv-nonppn.php?id='$id_inv_nonppn_encode'");
        } else {
            // Rollback jika terjadi kesalahan
            mysqli_rollback($connect);
            echo "Error: Query gagal. Transaksi dibatalkan.";
        }
    } catch (Exception $e) {
        // Rollback jika terjadi kesalahan atau pengecualian
        mysqli_rollback($connect);
        echo "Error: " . $e->getMessage();
    }
} else if (isset($_POST['simpan-cek-harga'])) {
    $id_inv = base64_encode($_POST['id_inv']);
    $id_trx = $_POST['id_trx'];
    $harga_produk = $_POST['harga_produk'];
    $disc = $_POST['disc'];
    $update_status_trx = 1;

    // Mulai transaction
    mysqli_begin_transaction($connect);

    try {
        for ($i = 0; $i < count($id_trx); $i++) {
            $id_trx_array = $id_trx[$i];
            $harga =  str_replace(',', '', $harga_produk[$i]);
            $harga = intval($harga);
            $disc_array = $disc[$i];
            $update_status_trx_array = $update_status_trx;

            $update_data = mysqli_query($connect,  "UPDATE transaksi_produk_reg SET
                                                    harga = '$harga',
                                                    disc = '$disc_array',
                                                    status_trx = '$update_status_trx_array'
                                                    WHERE id_transaksi = '$id_trx_array'");
        }

        // Commit transaction jika semua query berhasil
        mysqli_commit($connect);
        $_SESSION['info'] = 'Diupdate';
        header("Location:../cek-produk-inv-nonppn.php?id='$id_inv'");
    } catch (Exception $e) {
        // Rollback transaction jika terjadi kesalahan
        mysqli_rollback($connect);
        $_SESSION['info'] = 'Silahkan Ulangi Kembali';
        header("Location:../cek-produk-inv-nonppn.php?id='$id_inv'");
    }
} else if (isset($_POST['update-harga'])) {
    $id_trx = $_POST['id_trx'];
    $id_inv = base64_encode($_POST['id_inv']);
    $harga_produk = $_POST['harga_produk'];
    $hrg = str_replace(',', '', $harga_produk); // Menghapus tanda ribuan (,)
    $hrg = intval($hrg); // Mengubah string harga menjadi integer

    $update_data = mysqli_query($connect, "UPDATE transaksi_produk_reg SET harga = '$hrg' WHERE id_transaksi = '$id_trx'");
    $_SESSION['info'] = 'Diupdate';
    header("Location:../cek-produk-inv-nonppn.php?id='$id_inv'");
}
