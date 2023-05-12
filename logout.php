<?php
// Koneksi
include "koneksi.php";
session_start();

// Mengambil IP untuk logout akun mencurigakan
$ip = $_SESSION['ip'];
$cek_ip = $_GET['ip'];

$id_history = $_SESSION['encoded_id'];

// Simpan Waktu pada database
$id_user = $_SESSION['tiket_id'];
$offline = 'Offline';
$timezone = time() + (60 * 60 * 7);
$today = gmdate('Y/m/d G:i:s', $timezone);

if (isset($_GET['logout'])) {
    unset($_SESSION['username']);
    unset($_SESSION['login']);
    // Simpan History
    $decode = base64_decode($id_history);
    $history = mysqli_query($connect, "UPDATE user_history SET logout_time = '$today', status_perangkat = '$offline' WHERE id_history = '$decode'");

    session_destroy();
    header("Location:index.php");

    // Jika ada permintaan logout pengguna yang mencurigakan
} else if (isset($_GET['id_off'])) {
    session_destroy();
    header("Location:index.php");
}



// // Simpan History
// $id_history = $_GET['id'];
// $decode = base64_decode($id_history);
// $history = mysqli_query($connect, "UPDATE user_history SET logout_time = '$today', status_perangkat = '$offline' WHERE id_history = '$decode'");

// session_destroy();
// header("Location:index.php");
