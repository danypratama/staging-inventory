<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="assets/img/logo-kma.png" rel="icon">
</head>

<body>
    <?php
    if (!isset($_SESSION)) {
        session_start();
        $id_history = $_SESSION['encoded_id'];
    }

    //jika sesi ($_SESSION) tidak ada atau kosong
    if (empty($_SESSION['tiket_user'])) {
        //redirect ke halaman login.php
        header("location: login.php");
    }

    ?>

</body>

</html>


<script>
    // Fungsi untuk mengarahkan ke halaman login
    function redirectToLogin() {
        // Arahkan ke halaman login
        window.location.href = 'login.php';
    }

    // Fungsi untuk menampilkan Sweet Alert saat sesi habis
    function showSessionExpiredAlert() {
        Swal.fire({
            title: 'Sesi Anda telah habis',
            text: 'Silakan login kembali',
            icon: 'warning',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK',
            allowOutsideClick: false // Tambahkan opsi allowOutsideClick: false
        }).then((result) => {
            if (result.isConfirmed) {
                redirectToLogin();
            }
        });
    }

    // Fungsi untuk mengatur timer untuk melakukan logout saat waktu habis
    var timeout;

    function startTimer() {
        timeout = setTimeout(function() {
            showSessionExpiredAlert();
        }, 900000); // Waktu timeout dalam milidetik (15 menit)
    }

    // Fungsi untuk mereset timer saat pengguna berinteraksi dengan halaman web
    function resetTimer() {
        clearTimeout(timeout);
        startTimer();
    }

    // Mulai timer dan atur event listener untuk mereset timer saat pengguna berinteraksi dengan halaman web
    startTimer();
    document.addEventListener('mousemove', resetTimer);
    document.addEventListener('keypress', resetTimer);
</script>