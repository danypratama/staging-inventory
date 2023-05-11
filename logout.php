<?php
// Koneksi
include "koneksi.php";

session_start();

unset($_SESSION['username']);
unset($_SESSION['login']);

$ip = $_SESSION['ip'];
$last_login = $_SESSION['last_login'];
$os = $_SESSION['os'];
$lok = $_SESSION['lokasi'];

// Simpan Waktu pada database
$id_user = $_SESSION['tiket_id'];
$offline = 'Offline';
$timezone = time() + (60 * 60 * 7);
$today = gmdate('Y/m/d G:i:s', $timezone);

// Simpan History
$id_history = $_GET['id'];
$decode = base64_decode($id_history);
$history = mysqli_query($connect, "UPDATE user_history SET logout_time = '$today', status_perangkat = '$offline' WHERE id_history = '$decode'");

session_destroy();
header("Location:index.php");
