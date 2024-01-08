<!-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="assets/img/logo-kma.png" rel="icon">
</head>

<body> -->
<?php
// Periksa apakah sesi sudah dimulai
if (!isset($_SESSION)) {
    session_start();
}

// Periksa apakah pengguna telah login
if (empty($_SESSION['tiket_user'])) {
    // Redirect ke halaman logout.php
    header("location: logout.php");
} else {
    // Periksa apakah sesi telah berakhir (10 detik tidak ada aktivitas)
    $session_time = 1800; // 30 menit
    $current_time = time();

    if (isset($_SESSION['last_activity']) && ($current_time - $_SESSION['last_activity']) > $session_time) {
        // Jika sesi telah berakhir, hancurkan sesi dan redirect ke logout.php
        session_unset();
        session_destroy();
        header("location: logout.php");
    } else {
        // Perbarui waktu aktivitas terakhir setiap kali ada aktivitas
        $_SESSION['last_activity'] = $current_time;
    }
}
?>




<!-- </body>

</html> -->


<!-- Isi halaman web Anda -->

<script>
    // Fungsi untuk mengarahkan ke halaman login
    // function redirectToLogin() {
    //     // Arahkan ke halaman logout
    //     window.location.href = 'logout.php';
    // }

    // // Fungsi untuk menampilkan Sweet Alert saat sesi habis
    // function showSessionExpiredAlert() {
    //     Swal.fire({
    //         title: 'Sesi Anda telah habis',
    //         text: 'Silakan login kembali',
    //         icon: 'warning',
    //         showCancelButton: false,
    //         confirmButtonColor: '#3085d6',
    //         confirmButtonText: 'OK',
    //         allowOutsideClick: false
    //     }).then((result) => {
    //         if (result.isConfirmed) {
    //             redirectToLogin();
    //         }
    //     });
    // }

    // // Fungsi untuk mereset timer saat pengguna berinteraksi dengan halaman web
    // function resetTimer() {
    //     clearTimeout(timeout);
    //     startTimer();
    // }

    // // Fungsi untuk memulai timer
    // function startTimer() {
    //     timeout = setTimeout(function() {
    //         showSessionExpiredAlert();
    //     }, 900000); // Waktu timeout dalam milidetik (15 menit)
    // }

    // // Event listener saat pengguna melakukan refresh halaman
    // window.addEventListener('beforeunload', function() {
    //     redirectToLogin();
    // });

    // // Event listener untuk mereset timer saat pengguna berinteraksi dengan halaman web
    // document.addEventListener('mousemove', resetTimer);
    // document.addEventListener('keypress', resetTimer);

    // // Mulai timer
    // startTimer();
</script>
