<?php  
    include "../koneksi.php";

    if(isset($_POST['ubah-ongkir-nonppn'])){
        $id_inv = $_POST['id_inv'];
        $no_resi = $_POST['resi'];
        $ongkir =  str_replace(',', '', $_POST['ongkir']);
        $ongkir = intval($ongkir);

         // Begin transaction
         mysqli_begin_transaction($connect);
         try{
            $update_status_kirim = mysqli_query($connect, "UPDATE status_kirim SET no_resi = '$no_resi' WHERE id_inv = '$id_inv'");
            $update_inv_nonppn = mysqli_query($connect, "UPDATE inv_nonppn SET ongkir = '$ongkir' WHERE id_inv_nonppn = '$id_inv'");

            if($update_status_kirim && $update_inv_nonppn){
                 // Commit the transaction
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
        $no_resi = $_POST['resi'];
        $ongkir =  str_replace(',', '', $_POST['ongkir']);
        $ongkir = intval($ongkir);

         // Begin transaction
         mysqli_begin_transaction($connect);
         try{
            $update_status_kirim = mysqli_query($connect, "UPDATE status_kirim SET no_resi = '$no_resi' WHERE id_inv = '$id_inv'");
            $update_inv_ppn = mysqli_query($connect, "UPDATE inv_ppn SET ongkir = '$ongkir' WHERE id_inv_ppn = '$id_inv'");

            if($update_status_kirim && $update_inv_ppn){
                 // Commit the transaction
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
        $no_resi = $_POST['resi'];
        $ongkir =  str_replace(',', '', $_POST['ongkir']);
        $ongkir = intval($ongkir);

         // Begin transaction
         mysqli_begin_transaction($connect);
         try{
            $update_status_kirim = mysqli_query($connect, "UPDATE status_kirim SET no_resi = '$no_resi' WHERE id_inv = '$id_inv'");
            $update_inv_bum = mysqli_query($connect, "UPDATE inv_bum SET ongkir = '$ongkir' WHERE id_inv_bum = '$id_inv'");

            if($update_status_kirim && $update_inv_bum){
                 // Commit the transaction
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
?>