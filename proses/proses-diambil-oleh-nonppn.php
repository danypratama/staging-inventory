<?php  
    include "../koneksi.php";
    include "../page/resize-image.php";
    session_start();

    if(isset($_POST['diambil-oleh'])){
        $id_inv = $_POST['id_inv'];
        $diambil_oleh = $_POST['diambil_oleh'];

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
            $update_bukti_terima = mysqli_query($connect, "SELECT id_inv FROM inv_bukti_terima WHERE id_inv = '$id_inv'");

            if($update_bukti_terima -> num_rows > 0){
                $update_bukti_terima = mysqli_query($connect, "UPDATE inv_bukti_terima SET bukti_satu = '$new_file1_name' WHERE id_inv = '$id_inv'");

                $update_inv_penerima = mysqli_query($connect, "UPDATE inv_penerima SET nama_penerima = '$diambil_oleh' WHERE id_inv = '$id_inv'");

                $update_inv_nonppn = mysqli_query($connect, "UPDATE inv_nonppn SET status_transaksi = 'Diterima' WHERE id_inv_nonppn = '$id_inv'");

                if ($update_bukti_terima && $update_inv_penerima && $update_inv_nonppn) {
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
                                window.location.href = "../invoice-reguler-dikirim.php?sort=baru";
                            });
                            });
                        </script>
                    <?php
                }
            } else {
                $simpan_bukti_terima = mysqli_query($connect, "INSERT INTO inv_bukti_terima (id_bukti_terima, id_inv, bukti_satu) VALUES ('$id_bukti_terima', '$id_inv', '$new_file1_name')");

                $update_inv_penerima = mysqli_query($connect, "UPDATE inv_penerima SET nama_penerima = '$diambil_oleh' WHERE id_inv = '$id_inv'");

                $update_inv_nonppn = mysqli_query($connect, "UPDATE inv_nonppn SET status_transaksi = 'Diterima' WHERE id_inv_nonppn = '$id_inv'");
                
                if ($simpan_bukti_terima && $update_inv_penerima && $update_inv_nonppn) {
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
                                window.location.href = "../invoice-reguler-dikirim.php?sort=baru";
                            });
                            });
                        </script>
                    <?php
                }
            }
        }catch (Exception $e) {
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