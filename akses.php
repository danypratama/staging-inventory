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
    include "koneksi.php";
    // Ambil status pengguna dari database
    $id_user = $_SESSION['tiket_id'];
    $ip = $_SESSION['ip'];
    $id_history = $_SESSION['id_history'];
    $query = "SELECT status_perangkat FROM user_history WHERE id_history = '$id_history'";
    $result = $connect->query($query);

    // Periksa apakah query berhasil dijalankan
    if ($result) {
        $row = $result->fetch_assoc();
        $status = $row['status_perangkat'];

        // Periksa status pengguna
        if ($status == "Online") {
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
        } else {
            // Status pengguna tidak aktif, hancurkan sesi dan redirect ke logout.php
            session_unset();
            session_destroy();
            header("location: logout.php");
        }
    } else {
        die("Query gagal: " . $connect->error);
    }

    // Tutup koneksi database
    $connect->close();
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
<script>
    // var checkTabActive = true;

    // function checkTabStatus() {
    //     if (!checkTabActive) {
    //         // Jika tab tidak aktif, kirim permintaan ke server untuk logout
    //         var xhr = new XMLHttpRequest();
    //         xhr.open('GET', 'logout.php', true);
    //         xhr.send();
    //     }
    // }

    // // Atur interval untuk memeriksa status tab setiap beberapa detik
    // var checkTabInterval = setInterval(checkTabStatus, 10000); // Setiap 10 detik

    // // Tangkap event ketika tab menjadi aktif
    // window.addEventListener('focus', function() {
    //     checkTabActive = true;
    // });

    // // Tangkap event ketika tab tidak aktif
    // window.addEventListener('blur', function() {
    //     checkTabActive = false;
    // });

    // // Tangkap event ketika pengguna akan menutup tab atau mengganti URL
    // window.addEventListener('beforeunload', function(event) {
    //     // Hentikan interval untuk menghentikan pengecekan
    //     clearInterval(checkTabInterval);

    //     // Jika tab ditutup, kirim permintaan ke server untuk logout
    //     var xhr = new XMLHttpRequest();
    //     xhr.open('GET', 'logout.php', false);
    //     xhr.send();
    // });
    
</script>
</body>
</html>