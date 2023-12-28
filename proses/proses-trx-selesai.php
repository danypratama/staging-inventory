<?php  
include "../koneksi.php";

if(isset($_GET['id_inv_nonppn'])){
    $connect->begin_transaction();

    try{
        $year = date('y');
        $day = date('d');
        $month = date('m');
        $uuid = uuid();
        $id_finance = "FINANCE" . $year . "". $month . "" . $uuid . "" . $day;
        $id_inv_nonppn = $_GET['id_inv_nonppn'];
        $jenis_inv = "nonppn";
        $total_inv = $_GET['total_inv'];
    
        $update_inv_nonppn = mysqli_query($connect, "UPDATE inv_nonppn SET status_transaksi = 'Transaksi Selesai' WHERE id_inv_nonppn = '$id_inv_nonppn'");
        $create_finance = mysqli_query($connect, "INSERT INTO finance(id_finance, id_inv, jenis_inv, total_inv) VALUES ('$id_finance',  '$id_inv_nonppn', '$jenis_inv', '$total_inv')");
        $query_history_produk = mysqli_query($connect, "INSERT IGNORE INTO 
                                                            history_produk_terjual (id_trx_history, id_inv, id_produk, qty)
                                                        SELECT
                                                            tpr.id_transaksi,
                                                            spk.id_inv,
                                                            tpr.id_produk,
                                                            tpr.qty
                                                        FROM spk_reg AS spk
                                                        LEFT JOIN transaksi_produk_reg tpr ON spk.id_spk_reg = tpr.id_spk 
                                                        WHERE spk.id_inv = '$id_inv_nonppn'");

        if ($update_inv_nonppn && $create_finance && $query_history_produk) {
            // Commit transaksi
            $connect->commit();
            header("Location:../invoice-reguler-selesai.php");
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
                window.location.href = "../invoice-reguler-selesai.php";
            });
            });
        </script>
        <?php
    }
}else if(isset($_GET['id_inv_bum'])){
    $connect->begin_transaction();

    try{
        $year = date('y');
        $day = date('d');
        $month = date('m');
        $uuid = uuid();
        $id_finance = "FINANCE" . $year . "". $month . "" . $uuid . "" . $day;
        $id_inv_bum = $_GET['id_inv_bum'];
        $jenis_inv = "bum";
        $total_inv = $_GET['total_inv'];
    
        $update_inv_bum = mysqli_query($connect, "UPDATE inv_bum SET status_transaksi = 'Transaksi Selesai' WHERE id_inv_bum = '$id_inv_bum'");
        $create_finance = mysqli_query($connect, "INSERT INTO finance(id_finance, id_inv, jenis_inv, total_inv) VALUES ('$id_finance',  '$id_inv_bum', '$jenis_inv', '$total_inv')");
        $query_history_produk = mysqli_query($connect, "INSERT IGNORE INTO 
                                                            history_produk_terjual (id_trx_history, id_inv, id_produk, qty)
                                                        SELECT
                                                            tpr.id_transaksi,
                                                            spk.id_inv,
                                                            tpr.id_produk,
                                                            tpr.qty
                                                        FROM spk_reg AS spk
                                                        LEFT JOIN transaksi_produk_reg tpr ON spk.id_spk_reg = tpr.id_spk 
                                                        WHERE spk.id_inv = '$id_inv_bum'");

        if ($update_inv_bum && $create_finance && $query_history_produk) {
            // Commit transaksi
            $connect->commit();
            header("Location:../invoice-reguler-selesai.php");
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
                window.location.href = "../invoice-reguler-selesai.php";
            });
            });
        </script>
        <?php
    }
}else if(isset($_GET['id_inv_ppn'])){
    $connect->begin_transaction();

    try{
        $year = date('y');
        $day = date('d');
        $month = date('m');
        $uuid = uuid();
        $id_finance = "FINANCE" . $year . "". $month . "" . $uuid . "" . $day;
        $id_inv_ppn = $_GET['id_inv_ppn'];
        $jenis_inv = "ppn";
        $total_inv = $_GET['total_inv'];
    
        $update_inv_ppn = mysqli_query($connect, "UPDATE inv_ppn SET status_transaksi = 'Transaksi Selesai' WHERE id_inv_ppn = '$id_inv_ppn'");
        $create_finance = mysqli_query($connect, "INSERT INTO finance(id_finance, id_inv, jenis_inv, total_inv) VALUES ('$id_finance',  '$id_inv_ppn', '$jenis_inv', '$total_inv')");
        $query_history_produk = mysqli_query($connect, "INSERT IGNORE INTO 
                                                            history_produk_terjual (id_trx_history, id_inv, id_produk, qty)
                                                        SELECT
                                                            tpr.id_transaksi,
                                                            spk.id_inv,
                                                            tpr.id_produk,
                                                            tpr.qty
                                                        FROM spk_reg AS spk
                                                        LEFT JOIN transaksi_produk_reg tpr ON spk.id_spk_reg = tpr.id_spk 
                                                        WHERE spk.id_inv = '$id_inv_ppn'");

        if ($update_inv_ppn && $create_finance && $query_history_produk) {
            // Commit transaksi
            $connect->commit();
            header("Location:../invoice-reguler-selesai.php");
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
                window.location.href = "../invoice-reguler-selesai.php";
            });
            });
        </script>
        <?php
    }
}


function uuid() {
    $data = openssl_random_pseudo_bytes(16);
    assert(strlen($data) == 16);

    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

    return vsprintf('%s%s', str_split(bin2hex($data), 4));
}
?>