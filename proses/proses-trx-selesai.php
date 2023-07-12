<?php  
include "../koneksi.php";

if(isset($_GET['id_inv_nonppn'])){
    $id_inv_nonppn = $_GET['id_inv_nonppn'];

    $update_data = mysqli_query($connect, "UPDATE inv_nonppn SET status_transaksi = 'Transaksi Selesai' WHERE id_inv_nonppn = '$id_inv_nonppn'");
    header("Location:../invoice-reguler-diterima.php");
}else if(isset($_GET['id_inv_bum'])){
    $id_inv_bum = $_GET['id_inv_bum'];

    $update_data = mysqli_query($connect, "UPDATE inv_bum SET status_transaksi = 'Transaksi Selesai' WHERE id_inv_bum = '$id_inv_bum'");
    header("Location:../invoice-reguler-diterima.php");
}else if(isset($_GET['id_inv_ppn'])){
    $id_inv_ppn = $_GET['id_inv_ppn'];

    $update_data = mysqli_query($connect, "UPDATE inv_ppn SET status_transaksi = 'Transaksi Selesai' WHERE id_inv_ppn = '$id_inv_ppn'");
    header("Location:../invoice-reguler-diterima.php");
}
?>