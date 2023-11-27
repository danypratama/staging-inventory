<?php  
    include "../koneksi.php";
    if(isset($_POST['ubah-driver'])){
        $id_inv = $_POST['id_inv'];
        $pengirim = $_POST['pengirim'];

        $ubah_driver = mysqli_query($connect, "UPDATE status_kirim SET dikirim_driver = '$pengirim' WHERE id_inv = '$id_inv'");
        ?>
            <!-- Sweet Alert -->
            <link rel="stylesheet" href="../assets/sweet-alert/dist/sweetalert2.min.css">
            <script src="../assets/sweet-alert/dist/sweetalert2.all.min.js"></script>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: "Sukses",
                    text: "Data Berhasil Di Ubah",
                    icon: "success",
                }).then(function() {
                    window.location.href = "../cek-produk-inv-nonppn-dikirim.php?id=<?php echo base64_encode($id_inv) ?>";
                });
                });
            </script>
        <?php

    } else {
        ?>
            <!-- Sweet Alert -->
            <link rel="stylesheet" href="../assets/sweet-alert/dist/sweetalert2.min.css">
            <script src="../assets/sweet-alert/dist/sweetalert2.all.min.js"></script>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: "Error!",
                    text: "Data Gagal Di Ubah",
                    icon: "error",
                }).then(function() {
                    window.location.href = "../cek-produk-inv-nonppn-dikirim.php?id=<?php echo base64_encode($id_inv) ?>";
                });
                });
            </script>
        <?php
    }
?>