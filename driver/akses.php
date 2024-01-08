<?php
// Periksa apakah sesi sudah dimulai
if (!isset($_SESSION)) {
    session_start();
}

// Periksa apakah pengguna telah login
if (empty($_SESSION['tiket_user'])) {
    // Redirect ke halaman logout.php
    header("location: ../logout.php");
} else {
    // Periksa apakah sesi telah berakhir (10 detik tidak ada aktivitas)
    $session_time = 1800; // 30 menit
    $current_time = time();

    if (isset($_SESSION['last_activity']) && ($current_time - $_SESSION['last_activity']) > $session_time) {
        // Jika sesi telah berakhir, hancurkan sesi dan redirect ke logout.php
        session_unset();
        session_destroy();
        header("location: ../logout.php");
    } else {
        // Perbarui waktu aktivitas terakhir setiap kali ada aktivitas
        $_SESSION['last_activity'] = $current_time;
    }
}
?>