<?php  
include "../koneksi.php";

if(isset($_GET['id_inv_nonppn'])){
    $id_inv_nonppn = $_GET['id_inv_nonppn'];

    $update_data = mysqli_query($connect, "UPDATE inv_nonppn SET status_transaksi = 'Transaksi Selesai' WHERE id_inv_nonppn = '$id_inv_nonppn'");
    header("Location:../invoice-reguler-diterima.php");
}


?>