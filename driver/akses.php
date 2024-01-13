<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="assets/img/logo-kma.png" rel="icon">
</head>

<body>
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


<script>
    var countdown = <?php echo $session_time; ?>;
    
    function updateCountdown() {
        var minutes = Math.floor(countdown / 60);
        var seconds = countdown % 60;

        // Format menit dan detik dalam bentuk MM:SS
        var formattedTime = (minutes < 10 ? '0' : '') + minutes + ':' + (seconds < 10 ? '0' : '') + seconds;

        document.getElementById('countdown').innerHTML = formattedTime;

        if (countdown > 0) {
            countdown--;
            setTimeout(updateCountdown, 1000);
        } else {
            // Redirect ke halaman logout.php setelah hitungan mundur selesai
            window.location.href = 'logout.php';
        }
    }

    // Memanggil fungsi updateCountdown saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function () {
        updateCountdown();
    });
</script>
</body>

</html>