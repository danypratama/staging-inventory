<?php
session_start();
include "../koneksi.php";

if (isset($_POST['simpan'])) {
    $id_orderby = $_POST['id_orderby'];
    $order_by = $_POST['order_by'];
    $id_user = $_POST['id_user'];
    $created = $_POST['created'];

    $cek_data = mysqli_query($connect, "SELECT order_by FROM tb_orderby WHERE order_by = '$order_by'");

    if ($cek_data->num_rows < 1) {
        $simpan_data = "INSERT INTO tb_orderby
                        (id_orderby, id_user, order_by, created_date) VALUES ('$id_orderby', '$id_user', '$order_by', '$created')";
        $query = mysqli_query($connect, $simpan_data);
        $_SESSION['info'] = 'Disimpan';
        header("Location:../data-orderby.php");
    } else {
        $_SESSION['info'] = 'Data sudah ada';
        header("Location:../data-orderby.php");
    }
} elseif ($_GET['hapus']) {
    //tangkap URL dengan $_GET
    $idh = $_GET['hapus'];
    $id_orderby = base64_decode($idh);

    // perintah queery sql untuk hapus data
    $sql = "DELETE FROM tb_orderby WHERE id_orderby='$id_orderby'";
    $query_del = mysqli_query($connect, $sql) or die(mysqli_error($connect));


    if ($query_del) {
        $_SESSION['info'] = 'Dihapus';
        header("Location:../data-orderby.php");
    } else {
        $_SESSION['info'] = 'Data Gagal Dihapus';
        header("Location:../data-orderby.php");
    }
}
