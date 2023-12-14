<?php  
session_start();
include "../koneksi.php";

if(isset($_POST['simpan'])){
    $uuid =  uuid();
    $day = date('d');
    $month = date('m');
    $year = date('y');
    $id_bank_pt = "BANK_PT_" . $year . "" . $month . "" . $uuid . "" . $day ;
    $id_bank = $_POST['id_bank'];
    $no_rekening = $_POST['no_rekening'];
    $atas_nama = htmlspecialchars($_POST['atas_nama']);
    $created_by = $_SESSION['tiket_nama'];

    $sql_check_bank = mysqli_query($connect, "SELECT id_bank_pt FROM bank_pt WHERE id_bank_pt = '$id_bank_pt'");
    if(mysqli_num_rows($sql_check_bank) > 0) {
        // Jika data sudah ada, berikan pesan kesalahan
        $_SESSION['info'] = 'Data sudah ada';
        header("Location:../data-bank-pt.php");
        exit; // Keluar dari skrip
    } else {
        // Simpan data ke database
        $simpan_data = mysqli_query($connect, "INSERT INTO bank_pt (id_bank_pt, id_bank, no_rekening, atas_nama, created_by) VALUES ('$id_bank_pt', '$id_bank', '$no_rekening', '$atas_nama', '$created_by')");
        $_SESSION['info'] = 'Disimpan';
        header("Location:../data-bank-pt.php");
        exit; // Keluar dari skrip
    }
}else if(isset($_GET['id'])){
    $id_bank_pt = base64_decode($_GET['id']);
    $delete_bank = mysqli_query($connect, "DELETE FROM bank_pt WHERE id_bank_pt = '$id_bank_pt'");
    if($delete_bank){
        $_SESSION['info'] = 'Dihapus';
        unlink($file_destination);
        header("Location: ../data-bank-pt.php");
    }else{
        $_SESSION['info'] = 'Data Gagal Dihapus';
        header("Location: ../data-bank-pt.php");
    }

}

function uuid() {
    $data = openssl_random_pseudo_bytes(16);
    assert(strlen($data) == 16);

    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

    return vsprintf('%s%s', str_split(bin2hex($data), 4));
}
?>
