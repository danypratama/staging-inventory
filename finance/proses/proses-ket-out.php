<?php  
session_start();

include "../koneksi.php";

// Simpan
if(isset($_POST['simpan-ket-out'])){
    $id_ket_out = $_POST['id_ket_out'];
    $nama_ket_out = $_POST['nama_ket_out'];
    $created = $_POST['created'];
    $id_user = $_POST['user_created'];

    $sql = "SELECT ket_out, id_ket_out FROM keterangan_out WHERE ket_out = '$nama_ket_out' OR id_ket_out = '$id_ket_out' ";
    $query = mysqli_query($connect, $sql);

    if($query -> num_rows > 0 ){
        $_SESSION['info'] = 'Data sudah ada';
        header('Location:../keterangan-out.php');
    }else{
        $simpan_data = "INSERT INTO keterangan_out
                        (id_ket_out, id_user, ket_out, created_date)
                        VALUES
                        ('$id_ket_out', '$id_user', '$nama_ket_out', '$created')";
        $query = mysqli_query($connect, $simpan_data);
        $_SESSION['info'] = 'Disimpan';
        header('Location:../keterangan-out.php');
    }

// Edit
}else if (isset($_POST['edit-ket-out'])){
    $id_ket_out = $_POST['id_ket_out'];
    $nama_ket_out = $_POST['nama_ket_out'];

    $cek_data = "SELECT ket_out, id_ket_out FROM keterangan_out WHERE ket_out ='$nama_ket_out'";
    $query_cek = mysqli_query($connect, $cek_data);

    if($query_cek -> num_rows > 0){
        $_SESSION['info'] = 'Data sudah ada';
        header('Location: ../keterangan-out.php');
    }else{
        $update = "UPDATE keterangan_out SET  
                   ket_out = '$nama_ket_out' 
                   WHERE id_ket_out = '$id_ket_out' ";
        $query = mysqli_query($connect, $update);

        $_SESSION['info'] = 'Diupdate';
        header('Location: ../keterangan-out.php');
    }

// Hapus
}else if (isset($_GET['hapus-ket-out'])){
    $idh = base64_decode( $_GET['hapus-ket-out']);
    $hapus_data = "DELETE FROM keterangan_out WHERE id_ket_out = '$idh'";
    $query = mysqli_query($connect, $hapus_data);

    if($query){
        $_SESSION['info'] = 'Dihapus';
        header('Location:../keterangan-out.php');
    }else{
        $_SESSION['info'] = 'Data Gagal Dihapus';
        header('Location:../keterangan-out.php');
    }
}
