<?php  
session_start();

include "../koneksi.php";

// Simpon
if(isset($_POST['simpan-ket-in'])){
    $id_ket_in = $_POST['id_ket_in'];
    $nama_ket_in = $_POST['nama_ket_in'];
    $created = $_POST['created'];
    $id_user = $_POST['user_created'];

    $sql = "SELECT id_ket_in, ket_in FROM keterangan_in WHERE id_ket_in = '$id_ket_in' OR ket_in = '$nama_ket_in' ";
    $query = mysqli_query($connect, $sql);

    if($query -> num_rows > 0 ){
        $_SESSION['info'] = 'Data sudah ada';
        header('Location:../keterangan-in.php');
    }else{
        $simpan_data = "INSERT INTO keterangan_in 
                        (id_ket_in, id_user, ket_in, created_date)
                        VALUES
                        ('$id_ket_in', '$id_user', '$nama_ket_in', '$created')";
        $query = mysqli_query($connect, $simpan_data);
        $_SESSION['info'] = 'Disimpan';
        header('Location:../keterangan-in.php');
    }

// Edit
}else if (isset($_POST['edit-ket-in'])){
    $id_ket_in = $_POST['id_ket_in'];
    $nama_ket_in = $_POST['nama_ket_in'];

    $cek_data = "SELECT * FROM keterangan_in WHERE ket_in = '$nama_ket_in' ";
    $query_cek = mysqli_query($connect, $cek_data);

    if($query_cek -> num_rows > 0){
        $_SESSION['info'] = 'Data sudah ada';
        header('Location:../keterangan-in.php');     
    }else{
        $update = "UPDATE keterangan_in SET  
                   ket_in = '$nama_ket_in' 
                   WHERE id_ket_in = '$id_ket_in' ";
        $query = mysqli_query($connect, $update);
        $_SESSION['info'] = 'Diupdate';
        header('Location: ../keterangan-in.php');
    }

// Hapus
}else if (isset($_GET['hapus-ket-in'])){
    $idh = base64_decode($_GET['hapus-ket-in']);
    $hapus_data = "DELETE FROM keterangan_in WHERE id_ket_in = '$idh'";
    $query = mysqli_query($connect, $hapus_data);

    if($query){
        $_SESSION['info'] = 'Dihapus';
        header('Location:../keterangan-in.php');
    }else{
        $_SESSION['info'] = 'Data Gagal Dihapus';
        header('Location:../keterangan-in.php');
    }
}
