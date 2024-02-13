<?php  
    include "../koneksi.php";
    session_start();
    date_default_timezone_set('Asia/Jakarta');

    if(isset($_POST['cek-validasi'])){
        $id_reset = htmlspecialchars($_POST['id_reset']);
        $id_reset_encode = base64_encode($id_reset);
        $otp = htmlspecialchars($_POST['otp']);

        $cek_data_reset = $connect->query("SELECT id_reset, id_user, email FROM reset_password WHERE id_reset = '$id_reset' AND otp = '$otp'");
        $data = mysqli_fetch_array($cek_data_reset);
        if ($data) {
            header("Location:../reset-password.php?id=$id_reset_encode");
        } else {
           $_SESSION['alert'] = 'OTP tidak sesuai';
           header("Location:../validasi-otp.php?id=$id_reset_encode");
        }
    }
?>
