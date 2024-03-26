<?php
// Koneksi
include "koneksi.php";
session_start();

$id_history = 'HIS' . generate_uuid();
$ip = $_SESSION['ip'];
$device = $_SESSION['jenis_perangkat'];
$lokasi = $_SESSION['lokasi'];
$id_status = base64_decode($_SESSION['id_status']);
$id_token = base64_decode( $_SESSION['id_token']);
$id_user = base64_decode($_SESSION['tiket_id']);
$offline = 'Offline';
$timezone = time() + (60 * 60 * 7);
$today = gmdate('Y/m/d G:i:s', $timezone);

$data_status = $connect->query("SELECT login_time FROM user_status WHERE id_user_status = '$id_status'");
$tampil_data_status = mysqli_fetch_array($data_status);
$login_time = $tampil_data_status['login_time'];

// echo $id_status. "<br>";
// echo $login_time. "<br>";

$connect->begin_transaction();
try{

    $update_status = mysqli_query($connect, "UPDATE user_status SET id_token = '', logout_time = '$today', status_perangkat = '$offline' WHERE id_user_status = '$id_status'");

    $update_history = mysqli_query($connect, "UPDATE user_history SET logout_time = '$today' WHERE id_user = '$id_user' AND login_time = '$login_time'");
    
    $delete_token = $connect->query("DELETE FROM user_token WHERE id_token = '$id_token'");

    if ($update_status && $update_history  && $delete_token ) {
        $connect->commit();
        // Set header untuk mengontrol caching
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        session_destroy();
        session_reset();
        header("Location:../login.php");
    } else {
        // Rollback transaksi jika salah satu operasi gagal
        $connect->rollback();
        $_SESSION['alert'] = 'Terjadi kesalahan server, silahkan ulangi kembali';
        header("Location:dashboard.php");
    }   
}catch (Exception $e){
    // Rollback transaksi jika salah satu operasi gagal
    $connect->rollback();
    $_SESSION['alert'] = 'Terjadi kesalahan server, silahkan ulangi kembali';
    header("Location:dashboard.php");
}  

// Generate UUID
function generate_uuid()
{
    return sprintf(
        '%04x%04x%04x%04x',
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0x0fff) | 0x4000,
        mt_rand(0, 0x3fff) | 0x8000,
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff)
    );
}
// End Generate UUID 
?>