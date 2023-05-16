<?php
// Koneksi
include "koneksi.php";
session_start();

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
    header("Location:login.php");

    // Jika ada permintaan logout pengguna yang mencurigakan
} else if (isset($_GET['ip']) && isset($_GET['id_off'])) {
    // Setelah proses verifikasi login berhasil
    $ip_login = $_SESSION['ip_login'];
    $id_history = $_SESSION['id_history'];

    if ($ip_login != $cek_ip || $id_history != $_GET['id_off']) {
        // IP atau ID history tidak sesuai, lakukan logout
        // Hapus seluruh variabel sesi
        session_unset();
        // Hentikan sesi
        session_destroy();
        // Redirect ke halaman login
        header("Location: login.php");
        exit;
    } else {
        // IP dan ID history sesuai, lanjutkan dengan proses logout lainnya
        // ...
    }
}




// // Simpan History
// $id_history = $_GET['id'];
// $decode = base64_decode($id_history);
// $history = mysqli_query($connect, "UPDATE user_history SET logout_time = '$today', status_perangkat = '$offline' WHERE id_history = '$decode'");

// session_destroy(); 
// header("Location:index.php");
