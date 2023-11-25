<?php
session_start();
include "../koneksi.php";
include "../page/resize-image.php";

if(isset($_POST['diterima_driver'])){
    $diterima_oleh = $_POST['diterima_oleh'];
    if($diterima_oleh == 'Customer'){
        $connect->begin_transaction();
        try{
            $uuid = generate_uuid();
            $img_uuid = img_uuid();
            $year = date('y');
            $day = date('d');
            $month = date('m');
            $id_inv_bukti = "BKTI" . $year . "". $month . "" . $uuid . "" . $day;
            $id_inv_penerima = "PNMR" . $year . "". $month . "" . $uuid . "" . $day;
            $id_inv = $_POST['id_inv'];
            $alamat = $_POST['alamat'];
            $nama_penerima = $_POST['nama_penerima'];
            $tgl = $_POST['tgl'];

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

            $new_file1_name = "Bukti_Satu". $year . "" . $month . "" . $img_uuid . "" . $day . ".jpg";
            $new_file2_name = "Bukti_Dua". $year . "" . $month . "" . $img_uuid . "" . $day . ".jpg";
            $new_file3_name = "Bukti_Tiga". $year . "" . $month . "" . $img_uuid . "" . $day . ".jpg";

            if($file1_name != '' && $file2_name != '' &&  $file3_name != ''){
                // Kompres dan ubah ukuran gambar bukti terima 1
                $compressed_file1_destination = "../gambar/bukti1/$new_file1_name";
                compressAndResizeImage($file1_destination, $compressed_file1_destination, 500, 500, 100);
                unlink($file1_destination);

                // Kompres dan ubah ukuran gambar bukti terima 2
                $compressed_file2_destination = "../gambar/bukti2/$new_file2_name";
                compressAndResizeImage($file2_destination, $compressed_file2_destination, 500, 500, 100);
                unlink($file2_destination);

                // Kompres dan ubah ukuran gambar bukti terima 3
                $compressed_file3_destination = "../gambar/bukti3/$new_file3_name";
                compressAndResizeImage($file3_destination, $compressed_file3_destination, 500, 500, 100);
                unlink($file3_destination);

                $bukti_terima = mysqli_query($connect, "INSERT INTO inv_bukti_terima (id_bukti_terima, id_inv, bukti_satu, bukti_dua, bukti_tiga) VALUES ('$id_inv_bukti', '$id_inv', '$new_file1_name', '$new_file2_name', '$new_file3_name')");

                $query_diterima = mysqli_query($connect, "INSERT INTO inv_penerima (id_inv_penerima, id_inv, nama_penerima, alamat) VALUES ('$id_inv_penerima', '$id_inv', '$nama_penerima', '$alamat')");
    
                $query_update_inv = mysqli_query($connect, "UPDATE inv_bum SET status_transaksi = 'Diterima' WHERE id_inv_bum = '$id_inv'");

                $query_update_status = mysqli_query($connect, "UPDATE status_kirim SET jenis_penerima = 'Customer' WHERE id_inv = '$id_inv'");
    
                if ( $bukti_terima && $query_diterima && $query_update_inv && $query_update_status) {
                    // Commit transaksi
                    $connect->commit();
                    header("Location:../invoice-reguler-dikirim.php?sort=baru");
                }
            }elseif($file1_name != '' && $file2_name != ''){
                // Kompres dan ubah ukuran gambar bukti terima 1
                $compressed_file1_destination = "../gambar/bukti1/$new_file1_name";
                compressAndResizeImage($file1_destination, $compressed_file1_destination, 500, 500, 100);
                unlink($file1_destination);

                // Kompres dan ubah ukuran gambar bukti terima 2
                $compressed_file2_destination = "../gambar/bukti2/$new_file2_name";
                compressAndResizeImage($file2_destination, $compressed_file2_destination, 500, 500, 100);
                unlink($file2_destination);

                $bukti_terima = mysqli_query($connect, "INSERT INTO inv_bukti_terima (id_bukti_terima, id_inv, bukti_satu, bukti_dua) VALUES ('$id_inv_bukti', '$id_inv', '$new_file1_name', '$new_file2_name')");

                $query_diterima = mysqli_query($connect, "INSERT INTO inv_penerima (id_inv_penerima, id_inv, nama_penerima, alamat) VALUES ('$id_inv_penerima', '$id_inv', '$nama_penerima', '$alamat')");
    
                $query_update_inv = mysqli_query($connect, "UPDATE inv_bum SET status_transaksi = 'Diterima' WHERE id_inv_bum = '$id_inv'");

                $query_update_status = mysqli_query($connect, "UPDATE status_kirim SET jenis_penerima = 'Customer' WHERE id_inv = '$id_inv'");
    
                if ( $bukti_terima && $query_diterima && $query_update_inv && $query_update_status) {
                    // Commit transaksi
                    $connect->commit();
                    header("Location:../invoice-reguler-dikirim.php?sort=baru");
                }
            }elseif($file1_name != '' && $file3_name != ''){
                // Kompres dan ubah ukuran gambar bukti terima 1
                $compressed_file1_destination = "../gambar/bukti1/$new_file1_name";
                compressAndResizeImage($file1_destination, $compressed_file1_destination, 500, 500, 100);
                unlink($file1_destination);

                $bukti_terima = mysqli_query($connect, "INSERT INTO inv_bukti_terima (id_bukti_terima, id_inv, bukti_satu, bukti_tiga) VALUES ('$id_inv_bukti', '$id_inv', '$new_file1_name', '$new_file3_name')");

                $query_diterima = mysqli_query($connect, "INSERT INTO inv_penerima (id_inv_penerima, id_inv, nama_penerima, alamat) VALUES ('$id_inv_penerima', '$id_inv', '$nama_penerima', '$alamat')");
    
                $query_update_inv = mysqli_query($connect, "UPDATE inv_bum SET status_transaksi = 'Diterima' WHERE id_inv_bum = '$id_inv'");

                $query_update_status = mysqli_query($connect, "UPDATE status_kirim SET jenis_penerima = 'Customer' WHERE id_inv = '$id_inv'");
    
                if ( $bukti_terima && $query_diterima && $query_update_inv && $query_update_status) {
                    // Commit transaksi
                    $connect->commit();
                    header("Location:../invoice-reguler-dikirim.php?sort=baru");
                }
            }elseif($file1_name != ''){
                // Kompres dan ubah ukuran gambar bukti terima 1
                $compressed_file1_destination = "../gambar/bukti1/$new_file1_name";
                compressAndResizeImage($file1_destination, $compressed_file1_destination, 500, 500, 100);
                unlink($file1_destination);

                $bukti_terima = mysqli_query($connect, "INSERT INTO inv_bukti_terima (id_bukti_terima, id_inv, bukti_satu) VALUES ('$id_inv_bukti', '$id_inv', '$new_file1_name')");

                $query_diterima = mysqli_query($connect, "INSERT INTO inv_penerima (id_inv_penerima, id_inv, nama_penerima, alamat) VALUES ('$id_inv_penerima', '$id_inv', '$nama_penerima', '$alamat')");
    
                $query_update_inv = mysqli_query($connect, "UPDATE inv_bum SET status_transaksi = 'Diterima' WHERE id_inv_bum = '$id_inv'");

                $query_update_status = mysqli_query($connect, "UPDATE status_kirim SET jenis_penerima = 'Customer' WHERE id_inv = '$id_inv'");
    
                if ( $bukti_terima && $query_diterima && $query_update_inv && $query_update_status) {
                    // Commit transaksi
                    $connect->commit();
                    header("Location:../invoice-reguler-dikirim.php?sort=baru");
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
                    window.location.href = "../invoice-reguler.php?sort=baru";
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
            $id_inv_penerima = "PNMR" . $year . "". $month . "" . $uuid . "" . $day;
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

            if($file1_name != ''){
                // Kompres dan ubah ukuran gambar bukti terima 1
                $new_file1_name = "Bukti_Satu". $year . "" . $month . "" . $img_uuid . "" . $day . ".jpg";
                $compressed_file1_destination = "../gambar/bukti1/$new_file1_name";
                compressAndResizeImage($file1_destination, $compressed_file1_destination, 500, 500, 100);
                unlink($file1_destination);
            }elseif($file2_name != ''){
                // Kompres dan ubah ukuran gambar bukti terima 2
                $new_file1_name = "Bukti_Dua". $year . "" . $img_uuid . "" . $day . ".jpg";
                $compressed_file2_destination = "../gambar/bukti2/$new_file2_name";
                compressAndResizeImage($file2_destination, $compressed_file2_destination, 500, 500, 100);
                unlink($file2_destination);
            }elseif($file3_name != ''){
                // Kompres dan ubah ukuran gambar bukti terima 3
                $new_file1_name = "Bukti_Tiga". $year . "" . $img_uuid . "" . $day . ".jpg";
                $compressed_file3_destination = "../gambar/bukti3/$nem_file3_name";
                compressAndResizeImage($file3_destination, $compressed_file3_destination, 500, 500, 100);
                unlink($file3_destination);
            }

            $bukti_terima = mysqli_query($connect, "INSERT INTO inv_bukti_terima (id_bukti_terima, id_inv, bukti_satu) VALUES ('$id_inv_bukti', '$id_inv', '$new_file1_name')");

            $update_inv = mysqli_query($connect, "UPDATE inv_bum SET ongkir = '$ongkir', status_transaksi = 'Dikirim' WHERE id_inv_bum = '$id_inv'");

            $update_status_kirim = mysqli_query($connect, "UPDATE status_kirim SET jenis_penerima = 'Ekspedisi', dikirim_ekspedisi = '$id_ekspedisi', no_resi = '$resi', jenis_ongkir = '$jenis_ongkir'  WHERE id_inv = '$id_inv'");


            if ( $bukti_terima && $update_inv && $update_status_kirim) {
                // Commit transaksi
                $connect->commit();
                header("Location:../invoice-reguler-dikirim.php?sort=baru");
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
                    window.location.href = "../invoice-reguler-dikirim.php?sort=baru";
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
        $id_inv_penerima = "PNMR" . $year . "". $month . "" . $uuid . "" . $day;
        $id_inv = $_POST['id_inv'];
        $alamat = $_POST['alamat'];
        $nama_penerima = $_POST['nama_penerima'];
        $tgl = $_POST['tgl'];
        // Query 1
        $query_diterima = mysqli_query($connect, "INSERT INTO inv_penerima (id_inv_penerima, id_inv, nama_penerima, alamat) VALUES ('$id_inv_penerima', '$id_inv', '$nama_penerima', '$alamat')");

        $query_update_inv = mysqli_query($connect, "UPDATE inv_bum SET status_transaksi = 'Diterima' WHERE id_inv_bum = '$id_inv'");

        if ($query_diterima && $query_update_inv) {
            // Commit transaksi
            $connect->commit();
            header("Location:../invoice-reguler-dikirim.php?sort=baru");
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
                window.location.href = "../invoice-reguler-dikirim.php?sort=baru";
            });
            });
        </script>
        <?php
    }
}
?>


<!-- Generate UUID -->
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