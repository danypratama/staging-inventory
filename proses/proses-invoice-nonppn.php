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
        $sql_inv = mysqli_query($connect, "INSERT INTO inv_nonppn 
                                            (id_inv_nonppn, no_inv, tgl_inv, cs_inv, tgl_tempo, sp_disc, note_inv, kategori_inv, ongkir, status_transaksi, user_created)
                                            VALUES
                                            ('$id_inv_nonppn', '$no_inv_nonppn', '$tgl_inv', '$cs_inv', '$tgl_tempo', '$sp_disc', '$note_inv', '$jenis_inv', '$ongkir', '$status_inv', '$user')");
        for ($i = 0; $i < count($id_spk); $i++) {
            $id_spk_array = $_POST['id_spk'][$i];
            $sql = mysqli_query($connect, "UPDATE spk_reg SET id_inv = '$id_inv_nonppn', status_spk = '$status_spk' WHERE id_spk_reg = '$id_spk_array'");

            if (!$sql) {
                $success = false;
                break;
            }

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
    $qty = $_POST['qty'];
    $update_status_trx = 1;

    // Mulai transaction
    mysqli_begin_transaction($connect);

    try {
        for ($i = 0; $i < count($id_trx); $i++) {
            $id_trx_array = $id_trx[$i];
            $harga =  str_replace(',', '', $harga_produk[$i]);
            $harga = intval($harga);
            $disc_array = $disc[$i];
            $qty_array = str_replace(',', '', $qty[$i]);
            $qty_array = intval($qty_array);
            $update_status_trx_array = $update_status_trx;

            $diskon = $disc_array / 100;
            $harga_disc = $harga * $diskon;
            $total = $harga * $qty_array;
            $total_akhir = $total * $diskon;
            $total_final = $total - $total_akhir;

            $update_data = mysqli_query($connect,  "UPDATE transaksi_produk_reg SET
                                                    harga = '$harga',
                                                    disc = '$disc_array',
                                                    total_harga = '$total_final',
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
    $qty_produk = $_POST['qty'];
    $hrg = str_replace(',', '', $harga_produk); // Menghapus tanda ribuan (,)
    $hrg = intval($hrg); // Mengubah string harga menjadi integer
    $qty = str_replace(',', '', $qty_produk); // Menghapus tanda ribuan (,)
    $qty = intval($qty); // Mengubah string harga menjadi integer
    $total = $hrg * $qty;

    $update_data = mysqli_query($connect, "UPDATE transaksi_produk_reg SET harga = '$hrg', total_harga = '$total' WHERE id_transaksi = '$id_trx'");
    $_SESSION['info'] = 'Diupdate';
    header("Location:../cek-produk-inv-nonppn.php?id='$id_inv'");
    // =======================================
} else if (isset($_POST['update-harga-diskon'])) {
    $id_trx = $_POST['id_trx'];
    $id_inv = $_POST['id_inv'];
    $id_inv_encode = base64_encode($id_inv);
    $disc_tampil = $_POST['disc'];
    $disc = $_POST['disc'] / 100;
    $qty_produk = $_POST['qty'];
    $harga_produk = $_POST['harga_produk'];
    $hrg = str_replace(',', '', $harga_produk); // Menghapus tanda ribuan (,)
    $hrg = intval($hrg); // Mengubah string harga menjadi integer
    $qty = str_replace(',', '', $qty_produk); // Menghapus tanda ribuan (,)
    $qty = intval($qty); // Mengubah string harga menjadi integer
    $total = $hrg * $qty;
    $total_disc = $total * $disc;
    $grand_total = $total - $total_disc;

    $update_data = mysqli_query($connect, "UPDATE transaksi_produk_reg SET harga = '$hrg', disc = '$disc_tampil', total_harga = '$grand_total' WHERE id_transaksi = '$id_trx'");
    header("Location:../cek-produk-inv-nonppn.php?id='$id_inv_encode'");
    // ==========================
} else if (isset($_POST['ubah-kategori'])) {
    $id_inv = $_POST['id_inv'];
    $id_inv_encode = base64_encode($id_inv);
    $kat_inv = $_POST['kat_inv'];
    mysqli_query($connect, "UPDATE inv_nonppn SET kategori_inv = '$kat_inv', sp_disc = '0' WHERE id_inv_nonppn = '$id_inv'");
    mysqli_query($connect, "UPDATE transaksi_produk_reg AS tpr
                            JOIN spk_reg AS sr ON (tpr.id_spk = sr.id_spk_reg)
                            JOIN inv_nonppn AS nonppn ON (sr.id_inv = nonppn.id_inv_nonppn)
                            SET tpr.disc = '0',
                                tpr.total_harga = tpr.harga * tpr.qty
                            WHERE nonppn.id_inv_nonppn = '$id_inv';
                            
                                                    ");
    header("Location:../cek-produk-inv-nonppn.php?id='$id_inv_encode'");
    // =================================
} else if (isset($_POST['ubah-sp'])) {
    $id_inv = $_POST['id_inv'];
    $id_inv_encode = base64_encode($id_inv);
    $spdisc = $_POST['spdisc'];
    mysqli_query($connect, "UPDATE inv_nonppn SET sp_disc = '$spdisc' WHERE id_inv_nonppn = '$id_inv'");
    header("Location:../cek-produk-inv-nonppn.php?id='$id_inv_encode'");
}
