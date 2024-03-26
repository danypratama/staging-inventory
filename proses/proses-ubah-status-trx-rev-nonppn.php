<?php
    session_start();
    include("../koneksi.php");
    include "../page/resize-image.php";

    if(isset($_POST['ubah-status'])){
        $uuid = uuid();
        $day = date('d');
        $month = date('m');
        $year = date('y');
        $id_status_kirim_revisi = "SKREV-" . $year . "" . $month . "" . $uuid . "" . $day ;
        $id_trx_rev = "TRXREV-" . $year . "" . $month . "" . $uuid . "" . $day ;
        $id_inv_rev = "INVREV-" . $year . "" . $month . "" . $uuid . "" . $day ;
        $status_kirim = $_POST['status_kirim'];
        $id_komplain = $_POST['id_komplain'];
        $id_komplain_encode = base64_encode($id_komplain);
        $id_inv = $_POST['id_inv'];
        $no_inv = $_POST['no_inv'];
        $revisi_invoice = reviseInvoice($no_inv);
        $tgl = $_POST['tgl'];
        $cs_inv = $_POST['cs_inv'];
        $alamat = $_POST['alamat'];
        $total_inv = $_POST['total_inv'];
         
            if($status_kirim == 'dikirim'){
                $jenis_pengiriman = $_POST['jenis_pengiriman'];
                if($jenis_pengiriman == 'Driver'){
                    $pengirim = $_POST['pengirim'];
                     // Begin transaction
                    mysqli_begin_transaction($connect);

                    try{
                        $simapn_status_kirim = mysqli_query($connect,"INSERT INTO revisi_status_kirim (id_status_kirim_revisi, id_komplain, jenis_pengiriman, dikirim_driver, tgl_kirim) VALUES ('$id_status_kirim_revisi', '$id_komplain', '$jenis_pengiriman', '$pengirim', '$tgl')");

                        $simpan_inv_revisi = mysqli_query($connect,"INSERT INTO inv_revisi (id_inv_revisi, id_inv, no_inv_revisi, tgl_inv_revisi, pelanggan_revisi, alamat_revisi, total_inv, status_pengiriman, status_trx_komplain, status_trx_selesai) VALUES ('$id_inv_rev', '$id_inv', '$revisi_invoice', '$tgl', '$cs_inv', '$alamat', '$total_inv', '0', '0', '0')");


                        if (!$simapn_status_kirim && !$simpan_inv_revisi) {
                            throw new Exception("Error Insert Data");
                        }
                        // Commit the transaction
                        mysqli_commit($connect);
                        // Redirect to the invoice page
                        $_SESSION['info'] = 'Disimpan';
                        header("Location:../detail-komplain-revisi-nonppn.php?id=$id_komplain_encode");
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
                                        window.location.href = "../detail-komplain-revisi-nonppn.php?id=<?php echo $id_komplain_encode ?>";
                                    });
                                    });
                                </script>
                            <?php
                        } 
                } else if($jenis_pengiriman == 'Ekspedisi'){
                    $ekspedisi = $_POST['ekspedisi'];
                    $jenis_pengiriman = $_POST['jenis_pengiriman'];     
                    $resi = $_POST['resi'];
                    $jenis_ongkir = $_POST['jenis_ongkir'];
                    $ongkir = str_replace('.', '', $_POST['ongkir']); // Menghapus tanda ribuan (,)
                    $ongkir = intval($ongkir); // Mengubah string harga menjadi integer
                    $free_ongkir = $_POST['free_ongkir'];
                    $dikirim = $_POST['dikirim'];
                    $pj = $_POST['pj'];
                    $uuid = generate_uuid();
                    $img_uuid = img_uuid();
                    $year = date('y');
                    $day = date('d');
                    $month = date('m');
                    $id_inv_bukti = "BKTI" . $year . "". $month . "" . $uuid . "" . $day;
                    // Proses upload file
                    $file_name = $_FILES['fileku']['name'];
                    $file_tmp = $_FILES['fileku']['tmp_name'];
                    $file_destination = "../gambar-revisi/bukti1/" . $file_name;

                    move_uploaded_file($file_tmp, $file_destination);

                    mysqli_begin_transaction($connect);

                    try{
                        // Kompres dan ubah ukuran gambar bukti terima 1
                        $new_file_name = "Bukti_Satu". $year . "" . $month . "" . $img_uuid . "" . $day . ".jpg";
                        $compressed_file_destination = "../gambar-revisi/bukti1/$new_file_name";
                        compressAndResizeImage($file_destination, $compressed_file_destination, 500, 500, 100);
                        unlink($file_destination);   

                        // Proses simpan status kirim revisi
                        $simpan_status_kirim = mysqli_query($connect,"INSERT INTO revisi_status_kirim (id_status_kirim_revisi, id_komplain, jenis_pengiriman, jenis_penerima, dikirim_ekspedisi, no_resi, jenis_ongkir, ongkir, free_ongkir, dikirim_oleh, penanggung_jawab, tgl_kirim) VALUES ('$id_status_kirim_revisi', '$id_komplain', '$jenis_pengiriman', 'Ekspedisi', '$ekspedisi', '$resi', '$jenis_ongkir', '$ongkir', '$free_ongkir', '$dikirim', '$pj', '$tgl')");

                        // Proses simpan inv revisi
                        $simpan_inv_revisi = mysqli_query($connect,"INSERT INTO inv_revisi (id_inv_revisi, id_inv, no_inv_revisi, tgl_inv_revisi, pelanggan_revisi, alamat_revisi, total_inv, status_pengiriman, status_trx_komplain, status_trx_selesai) VALUES ('$id_inv_rev', '$id_inv', '$revisi_invoice', '$tgl', '$cs_inv', '$alamat', '$total_inv', '0', '0', '0')");

                        // Proses simpan bukti terima
                        $bukti_terima = mysqli_query($connect, "INSERT INTO inv_bukti_terima_revisi (id_bukti_terima, id_komplain, bukti_satu) VALUES ('$id_inv_bukti', '$id_komplain', '$new_file_name')");


                        if (!$simpan_status_kirim && !$simpan_inv_revisi && !$bukti_terima) {
                            throw new Exception("Error Insert Data");
                            unlink($file_destination);
                        } else {
                            // // Commit the transaction
                            mysqli_commit($connect);
                            // Redirect to the invoice page
                            $_SESSION['info'] = 'Disimpan';
                            header("Location:../detail-komplain-revisi-nonppn.php?id=$id_komplain_encode");
                            exit();
                        }
                    
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
                                    window.location.href = "../detail-komplain-revisi-nonppn.php?id=<?php echo $id_komplain_encode ?>";
                                });
                                });
                            </script>
                        <?php
                    } 
                } else if($jenis_pengiriman == 'Diambil Langsung'){
                    $diambil_oleh = $_POST['diambil_oleh'];
                    $uuid = generate_uuid();
                    $img_uuid = img_uuid();
                    $year = date('y');
                    $day = date('d');
                    $month = date('m');
                    $id_inv_bukti = "BKTI" . $year . "". $month . "" . $uuid . "" . $day;
                    $id_inv_penerima_revisi = "PNMR" . $year . "". $month . "" . $uuid . "" . $day;
                    // Proses upload file
                    $file_name = $_FILES['fileku']['name'];
                    $file_tmp = $_FILES['fileku']['tmp_name'];
                    $file_destination = "../gambar-revisi/bukti1/" . $file_name;

                    move_uploaded_file($file_tmp, $file_destination);
                    
                    // Begin transaction
                    mysqli_begin_transaction($connect);

                    try{
                        // Kompres dan ubah ukuran gambar bukti terima 1
                        $new_file_name = "Bukti_Satu". $year . "" . $month . "" . $img_uuid . "" . $day . ".jpg";
                        $compressed_file_destination = "../gambar-revisi/bukti1/$new_file_name";
                        compressAndResizeImage($file_destination, $compressed_file_destination, 500, 500, 100);
                        unlink($file_destination);

                        $simapn_status_kirim = mysqli_query($connect,"INSERT INTO revisi_status_kirim (id_status_kirim_revisi, id_komplain, jenis_pengiriman, diambil_oleh, tgl_kirim) VALUES ('$id_status_kirim_revisi', '$id_komplain', '$jenis_pengiriman', '$diambil_oleh', '$tgl')");

                        $simpan_inv_revisi = mysqli_query($connect,"INSERT INTO inv_revisi (id_inv_revisi, id_inv, no_inv_revisi, tgl_inv_revisi, pelanggan_revisi, alamat_revisi, total_inv, status_pengiriman, status_trx_komplain, status_trx_selesai) VALUES ('$id_inv_rev', '$id_inv', '$revisi_invoice', '$tgl', '$cs_inv', '$alamat', '$total_inv', '1', '1', '0')");

                        $bukti_terima = mysqli_query($connect, "INSERT INTO inv_bukti_terima_revisi (id_bukti_terima, id_komplain, bukti_satu) VALUES ('$id_inv_bukti', '$id_komplain', '$new_file_name')");

                        $query_diterima = mysqli_query($connect, "INSERT INTO inv_penerima_revisi (id_inv_penerima_revisi, id_komplain, nama_penerima, alamat, tgl_terima) VALUES ('$id_inv_penerima_revisi', '$id_komplain', '$diambil_oleh', 'PT. Karsa Mandiri Alkesindo', '$tgl')");


                        if (!$simpan_status_kirim && !$simpan_inv_revisi && !$bukti_terima) {
                            throw new Exception("Error Insert Data");
                            unlink($file_destination);
                        } else {
                            // // Commit the transaction
                            mysqli_commit($connect);
                            // Redirect to the invoice page
                            $_SESSION['info'] = 'Disimpan';
                            header("Location:../detail-komplain-revisi-nonppn.php?id=$id_komplain_encode");
                            exit();
                        }
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
                                    window.location.href = "../detail-komplain-revisi-nonppn.php?id=<?php echo $id_komplain_encode ?>";
                                });
                                });
                            </script>
                        <?php
                    } 
                    
                }
            } else if($status_kirim == 'selesai'){
                $connect->begin_transaction();

                try{
                    $year = date('y');
                    $day = date('d');
                    $month = date('m');
                    $uuid = uuid();
                    $id_komplain = $_POST['id_komplain'];
                    $id_komplain_encode = base64_encode($id_komplain);
                    $id_finance = "FINANCE" . $year . "". $month . "" . $uuid . "" . $day;
                    $id_inv = $_POST['id_inv'];
                    $jenis_inv = $_POST['jenis_inv'];
                    $total_inv = $_POST['total_inv'];

                    $update_inv = mysqli_query($connect, "UPDATE inv_nonppn SET status_transaksi = 'Komplain Selesai' WHERE id_inv_nonppn = '$id_inv'");

                    $create_finance = mysqli_query($connect, "INSERT INTO finance(id_finance, id_inv, total_inv, jenis_inv) VALUES ('$id_finance', '$id_inv', '$total_inv', '$jenis_inv')");

                    $update_inv_revisi = mysqli_query($connect, "UPDATE inv_revisi SET status_trx_selesai = '1' WHERE id_inv = '$id_inv'");

                    $update_inv_komplain = mysqli_query($connect, "UPDATE inv_komplain SET status_komplain = '1' WHERE id_komplain = '$id_komplain'");

                    $query_history_produk = mysqli_query($connect, "INSERT IGNORE INTO 
                                                            history_produk_terjual (id_trx_history, id_inv, id_produk, qty)
                                                        SELECT
                                                            tpr.id_tmp,
                                                            tpr.id_inv,
                                                            tpr.id_produk,
                                                            tpr.qty
                                                        FROM tmp_produk_komplain AS tpr
                                                        WHERE tpr.id_inv = '$id_inv'");

                    if ($update_inv && $create_finance && $update_inv_revisi && $update_inv_komplain && $query_history_produk) {
                        // Commit transaksi
                        $connect->commit();
                        ?>
                        <!-- Sweet Alert -->
                        <link rel="stylesheet" href="../assets/sweet-alert/dist/sweetalert2.min.css">
                        <script src="../assets/sweet-alert/dist/sweetalert2.all.min.js"></script>
                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                            Swal.fire({
                                title: "Success",
                                text: "Data Berhasil Disimpan",
                                icon: "success",
                            }).then(function() {
                                window.location.href = "../detail-komplain-revisi-nonppn.php?id=<?php echo $id_komplain_encode ?>";
                            });
                            });
                        </script>
                    <?php
                    }
                }catch (Exception $e) {
                    // Rollback transaksi jika terjadi exception
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
                            window.location.href = "../detail-komplain-revisi-nonppn.php?id=<?php echo $id_komplain_encode ?>";
                        });
                        });
                    </script>
                    <?php
                }
            }
    }

    function uuid() {
        $data = openssl_random_pseudo_bytes(16);
        assert(strlen($data) == 16);
    
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
    
        return vsprintf('%s%s', str_split(bin2hex($data), 4));
    }

    function reviseInvoice($invoice) {
        // Mencocokkan pola nomor invoice
        if (preg_match('/^(\d+)(\/Rev(\d+))?\/(\w+)\/(\w+)\/(\d+)$/', $invoice, $matches)) {
            $prefix = $matches[1];
            $revision = isset($matches[3]) ? intval($matches[3]) + 1 : 1;
            $part1 = $matches[4];
            $part2 = $matches[5];
            $year = $matches[6];
    
            $revisedInvoice = "$prefix/Rev$revision/$part1/$part2/$year";
            return $revisedInvoice;
        }
        // Jika pola tidak cocok, tambahkan revisi pertama
        return preg_replace('/(\d+)\/(\w+)\/(\w+)\/(\d+)/', '$1/Rev1/$2/$3/$4', $invoice);
    }
    // Kode untuk menampilkan hasil kode
    // $no_invoice = "004/Rev5/KM/X/2023";
    // $revised_invoice = reviseInvoice($no_invoice);
    
    // echo "Nomor Invoice Asli: $no_invoice<br>";
    // echo "Nomor Invoice Revisi: $revised_invoice";

    function img_uuid() {
        $data = openssl_random_pseudo_bytes(16);
        assert(strlen($data) == 16);

        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

        return vsprintf('%s%s', str_split(bin2hex($data), 4));
    }

    // generate UUID
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