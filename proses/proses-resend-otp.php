<?php  
    include "../koneksi.php";
    session_start();
    date_default_timezone_set('Asia/Jakarta');

    $expirationTime = 120;
    $expirationTimestamp = time() + $expirationTime;
    // Format waktu kedaluwarsa (opsional, dapat disesuaikan sesuai kebutuhan)
    $expirationFormatted = date("Y-m-d H:i:s", $expirationTimestamp);

    $otp = htmlspecialchars(base64_decode($_GET['otp']));
    $id_reset = htmlspecialchars(base64_decode($_GET['id_reset']));


    echo $otp;
    echo $id_reset;
    $cek_data_reset = $connect->query("SELECT id_reset, id_user, email , otp FROM reset_password WHERE id_reset = '$id_reset'");
    $data = mysqli_fetch_array($cek_data_reset);
    $id_reset_encode = base64_encode($data['id_reset']);
    if ($data) {
        $update = $connect->query("UPDATE reset_password SET otp = '$otp', expired = '$expirationFormatted' WHERE id_reset = '$id_reset'");
        header("Location:../send-mail.php?id=$id_reset_encode");
    } else {
        $_SESSION['alert'] = 'Username atau Email tidak ditemukan';
        // header("Location:lupa-password.php");
    }
       
    
?>
