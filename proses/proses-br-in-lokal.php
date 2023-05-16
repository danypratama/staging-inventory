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


    // Proses CRUD isi barang in lokal
} else if (isset($_POST['simpan-isi-br-in-lokal'])) {
    $id_isi = $_POST['id_isi_inv_br_in_lokal'];
    $id_inv = $_POST['id_inv_br_in_lokal'];
    $id_produk = $_POST['id_produk'];
    $qty = $_POST['qty'];
    $id_user = $_POST['id_user'];
    $created = $_POST['created'];
    $encode = base64_encode($id_inv);

    $sql = mysqli_query($connect, "SELECT * FROM isi_inv_br_in_lokal WHERE id_inv_br_in_lokal = '$id_inv'");
    $data = mysqli_fetch_array($sql);

    if ($data['id_produk_reg'] == $id_produk) {
        $_SESSION['info'] = "Data sudah ada";
        header("Location:../list-br-in-lokal.php?id=$encode");
    } else {
        $simpan_data = mysqli_query($connect, "INSERT INTO isi_inv_br_in_lokal
                                                (id_isi_inv_br_in_lokal, id_inv_br_in_lokal, id_produk_reg, qty, id_user, created_date )
                                                VALUES
                                                ('$id_isi', '$id_inv', '$id_produk', '$qty', '$id_user', '$created')
                                                ");

        $_SESSION['info'] = "Disimpan";
        header("Location:../list-br-in-lokal.php?id=$encode");
    }
} else if (isset($_POST['edit-isi-br-in-lokal'])) {
    $id_isi = $_POST['id_isi_inv_br_in_lokal'];
    $id_inv = $_POST['id_inv_br_in_lokal'];
    $id_produk = $_POST['id_produk'];
    $qty = $_POST['qty'];
    $encode = base64_encode($id_inv);

    $cek_data = mysqli_query($connect, "SELECT * FROM isi_inv_br_in_lokal WHERE id_isi_inv_br_in_lokal = '$id_isi'");
    $data = mysqli_fetch_array($cek_data);


    if ($data['id_produk_reg'] == $id_produk and $data['qty'] == $qty) {
        $_SESSION['info'] = "Tidak Ada Perubahan Data";
        header("Location:../list-br-in-lokal.php?id=$encode");
    } else {
        $update = mysqli_query($connect, "UPDATE isi_inv_br_in_lokal
                                          SET 
                                          id_produk_reg = '$id_produk',
                                          qty = '$qty'
                                          WHERE id_isi_inv_br_in_lokal = '$id_isi'");
        $_SESSION['info'] = "Diupdate";
        header("Location:../list-br-in-lokal.php?id=$encode");
    }
} else if (isset($_GET['hapus_isi'])) {
    $idh = base64_decode($_GET['hapus_isi']);
    $id_inv = base64_decode($_GET['id_inv']);
    $encode = base64_encode($id_inv);

    $hapus_data = mysqli_query($connect, "DELETE FROM isi_inv_br_in_lokal WHERE id_isi_inv_br_in_lokal = '$idh'");

    if ($hapus_data) {
        $_SESSION['info'] = 'Dihapus';
        header("Location:../list-br-in-lokal.php?id=$encode");
    }
}
