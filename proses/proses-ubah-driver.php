<?php  
    include "../koneksi.php";
    if(isset($_POST['ubah-driver'])){
        $id_inv = $_POST['id_inv'];
        $pengirim = $_POST['pengirim'];
        $id_inv_substr = $id_inv;
        $inv_id = substr($id_inv_substr, 0, 3);

        $ubah_driver = mysqli_query($connect, "UPDATE status_kirim SET dikirim_driver = '$pengirim' WHERE id_inv = '$id_inv'");
        if ($inv_id = "NON"){
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
        } else if ($inv_id = "PPN"){
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
                        window.location.href = "../cek-produk-inv-ppn-dikirim.php?id=<?php echo base64_encode($id_inv) ?>";
                    });
                    });
                </script>
            <?php
        } else if ($inv_id = "BUM"){
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
                        window.location.href = "../cek-produk-inv-bum-dikirim.php?id=<?php echo base64_encode($id_inv) ?>";
                    });
                    });
                </script>
            <?php
        }

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