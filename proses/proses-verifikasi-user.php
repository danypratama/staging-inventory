<?php  
    include "../koneksi.php";
    session_start();
    date_default_timezone_set('Asia/Jakarta');

    $id_verifikasi = htmlspecialchars($_GET['id']);
    $id_verifikasi_decode = base64_decode($id_verifikasi);
    $otp = htmlspecialchars($_GET['otp']);
    $otp_decode = base64_decode($otp);

    $cek_data_verifikasi = $connect->query("SELECT id_verifikasi, id_user, email FROM user_verifikasi WHERE id_verifikasi = '$id_verifikasi_decode' AND otp = '$otp_decode'");
    $data = mysqli_fetch_array($cek_data_verifikasi);
    $id_user = $data['id_user'];
    $tgl_verifikasi = date('d/m/Y, H:i:s');
    if ($data) {
        $update_user = $connect->query("UPDATE user SET verifikasi= '1', tgl_verifikasi = '$tgl_verifikasi' WHERE id_user = '$id_user'");
        $delete_verifikasi = $connect->query("DELETE FROM user_verifikasi WHERE id_user = '$id_user'");
        $_SESSION['alert'] = 'Akun sudah diverifikasi, silahkan tunggu aktivasi dari admin';
        header("Location:../login.php");
    } else {
       $_SESSION['alert'] = 'Verifikasi tidak berhasil';
       header("Location:../login.php");
    }
?>
