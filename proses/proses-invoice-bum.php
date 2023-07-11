<?php
session_start();
include "../koneksi.php";

if (isset($_POST['simpan-inv'])) {
    $id_spk = $_POST['id_spk'];
    $id_inv_bum = $_POST['id_inv_bum'];
    $no_inv_bum = $_POST['no_inv_bum'];
    $tgl_inv = $_POST['tgl_inv'];
    $cs = $_POST['cs'];
    $cs_inv = $_POST['cs_inv'];
    $jenis_inv = $_POST['jenis_inv'];
    $tgl_tempo = $_POST['tgl_tempo'];
    $sp_disc = $_POST['sp_disc'];
    $note_inv = $_POST['note_inv'];
    $ongkir = str_replace(',', '', $_POST['ongkir']); // Menghapus tanda ribuan (,)
    $ongkir = intval($ongkir); // Mengubah string harga menjadi integer
    $status_inv = 'Belum Dikirim';
    $status_spk = 'Invoice Sudah Diterbitkan';
    $user = $_SESSION['tiket_nama'];
    $id_inv_bum_encode = base64_encode($id_inv_bum);

    // Mulai transaksi
    // Mulai transaksi
    mysqli_begin_transaction($connect);

    try {
        $success = true;
        $sql_inv = mysqli_query($connect, "INSERT INTO inv_bum 
                                            (id_inv_bum, no_inv, tgl_inv, cs_inv, tgl_tempo, sp_disc, note_inv, kategori_inv, ongkir, status_transaksi, user_created)
                                            VALUES
                                            ('$id_inv_bum', '$no_inv_bum', '$tgl_inv', '$cs_inv', '$tgl_tempo', '$sp_disc', '$note_inv', '$jenis_inv', '$ongkir', '$status_inv', '$user')");
        for ($i = 0; $i < count($id_spk); $i++) {
            $id_spk_array = $_POST['id_spk'][$i];
            $sql = mysqli_query($connect, "UPDATE spk_reg SET id_inv = '$id_inv_bum', status_spk = '$status_spk' WHERE id_spk_reg = '$id_spk_array'");

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
            header("Location:../cek-produk-inv-bum.php?id='$id_inv_bum_encode'");
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
        header("Location:../cek-produk-inv-bum.php?id='$id_inv'");
    } catch (Exception $e) {
        // Rollback transaction jika terjadi kesalahan
        mysqli_rollback($connect);
        header("Location:../cek-produk-inv-bum.php?id='$id_inv'");
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
    header("Location:../cek-produk-inv-bum.php?id='$id_inv'");
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
    header("Location:../cek-produk-inv-bum.php?id='$id_inv_encode'");
    // ==========================
} else if (isset($_POST['ubah-kategori'])) {
    $id_inv = $_POST['id_inv'];
    $id_inv_encode = base64_encode($id_inv);
    $kat_inv = $_POST['kat_inv'];
    mysqli_query($connect, "UPDATE inv_bum SET kategori_inv = '$kat_inv', sp_disc = '0' WHERE id_inv_bum = '$id_inv'");
    mysqli_query($connect, "UPDATE transaksi_produk_reg AS tpr
                            JOIN spk_reg AS sr ON (tpr.id_spk = sr.id_spk_reg)
                            JOIN inv_bum AS bum ON (sr.id_inv = bum.id_inv_bum)
                            SET tpr.disc = '0',
                                tpr.total_harga = tpr.harga * tpr.qty
                            WHERE bum.id_inv_bum = '$id_inv';
                            
                                                    ");
    header("Location:../cek-produk-inv-bum.php?id='$id_inv_encode'");
    // =================================
} else if (isset($_POST['ubah-sp'])) {
    $id_inv = $_POST['id_inv'];
    $id_inv_encode = base64_encode($id_inv);
    $spdisc = $_POST['spdisc'];
    mysqli_query($connect, "UPDATE inv_bum SET sp_disc = '$spdisc' WHERE id_inv_bum = '$id_inv'");
    header("Location:../cek-produk-inv-bum.php?id='$id_inv_encode'");
} else if (isset($_POST['add-spk'])) {
    $id_spk = $_POST['id_spk'];
    $id_inv = $_POST['id_inv'];
    $id_inv_encode = base64_encode($id_inv);
    $status_spk = 'Invoice Sudah Diterbitkan';

    for ($i = 0; $i < count($id_spk); $i++) {
        $id_spk_array = $_POST['id_spk'][$i];

        mysqli_query($connect, "UPDATE spk_reg SET id_inv = '$id_inv', status_spk = '$status_spk'  WHERE id_spk_reg = '$id_spk_array'");
        mysqli_query($connect, "UPDATE transaksi_produk_reg SET status_trx = '1'  WHERE id_spk = '$id_spk_array'");

        header("Location:../cek-produk-inv-bum.php?id='$id_inv_encode'");
    }
} else if (isset($_POST['ubah-dikirim'])) {
    // Mulai transaksi
    mysqli_begin_transaction($connect);

    try {
        $id_status = $_POST['id_status'];
        $id_inv = $_POST['id_inv'];
        $jenis_pengiriman = $_POST['jenis_pengiriman'];
        $tgl = $_POST['tgl'];
        $jenis_inv = "bum";

        $uuid = generate_uuid();
        $year = date('y');
        $day = date('d');
        $month = date('m');
        $id_inv_penerima = "BKTI" . $year . "" . $uuid . "" . $day;
        $id_inv = $_POST['id_inv'];
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
        if ($jenis_pengiriman == 'Driver') {
            $pengirim = $_POST['pengirim'];


            $ubah_status = mysqli_query($connect, "UPDATE inv_bum SET status_transaksi = 'Dikirim' WHERE id_inv_bum = '$id_inv'");

            $status_kirim = mysqli_query($connect, "INSERT INTO status_kirim
                                                    (id_status_kirim, id_inv, jenis_inv, jenis_pengiriman, dikirim_driver, tgl_kirim)
                                                    VALUES 
                                                    ('$id_status', '$id_inv', '$jenis_inv', '$jenis_pengiriman', '$pengirim', '$tgl')");

            if ($ubah_status && $status_kirim) {
                // Commit transaksi jika berhasil
                mysqli_commit($connect);
                header("Location:../invoice-reguler.php?sort=baru");
            }
        } else {
            $ekspedisi = $_POST['ekspedisi'];
            $resi = $_POST['resi'];

            $ubah_status = mysqli_query($connect, "UPDATE inv_bum SET status_transaksi = 'Dikirim' WHERE id_inv_bum = '$id_inv'");

            $status_kirim = mysqli_query($connect, "INSERT INTO status_kirim
                                                        (id_status_kirim, id_inv, jenis_inv, jenis_pengiriman, dikirim_ekspedisi, no_resi, tgl_kirim) 
                                                        VALUES 
                                                        ('$id_status', '$id_inv', '$jenis_inv', '$jenis_pengiriman', '$ekspedisi', '$resi', '$tgl')");

            $bukti_terima = mysqli_query($connect, "INSERT INTO inv_bukti_terima (id_bukti_terima, id_inv, bukti_satu, bukti_dua, bukti_tiga) VALUES ('$id_inv_penerima', '$id_inv', '$file1_name', '$file2_name', '$file3_name')");

            if ($ubah_status && $status_kirim && $bukti_terima) {
                // Commit transaksi jika berhasil
                mysqli_commit($connect);
                header("Location:../invoice-reguler.php?sort=baru");
            }
        }
    } catch (Exception $e) {
        $connect->rollback();
        $error_message = "Terjadi kesalahan saat melakukan transaksi: " . $e->getMessage();
?>
        <!-- Sweet Alert -->
        <link rel="stylesheet" href="../assets/sweet-alert/dist/sweetalert2.min.css">
        <script src="../assets/sweet-alert/dist/sweetalert2.all.min.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: "Error!",
                    text: "<?php echo $error_message; ?>",
                    icon: "error",
                }).then(function() {
                    window.location.href = "../invoice-reguler.php?sort=baru";
                });
            });
        </script>
<?php
    }
} else if (isset($_POST['update-ongkir'])) {
    $id_inv = $_POST['id_inv'];
    $id_inv_encode = base64_encode($id_inv);
    $ongkir = str_replace(',', '', $_POST['ongkir']); // Menghapus tanda ribuan (,)
    $ongkir = intval($ongkir); // Mengubah string harga menjadi integer

    $update_data = mysqli_query($connect, "UPDATE inv_bum SET ongkir = '$ongkir' WHERE id_inv_bum = '$id_inv'");
    header("Location:../cek-produk-inv-bum.php?id='$id_inv_encode'");
}
?>

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