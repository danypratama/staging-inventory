<?php
session_start();


include "koneksi.php";
date_default_timezone_set('Asia/Jakarta');
$datetime = date('d/m/Y H:i:s');

$id_history = $_GET['id_off'];

$update_status_user = mysqli_query($connect, "UPDATE user_history SET logout_time = '$datetime', status_perangkat = 'Offline' WHERE id_history = '$id_history'");
if ($update_status_user) {
    $_SESSION['info'] = 'Dilogout';
    header("Location:data-user.php");
  } else {
    $_SESSION['info'] = 'Gagal Dilogout';
    header("Location:data-user.php");
  }
?>