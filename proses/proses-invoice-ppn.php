<?php
session_start();
include "../koneksi.php";
include "../page/resize-image.php";

if (isset($_POST['simpan-inv'])) {
    // Ambil data dari form dan lakukan sanitasi
    $id_spk = $_POST['id_spk'];
    $id_spk_escaped = array();
    
    // Escape each element of the $id_spk array
    foreach ($id_spk as $value) {
        $id_spk_escaped[] = mysqli_real_escape_string($connect, $value);
    }
    $id_inv_ppn = mysqli_real_escape_string($connect, $_POST['id_inv_ppn']);
    $no_inv_ppn = mysqli_real_escape_string($connect, $_POST['no_inv_ppn']);
    $tgl_inv = mysqli_real_escape_string($connect, $_POST['tgl_inv']);
    $cs = mysqli_real_escape_string($connect, $_POST['cs']);
    $cs_inv = mysqli_real_escape_string($connect, $_POST['cs_inv']);
    $jenis_inv = mysqli_real_escape_string($connect, $_POST['jenis_inv']);
    $tgl_tempo = mysqli_real_escape_string($connect, $_POST['tgl_tempo']);
    $no_po = mysqli_real_escape_string($connect, $_POST['no_po']);
    $sp_disc = mysqli_real_escape_string($connect, $_POST['sp_disc']);
    $note_inv = mysqli_real_escape_string($connect, $_POST['note_inv']);
    $ongkir = str_replace(',', '', $_POST['ongkir']); // Menghapus tanda ribuan (,)
    $ongkir = intval($ongkir); // Mengubah string harga menjadi integer
    $status_inv = 'Belum Dikirim';
    $status_spk = 'Invoice Sudah Diterbitkan';
    $user = mysqli_real_escape_string($connect, $_SESSION['tiket_nama']);
    $id_inv_ppn_encode = base64_encode($id_inv_ppn);
    $nama_invoice = 'Invoice_Non_PPN';
    $kwitansi = $_POST['kwitansi'];
    $surat_jalan = $_POST['surat_jalan'];

    // Begin transaction
    mysqli_begin_transaction($connect);

    try {
        // Insert invoice data into the database
        $sql_inv = mysqli_query($connect, "INSERT INTO inv_ppn 
            (id_inv_ppn, no_inv, tgl_inv, cs_inv, tgl_tempo, sp_disc, kwitansi, surat_jalan, note_inv, kategori_inv, ongkir, status_transaksi, nama_invoice, user_created)
            VALUES
            ('$id_inv_ppn', '$no_inv_ppn', '$tgl_inv', '$cs_inv', '$tgl_tempo', '$sp_disc', '$kwitansi', '$surat_jalan', '$note_inv', '$jenis_inv', '$ongkir', '$status_inv', '$nama_invoice', '$user')");

        // Convert $no_inv_ppn to the desired format
        $no_inv_ppn_converted = str_replace('/', '_', $no_inv_ppn);

        // Generate folder name based on invoice details
        $folder_name = $no_inv_ppn_converted;

        // Encode a portion of the folder name
        $encoded_portion = base64_encode($folder_name);

        // Combine the original $no_inv_ppn, encoded portion, and underscore
        $encoded_folder_name = $no_inv_ppn_converted . '_' . $encoded_portion;

        // Set the path for the customer's folder
        $customer_folder_path = "../Customer/" . $cs . "/" . date('Y') . "/" . date('m') . "/" . date('d') . "/" . ucwords(strtolower(str_replace('_', ' ', $nama_invoice))) . "/" . $encoded_folder_name;

        // Create the customer's folder if it doesn't exist
        if (!is_dir($customer_folder_path)) {
            mkdir($customer_folder_path, 0777, true); // Set permission to 0777 to ensure the folder is writable
        }

        // Update SPK data in the database
        $id_spk_count = count($id_spk_escaped);
        for ($i = 0; $i < $id_spk_count; $i++) {
            $id_spk_array = $id_spk_escaped[$i];
            $sql_spk = mysqli_query($connect, "UPDATE spk_reg SET id_inv = '$id_inv_ppn', no_po = '$no_po', status_spk = '$status_spk' WHERE id_spk_reg = '$id_spk_array'");

            if (!$sql_spk) {
                throw new Exception("Error updating SPK data");
            }
        }

        // Commit the transaction
        mysqli_commit($connect);
        echo $sql_inv;

        // Redirect to the invoice page
        header("Location:../cek-produk-inv-ppn.php?id=$id_inv_ppn_encode");
        exit();
    } catch (Exception $e) {
        // Rollback the transaction if an error occurs
        mysqli_rollback($connect);
        // Handle the error (e.g., display an error message)
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
                    window.location.href = "../cek-produk-inv-ppn.php?id=$id_inv_ppn_encode";
                });
                });
            </script>
            <?php
        }


} else if (isset($_POST['simpan-cek-harga'])) {
    $id_inv = base64_encode($_POST['id_inv']);
    $id_trx = $_POST['id_trx'];
    $nama_produk = $_POST['nama_produk'];
    $harga_produk = $_POST['harga_produk'];
    $disc = $_POST['disc'];
    $qty = $_POST['qty'];
    $update_status_trx = 1;

    // Mulai transaction
    mysqli_begin_transaction($connect);

    try {
        for ($i = 0; $i < count($id_trx); $i++) {
            $id_trx_array = $id_trx[$i];
            $nama_produk_array = $nama_produk[$i];
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
                                                    nama_produk_spk = '$nama_produk_array',
                                                    harga = '$harga',
                                                    disc = '$disc_array',
                                                    total_harga = '$total_final',
                                                    status_trx = '$update_status_trx_array'
                                                    WHERE id_transaksi = '$id_trx_array'");
        }

        // Commit transaction jika semua query berhasil
        mysqli_commit($connect);
        header("Location:../cek-produk-inv-ppn.php?id='$id_inv'");
    } catch (Exception $e) {
        // Rollback transaction jika terjadi kesalahan
        mysqli_rollback($connect);
        header("Location:../cek-produk-inv-ppn.php?id='$id_inv'");
    }
} else if (isset($_POST['update-harga'])) {
    $id_trx = $_POST['id_trx'];
    $id_inv = base64_encode($_POST['id_inv']);
    $nama_produk = $_POST['nama_produk'];
    $harga_produk = $_POST['harga_produk'];
    $qty_produk = $_POST['qty'];
    $hrg = str_replace(',', '', $harga_produk); // Menghapus tanda ribuan (,)
    $hrg = intval($hrg); // Mengubah string harga menjadi integer
    $qty = str_replace(',', '', $qty_produk); // Menghapus tanda ribuan (,)
    $qty = intval($qty); // Mengubah string harga menjadi integer
    $total = $hrg * $qty;

    $update_data = mysqli_query($connect, "UPDATE transaksi_produk_reg SET nama_produk_spk = '$nama_produk', harga = '$hrg', total_harga = '$total' WHERE id_transaksi = '$id_trx'");
    header("Location:../cek-produk-inv-ppn.php?id='$id_inv'");
    // =======================================
} else if (isset($_POST['update-harga-diskon'])) {
    $id_trx = $_POST['id_trx'];
    $id_inv = $_POST['id_inv'];
    $id_inv_encode = base64_encode($id_inv);
    $nama_produk = $_POST['nama_produk'];
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

    $update_data = mysqli_query($connect, "UPDATE transaksi_produk_reg SET nama_produk_spk = '$nama_produk', harga = '$hrg', disc = '$disc_tampil', total_harga = '$grand_total' WHERE id_transaksi = '$id_trx'");
    header("Location:../cek-produk-inv-ppn.php?id='$id_inv_encode'");
    // =============================
} else if (isset($_POST['ubah-kategori'])) {
    $id_inv = $_POST['id_inv'];
    $id_inv_encode = base64_encode($id_inv);
    $kat_inv = $_POST['kat_inv'];
    mysqli_query($connect, "UPDATE inv_ppn SET kategori_inv = '$kat_inv', sp_disc = '0' WHERE id_inv_ppn = '$id_inv'");
    mysqli_query($connect, "UPDATE transaksi_produk_reg AS tpr
                            JOIN spk_reg AS sr ON (tpr.id_spk = sr.id_spk_reg)
                            JOIN inv_ppn AS ppn ON (sr.id_inv = ppn.id_inv_ppn)
                            SET tpr.disc = '0',
                                tpr.total_harga = tpr.harga * tpr.qty
                            WHERE ppn.id_inv_ppn = '$id_inv';
                            ");
    header("Location: ../cek-produk-inv-ppn.php?id=$id_inv_encode");
    // =================================
} else if (isset($_POST['ubah-sp'])) {
    $id_inv = $_POST['id_inv'];
    $id_inv_encode = base64_encode($id_inv);
    $spdisc = $_POST['spdisc'];
    mysqli_query($connect, "UPDATE inv_ppn SET sp_disc = '$spdisc' WHERE id_inv_ppn = '$id_inv'");
    header("Location: ../cek-produk-inv-ppn.php?id=$id_inv_encode");
} else if (isset($_POST['add-spk'])) {
    $id_spk = $_POST['id_spk'];
    $id_inv = $_POST['id_inv'];
    $id_inv_encode = base64_encode($id_inv);
    $status_spk = 'Invoice Sudah Diterbitkan';

    for ($i = 0; $i < count($id_spk); $i++) {
        $id_spk_array = $_POST['id_spk'][$i];

        mysqli_query($connect, "UPDATE spk_reg SET id_inv = '$id_inv', status_spk = '$status_spk'  WHERE id_spk_reg = '$id_spk_array'");
        mysqli_query($connect, "UPDATE transaksi_produk_reg SET status_trx = '0'  WHERE id_spk = '$id_spk_array'");

        header("Location:../cek-produk-inv-ppn.php?id='$id_inv_encode'");
    }
} else if (isset($_POST['ubah-dikirim'])) {
    // Mulai transaksi
    mysqli_begin_transaction($connect);

    try {
        $id_status = $_POST['id_status'];
        $id_inv = $_POST['id_inv'];
        $jenis_pengiriman = $_POST['jenis_pengiriman'];
        $tgl = $_POST['tgl'];
        $jenis_inv = "ppn";
        $uuid = generate_uuid();
        $img_uuid = img_uuid();
        $year = date('y');
        $day = date('d');
        $month = date('m');
        $id_inv_penerima = "BKTI" . $year . "" . $uuid . "" . $day;
        $id_inv = $_POST['id_inv'];
       

        if ($jenis_pengiriman == 'Driver') { 
            $pengirim = $_POST['pengirim'];

            $ubah_status = mysqli_query($connect, "UPDATE inv_ppn SET status_transaksi = 'Dikirim' WHERE id_inv_ppn = '$id_inv'");

            $status_kirim = mysqli_query($connect, "INSERT INTO status_kirim
                                                    (id_status_kirim, id_inv, jenis_inv, jenis_pengiriman, dikirim_driver, tgl_kirim)
                                                    VALUES 
                                                    ('$id_status', '$id_inv', '$jenis_inv', '$jenis_pengiriman', '$pengirim', '$tgl')");

            if ($ubah_status && $status_kirim) {
                // Commit transaksi jika berhasil
                mysqli_commit($connect);
                header("Location:../invoice-reguler.php?sort=baru");
            }
        } else if ($jenis_pengiriman == 'Diambil Langsung'){
            $diambil = $_POST['diambil'];
            $uuid = generate_uuid();
            $year = date('y');
            $day = date('d');
            $month = date('m');
            $id_inv_penerima = "PNMR" . $year . "". $month . "" . $uuid . "" . $day;


            $ubah_status = mysqli_query($connect, "UPDATE inv_ppn SET status_transaksi = 'Dikirim' WHERE id_inv_ppn = '$id_inv'");

            $status_kirim = mysqli_query($connect, "INSERT INTO status_kirim
                                                    (id_status_kirim, id_inv, jenis_inv, jenis_pengiriman, jenis_penerima, tgl_kirim)
                                                    VALUES 
                                                    ('$id_status', '$id_inv', '$jenis_inv', '$jenis_pengiriman', 'Customer', '$tgl')");
            
            $query_diterima = mysqli_query($connect, "INSERT INTO inv_penerima 
                                                        (id_inv_penerima, id_inv, alamat) 
                                                        VALUES 
                                                        ('$id_inv_penerima', '$id_inv', 'PT. Karsa Mandiri Alkesindo')");
        

            if ($ubah_status && $status_kirim && $query_diterima) {
                // Commit transaksi jika berhasil
                mysqli_commit($connect);
                header("Location:../invoice-reguler.php?sort=baru");
            }

        } else {
            $ekspedisi = $_POST['ekspedisi'];
            $resi = $_POST['resi'];
            $jenis_penerima = 'Ekspedisi';
            $jenis_ongkir = $_POST['jenis_ongkir'];
            $ongkir = str_replace(',', '', $_POST['ongkir']); // Menghapus tanda ribuan (,)
            $ongkir = intval($ongkir); // Mengubah string harga menjadi integer
            $dikirim = $_POST['dikirim'];
            $pj = $_POST['pj'];

            $ubah_status = mysqli_query($connect, "UPDATE inv_ppn SET status_transaksi = 'Dikirim', ongkir = '$ongkir' WHERE id_inv_ppn = '$id_inv'");

            $status_kirim = mysqli_query($connect, "INSERT INTO status_kirim
                                                            (id_status_kirim, id_inv, jenis_inv, jenis_pengiriman, jenis_penerima, dikirim_ekspedisi, dikirim_oleh, penanggung_jawab, tgl_kirim) 
                                                            VALUES 
                                                            ('$id_status', '$id_inv', '$jenis_inv', '$jenis_pengiriman', '$jenis_penerima', '$ekspedisi', '$dikirim', '$pj', '$tgl')");
            
            if ($ubah_status && $status_kirim) {
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

    $update_data = mysqli_query($connect, "UPDATE inv_ppn SET ongkir = '$ongkir' WHERE id_inv_ppn = '$id_inv'");
    header("Location:../cek-produk-inv-ppn.php?id='$id_inv_encode'");
} else if (isset($_POST['ubah-cs-inv'])) {
    $id_inv = $_POST['id_inv'];
    $cs_inv = $_POST['cs_inv'];
    $no_po = $_POST['no_po'];
    $id_inv_encode = base64_encode($id_inv);

    $update_data = mysqli_query($connect, "UPDATE inv_ppn SET cs_inv = '$cs_inv' WHERE id_inv_ppn = '$id_inv'");
    $update_data_spk = mysqli_query($connect, "UPDATE spk_reg SET no_po = '$no_po' WHERE id_inv = '$id_inv'");
    header("Location:../cek-produk-inv-ppn.php?id=$id_inv_encode");
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


function img_uuid() {
    $data = openssl_random_pseudo_bytes(16);
    assert(strlen($data) == 16);

    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

    return vsprintf('%s%s', str_split(bin2hex($data), 4));
}
?>