<?php  
    include "../koneksi.php";
    include "../page/resize-image.php";
    session_start();

    if(isset($_POST['ubah-ongkir-nonppn'])){
        $id_inv = $_POST['id_inv'];
        $no_resi = $_POST['edit_resi'];
        $jenis_ongkir = $_POST['jenis_ongkir_edit'];
        $ongkir =  str_replace(',', '', $_POST['edit_ongkir']);
        $ongkir = intval($ongkir);

         // Begin transaction
         mysqli_begin_transaction($connect);
         try{
            $uuid = generate_uuid();
            $img_uuid = img_uuid();
            $year = date('y');
            $day = date('d');
            $month = date('m');
            $id_bukti_terima = "BKTI" . $year . "" . $uuid . "" . $day;

            // Mendapatkan informasi file bukti terima 1
            $file1_name = $_FILES['fileku1']['name'];
            $file1_tmp = $_FILES['fileku1']['tmp_name'];
            $file1_destination = "../gambar/bukti1/" . $file1_name;

            //Pindahkan file bukti terima ke lokasi tujuan
            move_uploaded_file($file1_tmp, $file1_destination);

            if($file1_name != ''){
                // Kompres dan ubah ukuran gambar bukti terima 1
                $new_file1_name = "Bukti_Satu". $year . "" . $month . "" . $img_uuid . "" . $day . ".jpg";
                $compressed_file1_destination = "../gambar/bukti1/$new_file1_name";
                compressAndResizeImage($file1_destination, $compressed_file1_destination, 500, 500, 100);
                unlink($file1_destination);
            }


            // Cek Bukti terima 
            $cek_bukti_terima = mysqli_query($connect, "SELECT id_inv FROM inv_bukti_terima WHERE id_inv = '$id_inv'");

            if($cek_bukti_terima -> num_rows > 0){
                $update_bukti_terima = mysqli_query($connect, "UPDATE inv_bukti_terima SET bukti_satu = '$new_file1_name' WHERE id_inv = '$id_inv'");

                $update_status_kirim = mysqli_query($connect, "UPDATE status_kirim SET no_resi = '$no_resi', jenis_ongkir = '$jenis_ongkir' WHERE id_inv = '$id_inv'");

                $update_inv_nonppn = mysqli_query($connect, "UPDATE inv_nonppn SET ongkir = '$ongkir' WHERE id_inv_nonppn = '$id_inv'");

                if ($update_bukti_terima && $update_status_kirim && $update_inv_nonppn) {
                    // Commit transaksi jika berhasil
                    mysqli_commit($connect);
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
                                window.location.href = "../cek-produk-inv-nonppn-dikirim.php?id=<?php echo base64_encode($id_inv) ?>";
                            });
                            });
                        </script>
                    <?php
                }
            } else {
                $simpan_bukti_terima = mysqli_query($connect, "INSERT INTO inv_bukti_terima (id_bukti_terima, id_inv, bukti_satu) VALUES ('$id_bukti_terima', '$id_inv', '$new_file1_name')");

                $update_status_kirim = mysqli_query($connect, "UPDATE status_kirim SET no_resi = '$no_resi', jenis_ongkir = '$jenis_ongkir' WHERE id_inv = '$id_inv'");

                $update_inv_nonppn = mysqli_query($connect, "UPDATE inv_nonppn SET ongkir = '$ongkir' WHERE id_inv_nonppn = '$id_inv'");
                
                if ($simpan_bukti_terima && $update_status_kirim && $update_inv_nonppn) {
                    // Commit transaksi jika berhasil
                    mysqli_commit($connect);
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
                                window.location.href = "../cek-produk-inv-nonppn-dikirim.php?id=<?php echo base64_encode($id_inv) ?>";
                            });
                            });
                        </script>
                    <?php
                }
            }          
        } catch (Exception $e){
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
                            window.location.href = "../cek-produk-inv-nonppn-dikirim.php?id=<?php echo base64_encode($id_inv) ?>";
                        });
                    });
                    </script>
                <?php 
        }

        
    } else if(isset($_POST['ubah-ongkir-ppn'])){
        $id_inv = $_POST['id_inv'];
        $no_resi = $_POST['edit_resi'];
        $jenis_ongkir = $_POST['jenis_ongkir_edit'];
        $ongkir =  str_replace(',', '', $_POST['edit_ongkir']);
        $ongkir = intval($ongkir);

         // Begin transaction
         mysqli_begin_transaction($connect);
         try{
            $uuid = generate_uuid();
            $img_uuid = img_uuid();
            $year = date('y');
            $day = date('d');
            $month = date('m');
            $id_bukti_terima = "BKTI" . $year . "" . $uuid . "" . $day;

            // Mendapatkan informasi file bukti terima 1
            $file1_name = $_FILES['fileku1']['name'];
            $file1_tmp = $_FILES['fileku1']['tmp_name'];
            $file1_destination = "../gambar/bukti1/" . $file1_name;

            //Pindahkan file bukti terima ke lokasi tujuan
            move_uploaded_file($file1_tmp, $file1_destination);

            if($file1_name != ''){
                // Kompres dan ubah ukuran gambar bukti terima 1
                $new_file1_name = "Bukti_Satu". $year . "" . $month . "" . $img_uuid . "" . $day . ".jpg";
                $compressed_file1_destination = "../gambar/bukti1/$new_file1_name";
                compressAndResizeImage($file1_destination, $compressed_file1_destination, 500, 500, 100);
                unlink($file1_destination);
            }


            // Cek Bukti terima 
            $cek_bukti_terima = mysqli_query($connect, "SELECT id_inv FROM inv_bukti_terima WHERE id_inv = '$id_inv'");

            if($cek_bukti_terima -> num_rows > 0){
                $update_bukti_terima = mysqli_query($connect, "UPDATE inv_bukti_terima SET bukti_satu = '$new_file1_name' WHERE id_inv = '$id_inv'");

                $update_status_kirim = mysqli_query($connect, "UPDATE status_kirim SET no_resi = '$no_resi', jenis_ongkir = '$jenis_ongkir' WHERE id_inv = '$id_inv'");

                $update_inv_ppn = mysqli_query($connect, "UPDATE inv_ppn SET ongkir = '$ongkir' WHERE id_inv_ppn = '$id_inv'");

                if ($update_bukti_terima && $update_status_kirim && $update_inv_ppn) {
                    // Commit transaksi jika berhasil
                    mysqli_commit($connect);
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
                                window.location.href = "../cek-produk-inv-ppn-dikirim.php?id=<?php echo base64_encode($id_inv) ?>";
                            });
                            });
                        </script>
                    <?php
                }
            } else {
                $simpan_bukti_terima = mysqli_query($connect, "INSERT INTO inv_bukti_terima (id_bukti_terima, id_inv, bukti_satu) VALUES ('$id_bukti_terima', '$id_inv', '$new_file1_name')");

                $update_status_kirim = mysqli_query($connect, "UPDATE status_kirim SET no_resi = '$no_resi', jenis_ongkir = '$jenis_ongkir' WHERE id_inv = '$id_inv'");

                $update_inv_ppn = mysqli_query($connect, "UPDATE inv_ppn SET ongkir = '$ongkir' WHERE id_inv_ppn = '$id_inv'");
                
                if ($simpan_bukti_terima && $update_status_kirim && $update_inv_ppn) {
                    // Commit transaksi jika berhasil
                    mysqli_commit($connect);
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
                                window.location.href = "../cek-produk-inv-ppn-dikirim.php?id=<?php echo base64_encode($id_inv) ?>";
                            });
                            });
                        </script>
                    <?php
                }
            }          
        } catch (Exception $e){
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
                            window.location.href = "../cek-produk-inv-ppn-dikirim.php?id=<?php echo base64_encode($id_inv) ?>";
                        });
                    });
                    </script>
                <?php 
        }

    } else if(isset($_POST['ubah-ongkir-bum'])){
        $id_inv = $_POST['id_inv'];
        $no_resi = $_POST['edit_resi'];
        $jenis_ongkir = $_POST['jenis_ongkir_edit'];
        $ongkir =  str_replace(',', '', $_POST['edit_ongkir']);
        $ongkir = intval($ongkir);

         // Begin transaction
         mysqli_begin_transaction($connect);
         try{
            $uuid = generate_uuid();
            $img_uuid = img_uuid();
            $year = date('y');
            $day = date('d');
            $month = date('m');
            $id_bukti_terima = "BKTI" . $year . "" . $uuid . "" . $day;

            // Mendapatkan informasi file bukti terima 1
            $file1_name = $_FILES['fileku1']['name'];
            $file1_tmp = $_FILES['fileku1']['tmp_name'];
            $file1_destination = "../gambar/bukti1/" . $file1_name;

            //Pindahkan file bukti terima ke lokasi tujuan
            move_uploaded_file($file1_tmp, $file1_destination);

            if($file1_name != ''){
                // Kompres dan ubah ukuran gambar bukti terima 1
                $new_file1_name = "Bukti_Satu". $year . "" . $month . "" . $img_uuid . "" . $day . ".jpg";
                $compressed_file1_destination = "../gambar/bukti1/$new_file1_name";
                compressAndResizeImage($file1_destination, $compressed_file1_destination, 500, 500, 100);
                unlink($file1_destination);
            }


            // Cek Bukti terima 
            $cek_bukti_terima = mysqli_query($connect, "SELECT id_inv FROM inv_bukti_terima WHERE id_inv = '$id_inv'");

            if($cek_bukti_terima -> num_rows > 0){
                $update_bukti_terima = mysqli_query($connect, "UPDATE inv_bukti_terima SET bukti_satu = '$new_file1_name' WHERE id_inv = '$id_inv'");

                $update_status_kirim = mysqli_query($connect, "UPDATE status_kirim SET no_resi = '$no_resi', jenis_ongkir = '$jenis_ongkir' WHERE id_inv = '$id_inv'");

                $update_inv_bum = mysqli_query($connect, "UPDATE inv_bum SET ongkir = '$ongkir' WHERE id_inv_bum = '$id_inv'");

                if ($update_bukti_terima && $update_status_kirim && $update_inv_bum) {
                    // Commit transaksi jika berhasil
                    mysqli_commit($connect);
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
                                window.location.href = "../cek-produk-inv-bum-dikirim.php?id=<?php echo base64_encode($id_inv) ?>";
                            });
                            });
                        </script>
                    <?php
                }
            } else {
                $simpan_bukti_terima = mysqli_query($connect, "INSERT INTO inv_bukti_terima (id_bukti_terima, id_inv, bukti_satu) VALUES ('$id_bukti_terima', '$id_inv', '$new_file1_name')");

                $update_status_kirim = mysqli_query($connect, "UPDATE status_kirim SET no_resi = '$no_resi', jenis_ongkir = '$jenis_ongkir' WHERE id_inv = '$id_inv'");

                $update_inv_bum = mysqli_query($connect, "UPDATE inv_bum SET ongkir = '$ongkir' WHERE id_inv_bum = '$id_inv'");
                
                if ($simpan_bukti_terima && $update_status_kirim && $update_inv_bum) {
                    // Commit transaksi jika berhasil
                    mysqli_commit($connect);
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
                                window.location.href = "../cek-produk-inv-bum-dikirim.php?id=<?php echo base64_encode($id_inv) ?>";
                            });
                            });
                        </script>
                    <?php
                }
            }          
        } catch (Exception $e){
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
                            window.location.href = "../cek-produk-inv-bum-dikirim.php?id=<?php echo base64_encode($id_inv) ?>";
                        });
                    });
                    </script>
                <?php 
        }

    }    
    
    
    function img_uuid() {
        $data = openssl_random_pseudo_bytes(16);
        assert(strlen($data) == 16);
    
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
    
        return vsprintf('%s%s', str_split(bin2hex($data), 4));
    }

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