<?php
session_start();
include "../koneksi.php";

if (isset($_POST['simpan-br-in-import'])) {
    $id_inv_br_import = $_POST['id_inv_br_import'];
    $no_inv = $_POST['no_inv'];
    $tgl_inv = $_POST['tgl_inv'];
    $id_sp = $_POST['id_sp'];
    $no_order = $_POST['no_order'];
    $tgl_order = $_POST['tgl_order'];
    $no_awb = $_POST['no_awb'];
    $tgl_kirim = $_POST['tgl_kirim'];
    $ship = $_POST['ship'];
    $tgl_est = $_POST['tgl_est'];
    $id_user = $_POST['id_user'];
    $created = $_POST['created'];
    $laut = 'laut';
    $udara = 'udara';

    if ($ship == 10) {
        $simpan_data = "INSERT INTO inv_br_import
                        (id_inv_br_import, id_user, id_supplier, no_inv, tgl_inv, no_order, tgl_order, shipping_by, no_awb, tgl_kirim, tgl_est, created_date)
                        VALUES
                        ('$id_inv_br_import', '$id_user', '$id_sp', '$no_inv', '$tgl_inv', '$no_order', '$tgl_order', '$udara', '$no_awb', '$tgl_kirim', '$tgl_est', '$created')";
        $query = mysqli_query($connect, $simpan_data);
        $_SESSION['info'] = 'Disimpan';
        header("Location:../barang-masuk-reg-import.php");
    } else {
        $simpan_data = "INSERT INTO inv_br_import
                            (id_inv_br_import, id_user, id_supplier, no_inv, tgl_inv, no_order, tgl_order, shipping_by, no_awb, tgl_kirim, tgl_est, created_date)
                            VALUES
                            ('$id_inv_br_import', '$id_user', '$id_sp', '$no_inv', '$tgl_inv', '$no_order', '$tgl_order', '$laut', '$no_awb', '$tgl_kirim', '$tgl_est', '$created')";
        $query = mysqli_query($connect, $simpan_data);
        $_SESSION['info'] = 'Disimpan';
        header("Location: ../barang-masuk-reg-import.php");
    }
} else if (isset($_POST['simpan-isi-br-import'])) {
    $id_isi_inv_br_import = $_POST['id_isi_inv_br_import'];
    $id_inv_import = $_POST['id_inv_import'];
    $id_produk = $_POST['id_produk'];
    $qty = $_POST['qty'];
    $id_user = $_POST['id_user'];
    $created = $_POST['created'];

    $qty = intval(preg_replace("/[^0-9]/", "", $qty));

    $sql = "INSERT INTO isi_inv_br_import
                (id_isi_inv_br_import, id_inv_br_import, id_produk_reg, qty, id_user, created_date)
                VALUES
                ('$id_isi_inv_br_import', '$id_inv_import', '$id_produk', '$qty', '$id_user', '$created')";
    $query = mysqli_query($connect, $sql);

    if ($query) {
        $_SESSION['info'] = 'Disimpan';
        header("Location:../input-isi-inv-br-import.php?id=$id_inv_import");
    } else {
        $_SESSION['info'] = 'Data Gagal Disimpan';
        header("Location:../input-isi-inv-br-import.php?id=$id_inv_import");
    }
} else if (isset($_POST['simpan-act-br-import'])) {
    $id_act_br_import = $_POST['id_act_br_import'];
    $id_isi_inv_br_import = $_POST['id_isi_inv_br_import'];
    $id_inv_import = $_POST['id_inv_import'];
    $id_produk = $_POST['id_produk'];
    $qty_act = $_POST['qty_act'];
    $id_user = $_POST['id_user'];
    $created = $_POST['created'];

    $qty_act = intval(preg_replace("/[^0-9]/", "", $qty_act));

    $simpan_data = "INSERT INTO act_br_import
                        (id_act_br_import, id_isi_inv_br_import, id_produk_reg, qty_act, id_user, created_date)
                        VALUES
                        ('$id_act_br_import', '$id_isi_inv_br_import', '$id_produk', '$qty_act', '$id_user', '$created')";
    $query = mysqli_query($connect, $simpan_data);


    if ($query) {
        $_SESSION['info'] = 'Disimpan';
        header("Location:../tampil-br-import.php?id=$id_inv_import");
    } else {
        $_SESSION['info'] = 'Data Gagal Disimpan';
        header("Location:../tampil-br-import.php?id=$id_inv_import");
    }
} else if (isset($_POST['edit-inv-br-in-import'])) {
    $id_inv_br_import = $_POST['id_inv_br_import'];
    $no_inv = $_POST['no_inv'];
    $tgl_inv = $_POST['tgl_inv'];
    $id_sp = $_POST['id_sp'];
    $no_order = $_POST['no_order'];
    $tgl_order = $_POST['tgl_order'];
    $no_awb = $_POST['no_awb'];
    $tgl_kirim = $_POST['tgl_kirim'];
    $ship = $_POST['ship'];
    $tgl_est = $_POST['tgl_est'];
    $laut = 'laut';
    $udara = 'udara';

    echo $ship;

    $cek_data = "SELECT * FROM inv_br_import WHERE id_inv_br_import = '$id_inv_br_import'";
    $query_cek = mysqli_query($connect, $cek_data);
    $data_sebelumnya = mysqli_fetch_assoc($query_cek);

    if ($data_sebelumnya['id_supplier'] == $id_sp && $data_sebelumnya['no_inv'] == $no_inv && $data_sebelumnya['tgl_inv'] == $tgl_inv && $data_sebelumnya['tgl_inv'] == $tgl_inv && $data_sebelumnya['no_order'] == $no_order && $data_sebelumnya['tgl_order'] == $tgl_order && $data_sebelumnya['shipping_by'] == $ship && $data_sebelumnya['no_awb'] == $no_awb && $data_sebelumnya['tgl_kirim'] == $tgl_kirim && $data_sebelumnya['tgl_est'] == $tgl_est) {
        $_SESSION['info'] = 'Tidak Ada Perubahan Data';
        header("Location:../barang-masuk-reg-import.php");
        exit;
    } else {
        $edit_data = "UPDATE inv_br_import
                            SET 
                            id_supplier = '$id_sp',
                            no_inv = '$no_inv',
                            tgl_inv = '$tgl_inv',
                            no_order = '$no_order',
                            tgl_order = '$tgl_order',
                            shipping_by = '$ship',
                            no_awb = '$no_awb',
                            tgl_kirim = '$tgl_kirim',
                            tgl_est = '$tgl_est'
                            WHERE  id_inv_br_import = '$id_inv_br_import'";
        $query = mysqli_query($connect, $edit_data);

        if ($query) {
            $_SESSION['info'] = 'Diupdate';
            header("Location:../barang-masuk-reg-import.php");
        } else {
            $_SESSION['info'] = 'Data Gagal Diupdate';
            header("Location:../barang-masuk-reg-import.php");
        }
    }
} else if (isset($_POST['edit-isi-br-import'])) {
    $id_isi_inv_br_import = $_POST['id_isi_inv_br_import'];
    $id_inv_import = $_POST['id_inv_import'];
    $id_produk = $_POST['id_produk'];
    $qty = $_POST['qty'];

    $qty = intval(preg_replace("/[^0-9]/", "", $qty));

    // cek apakah data sebelumnya sama dengan data yang akan diubah
    $cek_data = "SELECT id_produk_reg, qty FROM isi_inv_br_import WHERE id_isi_inv_br_import = '$id_isi_inv_br_import'";
    $query_cek = mysqli_query($connect, $cek_data);
    $data_sebelumnya = mysqli_fetch_assoc($query_cek);

    if ($data_sebelumnya['id_produk_reg'] == $id_produk && $data_sebelumnya['qty'] == $qty) {
        $_SESSION['info'] = 'Tidak Ada Perubahan Data';
        header("Location:../tampil-br-import.php?id=$id_inv_import");
        exit;
    } else {
        $edit_data = "UPDATE isi_inv_br_import
                            SET 
                            id_produk_reg = '$id_produk',
                            qty = '$qty'
                            WHERE  id_isi_inv_br_import = '$id_isi_inv_br_import'";

        $query = mysqli_query($connect, $edit_data);

        if ($query) {
            $_SESSION['info'] = 'Diupdate';
            header("Location:../tampil-br-import.php?id=$id_inv_import");
        } else {
            $_SESSION['info'] = 'Data Gagal Diupdate';
            header("Location:../tampil-br-import.php?id=$id_inv_import");
        }
    }
} else if (isset($_POST['edit-act-br-import'])) {
    $id_act_br_import = $_POST['id_act_br_import'];
    $id_isi_inv_br_import = $_POST['id_isi_inv_br_import'];
    $id_inv_br_import = $_POST['id_inv_br_import'];
    $id_produk = $_POST['id_produk'];
    $qty = $_POST['qty_act'];

    $qty = intval(preg_replace("/[^0-9]/", "", $qty));

    // cek apakah data sebelumnya sama dengan data yang akan diubah
    $cek_data = "SELECT id_produk_reg, qty_act FROM act_br_import WHERE id_act_br_import = '$id_act_br_import'";
    $query_cek = mysqli_query($connect, $cek_data);
    $data_sebelumnya = mysqli_fetch_assoc($query_cek);

    if ($data_sebelumnya['id_produk_reg'] == $id_produk && $data_sebelumnya['qty_act'] == $qty) {
        $_SESSION['info'] = 'Tidak Ada Perubahan Data';
        header("Location:../list-act-br-import.php?id=$id_isi_inv_br_import && id_inv=$id_inv_br_import");
        exit;
    } else {
        $edit_data = "UPDATE act_br_import
                            SET 
                            id_produk_reg = '$id_produk',
                            qty_act = '$qty'
                            WHERE id_act_br_import = '$id_act_br_import'";

        $query = mysqli_query($connect, $edit_data);

        if ($query) {
            $_SESSION['info'] = 'Diupdate';
            header("Location:../list-act-br-import.php?id=$id_isi_inv_br_import && id_inv=$id_inv_br_import");
        } else {
            $_SESSION['info'] = 'Data Gagal Diupdate';
            header("Location:../list-act-br-import.php?id=$id_isi_inv_br_import && id_inv=$id_inv_br_import");
        }
    }
} else if (isset($_GET['hapus'])) {
    //tangkap URL dengan $_GET
    $idh = $_GET['hapus'];
    $id_inv = $_GET['id_inv'];

    //perintah queery sql untuk hapus data
    $sql = "DELETE iibi, act 
                FROM isi_inv_br_import iibi
                LEFT JOIN act_br_import act ON iibi.id_isi_inv_br_import = act.id_isi_inv_br_import
                WHERE iibi.id_isi_inv_br_import = '$idh'";
    $query_del = mysqli_query($connect, $sql) or die(mysqli_error($connect));

    if ($query_del) {
        $_SESSION['info'] = 'Dihapus';
        header("Location:../tampil-br-import.php?id=$id_inv");
    } else {
        $_SESSION['info'] = 'Data Gagal Dihapus';
        header("Location:../tampil-br-import.php?id=$id_inv");
    }
} else if (isset($_GET['hapus-act'])) {
    $id_act = $_GET['hapus-act'];
    $id = $_GET['id'];
    $id_inv = $_GET['id_inv'];

    $sql = "DELETE FROM act_br_import WHERE id_act_br_import='$id_act'";
    $query_del = mysqli_query($connect, $sql) or die(mysqli_error($connect));

    if ($query_del) {
        $_SESSION['info'] = 'Dihapus';
        header("Location:../list-act-br-import.php?id=$id && id_inv=$id_inv");
    } else {
        $_SESSION['info'] = 'Data Gagal Dihapus';
        header("Location:../list-act-br-import.php?id=$id && id_inv=$id_inv");
    }
}
