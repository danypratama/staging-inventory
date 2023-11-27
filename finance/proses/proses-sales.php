<?php
session_start();
include "../koneksi.php";

if (isset($_POST['simpan-sales'])) {
    $id_sales = $_POST['id_sales'];
    $nama_sales = $_POST['nama_sales'];
    $telp = $_POST['telp'];
    $id_user = $_POST['id_user'];
    $created = $_POST['created'];

    $cek_data = mysqli_query($connect, "SELECT nama_sales FROM tb_sales WHERE nama_sales = '$nama_sales'");

    if ($cek_data->num_rows < 1) {
        $simpan_data = "INSERT INTO tb_sales
                        (id_sales, id_user, nama_sales, no_telp, created_date) VALUES ('$id_sales', '$id_user', '$nama_sales', '$telp', '$created')";
        $query = mysqli_query($connect, $simpan_data);
        $_SESSION['info'] = 'Disimpan';
        header("Location:../data-sales.php");
    } else {
        $_SESSION['info'] = 'Data sudah ada';
        header("Location:../data-sales.php");
    }
} else if (isset($_POST['edit-sales'])) {
    $id_sales = $_POST['id_sales'];
    $nama_sales = $_POST['nama_sales'];
    $telp = $_POST['telp_sales'];

    $cek_data = mysqli_query($connect, "SELECT * FROM tb_sales WHERE id_sales = '$id_sales'");
    $row = mysqli_fetch_array($cek_data);

    if ($row['nama_sales'] == $nama_sales) {
        $edit_data = mysqli_query($connect, "UPDATE tb_sales
        SET
        no_telp = '$telp'
        WHERE id_sales = '$id_sales'");
        $_SESSION['info'] = 'Diupdate';
        header("Location:../data-sales.php");
    } else {
        $cek_data = mysqli_query($connect, "SELECT nama_sales FROM tb_sales WHERE nama_sales = '$nama_sales'");

        if ($cek_data->num_rows > 0) {
            // Ada nama yang sama di database, tampilkan pesan error
            $_SESSION['info'] = 'Data sudah ada';
            header("Location:../data-sales.php");
        } else {
            // Nama belum digunakan, simpan data
            $edit_data = mysqli_query($connect, "UPDATE tb_sales
            SET
            nama_sales = '$nama_sales',
            no_telp = '$telp'
            WHERE id_sales = '$id_sales'");

            $_SESSION['info'] = 'Diupdate';
            header("Location:../data-sales.php");
        }
    }
} elseif ($_GET['hapus-sales']) {
    //tangkap URL dengan $_GET
    $idh = $_GET['hapus-sales'];
    $id_sales = base64_decode($idh);

    // perintah queery sql untuk hapus data
    $sql = "DELETE FROM tb_sales WHERE id_sales='$id_sales'";
    $query_del = mysqli_query($connect, $sql) or die(mysqli_error($connect));


    if ($query_del) {
        $_SESSION['info'] = 'Dihapus';
        header("Location:../data-sales.php");
    } else {
        $_SESSION['info'] = 'Data Gagal Dihapus';
        header("Location:../data-sales.php");
    }
}
