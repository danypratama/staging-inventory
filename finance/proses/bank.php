<?php  
session_start();
include "../koneksi.php";
include "../function/function-enkripsi.php";

if(isset($_POST['simpan'])){
    $UUID =  uuid();
    $id_bank = "BNK" . $UUID;
    $nama_bank = htmlspecialchars($_POST['nama_bank']);
    $no_rek = $_POST['no_rek'];
    $atas_nama = htmlspecialchars($_POST['atas_nama']);
    $created_by = $_SESSION['tiket_nama'];

    $key = "IT@Support";
    $enkripsi_no_rek = encrypt($no_rek, $key);
    $enkripsi_atas_nama = encrypt($atas_nama, $key);

    $file_name = $_FILES['fileku']['name'];
    $file_tmp = $_FILES['fileku']['tmp_name'];
    $file_destination = "../logo-bank/" . $file_name;

    $sql_check_bank = mysqli_query($connect, "SELECT no_rekening FROM finance_bank WHERE no_rekening = '$enkripsi_no_rek'");
    if(mysqli_num_rows($sql_check_bank) > 0) {
        // Jika data sudah ada, berikan pesan kesalahan
        $_SESSION['info'] = 'Data sudah ada';
        header("Location:../data-bank.php");
        exit; // Keluar dari skrip
    } else {
        if (file_exists($file_destination)) {
            // Simpan data ke database
            $simpan_data = mysqli_query($connect, "INSERT INTO finance_bank (id_bank, nama_bank, no_rekening, atas_nama, logo, created_by) VALUES ('$id_bank', '$nama_bank', '$enkripsi_no_rek', '$enkripsi_atas_nama', '$file_name', '$created_by')");
            $_SESSION['info'] = 'Disimpan';
            header("Location:../data-bank.php");
            exit; // Keluar dari skrip untuk menghindari eksekusi lebih lanjut.
        } else {
            // Jika file belum ada, maka upload gambar
            move_uploaded_file($file_tmp, $file_destination);
            // Simpan data ke database
            $simpan_data = mysqli_query($connect, "INSERT INTO finance_bank (id_bank, nama_bank, no_rekening, atas_nama, logo, created_by) VALUES ('$id_bank', '$nama_bank', '$enkripsi_no_rek', '$enkripsi_atas_nama', '$file_name', '$created_by')");
            $_SESSION['info'] = 'Disimpan';
            header("Location:../data-bank.php");
        }
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
