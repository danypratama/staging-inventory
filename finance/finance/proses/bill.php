<?php  
include "../koneksi.php";

if(isset($_POST['simpan-bill'])){
    $id_inv = $_POST['id_inv'];
    $uuid = uuid();
    $day = date('d');
    $month = date('m');
    $year = date('y');
    $id_tagihan = "BILL" . $year . "" . $month . "" . $uuid . "" . $day ;
    $total_tagihan = str_replace('.', '', $_POST['total_tagihan']); // Menghapus tanda ribuan (,)
    $total_tagihan = intval($total_tagihan); // Mengubah string harga menjadi integer
    $no_tagihan = mysqli_real_escape_string($connect, $_POST['no_tagihan']);
    $tgl_tagihan = mysqli_real_escape_string($connect, $_POST['tgl_tagihan']);
    
    foreach($id_inv as $id_inv_array){
        $id_inv_escape[] = mysqli_real_escape_string($connect, $id_inv_array);
    }

    // Begin transaction
    mysqli_begin_transaction($connect);

    try{
       
        $id_inv_count = count($id_inv_escape);
        for ($i = 0; $i < $id_inv_count; $i++){

            $sql_tagihan = mysqli_query($connect, "INSERT IGNORE INTO finance_tagihan (id_tagihan, no_tagihan, tgl_tagihan, total_tagihan) VALUES ('$id_tagihan','$no_tagihan', '$tgl_tagihan', '$total_tagihan')");
            $id_inv_array = $id_inv_escape[$i];

            $sql_finance = mysqli_query($connect, "UPDATE finance SET id_tagihan = '$id_tagihan', status_tagihan = 1  WHERE id_inv = '$id_inv_array'");
            if (!$sql_finance && !$sql_tagihan) {
                throw new Exception("Error updating data");
            }
        }
        // Commit the transaction
        mysqli_commit($connect);
        // Redirect to the invoice page
        header("Location:../finance-inv.php?date_range=weekly");
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
                    window.location.href = "../finance-inv.php?date_range=weekly";
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

    return vsprintf('%s%s%s', str_split(bin2hex($data), 4));
}
?>