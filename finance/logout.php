<?php
// Koneksi
include "koneksi.php";
session_start();

$ip = $_SESSION['ip'];

$id_history = $_SESSION['encoded_id'];

// Simpan Waktu pada database
$id_user = $_SESSION['tiket_id'];
$offline = 'Offline';
$timezone = time() + (60 * 60 * 7);
$today = gmdate('Y/m/d G:i:s', $timezone);
unset($_SESSION['username']);
unset($_SESSION['login']);
// Simpan History
$decode = base64_decode($id_history);
$history = mysqli_query($connect, "UPDATE user_history SET logout_time = '$today', status_perangkat = '$offline' WHERE id_history = '$decode'");

session_destroy();
header("Location:login.php");
