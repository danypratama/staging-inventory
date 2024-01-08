<?php  
    session_start();
    include "../koneksi.php";
    
    $id_status_kirim = base64_decode($_GET['id_status_kirim']);
    $id_inv = base64_decode($_GET['id_inv']);
    // Kode untuk membuat kondisi update Nonppn, Ppn, dan Bum
    $id_inv_substr = substr($id_inv, 0,3);
    if($id_inv_substr == 'NON'){
        mysqli_begin_transaction($connect);
        try {
            // Kode yang mungkin menyebabkan kesalahan
            $cek_inv_penerima = mysqli_query($connect, "SELECT id_inv FROM inv_penerima WHERE id_inv = '$id_inv'");

            if($cek_inv_penerima->num_rows > 0){
                $update_inv = mysqli_query($connect, "UPDATE inv_nonppn SET status_transaksi = 'Belum Dikirim' WHERE id_inv_nonppn = '$id_inv'");
                $delete_status_kirim = mysqli_query($connect, "DELETE FROM status_kirim WHERE id_status_kirim = '$id_status_kirim'");
                $delete_inv_penerima = mysqli_query($connect, "DELETE FROM inv_penerima WHERE id_inv = '$id_inv'"); 
                if($update_inv && $delete_status_kirim && $delete_inv_penerima){
                    mysqli_commit($connect);
                    ?>
                        <!-- Sweet Alert -->
                        <link rel="stylesheet" href="../assets/sweet-alert/dist/sweetalert2.min.css">
                        <script src="../assets/sweet-alert/dist/sweetalert2.all.min.js"></script>
                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                            Swal.fire({
                                title: "Sukses",
                                text: "Data Berhasil Diupdate",
                                icon: "success",
                            }).then(function() {
                                window.location.href = "../invoice-reguler-dikirim.php";
                            });
                            });
                        </script>
                    <?php
                }
            } else {
                $update_inv = mysqli_query($connect, "UPDATE inv_nonppn SET status_transaksi = 'Belum Dikirim' WHERE id_inv_nonppn = '$id_inv'");
                $delete_status_kirim = mysqli_query($connect, "DELETE FROM status_kirim WHERE id_status_kirim = '$id_status_kirim'");
                if($update_inv && $delete_status_kirim){
                    mysqli_commit($connect);
                    ?>
                        <!-- Sweet Alert -->
                        <link rel="stylesheet" href="../assets/sweet-alert/dist/sweetalert2.min.css">
                        <script src="../assets/sweet-alert/dist/sweetalert2.all.min.js"></script>
                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                            Swal.fire({
                                title: "Sukses",
                                text: "Data Berhasil Diupdate",
                                icon: "success",
                            }).then(function() {
                                window.location.href = "../invoice-reguler-dikirim.php";
                            });
                            });
                        </script>
                    <?php
                }
            }

        } catch (Exception $e) {
            // Tangani kesalahan di sini
            mysqli_rollback($connect);
            $error_message = "Terjadi kesalahan saat ubah pengiriman: " . $e->getMessage();
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
                        window.location.href = "../invoice-reguler-dikirim.php";
                    });
                    });
                </script>
            <?php
        }
    }else if($id_inv_substr == 'PPN'){
        mysqli_begin_transaction($connect);
        try {
            // Kode yang mungkin menyebabkan kesalahan
            $cek_inv_penerima = mysqli_query($connect, "SELECT id_inv FROM inv_penerima WHERE id_inv = '$id_inv'");

            if($cek_inv_penerima->num_rows > 0){
                $update_inv = mysqli_query($connect, "UPDATE inv_ppn SET status_transaksi = 'Belum Dikirim' WHERE id_inv_ppn = '$id_inv'");
                $delete_status_kirim = mysqli_query($connect, "DELETE FROM status_kirim WHERE id_status_kirim = '$id_status_kirim'");
                $delete_inv_penerima = mysqli_query($connect, "DELETE FROM inv_penerima WHERE id_inv = '$id_inv'"); 
                if($update_inv && $delete_status_kirim && $delete_inv_penerima){
                    mysqli_commit($connect);
                    ?>
                        <!-- Sweet Alert -->
                        <link rel="stylesheet" href="../assets/sweet-alert/dist/sweetalert2.min.css">
                        <script src="../assets/sweet-alert/dist/sweetalert2.all.min.js"></script>
                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                            Swal.fire({
                                title: "Sukses",
                                text: "Data Berhasil Diupdate",
                                icon: "success",
                            }).then(function() {
                                window.location.href = "../invoice-reguler-dikirim.php";
                            });
                            });
                        </script>
                    <?php
                }
            } else {
                $update_inv = mysqli_query($connect, "UPDATE inv_ppn SET status_transaksi = 'Belum Dikirim' WHERE id_inv_ppn = '$id_inv'");
                $delete_status_kirim = mysqli_query($connect, "DELETE FROM status_kirim WHERE id_status_kirim = '$id_status_kirim'");
                if($update_inv && $delete_status_kirim){
                    mysqli_commit($connect);
                    ?>
                        <!-- Sweet Alert -->
                        <link rel="stylesheet" href="../assets/sweet-alert/dist/sweetalert2.min.css">
                        <script src="../assets/sweet-alert/dist/sweetalert2.all.min.js"></script>
                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                            Swal.fire({
                                title: "Sukses",
                                text: "Data Berhasil Diupdate",
                                icon: "success",
                            }).then(function() {
                                window.location.href = "../invoice-reguler-dikirim.php";
                            });
                            });
                        </script>
                    <?php
                }
            }

        } catch (Exception $e) {
            // Tangani kesalahan di sini
            mysqli_rollback($connect);
            $error_message = "Terjadi kesalahan saat ubah pengiriman: " . $e->getMessage();
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
                        window.location.href = "../invoice-reguler-dikirim.php";
                    });
                    });
                </script>
            <?php
        }
    }else if($id_inv_substr == "BUM"){
        mysqli_begin_transaction($connect);
        try {
            // Kode yang mungkin menyebabkan kesalahan
            $cek_inv_penerima = mysqli_query($connect, "SELECT id_inv FROM inv_penerima WHERE id_inv = '$id_inv'");

            if($cek_inv_penerima->num_rows > 0){
                $update_inv = mysqli_query($connect, "UPDATE inv_bum SET status_transaksi = 'Belum Dikirim' WHERE id_inv_bum = '$id_inv'");
                $delete_status_kirim = mysqli_query($connect, "DELETE FROM status_kirim WHERE id_status_kirim = '$id_status_kirim'");
                $delete_inv_penerima = mysqli_query($connect, "DELETE FROM inv_penerima WHERE id_inv = '$id_inv'"); 
                if($update_inv && $delete_status_kirim && $delete_inv_penerima){
                    mysqli_commit($connect);
                    ?>
                        <!-- Sweet Alert -->
                        <link rel="stylesheet" href="../assets/sweet-alert/dist/sweetalert2.min.css">
                        <script src="../assets/sweet-alert/dist/sweetalert2.all.min.js"></script>
                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                            Swal.fire({
                                title: "Sukses",
                                text: "Data Berhasil Diupdate",
                                icon: "success",
                            }).then(function() {
                                window.location.href = "../invoice-reguler-dikirim.php";
                            });
                            });
                        </script>
                    <?php
                }
            } else {
                $update_inv = mysqli_query($connect, "UPDATE inv_bum SET status_transaksi = 'Belum Dikirim' WHERE id_inv_bum = '$id_inv'");
                $delete_status_kirim = mysqli_query($connect, "DELETE FROM status_kirim WHERE id_status_kirim = '$id_status_kirim'");
                if($update_inv && $delete_status_kirim){
                    mysqli_commit($connect);
                    ?>
                        <!-- Sweet Alert -->
                        <link rel="stylesheet" href="../assets/sweet-alert/dist/sweetalert2.min.css">
                        <script src="../assets/sweet-alert/dist/sweetalert2.all.min.js"></script>
                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                            Swal.fire({
                                title: "Sukses",
                                text: "Data Berhasil Diupdate",
                                icon: "success",
                            }).then(function() {
                                window.location.href = "../invoice-reguler-dikirim.php";
                            });
                            });
                        </script>
                    <?php
                }
            }

        } catch (Exception $e) {
            // Tangani kesalahan di sini
            mysqli_rollback($connect);
            $error_message = "Terjadi kesalahan saat ubah pengiriman: " . $e->getMessage();
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
                        window.location.href = "../invoice-reguler-dikirim.php";
                    });
                    });
                </script>
            <?php
        }
    }
?>