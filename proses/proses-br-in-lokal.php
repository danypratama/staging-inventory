<?php
session_start();
include "../koneksi.php";

if (isset($_POST['simpan-br-in-lokal'])) {
    $id_inv_br_in_lokal = $_POST['id_inv_br_in_lokal'];
    $no_inv = $_POST['no_inv'];
    $tgl_inv = $_POST['tgl_inv'];
    $id_sp = $_POST['id_sp'];
    $id_user = $_POST['id_user'];
    $created = $_POST['created'];

    $cek_data = mysqli_query($connect, "SELECT id_inv_br_in_lokal FROM inv_br_in_lokal WHERE id_inv_br_in_lokal = '$id_inv_br_in_lokal'");

    if ($cek_data->num_rows > 0) {
        $_SESSION['info'] = "Data sudah ada";
        header('Location:../barang-masuk-lokal.php');
    } else {
        $sql = "INSERT INTO inv_br_in_lokal 
            (id_inv_br_in_lokal, id_user, id_sp, no_inv, tgl_inv, created_date)
            VALUES
            ('$id_inv_br_in_lokal', '$id_user', '$id_sp', '$no_inv', '$tgl_inv', '$created')";

        $query = mysqli_query($connect, $sql);

        $_SESSION['info'] = "Disimpan";
        header('Location:../barang-masuk-lokal.php');
    }
} else if (isset($_POST['edit-br-in-lokal'])) {
    $id_inv_br_in_lokal = $_POST['id_inv_br_in_lokal'];
    $no_inv = $_POST['no_inv'];
    $tgl_inv = $_POST['tgl_inv'];
    $id_sp = $_POST['id_sp'];

    $cek_data = mysqli_query($connect, "SELECT * FROM inv_br_in_lokal WHERE id_inv_br_in_lokal = '$id_inv_br_in_lokal'");
    $data = mysqli_fetch_array($cek_data);

    if ($data['id_sp'] == $id_sp && $data['no_inv'] == $no_inv && $data['tgl_inv'] == $tgl_inv) {
        $_SESSION['info'] = 'Tidak Ada Perubahan Data';
        header('Location:../barang-masuk-lokal.php');
        exit;
    } else {
        $edit_data = "UPDATE inv_br_in_lokal
                            SET 
                            id_sp = '$id_sp',
                            no_inv = '$no_inv',
                            tgl_inv = '$tgl_inv'
                            WHERE  id_inv_br_in_lokal = '$id_inv_br_in_lokal'";
        $query = mysqli_query($connect, $edit_data);

        if ($query) {
            $_SESSION['info'] = 'Diupdate';
            header('Location:../barang-masuk-lokal.php');
        } else {
            $_SESSION['info'] = 'Data Gagal Diupdate';
            header('Location:../barang-masuk-lokal.php');
        }
    }
} else if (isset($_GET['id'])) {
    $idh = $_GET['id'];
    //perintah queery sql untuk hapus data
    $sql = "DELETE ibil, iibil 
                FROM inv_br_in_lokal ibil
                LEFT JOIN isi_inv_br_in_lokal iibil ON (ibil.id_inv_br_in_lokal = iibil.id_inv_br_in_lokal)
                WHERE ibil.id_inv_br_in_lokal = '$idh'";
    $query_del = mysqli_query($connect, $sql) or die(mysqli_error($connect));

    if ($query_del) {
        $_SESSION['info'] = 'Dihapus';
        header('Location:../barang-masuk-lokal.php');
    } else {
        $_SESSION['info'] = 'Data Gagal Dihapus';
        header('Location:../barang-masuk-lokal.php');
    }
}
