<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Inventory KMA</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
</head>

<body>
    <main id="main" class="main">
        <section>
            <?php
            session_start();
            include "../koneksi.php";
            include "../page/resize-image.php";

            if(isset($_POST['diterima_driver'])){
                $diterima_oleh = $_POST['diterima_oleh'];
                if($diterima_oleh == 'Customer'){
                    $kondisi_pesanan = $_POST['kondisi'];
                    if($kondisi_pesanan == 'sesuai'){
                        $connect->begin_transaction();
                        try{
                            $uuid = generate_uuid();
                            $img_uuid = img_uuid();
                            $year = date('y');
                            $day = date('d');
                            $month = date('m');
                            $id_inv_bukti = "BKTI" . $year . "". $month . "" . $uuid . "" . $day;
                            $id_inv_penerima_revisi = "PNMR" . $year . "". $month . "" . $uuid . "" . $day;
                            $id_inv = $_POST['id_inv'];
                            $id_komplain = $_POST['id_komplain'];
                            $alamat = $_POST['alamat'];
                            $nama_penerima = $_POST['nama_penerima'];
                            $tgl = $_POST['tgl'];

                            $file1_name = $_FILES['fileku1']['name'];
                            $file1_tmp = $_FILES['fileku1']['tmp_name'];
                            $file1_destination = "../../gambar-revisi/bukti1/" . $file1_name;

                            // Mendapatkan informasi file bukti terima 2
                            $file2_name = $_FILES['fileku2']['name'];
                            $file2_tmp = $_FILES['fileku2']['tmp_name'];
                            $file2_destination = "../../gambar-revisi/bukti2/" . $file2_name;

                            // Mendapatkan informasi file bukti terima 3
                            $file3_name = $_FILES['fileku3']['name'];
                            $file3_tmp = $_FILES['fileku3']['tmp_name'];
                            $file3_destination = "../../gambar-revisi/bukti3/" . $file3_name;

                            // Pindahkan file bukti terima ke lokasi tujuan
                            move_uploaded_file($file1_tmp, $file1_destination);
                            move_uploaded_file($file2_tmp, $file2_destination);
                            move_uploaded_file($file3_tmp, $file3_destination);

                            $new_file1_name = "Bukti_Satu". $year . "" . $month . "" . $img_uuid . "" . $day . ".jpg";
                            $new_file2_name = "Bukti_Dua". $year . "" . $month . "" . $img_uuid . "" . $day . ".jpg";
                            $new_file3_name = "Bukti_Tiga". $year . "" . $month . "" . $img_uuid . "" . $day . ".jpg";

                            if($file1_name != '' && $file2_name != '' &&  $file3_name != ''){
                                // Kompres dan ubah ukuran gambar-revisi bukti terima 1
                                $compressed_file1_destination = "../../gambar-revisi/bukti1/$new_file1_name";
                                compressAndResizeImage($file1_destination, $compressed_file1_destination, 500, 500, 100);
                                unlink($file1_destination);

                                // Kompres dan ubah ukuran gambar-revisi bukti terima 2
                                $compressed_file2_destination = "../../gambar-revisi/bukti2/$new_file2_name";
                                compressAndResizeImage($file2_destination, $compressed_file2_destination, 500, 500, 100);
                                unlink($file2_destination);

                                // Kompres dan ubah ukuran gambar-revisi bukti terima 3
                                $compressed_file3_destination = "../../gambar-revisi/bukti3/$new_file3_name";
                                compressAndResizeImage($file3_destination, $compressed_file3_destination, 500, 500, 100);
                                unlink($file3_destination);

                                $bukti_terima = mysqli_query($connect, "INSERT INTO inv_bukti_terima_revisi (id_bukti_terima, id_komplain, bukti_satu, bukti_dua, bukti_tiga) VALUES ('$id_inv_bukti', '$id_komplain', '$new_file1_name', '$new_file2_name', '$new_file3_name')");

                               $query_diterima = mysqli_query($connect, "INSERT INTO inv_penerima_revisi (id_inv_penerima_revisi, id_komplain, nama_penerima, alamat, tgl_terima) VALUES ('$id_inv_penerima_revisi', '$id_komplain', '$nama_penerima', '$alamat', '$tgl')");
                    
                                $query_update_inv = mysqli_query($connect, "UPDATE inv_nonppn SET status_transaksi = 'Diterima' WHERE id_inv_nonppn = '$id_inv'");

                                $query_update_status = mysqli_query($connect, "UPDATE revisi_status_kirim SET jenis_penerima = 'Customer' WHERE id_komplain = '$id_komplain'");

                                 $query_inv_revisi = mysqli_query($connect, "UPDATE inv_revisi SET status_pengiriman = '1', status_trx_komplain = '1' WHERE id_inv = '$id_inv'");
                    
                                if ( $bukti_terima && $query_diterima && $query_update_inv && $query_update_status && $query_inv_revisi ) {
                                    // Commit transaksi
                                    $connect->commit();
                                    ?>
                                    <!-- Sweet Alert -->
                                    <link rel="stylesheet" href="../assets/sweet-alert/dist/sweetalert2.min.css">
                                    <script src="../assets/sweet-alert/dist/sweetalert2.all.min.js"></script>
                                    <script>
                                        document.addEventListener("DOMContentLoaded", function() {
                                        Swal.fire({
                                            title: "Sukses",
                                            text: "Data Berhasil Disimpan",
                                            icon: "success",
                                        }).then(function() {
                                            window.location.href = "../list-invoice-revisi.php?sort=baru";
                                        });
                                        });
                                    </script>
                                    <?php
                                } else {
                                    unlink($compressed_file1_destination);
                                    unlink($compressed_file2_destination);
                                    unlink($compressed_file3_destination);
                                }
                            }elseif($file1_name != '' && $file2_name != ''){
                                // Kompres dan ubah ukuran gambar-revisi bukti terima 1
                                $compressed_file1_destination = "../../gambar-revisi/bukti1/$new_file1_name";
                                compressAndResizeImage($file1_destination, $compressed_file1_destination, 500, 500, 100);
                                unlink($file1_destination);

                                // Kompres dan ubah ukuran gambar-revisi bukti terima 2
                                $compressed_file2_destination = "../../gambar-revisi/bukti2/$new_file2_name";
                                compressAndResizeImage($file2_destination, $compressed_file2_destination, 500, 500, 100);
                                unlink($file2_destination);

                                $bukti_terima = mysqli_query($connect, "INSERT INTO inv_bukti_terima_revisi (id_bukti_terima, id_komplain, bukti_satu, bukti_dua, bukti_tiga) VALUES ('$id_inv_bukti', '$id_komplain', '$new_file1_name', '$new_file2_name', '$new_file3_name')");

                               $query_diterima = mysqli_query($connect, "INSERT INTO inv_penerima_revisi (id_inv_penerima_revisi, id_komplain, nama_penerima, alamat, tgl_terima) VALUES ('$id_inv_penerima_revisi', '$id_komplain', '$nama_penerima', '$alamat', '$tgl')");
                    
                                $query_update_inv = mysqli_query($connect, "UPDATE inv_nonppn SET status_transaksi = 'Diterima' WHERE id_inv_nonppn = '$id_inv'");

                                $query_update_status = mysqli_query($connect, "UPDATE revisi_status_kirim SET jenis_penerima = 'Customer' WHERE id_komplain = '$id_komplain'");

                                $query_inv_revisi = mysqli_query($connect, "UPDATE inv_revisi SET status_pengiriman = '1', status_trx_komplain = '1' WHERE id_inv = '$id_inv'");
                    
                                if ( $bukti_terima && $query_diterima && $query_update_inv && $query_update_status && $query_inv_revisi ) {
                                    // Commit transaksi
                                    $connect->commit();
                                    ?>
                                    <!-- Sweet Alert -->
                                    <link rel="stylesheet" href="../assets/sweet-alert/dist/sweetalert2.min.css">
                                    <script src="../assets/sweet-alert/dist/sweetalert2.all.min.js"></script>
                                    <script>
                                        document.addEventListener("DOMContentLoaded", function() {
                                        Swal.fire({
                                            title: "Sukses",
                                            text: "Data Berhasil Disimpan",
                                            icon: "success",
                                        }).then(function() {
                                            window.location.href = "../list-invoice-revisi.php?sort=baru";
                                        });
                                        });
                                    </script>
                                    <?php
                                } else {
                                    unlink($compressed_file1_destination);
                                    unlink($compressed_file2_destination);
                                }
                            }elseif($file1_name != '' && $file3_name != ''){
                                // Kompres dan ubah ukuran gambar-revisi bukti terima 1
                                $compressed_file1_destination = "../../gambar-revisi/bukti1/$new_file1_name";
                                compressAndResizeImage($file1_destination, $compressed_file1_destination, 500, 500, 100);
                                unlink($file1_destination);

                                $bukti_terima = mysqli_query($connect, "INSERT INTO inv_bukti_terima_revisi (id_bukti_terima, id_komplain, bukti_satu, bukti_dua, bukti_tiga) VALUES ('$id_inv_bukti', '$id_komplain', '$new_file1_name', '$new_file2_name', '$new_file3_name')");

                               $query_diterima = mysqli_query($connect, "INSERT INTO inv_penerima_revisi (id_inv_penerima_revisi, id_komplain, nama_penerima, alamat, tgl_terima) VALUES ('$id_inv_penerima_revisi', '$id_komplain', '$nama_penerima', '$alamat', '$tgl')");
                    
                                $query_update_inv = mysqli_query($connect, "UPDATE inv_nonppn SET status_transaksi = 'Diterima' WHERE id_inv_nonppn = '$id_inv'");

                                $query_update_status = mysqli_query($connect, "UPDATE revisi_status_kirim SET jenis_penerima = 'Customer' WHERE id_komplain = '$id_komplain'");

                                 $query_inv_revisi = mysqli_query($connect, "UPDATE inv_revisi SET status_pengiriman = '1', status_trx_komplain = '1' WHERE id_inv = '$id_inv'");
                    
                                if ( $bukti_terima && $query_diterima && $query_update_inv && $query_update_status && $query_inv_revisi ) {
                                    // Commit transaksi
                                    $connect->commit();
                                    ?>
                                    <!-- Sweet Alert -->
                                    <link rel="stylesheet" href="../assets/sweet-alert/dist/sweetalert2.min.css">
                                    <script src="../assets/sweet-alert/dist/sweetalert2.all.min.js"></script>
                                    <script>
                                        document.addEventListener("DOMContentLoaded", function() {
                                        Swal.fire({
                                            title: "Sukses",
                                            text: "Data Berhasil Disimpan",
                                            icon: "success",
                                        }).then(function() {
                                            window.location.href = "../list-invoice-revisi.php?sort=baru";
                                        });
                                        });
                                    </script>
                                    <?php
                                }else{
                                    unlink($compressed_file1_destination);
                                    unlink($compressed_file3_destination);
                                }
                            }elseif($file1_name != ''){
                                // Kompres dan ubah ukuran gambar-revisi bukti terima 1
                                $compressed_file1_destination = "../../gambar-revisi/bukti1/$new_file1_name";
                                compressAndResizeImage($file1_destination, $compressed_file1_destination, 500, 500, 100);
                                unlink($file1_destination);

                                $bukti_terima = mysqli_query($connect, "INSERT INTO inv_bukti_terima_revisi (id_bukti_terima, id_komplain, bukti_satu, bukti_dua, bukti_tiga) VALUES ('$id_inv_bukti', '$id_komplain', '$new_file1_name', '$new_file2_name', '$new_file3_name')");

                               $query_diterima = mysqli_query($connect, "INSERT INTO inv_penerima_revisi (id_inv_penerima_revisi, id_komplain, nama_penerima, alamat, tgl_terima) VALUES ('$id_inv_penerima_revisi', '$id_komplain', '$nama_penerima', '$alamat', '$tgl')");
                    
                                $query_update_inv = mysqli_query($connect, "UPDATE inv_nonppn SET status_transaksi = 'Diterima' WHERE id_inv_nonppn = '$id_inv'");

                                $query_update_status = mysqli_query($connect, "UPDATE revisi_status_kirim SET jenis_penerima = 'Customer' WHERE id_komplain = '$id_komplain'");

                                 $query_inv_revisi = mysqli_query($connect, "UPDATE inv_revisi SET status_pengiriman = '1', status_trx_komplain = '1' WHERE id_inv = '$id_inv'");
                    
                                if ( $bukti_terima && $query_diterima && $query_update_inv && $query_update_status && $query_inv_revisi ) {
                                    // Commit transaksi
                                    $connect->commit();
                                    ?>
                                    <!-- Sweet Alert -->
                                    <link rel="stylesheet" href="../assets/sweet-alert/dist/sweetalert2.min.css">
                                    <script src="../assets/sweet-alert/dist/sweetalert2.all.min.js"></script>
                                    <script>
                                        document.addEventListener("DOMContentLoaded", function() {
                                        Swal.fire({
                                            title: "Sukses",
                                            text: "Data Berhasil Disimpan",
                                            icon: "success",
                                        }).then(function() {
                                            window.location.href = "../list-invoice-revisi.php?sort=baru";
                                        });
                                        });
                                    </script>
                                    <?php
                                }else{
                                    unlink($compressed_file1_destination);
                                }
                            }

                        } catch (Exception $e) {
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
                                    window.location.href = "../list-invoice-revisi.php?sort=baru";
                                });
                                });
                            </script>
                            <?php
                        }
                    } else {
                        $retur = $_POST['retur'];
                        if($retur == 1){
                            $connect->begin_transaction();
                            try{
                                $uuid = generate_uuid();
                                $img_uuid = img_uuid();
                                $year = date('y');
                                $day = date('d');
                                $month = date('m');
                                $id_inv_bukti = "BKTI" . $year . "". $month . "" . $uuid . "" . $day;
                                $id_inv_penerima_revisi = "PNMR" . $year . "". $month . "" . $uuid . "" . $day;
                                $id_inv_refund = "REFUND" . $year . "". $month . "" . $uuid . "" . $day;
                                $id_kondisi = "KNDSI" . $year . "". $month . "" . $uuid . "" . $day;
                                $id_inv = $_POST['id_inv'];
                                $id_komplain = $_POST['id_komplain'];
                                $alamat = $_POST['alamat'];
                                $nama_penerima = $_POST['nama_penerima'];
                                $tgl = $_POST['tgl'];
                                $kat_komplain = $_POST['kat_komplain'];
                                $kondisi_pesanan = $_POST['kondisi_pesanan'];
                                $refund = $_POST['refund'];
                                $catatan = $_POST['catatan'];
                                $id_spk = $_POST['id_spk'];
                                $no_komplain = $_POST['no_komplain'];
                
                                $file1_name = $_FILES['fileku1']['name'];
                                $file1_tmp = $_FILES['fileku1']['tmp_name'];
                                $file1_destination = "../../gambar-revisi/bukti1/" . $file1_name;
                
                                // Mendapatkan informasi file bukti terima 2
                                $file2_name = $_FILES['fileku2']['name'];
                                $file2_tmp = $_FILES['fileku2']['tmp_name'];
                                $file2_destination = "../../gambar-revisi/bukti2/" . $file2_name;
                
                                // Mendapatkan informasi file bukti terima 3
                                $file3_name = $_FILES['fileku3']['name'];
                                $file3_tmp = $_FILES['fileku3']['tmp_name'];
                                $file3_destination = "../../gambar-revisi/bukti3/" . $file3_name;
                
                                // Pindahkan file bukti terima ke lokasi tujuan
                                move_uploaded_file($file1_tmp, $file1_destination);
                                move_uploaded_file($file2_tmp, $file2_destination);
                                move_uploaded_file($file3_tmp, $file3_destination);
                
                                $new_file1_name = "Bukti_Satu". $year . "" . $month . "" . $img_uuid . "" . $day . ".jpg";
                                $new_file2_name = "Bukti_Dua". $year . "" . $month . "" . $img_uuid . "" . $day . ".jpg";
                                $new_file3_name = "Bukti_Tiga". $year . "" . $month . "" . $img_uuid . "" . $day . ".jpg";
                
                                if($file1_name != '' && $file2_name != '' &&  $file3_name != ''){
                                    // Kompres dan ubah ukuran gambar-revisi bukti terima 1
                                    $compressed_file1_destination = "../../gambar-revisi/bukti1/$new_file1_name";
                                    compressAndResizeImage($file1_destination, $compressed_file1_destination, 500, 500, 100);
                                    unlink($file1_destination);
                                    
                                    // Kompres dan ubah ukuran gambar-revisi bukti terima 2
                                    $compressed_file2_destination = "../../gambar-revisi/bukti2/$new_file2_name";
                                    compressAndResizeImage($file2_destination, $compressed_file2_destination, 500, 500, 100);
                                    unlink($file2_destination);
                
                                    // Kompres dan ubah ukuran gambar-revisi bukti terima 3
                                    $compressed_file3_destination = "../../gambar-revisi/bukti3/$new_file3_name";
                                    compressAndResizeImage($file3_destination, $compressed_file3_destination, 500, 500, 100);
                                    unlink($file3_destination);
                
                                    $bukti_terima = mysqli_query($connect, "INSERT INTO inv_bukti_terima_revisi (id_bukti_terima, id_komplain, bukti_satu, bukti_dua, bukti_tiga) VALUES ('$id_inv_bukti', '$id_komplain', '$new_file1_name', '$new_file2_name', '$new_file3_name')");
                
                                   $query_diterima = mysqli_query($connect, "INSERT INTO inv_penerima_revisi (id_inv_penerima_revisi, id_komplain, nama_penerima, alamat, tgl_terima) VALUES ('$id_inv_penerima_revisi', '$id_komplain', '$nama_penerima', '$alamat', '$tgl')");
                        
                                    $id_inv_substr = $id_inv;
                                    $inv_id = substr($id_inv_substr, 0, 3);
                                    $query_update_inv = "";
                                    if ($inv_id = "NON"){
                                        $query_update_inv = mysqli_query($connect, "UPDATE inv_nonppn SET status_transaksi = 'Komplain' WHERE id_inv_nonppn = '$id_inv'");
                                    } else if ($inv_id = "PPN"){
                                        $query_update_inv = mysqli_query($connect, "UPDATE inv_ppn SET status_transaksi = 'Komplain' WHERE id_inv_ppn = '$id_inv'");
                                    } else if ($inv_id = "BUM"){
                                        $query_update_inv = mysqli_query($connect, "UPDATE inv_bum SET status_transaksi = 'Komplain' WHERE id_inv_bum = '$id_inv'");
                                    }
                
                                    $query_update_status = mysqli_query($connect, "UPDATE revisi_status_kirim SET jenis_penerima = 'Customer' WHERE id_komplain = '$id_komplain'");

                                    $query_komplain = mysqli_query($connect, "INSERT INTO komplain_kondisi (id_kondisi, id_komplain, kat_komplain, kondisi_pesanan, status_retur, status_refund, catatan) VALUES ('$id_kondisi', '$id_komplain', '$kat_komplain', '$kondisi_pesanan', '$retur', '$refund', '$catatan')");

                                    $query_inv_revisi = mysqli_query($connect, "UPDATE inv_revisi SET status_pengiriman = '1', status_trx_komplain = '0', status_trx_selesai = '0' WHERE id_inv = '$id_inv'");

                                    if ( $bukti_terima && $query_diterima && $query_update_inv && $query_update_status && $query_komplain && $query_inv_revisi ) {
                                        // Commit transaksi
                                        $connect->commit();

                                        $_SESSION['info'] = "Disimpan";
                                        header("Location:../list-invoice-revisi.php");
                                    } else {
                                        unlink($compressed_file1_destination);
                                        unlink($compressed_file2_destination);
                                        unlink($compressed_file3_destination);
                                    }
                                }elseif($file1_name != '' && $file2_name != ''){
                                    // Kompres dan ubah ukuran gambar-revisi bukti terima 1
                                    $compressed_file1_destination = "../../gambar-revisi/bukti1/$new_file1_name";
                                    compressAndResizeImage($file1_destination, $compressed_file1_destination, 500, 500, 100);
                                    unlink($file1_destination);
                
                                    // Kompres dan ubah ukuran gambar-revisi bukti terima 2
                                    $compressed_file2_destination = "../../gambar-revisi/bukti2/$new_file2_name";
                                    compressAndResizeImage($file2_destination, $compressed_file2_destination, 500, 500, 100);
                                    unlink($file2_destination);
                
                                    $bukti_terima = mysqli_query($connect, "INSERT INTO inv_bukti_terima_revisi (id_bukti_terima, id_komplain, bukti_satu, bukti_dua) VALUES ('$id_inv_bukti', '$id_komplain', '$new_file1_name', '$new_file2_name')");
                
                                   $query_diterima = mysqli_query($connect, "INSERT INTO inv_penerima_revisi (id_inv_penerima_revisi, id_komplain, nama_penerima, alamat, tgl_terima) VALUES ('$id_inv_penerima_revisi', '$id_komplain', '$nama_penerima', '$alamat', '$tgl')");
                        
                                    $id_inv_substr = $id_inv;
                                    $inv_id = substr($id_inv_substr, 0, 3);
                                    $query_update_inv = "";
                                    if ($inv_id = "NON"){
                                        $query_update_inv = mysqli_query($connect, "UPDATE inv_nonppn SET status_transaksi = 'Komplain' WHERE id_inv_nonppn = '$id_inv'");
                                    } else if ($inv_id = "PPN"){
                                        $query_update_inv = mysqli_query($connect, "UPDATE inv_ppn SET status_transaksi = 'Komplain' WHERE id_inv_ppn = '$id_inv'");
                                    } else if ($inv_id = "BUM"){
                                        $query_update_inv = mysqli_query($connect, "UPDATE inv_bum SET status_transaksi = 'Komplain' WHERE id_inv_bum = '$id_inv'");
                                    }
                
                                    $query_update_status = mysqli_query($connect, "UPDATE revisi_status_kirim SET jenis_penerima = 'Customer' WHERE id_komplain = '$id_komplain'");

                                    $query_komplain = mysqli_query($connect, "INSERT INTO komplain_kondisi (id_kondisi, id_komplain, kat_komplain, kondisi_pesanan, status_retur, status_refund, catatan) VALUES ('$id_kondisi', '$id_komplain', '$kat_komplain', '$kondisi_pesanan', '$retur', '$refund', '$catatan')");

                                   $query_inv_revisi = mysqli_query($connect, "UPDATE inv_revisi SET status_pengiriman = '1', status_trx_komplain = '0', status_trx_selesai = '0' WHERE id_inv = '$id_inv'");
                                    
                                    if ( $bukti_terima && $query_diterima && $query_update_inv && $query_update_status && $query_komplain && $query_inv_revisi ) {
                                        // Commit transaksi
                                        $connect->commit();
                                        ?>
                                        <!-- Sweet Alert -->
                                        <link rel="stylesheet" href="../assets/sweet-alert/dist/sweetalert2.min.css">
                                        <script src="../assets/sweet-alert/dist/sweetalert2.all.min.js"></script>
                                        <script>
                                            document.addEventListener("DOMContentLoaded", function() {
                                            Swal.fire({
                                                title: "Sukses",
                                                text: "Data Berhasil Disimpan",
                                                icon: "success",
                                            }).then(function() {
                                                window.location.href = "../list-invoice-revisi.php?sort=baru";
                                            });
                                            });
                                        </script>
                                        <?php
                                    } else {
                                        unlink($compressed_file1_destination);
                                        unlink($compressed_file2_destination);
                                    }
                                }elseif($file1_name != '' && $file3_name != ''){
                                    // Kompres dan ubah ukuran gambar-revisi bukti terima 1
                                    $compressed_file1_destination = "../../gambar-revisi/bukti1/$new_file1_name";
                                    compressAndResizeImage($file1_destination, $compressed_file1_destination, 500, 500, 100);
                                    unlink($file1_destination);
                
                                    // Kompres dan ubah ukuran gambar-revisi bukti terima 3
                                    $compressed_file3_destination = "../../gambar-revisi/bukti3/$new_file3_name";
                                    compressAndResizeImage($file3_destination, $compressed_file3_destination, 500, 500, 100);
                                    unlink($file3_destination);
                
                                    $bukti_terima = mysqli_query($connect, "INSERT INTO inv_bukti_terima_revisi (id_bukti_terima, id_komplain, bukti_satu, bukti_tiga) VALUES ('$id_inv_bukti', '$id_komplain', '$new_file1_name', '$new_file3_name')");
                
                                   $query_diterima = mysqli_query($connect, "INSERT INTO inv_penerima_revisi (id_inv_penerima_revisi, id_komplain, nama_penerima, alamat, tgl_terima) VALUES ('$id_inv_penerima_revisi', '$id_komplain', '$nama_penerima', '$alamat', '$tgl')");
                        
                                    $id_inv_substr = $id_inv;
                                    $inv_id = substr($id_inv_substr, 0, 3);
                                    $query_update_inv = "";
                                    if ($inv_id = "NON"){
                                        $query_update_inv = mysqli_query($connect, "UPDATE inv_nonppn SET status_transaksi = 'Komplain' WHERE id_inv_nonppn = '$id_inv'");
                                    } else if ($inv_id = "PPN"){
                                        $query_update_inv = mysqli_query($connect, "UPDATE inv_ppn SET status_transaksi = 'Komplain' WHERE id_inv_ppn = '$id_inv'");
                                    } else if ($inv_id = "BUM"){
                                        $query_update_inv = mysqli_query($connect, "UPDATE inv_bum SET status_transaksi = 'Komplain' WHERE id_inv_bum = '$id_inv'");
                                    }
                
                                    $query_update_status = mysqli_query($connect, "UPDATE revisi_status_kirim SET jenis_penerima = 'Customer' WHERE id_komplain = '$id_komplain'");

                                    $query_komplain = mysqli_query($connect, "INSERT INTO komplain_kondisi (id_kondisi, id_komplain, kat_komplain, kondisi_pesanan, status_retur, status_refund, catatan) VALUES ('$id_kondisi', '$id_komplain', '$kat_komplain', '$kondisi_pesanan', '$retur', '$refund', '$catatan')");

                                   $query_inv_revisi = mysqli_query($connect, "UPDATE inv_revisi SET status_pengiriman = '1', status_trx_komplain = '0', status_trx_selesai = '0' WHERE id_inv = '$id_inv'");

                                    if ( $bukti_terima && $query_diterima && $query_update_inv && $query_update_status && $query_komplain && $query_inv_revisi ) {
                                        // Commit transaksi
                                        $connect->commit();
                                        ?>
                                        <!-- Sweet Alert -->
                                        <link rel="stylesheet" href="../assets/sweet-alert/dist/sweetalert2.min.css">
                                        <script src="../assets/sweet-alert/dist/sweetalert2.all.min.js"></script>
                                        <script>
                                            document.addEventListener("DOMContentLoaded", function() {
                                            Swal.fire({
                                                title: "Sukses",
                                                text: "Data Berhasil Disimpan",
                                                icon: "success",
                                            }).then(function() {
                                                window.location.href = "../list-invoice-revisi.php?sort=baru";
                                            });
                                            });
                                        </script>
                                        <?php
                                    } else {
                                        unlink($compressed_file1_destination);
                                        unlink($compressed_file3_destination);
                                    }
                                }elseif($file1_name != ''){
                                    // Kompres dan ubah ukuran gambar-revisi bukti terima 1
                                    $compressed_file1_destination = "../../gambar-revisi/bukti1/$new_file1_name";
                                    compressAndResizeImage($file1_destination, $compressed_file1_destination, 500, 500, 100);
                                    unlink($file1_destination);
                
                                    $bukti_terima = mysqli_query($connect, "INSERT INTO inv_bukti_terima_revisi (id_bukti_terima, id_komplain, bukti_satu) VALUES ('$id_inv_bukti', '$id_komplain', '$new_file1_name')");
                
                                   $query_diterima = mysqli_query($connect, "INSERT INTO inv_penerima_revisi (id_inv_penerima_revisi, id_komplain, nama_penerima, alamat, tgl_terima) VALUES ('$id_inv_penerima_revisi', '$id_komplain', '$nama_penerima', '$alamat', '$tgl')");
                        
                                    $id_inv_substr = $id_inv;
                                    $inv_id = substr($id_inv_substr, 0, 3);
                                    $query_update_inv = "";
                                    if ($inv_id = "NON"){
                                        $query_update_inv = mysqli_query($connect, "UPDATE inv_nonppn SET status_transaksi = 'Komplain' WHERE id_inv_nonppn = '$id_inv'");
                                    } else if ($inv_id = "PPN"){
                                        $query_update_inv = mysqli_query($connect, "UPDATE inv_ppn SET status_transaksi = 'Komplain' WHERE id_inv_ppn = '$id_inv'");
                                    } else if ($inv_id = "BUM"){
                                        $query_update_inv = mysqli_query($connect, "UPDATE inv_bum SET status_transaksi = 'Komplain' WHERE id_inv_bum = '$id_inv'");
                                    }
                
                                    $query_update_status = mysqli_query($connect, "UPDATE revisi_status_kirim SET jenis_penerima = 'Customer' WHERE id_komplain = '$id_komplain'");

                                    $query_komplain = mysqli_query($connect, "INSERT INTO komplain_kondisi (id_kondisi, id_komplain, kat_komplain, kondisi_pesanan, status_retur, status_refund, catatan) VALUES ('$id_kondisi', '$id_komplain', '$kat_komplain', '$kondisi_pesanan', '$retur', '$refund', '$catatan')");

                                   $query_inv_revisi = mysqli_query($connect, "UPDATE inv_revisi SET status_pengiriman = '1', status_trx_komplain = '0', status_trx_selesai = '0' WHERE id_inv = '$id_inv'");

                                    if ($bukti_terima && $query_diterima && $query_update_inv && $query_update_status && $query_komplain && $query_inv_revisi) {
                                        // Commit transaksi
                                        $connect->commit();
                                        ?>
                                        <!-- Sweet Alert -->
                                        <link rel="stylesheet" href="../assets/sweet-alert/dist/sweetalert2.min.css">
                                        <script src="../assets/sweet-alert/dist/sweetalert2.all.min.js"></script>
                                        <script>
                                            document.addEventListener("DOMContentLoaded", function() {
                                            Swal.fire({
                                                title: "Sukses",
                                                text: "Data Berhasil Disimpan",
                                                icon: "success",
                                            }).then(function() {
                                                window.location.href = "../list-invoice-revisi.php?sort=baru";
                                            });
                                            });
                                        </script>
                                        <?php
                                    } else {
                                        unlink($compressed_file1_destination);
                                    }
                                }
                            } catch (Exception $e) {
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
                                        window.location.href = "../list-invoice-revisi.php?sort=baru";
                                    });
                                    });
                                </script>
                                <?php
                            }
                        } else {
                            $connect->begin_transaction();
                            try{
                                $uuid = generate_uuid();
                                $img_uuid = img_uuid();
                                $year = date('y');
                                $day = date('d');
                                $month = date('m');
                                $id_inv_bukti = "BKTI" . $year . "". $month . "" . $uuid . "" . $day;
                                $id_inv_penerima_revisi = "PNMR" . $year . "". $month . "" . $uuid . "" . $day;
                                $id_kondisi = "KNDSI" . $year . "". $month . "" . $uuid . "" . $day;
                                $id_inv = $_POST['id_inv'];
                                $id_komplain = $_POST['id_komplain'];
                                $alamat = $_POST['alamat'];
                                $nama_penerima = $_POST['nama_penerima'];
                                $tgl = $_POST['tgl'];
                                $kat_komplain = $_POST['kat_komplain'];
                                $kondisi_pesanan = $_POST['kondisi_pesanan'];
                                $catatan = $_POST['catatan'];
                                $id_spk = $_POST['id_spk'];
                                $no_komplain = $_POST['no_komplain'];
                
                                $file1_name = $_FILES['fileku1']['name'];
                                $file1_tmp = $_FILES['fileku1']['tmp_name'];
                                $file1_destination = "../../gambar-revisi/bukti1/" . $file1_name;
                
                                // Mendapatkan informasi file bukti terima 2
                                $file2_name = $_FILES['fileku2']['name'];
                                $file2_tmp = $_FILES['fileku2']['tmp_name'];
                                $file2_destination = "../../gambar-revisi/bukti2/" . $file2_name;
                
                                // Mendapatkan informasi file bukti terima 3
                                $file3_name = $_FILES['fileku3']['name'];
                                $file3_tmp = $_FILES['fileku3']['tmp_name'];
                                $file3_destination = "../../gambar-revisi/bukti3/" . $file3_name;
                
                                // Pindahkan file bukti terima ke lokasi tujuan
                                move_uploaded_file($file1_tmp, $file1_destination);
                                move_uploaded_file($file2_tmp, $file2_destination);
                                move_uploaded_file($file3_tmp, $file3_destination);
                
                                $new_file1_name = "Bukti_Satu". $year . "" . $month . "" . $img_uuid . "" . $day . ".jpg";
                                $new_file2_name = "Bukti_Dua". $year . "" . $month . "" . $img_uuid . "" . $day . ".jpg";
                                $new_file3_name = "Bukti_Tiga". $year . "" . $month . "" . $img_uuid . "" . $day . ".jpg";
                
                                if($file1_name != '' && $file2_name != '' &&  $file3_name != ''){
                                    // Kompres dan ubah ukuran gambar-revisi bukti terima 1
                                    $compressed_file1_destination = "../../gambar-revisi/bukti1/$new_file1_name";
                                    compressAndResizeImage($file1_destination, $compressed_file1_destination, 500, 500, 100);
                                    unlink($file1_destination);
                
                                    // Kompres dan ubah ukuran gambar-revisi bukti terima 2
                                    $compressed_file2_destination = "../../gambar-revisi/bukti2/$new_file2_name";
                                    compressAndResizeImage($file2_destination, $compressed_file2_destination, 500, 500, 100);
                                    unlink($file2_destination);
                
                                    // Kompres dan ubah ukuran gambar-revisi bukti terima 3
                                    $compressed_file3_destination = "../../gambar-revisi/bukti3/$new_file3_name";
                                    compressAndResizeImage($file3_destination, $compressed_file3_destination, 500, 500, 100);
                                    unlink($file3_destination);
                
                                    $bukti_terima = mysqli_query($connect, "INSERT INTO inv_bukti_terima_revisi (id_bukti_terima, id_komplain, bukti_satu, bukti_dua, bukti_tiga) VALUES ('$id_inv_bukti', '$id_komplain', '$new_file1_name', '$new_file2_name', '$new_file3_name')");
                
                                    $query_diterima = mysqli_query($connect, "INSERT INTO inv_penerima_revisi (id_inv_penerima_revisi, id_komplain, nama_penerima, alamat, tgl_terima) VALUES ('$id_inv_penerima_revisi', '$id_komplain', '$nama_penerima', '$alamat', '$tgl')");
                        
                                    $id_inv_substr = $id_inv;
                                    $inv_id = substr($id_inv_substr, 0, 3);
                                    $query_update_inv = "";
                                    if ($inv_id = "NON"){
                                        $query_update_inv = mysqli_query($connect, "UPDATE inv_nonppn SET status_transaksi = 'Komplain' WHERE id_inv_nonppn = '$id_inv'");
                                    } else if ($inv_id = "PPN"){
                                        $query_update_inv = mysqli_query($connect, "UPDATE inv_ppn SET status_transaksi = 'Komplain' WHERE id_inv_ppn = '$id_inv'");
                                    } else if ($inv_id = "BUM"){
                                        $query_update_inv = mysqli_query($connect, "UPDATE inv_bum SET status_transaksi = 'Komplain' WHERE id_inv_bum = '$id_inv'");
                                    }
                
                                    $query_update_status = mysqli_query($connect, "UPDATE revisi_status_kirim SET jenis_penerima = 'Customer' WHERE id_komplain = '$id_komplain'");
                
                                    $query_komplain = mysqli_query($connect, "INSERT INTO komplain_kondisi (id_kondisi, id_komplain, kat_komplain, kondisi_pesanan, status_retur, catatan) VALUES ('$id_kondisi', '$id_komplain', '$kat_komplain', '$kondisi_pesanan', '$retur', '$catatan')");

                                   $query_inv_revisi = mysqli_query($connect, "UPDATE inv_revisi SET status_pengiriman = '1', status_trx_komplain = '0', status_trx_selesai = '0' WHERE id_inv = '$id_inv'");

                                    if ( $bukti_terima && $query_diterima && $query_update_inv && $query_update_status && $query_komplain && $query_inv_revisi ) {
                                        // Commit transaksi
                                        $connect->commit();
                                        ?>
                                        <!-- Sweet Alert -->
                                        <link rel="stylesheet" href="../assets/sweet-alert/dist/sweetalert2.min.css">
                                        <script src="../assets/sweet-alert/dist/sweetalert2.all.min.js"></script>
                                        <script>
                                            document.addEventListener("DOMContentLoaded", function() {
                                            Swal.fire({
                                                title: "Sukses",
                                                text: "Data Berhasil Disimpan",
                                                icon: "success",
                                            }).then(function() {
                                                window.location.href = "../list-invoice-revisi.php?sort=baru";
                                            });
                                            });
                                        </script>
                                        <?php
                                    } else {
                                        unlink($compressed_file1_destination);
                                        unlink($compressed_file2_destination);
                                        unlink($compressed_file3_destination);
                                    }
                                }elseif($file1_name != '' && $file2_name != ''){
                                    // Kompres dan ubah ukuran gambar-revisi bukti terima 1
                                    $compressed_file1_destination = "../../gambar-revisi/bukti1/$new_file1_name";
                                    compressAndResizeImage($file1_destination, $compressed_file1_destination, 500, 500, 100);
                                    unlink($file1_destination);
                
                                    // Kompres dan ubah ukuran gambar-revisi bukti terima 2
                                    $compressed_file2_destination = "../../gambar-revisi/bukti2/$new_file2_name";
                                    compressAndResizeImage($file2_destination, $compressed_file2_destination, 500, 500, 100);
                                    unlink($file2_destination);
                
                                    $bukti_terima = mysqli_query($connect, "INSERT INTO inv_bukti_terima_revisi (id_bukti_terima, id_komplain, bukti_satu, bukti_dua) VALUES ('$id_inv_bukti', '$id_komplain', '$new_file1_name', '$new_file2_name')");
                
                                   $query_diterima = mysqli_query($connect, "INSERT INTO inv_penerima_revisi (id_inv_penerima_revisi, id_komplain, nama_penerima, alamat, tgl_terima) VALUES ('$id_inv_penerima_revisi', '$id_komplain', '$nama_penerima', '$alamat', '$tgl')");
                        
                                    $id_inv_substr = $id_inv;
                                    $inv_id = substr($id_inv_substr, 0, 3);
                                    $query_update_inv = "";
                                    if ($inv_id = "NON"){
                                        $query_update_inv = mysqli_query($connect, "UPDATE inv_nonppn SET status_transaksi = 'Komplain' WHERE id_inv_nonppn = '$id_inv'");
                                    } else if ($inv_id = "PPN"){
                                        $query_update_inv = mysqli_query($connect, "UPDATE inv_ppn SET status_transaksi = 'Komplain' WHERE id_inv_ppn = '$id_inv'");
                                    } else if ($inv_id = "BUM"){
                                        $query_update_inv = mysqli_query($connect, "UPDATE inv_bum SET status_transaksi = 'Komplain' WHERE id_inv_bum = '$id_inv'");
                                    }
                
                                    $query_update_status = mysqli_query($connect, "UPDATE revisi_status_kirim SET jenis_penerima = 'Customer' WHERE id_komplain = '$id_komplain'");
                
                                    $query_komplain = mysqli_query($connect, "INSERT INTO komplain_kondisi (id_kondisi, id_komplain, kat_komplain, kondisi_pesanan, status_retur, catatan) VALUES ('$id_kondisi', '$id_komplain', '$kat_komplain', '$kondisi_pesanan', '$retur', '$catatan')");

                                   $query_inv_revisi = mysqli_query($connect, "UPDATE inv_revisi SET status_pengiriman = '1', status_trx_komplain = '0', status_trx_selesai = '0' WHERE id_inv = '$id_inv'");

                                    if ( $bukti_terima && $query_diterima && $query_update_inv && $query_update_status && $query_komplain ) {
                                        // Commit transaksi
                                        $connect->commit();
                                        ?>
                                        <!-- Sweet Alert -->
                                        <link rel="stylesheet" href="../assets/sweet-alert/dist/sweetalert2.min.css">
                                        <script src="../assets/sweet-alert/dist/sweetalert2.all.min.js"></script>
                                        <script>
                                            document.addEventListener("DOMContentLoaded", function() {
                                            Swal.fire({
                                                title: "Sukses",
                                                text: "Data Berhasil Disimpan",
                                                icon: "success",
                                            }).then(function() {
                                                window.location.href = "../list-invoice-revisi.php?sort=baru";
                                            });
                                            });
                                        </script>
                                        <?php
                                    } else {
                                        unlink($compressed_file1_destination);
                                        unlink($compressed_file2_destination);
                                    }
                                }elseif($file1_name != '' && $file3_name != ''){
                                    // Kompres dan ubah ukuran gambar-revisi bukti terima 1
                                    $compressed_file1_destination = "../../gambar-revisi/bukti1/$new_file1_name";
                                    compressAndResizeImage($file1_destination, $compressed_file1_destination, 500, 500, 100);
                                    unlink($file1_destination);
                
                                    // Kompres dan ubah ukuran gambar-revisi bukti terima 3
                                    $compressed_file3_destination = "../../gambar-revisi/bukti3/$new_file3_name";
                                    compressAndResizeImage($file3_destination, $compressed_file3_destination, 500, 500, 100);
                                    unlink($file3_destination);
                
                                    $bukti_terima = mysqli_query($connect, "INSERT INTO inv_bukti_terima_revisi (id_bukti_terima, id_komplain, bukti_satu, bukti_tiga) VALUES ('$id_inv_bukti', '$id_komplain', '$new_file1_name', '$new_file3_name')");
                
                                   $query_diterima = mysqli_query($connect, "INSERT INTO inv_penerima_revisi (id_inv_penerima_revisi, id_komplain, nama_penerima, alamat, tgl_terima) VALUES ('$id_inv_penerima_revisi', '$id_komplain', '$nama_penerima', '$alamat', '$tgl')");
                        
                                    $id_inv_substr = $id_inv;
                                    $inv_id = substr($id_inv_substr, 0, 3);
                                    $query_update_inv = "";
                                    if ($inv_id = "NON"){
                                        $query_update_inv = mysqli_query($connect, "UPDATE inv_nonppn SET status_transaksi = 'Komplain' WHERE id_inv_nonppn = '$id_inv'");
                                    } else if ($inv_id = "PPN"){
                                        $query_update_inv = mysqli_query($connect, "UPDATE inv_ppn SET status_transaksi = 'Komplain' WHERE id_inv_ppn = '$id_inv'");
                                    } else if ($inv_id = "BUM"){
                                        $query_update_inv = mysqli_query($connect, "UPDATE inv_bum SET status_transaksi = 'Komplain' WHERE id_inv_bum = '$id_inv'");
                                    }
                
                                    $query_update_status = mysqli_query($connect, "UPDATE revisi_status_kirim SET jenis_penerima = 'Customer' WHERE id_komplain = '$id_komplain'");
                
                                    $query_komplain = mysqli_query($connect, "INSERT INTO komplain_kondisi (id_kondisi, id_komplain, kat_komplain, kondisi_pesanan, status_retur, catatan) VALUES ('$id_kondisi', '$id_komplain', '$kat_komplain', '$kondisi_pesanan', '$retur', '$catatan')");

                                   $query_inv_revisi = mysqli_query($connect, "UPDATE inv_revisi SET status_pengiriman = '1', status_trx_komplain = '0', status_trx_selesai = '0' WHERE id_inv = '$id_inv'");

                                    if ( $bukti_terima && $query_diterima && $query_update_inv && $query_update_status && $query_komplain ) {
                                        // Commit transaksi
                                        $connect->commit();
                                        ?>
                                        <!-- Sweet Alert -->
                                        <link rel="stylesheet" href="../assets/sweet-alert/dist/sweetalert2.min.css">
                                        <script src="../assets/sweet-alert/dist/sweetalert2.all.min.js"></script>
                                        <script>
                                            document.addEventListener("DOMContentLoaded", function() {
                                            Swal.fire({
                                                title: "Sukses",
                                                text: "Data Berhasil Disimpan",
                                                icon: "success",
                                            }).then(function() {
                                                window.location.href = "../list-invoice-revisi.php?sort=baru";
                                            });
                                            });
                                        </script>
                                        <?php
                                    } else {
                                        unlink($compressed_file1_destination);
                                        unlink($compressed_file3_destination);
                                    }
                                }elseif($file1_name != ''){
                                    // Kompres dan ubah ukuran gambar-revisi bukti terima 1
                                    $compressed_file1_destination = "../../gambar-revisi/bukti1/$new_file1_name";
                                    compressAndResizeImage($file1_destination, $compressed_file1_destination, 500, 500, 100);
                                    unlink($file1_destination);
                
                                    $bukti_terima = mysqli_query($connect, "INSERT INTO inv_bukti_terima_revisi (id_bukti_terima, id_komplain, bukti_satu) VALUES ('$id_inv_bukti', '$id_komplain', '$new_file1_name')");
                
                                    $query_diterima = mysqli_query($connect, "INSERT INTO inv_penerima_revisi (id_inv_penerima_revisi, id_komplain, nama_penerima, alamat, tgl_terima) VALUES ('$id_inv_penerima_revisi', '$id_komplain', '$nama_penerima', '$alamat', '$tgl')");
                        
                                    $id_inv_substr = $id_inv;
                                    $inv_id = substr($id_inv_substr, 0, 3);
                                    $query_update_inv = "";
                                    if ($inv_id = "NON"){
                                        $query_update_inv = mysqli_query($connect, "UPDATE inv_nonppn SET status_transaksi = 'Komplain' WHERE id_inv_nonppn = '$id_inv'");
                                    } else if ($inv_id = "PPN"){
                                        $query_update_inv = mysqli_query($connect, "UPDATE inv_ppn SET status_transaksi = 'Komplain' WHERE id_inv_ppn = '$id_inv'");
                                    } else if ($inv_id = "BUM"){
                                        $query_update_inv = mysqli_query($connect, "UPDATE inv_bum SET status_transaksi = 'Komplain' WHERE id_inv_bum = '$id_inv'");
                                    }
                
                                    $query_update_status = mysqli_query($connect, "UPDATE revisi_status_kirim SET jenis_penerima = 'Customer' WHERE id_komplain = '$id_komplain'");
                
                                    $query_komplain = mysqli_query($connect, "INSERT INTO komplain_kondisi (id_kondisi, id_komplain, kat_komplain, kondisi_pesanan, status_retur, catatan) VALUES ('$id_kondisi', '$id_komplain', '$kat_komplain', '$kondisi_pesanan', '$retur', '$catatan')");

                                   $query_inv_revisi = mysqli_query($connect, "UPDATE inv_revisi SET status_pengiriman = '1', status_trx_komplain = '0', status_trx_selesai = '0' WHERE id_inv = '$id_inv'");
                                    
                        
                                    if ( $bukti_terima && $query_diterima && $query_update_inv && $query_update_status && $query_komplain ) {
                                        // Commit transaksi
                                        $connect->commit();
                                        ?>
                                        <!-- Sweet Alert -->
                                        <link rel="stylesheet" href="../assets/sweet-alert/dist/sweetalert2.min.css">
                                        <script src="../assets/sweet-alert/dist/sweetalert2.all.min.js"></script>
                                        <script>
                                            document.addEventListener("DOMContentLoaded", function() {
                                            Swal.fire({
                                                title: "Sukses",
                                                text: "Data Berhasil Disimpan",
                                                icon: "success",
                                            }).then(function() {
                                                window.location.href = "../list-invoice-revisi.php?sort=baru";
                                            });
                                            });
                                        </script>
                                        <?php
                                    } else {
                                        unlink($compressed_file1_destination);
                                    }
                                }
                            } catch (Exception $e) {
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
                                        window.location.href = "../list-invoice-revisi.php?sort=baru";
                                    });
                                    });
                                </script>
                                <?php
                            }
                        }
                    }
                } else {
                    $connect->begin_transaction();
                    try{
                        $uuid = generate_uuid();
                        $img_uuid = img_uuid();
                        $year = date('y');
                        $day = date('d');
                        $month = date('m');
                        $id_inv_bukti = "BKTI" . $year . "". $month . "" . $uuid . "" . $day;
                        $id_inv_penerima_revisi = "PNMR" . $year . "". $month . "" . $uuid . "" . $day;
                        $id_komplain = $_POST['id_komplain'];
                        $id_inv = $_POST['id_inv'];
                        $alamat = $_POST['alamat'];
                        $nama_penerima = $_POST['nama_penerima'];
                        $nama_ekspedisi = $_POST['nama_ekspedisi'];
                        $resi = $_POST['resi'];
                        $jenis_ongkir = $_POST['jenis_ongkir'];
                        $ongkir = str_replace(',', '', $_POST['ongkir']); // Menghapus tanda ribuan (,)
                        $ongkir = intval($ongkir); // Mengubah string harga menjadi integer
                        $tgl = $_POST['tgl'];

                        $query_ekspedisi = mysqli_query($connect, "SELECT id_ekspedisi, nama_ekspedisi FROM ekspedisi WHERE nama_ekspedisi = '$nama_ekspedisi'");
                        $data_ekspedisi = mysqli_fetch_array($query_ekspedisi);
                        $id_ekspedisi = $data_ekspedisi['id_ekspedisi'];

                        $file1_name = $_FILES['fileku1']['name'];
                        $file1_tmp = $_FILES['fileku1']['tmp_name'];
                        $file1_destination = "../../gambar-revisi/bukti1/" . $file1_name;

                        // Mendapatkan informasi file bukti terima 2
                        $file2_name = $_FILES['fileku2']['name'];
                        $file2_tmp = $_FILES['fileku2']['tmp_name'];
                        $file2_destination = "../../gambar-revisi/bukti2/" . $file2_name;

                        // Mendapatkan informasi file bukti terima 3
                        $file3_name = $_FILES['fileku3']['name'];
                        $file3_tmp = $_FILES['fileku3']['tmp_name'];
                        $file3_destination = "../../gambar-revisi/bukti3/" . $file3_name;

                        // Pindahkan file bukti terima ke lokasi tujuan
                        move_uploaded_file($file1_tmp, $file1_destination);
                        move_uploaded_file($file2_tmp, $file2_destination);
                        move_uploaded_file($file3_tmp, $file3_destination);

                        $new_file1_name = "Bukti_Satu". $year . "" . $month . "" . $img_uuid . "" . $day . ".jpg";
                        $new_file2_name = "Bukti_Dua". $year . "" . $month . "" . $img_uuid . "" . $day . ".jpg";
                        $new_file3_name = "Bukti_Tiga". $year . "" . $month . "" . $img_uuid . "" . $day . ".jpg";

                        if($file1_name != '' && $file2_name != '' &&  $file3_name != ''){
                            // Kompres dan ubah ukuran gambar-revisi bukti terima 1
                            $compressed_file1_destination = "../../gambar-revisi/bukti1/$new_file1_name";
                            compressAndResizeImage($file1_destination, $compressed_file1_destination, 500, 500, 100);
                            unlink($file1_destination);

                            // Kompres dan ubah ukuran gambar-revisi bukti terima 2
                            $compressed_file2_destination = "../../gambar-revisi/bukti2/$new_file2_name";
                            compressAndResizeImage($file2_destination, $compressed_file2_destination, 500, 500, 100);
                            unlink($file2_destination);

                            // Kompres dan ubah ukuran gambar-revisi bukti terima 3
                            $compressed_file3_destination = "../../gambar-revisi/bukti3/$new_file3_name";
                            compressAndResizeImage($file3_destination, $compressed_file3_destination, 500, 500, 100);
                            unlink($file3_destination);

                            $bukti_terima = mysqli_query($connect, "INSERT INTO inv_bukti_terima_revisi (id_bukti_terima, id_komplain, bukti_satu, bukti_dua, bukti_tiga) VALUES ('$id_inv_bukti', '$id_komplain', '$new_file1_name', '$new_file2_name', '$new_file3_name')");


                            $update_revisi_status_kirim = mysqli_query($connect, "UPDATE revisi_status_kirim SET jenis_penerima = 'Ekspedisi', dikirim_ekspedisi = '$id_ekspedisi', no_resi = '$resi', jenis_ongkir = '$jenis_ongkir' WHERE id_komplain = '$id_komplain'");

                            
                
                            if ($bukti_terima && $update_revisi_status_kirim) {
                                // Commit transaksi
                                $connect->commit();
                                ?>
                                <!-- Sweet Alert -->
                                <link rel="stylesheet" href="../assets/sweet-alert/dist/sweetalert2.min.css">
                                <script src="../assets/sweet-alert/dist/sweetalert2.all.min.js"></script>
                                <script>
                                    document.addEventListener("DOMContentLoaded", function() {
                                    Swal.fire({
                                        title: "Sukses",
                                        text: "Data Berhasil Disimpan",
                                        icon: "success",
                                    }).then(function() {
                                        window.location.href = "../list-invoice-revisi.php?sort=baru";
                                    });
                                    });
                                </script>
                                <?php
                            } else {
                                unlink($compressed_file1_destination);
                                unlink($compressed_file2_destination);
                                unlink($compressed_file3_destination);
                            }
                        }elseif($file1_name != '' && $file2_name != ''){
                            // Kompres dan ubah ukuran gambar-revisi bukti terima 1
                            $compressed_file1_destination = "../../gambar-revisi/bukti1/$new_file1_name";
                            compressAndResizeImage($file1_destination, $compressed_file1_destination, 500, 500, 100);
                            unlink($file1_destination);

                            // Kompres dan ubah ukuran gambar-revisi bukti terima 2
                            $compressed_file2_destination = "../../gambar-revisi/bukti2/$new_file2_name";
                            compressAndResizeImage($file2_destination, $compressed_file2_destination, 500, 500, 100);
                            unlink($file2_destination);

                            $bukti_terima = mysqli_query($connect, "INSERT INTO inv_bukti_terima_revisi (id_bukti_terima, id_komplain, bukti_satu, bukti_dua) VALUES ('$id_inv_bukti', '$id_komplain', '$new_file1_name', '$new_file2_name')");

                            $update_revisi_status_kirim = mysqli_query($connect, "UPDATE revisi_status_kirim SET jenis_penerima = 'Ekspedisi', dikirim_ekspedisi = '$id_ekspedisi', no_resi = '$resi', jenis_ongkir = '$jenis_ongkir'  WHERE id_komplain = '$id_komplain'");
                
                            if ($bukti_terima && $update_revisi_status_kirim) {
                                // Commit transaksi
                                $connect->commit();
                                ?>
                                <!-- Sweet Alert -->
                                <link rel="stylesheet" href="../assets/sweet-alert/dist/sweetalert2.min.css">
                                <script src="../assets/sweet-alert/dist/sweetalert2.all.min.js"></script>
                                <script>
                                    document.addEventListener("DOMContentLoaded", function() {
                                    Swal.fire({
                                        title: "Sukses",
                                        text: "Data Berhasil Disimpan",
                                        icon: "success",
                                    }).then(function() {
                                        window.location.href = "../list-invoice-revisi.php?sort=baru";
                                    });
                                    });
                                </script>
                                <?php
                            } else {
                                unlink($compressed_file1_destination);
                                unlink($compressed_file2_destination);
                            }
                        }elseif($file1_name != '' && $file3_name != ''){
                            // Kompres dan ubah ukuran gambar-revisi bukti terima 1
                            $compressed_file1_destination = "../../gambar-revisi/bukti1/$new_file1_name";
                            compressAndResizeImage($file1_destination, $compressed_file1_destination, 500, 500, 100);
                            unlink($file1_destination);

                            // Kompres dan ubah ukuran gambar-revisi bukti terima 3
                            $compressed_file3_destination = "../../gambar-revisi/bukti3/$new_file3_name";
                            compressAndResizeImage($file3_destination, $compressed_file3_destination, 500, 500, 100);
                            unlink($file3_destination);

                            $bukti_terima = mysqli_query($connect, "INSERT INTO inv_bukti_terima_revisi (id_bukti_terima, id_komplain, bukti_satu, bukti_tiga) VALUES ('$id_inv_bukti', '$id_komplain', '$new_file1_name', '$new_file3_name')");


                            $update_revisi_status_kirim = mysqli_query($connect, "UPDATE revisi_status_kirim SET jenis_penerima = 'Ekspedisi', dikirim_ekspedisi = '$id_ekspedisi', no_resi = '$resi', jenis_ongkir = '$jenis_ongkir'  WHERE id_komplain = '$id_komplain'");
                
                            if ($bukti_terima && $update_revisi_status_kirim) {
                                // Commit transaksi
                                $connect->commit();
                                ?>
                                <!-- Sweet Alert -->
                                <link rel="stylesheet" href="../assets/sweet-alert/dist/sweetalert2.min.css">
                                <script src="../assets/sweet-alert/dist/sweetalert2.all.min.js"></script>
                                <script>
                                    document.addEventListener("DOMContentLoaded", function() {
                                    Swal.fire({
                                        title: "Sukses",
                                        text: "Data Berhasil Disimpan",
                                        icon: "success",
                                    }).then(function() {
                                        window.location.href = "../list-invoice-revisi.php?sort=baru";
                                    });
                                    });
                                </script>
                                <?php
                            }else{
                                unlink($compressed_file1_destination);
                                unlink($compressed_file3_destination);
                            }
                        }elseif($file1_name != ''){
                            // Kompres dan ubah ukuran gambar-revisi bukti terima 1
                            $compressed_file1_destination = "../../gambar-revisi/bukti1/$new_file1_name";
                            compressAndResizeImage($file1_destination, $compressed_file1_destination, 500, 500, 100);
                            unlink($file1_destination);

                            $bukti_terima = mysqli_query($connect, "INSERT INTO inv_bukti_terima_revisi (id_bukti_terima, id_komplain, bukti_satu) VALUES ('$id_inv_bukti', '$id_komplain', '$new_file1_name')");

                            $update_revisi_status_kirim = mysqli_query($connect, "UPDATE revisi_status_kirim SET jenis_penerima = 'Ekspedisi', dikirim_ekspedisi = '$id_ekspedisi', no_resi = '$resi', jenis_ongkir = '$jenis_ongkir' WHERE id_komplain = '$id_komplain'");
                
                            if ($bukti_terima && $update_revisi_status_kirim) {
                                // Commit transaksi
                                $connect->commit();
                                ?>
                                <!-- Sweet Alert -->
                                <link rel="stylesheet" href="../assets/sweet-alert/dist/sweetalert2.min.css">
                                <script src="../assets/sweet-alert/dist/sweetalert2.all.min.js"></script>
                                <script>
                                    document.addEventListener("DOMContentLoaded", function() {
                                    Swal.fire({
                                        title: "Sukses",
                                        text: "Data Berhasil Disimpan",
                                        icon: "success",
                                    }).then(function() {
                                        window.location.href = "../list-invoice-revisi.php?sort=baru";
                                    });
                                    });
                                </script>
                                <?php
                            }else{
                                unlink($compressed_file1_destination);
                            }
                        }
                    } catch (Exception $e) {
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
                                window.location.href = "../list-invoice-revisi.php";
                            });
                            });
                        </script>
                        <?php
                    }
                }
            }else if(isset($_POST['diterima_ekspedisi'])){
                $connect->begin_transaction();
                try{
                    $uuid = generate_uuid();
                    $year = date('y');
                    $day = date('d');
                    $month = date('m');
                    $id_inv_penerima_revisi = "PNMR" . $year . "". $month . "" . $uuid . "" . $day;
                    $id_inv = $_POST['id_inv'];
                    $alamat = $_POST['alamat'];
                    $nama_penerima = $_POST['nama_penerima'];
                    $tgl = $_POST['tgl'];
                    // Query 1
                    $query_diterima = mysqli_query($connect, "INSERT INTO inv_penerima_revisi (id_inv_penerima_revisi, id_inv, nama_penerima, alamat) VALUES ('$id_inv_penerima_revisi', '$id_inv', '$nama_penerima', '$alamat')");

                    $query_update_inv = mysqli_query($connect, "UPDATE inv_nonppn SET status_transaksi = 'Dikirim' WHERE id_inv_nonppn = '$id_inv'");

                    if ($query_diterima && $query_update_inv) {
                        // Commit transaksi
                        $connect->commit();
                        ?>
                        <!-- Sweet Alert -->
                        <link rel="stylesheet" href="../assets/sweet-alert/dist/sweetalert2.min.css">
                        <script src="../assets/sweet-alert/dist/sweetalert2.all.min.js"></script>
                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                            Swal.fire({
                                title: "Sukses",
                                text: "Data Berhasil Disimpan",
                                icon: "success",
                            }).then(function() {
                                window.location.href = "../list-invoice-revisi.php?sort=baru";
                            });
                            });
                        </script>
                        <?php
                    }

                } catch (Exception $e) {
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
                            window.location.href = "../list-invoice-revisi.php";
                        });
                        });
                    </script>
                    <?php
                }
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

            function img_uuid() {
                $data = openssl_random_pseudo_bytes(16);
                assert(strlen($data) == 16);

                $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
                $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

                return vsprintf('%s%s', str_split(bin2hex($data), 4));
            }
            ?>
        </section>
    </main><!-- End #main -->
</body>
</html>
   