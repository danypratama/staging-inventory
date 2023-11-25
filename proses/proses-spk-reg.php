<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include "../koneksi.php";

if (isset($_POST['simpan'])) {
    $id_spk = $_POST['id_spk_reg'];
    $no_spk = $_POST['no_spk'];
    $tgl_spk = $_POST['tgl_spk'];
    $no_po = $_POST['no_po'];
    $tgl_pesan = $_POST['tgl_pesan'];
    $order_by = $_POST['order_by'];
    $sales = $_POST['sales'];
    $id_cs = $_POST['id_cs'];
    $note = $_POST['note'];
    $id_user = $_POST['id_user'];
    $id_status = 'Belum Diproses';
    $id_spk_encode = base64_encode($id_spk);

    $cek_data = mysqli_query($connect, "SELECT no_spk FROM spk_reg WHERE no_spk = '$no_spk'");

    if ($cek_data->num_rows > 0) {
        $_SESSION['info'] = 'No SPK sudah ada';
        header("Location:../form-create-spk-reg.php");
    } else {
        $simpan = "INSERT INTO spk_reg
                   (id_spk_reg, no_spk, tgl_spk, no_po, tgl_pesanan, id_orderby, id_sales, id_customer, note, id_user, status_spk, created_date)
                   VALUES
                   ('$id_spk', '$no_spk', '$tgl_spk', '$no_po', '$tgl_pesan', '$order_by', '$sales', '$id_cs', '$note', '$id_user', '$id_status', '$tgl_spk')";
        $query = mysqli_query($connect, $simpan);
        $_SESSION['info'] = 'No SPK berhasil dibuat';
        header("Location:../detail-produk-spk-reg.php?id=$id_spk_encode");
    }

    // Edit 
} else if (isset($_POST['edit'])) {
    $id_spk = $_POST['id_spk_reg'];
    $no_po = $_POST['no_po'];
    $tgl_pesan = $_POST['tgl_pesan'];
    $order_by = $_POST['order_by'];
    $sales = $_POST['sales'];
    $note = $_POST['note'];
    $id_user = $_POST['id_user'];
    $id_status = 'Belum Diproses';
    $id_spk_encode = base64_encode($id_spk);
    $tgl_updated = $_POST['updated'];

    echo $id_spk_encode;

    $update = "UPDATE spk_reg 
               SET
               no_po = '$no_po',
               tgl_pesanan = '$tgl_pesan',
               id_orderby = '$order_by',
               id_sales = '$sales',
               note = '$note',
               user_updated = '$id_user',
               updated_date = '$tgl_updated'
               WHERE id_spk_reg = '$id_spk'";
    $query = mysqli_query($connect, $update);
    header("Location:../detail-produk-spk-reg-dalam-proses.php?id=$id_spk_encode");
}
