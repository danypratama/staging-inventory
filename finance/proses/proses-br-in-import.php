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
    $laut = 'Laut';
    $udara = 'Udara';

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
    $encode = base64_encode($id_inv_import);

    $qty = intval(preg_replace("/[^0-9]/", "", $qty));

    $cek_data = mysqli_query($connect, "SELECT id_produk_reg, id_inv_br_import FROM isi_inv_br_import WHERE id_produk_reg ='$id_produk'");
    $data = mysqli_fetch_array($cek_data);

    if ($data['id_produk_reg'] == $id_produk && $data['id_inv_br_import'] == $id_inv_import) {
        $_SESSION['info'] = 'Data sudah ada';
        header("Location:../tampil-br-import.php?id=$encode");
        exit;
    } else {
        $sql = "INSERT INTO isi_inv_br_import
                (id_isi_inv_br_import, id_inv_br_import, id_produk_reg, qty, id_user, created_date)
                VALUES
                ('$id_isi_inv_br_import', '$id_inv_import', '$id_produk', '$qty', '$id_user', '$created')";
        $query = mysqli_query($connect, $sql);

        if ($query) {
            $_SESSION['info'] = 'Disimpan';
            header("Location:../input-isi-inv-br-import.php?id=$encode");
        } else {
            $_SESSION['info'] = 'Data Gagal Disimpan';
            header("Location:../input-isi-inv-br-import.php?id=$encode");
        }
    }
} else if (isset($_POST['simpan-act-br-import'])) {
    $id_act_br_import = $_POST['id_act_br_import'];
    $id_isi_inv_br_import = $_POST['id_isi_inv_br_import'];
    $id_inv_import = $_POST['id_inv_import'];
    $id_produk = $_POST['id_produk'];
    $qty_act = $_POST['qty_act'];
    $id_user = $_POST['id_user'];
    $created = $_POST['created'];
    $encode = base64_encode($id_inv_import);

    $qty_act = intval(preg_replace("/[^0-9]/", "", $qty_act));

    $simpan_data = "INSERT INTO act_br_import
                        (id_act_br_import, id_isi_inv_br_import, id_produk_reg, qty_act, id_user, created_date)
                        VALUES
                        ('$id_act_br_import', '$id_isi_inv_br_import', '$id_produk', '$qty_act', '$id_user', '$created')";
    $query = mysqli_query($connect, $simpan_data);


    if ($query) {
        $_SESSION['info'] = 'Disimpan';
        header("Location:../tampil-br-import.php?id=$encode");
    } else {
        $_SESSION['info'] = 'Data Gagal Disimpan';
        header("Location:../tampil-br-import.php?id=$encode");
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
    $laut = 'Laut';
    $udara = 'Udara';


    $cek_data = "SELECT * FROM inv_br_import WHERE id_inv_br_import = '$id_inv_br_import'";
    $query_cek = mysqli_query($connect, $cek_data);
    $data_sebelumnya = mysqli_fetch_assoc($query_cek);

    if ($data_sebelumnya['id_supplier'] == $id_sp && $data_sebelumnya['no_inv'] == $no_inv && $data_sebelumnya['tgl_inv'] == $tgl_inv && $data_sebelumnya['tgl_inv'] == $tgl_inv && $data_sebelumnya['no_order'] == $no_order && $data_sebelumnya['tgl_order'] == $tgl_order && $data_sebelumnya['shipping_by'] == $ship && $data_sebelumnya['no_awb'] == $no_awb && $data_sebelumnya['tgl_kirim'] == $tgl_kirim && $data_sebelumnya['tgl_est'] == $tgl_est) {
        $_SESSION['info'] = 'Tidak Ada Perubahan Data';
        header("Location:../barang-masuk-reg-import.php");
        exit;
    } else if ($ship == 10 OR $ship == $udara) {
        $edit_data = "UPDATE inv_br_import
                            SET 
                            id_supplier = '$id_sp',
                            no_inv = '$no_inv',
                            tgl_inv = '$tgl_inv',
                            no_order = '$no_order',
                            tgl_order = '$tgl_order',
                            shipping_by = '$udara',
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
    } else if ($ship == 30 OR $ship == $laut) {
        $edit_data = "UPDATE inv_br_import
                            SET 
                            id_supplier = '$id_sp',
                            no_inv = '$no_inv',
                            tgl_inv = '$tgl_inv',
                            no_order = '$no_order',
                            tgl_order = '$tgl_order',
                            shipping_by = '$laut',
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
    $encode = base64_encode($id_inv_import);

    $qty = intval(preg_replace("/[^0-9]/", "", $qty));

    // cek apakah data sebelumnya sama dengan data yang akan diubah
    $cek_data = "SELECT id_produk_reg, qty FROM isi_inv_br_import WHERE id_isi_inv_br_import = '$id_isi_inv_br_import'";
    $query_cek = mysqli_query($connect, $cek_data);
    $data_sebelumnya = mysqli_fetch_assoc($query_cek);

    if ($data_sebelumnya['id_produk_reg'] == $id_produk && $data_sebelumnya['qty'] == $qty) {
        $_SESSION['info'] = 'Tidak Ada Perubahan Data';
        header("Location:../tampil-br-import.php?id=$encode");
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
            header("Location:../tampil-br-import.php?id=$encode");
        } else {
            $_SESSION['info'] = 'Data Gagal Diupdate';
            header("Location:../tampil-br-import.php?id=$encode");
        }
    }
} else if (isset($_POST['edit-act-br-import'])) {
    $id_act_br_import = $_POST['id_act_br_import'];
    $id_isi_inv_br_import = $_POST['id_isi_inv_br_import'];
    $id_inv_br_import = $_POST['id_inv_br_import'];
    $id_produk = $_POST['id_produk'];
    $qty = $_POST['qty_act'];
    $id_isi = base64_encode($id_isi_inv_br_import);
    $id_inv = base64_encode($id_inv_br_import);

    $qty = intval(preg_replace("/[^0-9]/", "", $qty));

    // cek apakah data sebelumnya sama dengan data yang akan diubah
    $cek_data = "SELECT id_produk_reg, qty_act FROM act_br_import WHERE id_act_br_import = '$id_act_br_import'";
    $query_cek = mysqli_query($connect, $cek_data);
    $data_sebelumnya = mysqli_fetch_assoc($query_cek);

    if ($data_sebelumnya['id_produk_reg'] == $id_produk && $data_sebelumnya['qty_act'] == $qty) {
        $_SESSION['info'] = 'Tidak Ada Perubahan Data';
        header("Location:../list-act-br-import.php?id=$id_isi && id_inv=$id_inv");
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
            header("Location:../list-act-br-import.php?id=$id_isi && id_inv=$id_inv");
        } else {
            $_SESSION['info'] = 'Data Gagal Diupdate';
            header("Location:../list-act-br-import.php?id=$id_isi && id_inv=$id_inv");
        }
    }
} else if (isset($_GET['hapus'])) {
    //tangkap URL dengan $_GET
    $idh = base64_decode($_GET['hapus']);
    $id_inv = base64_decode($_GET['id_inv']);
    $encode = base64_encode($id_inv);

    //perintah queery sql untuk hapus data
    $sql = "DELETE iibi, act 
                FROM isi_inv_br_import iibi
                LEFT JOIN act_br_import act ON iibi.id_isi_inv_br_import = act.id_isi_inv_br_import
                WHERE iibi.id_isi_inv_br_import = '$idh'";
    $query_del = mysqli_query($connect, $sql) or die(mysqli_error($connect));

    if ($query_del) {
        $_SESSION['info'] = 'Dihapus';
        header("Location:../tampil-br-import.php?id=$encode");
    } else {
        $_SESSION['info'] = 'Data Gagal Dihapus';
        header("Location:../tampil-br-import.php?id=$encode");
    }
} else if (isset($_GET['hapus-act'])) {
    $id_act = base64_decode($_GET['hapus-act']);
    $id = base64_decode($_GET['id']);
    $id_inv = base64_decode($_GET['id_inv']);
    $encode_id = base64_encode($id);
    $encode_inv = base64_encode($id_inv);

    $sql = "DELETE FROM act_br_import WHERE id_act_br_import='$id_act'";
    $query_del = mysqli_query($connect, $sql) or die(mysqli_error($connect));

    if ($query_del) {
        $_SESSION['info'] = 'Dihapus';
        header("Location:../list-act-br-import.php?id= $encode_id && id_inv= $encode_inv");
    } else {
        $_SESSION['info'] = 'Data Gagal Dihapus';
        header("Location:../list-act-br-import.php?id= $encode_id && id_inv= $encode_inv");
    }

    // Update Status Pengiriman
} else if (isset($_POST['update-status'])) {
    $id_inv_br_import = $_POST['id_inv_br_import'];
    $tgl_est_str = $_POST['tgl_est'];
    $status = $_POST['status'];
    $hub_sp = 'Mohon tunggu / silahkan hubungi supplier kembali';
    echo $status;
 
    if ($status == "Sudah Diterima"){
        // Konversi tanggal
        $tgl_terima_str = $_POST['tgl_terima'];
        $tgl_est_datetime = DateTime::createFromFormat('d/m/Y', $tgl_est_str);
        $tgl_terima_datetime = DateTime::createFromFormat('d/m/Y', $tgl_terima_str);

        // Ambil format yang diinginkan
        $tgl_est = $tgl_est_datetime->format('Y/m/d');
        $tgl_terima = $tgl_terima_datetime->format('Y/m/d');

        // Konversi tanggal ke dalam format Unix timestamp
        $timestamp_est = strtotime($tgl_est);
        $timestamp_terima = strtotime($tgl_terima);

        // Hitung selisih hari antara kedua tanggal
        $selisih_hari = abs($timestamp_terima - $timestamp_est) / 86400;
        $tepat_waktu = 'Tepat Waktu';
        $telat = 'Barang Diterima Telat ' . $selisih_hari . ' hari';
        $lebih_awal = 'Barang Diterima Lebih Awal ' . $selisih_hari . ' hari';

        if ($tgl_est == $tgl_terima) {
            $update = mysqli_query($connect, "UPDATE inv_br_import 
                            SET 
                            status_pengiriman = '$status',
                            tgl_terima = '$tgl_terima_str',
                            keterangan = '$tepat_waktu'
                            WHERE id_inv_br_import = '$id_inv_br_import'");
            $_SESSION['info'] = 'Disimpan';
            header("Location:../barang-masuk-reg-import.php");
        } else if ($tgl_est < $tgl_terima) {
            $update = mysqli_query($connect, "  UPDATE inv_br_import 
                                                SET 
                                                status_pengiriman = '$status',
                                                tgl_terima = '$tgl_terima_str',
                                                keterangan = '$telat'
                                                WHERE id_inv_br_import = '$id_inv_br_import'");
            $_SESSION['info'] = 'Disimpan';
            header("Location:../barang-masuk-reg-import.php");
        } else {
            $update = mysqli_query($connect, "UPDATE inv_br_import 
                            SET 
                            status_pengiriman = '$status',
                            tgl_terima = '$tgl_terima_str',
                            keterangan = '$lebih_awal'
                            WHERE id_inv_br_import = '$id_inv_br_import'");
            $_SESSION['info'] = 'Disimpan';
            header("Location:../barang-masuk-reg-import.php");
        }
    }else if ($status == "Masih Dalam Perjalanan" OR $status == "Belum Dikirim") {
        $update = mysqli_query($connect, "  UPDATE inv_br_import 
                                            SET 
                                            status_pengiriman = '$status',
                                            tgl_terima = '',
                                            keterangan = '$hub_sp'
                                            WHERE id_inv_br_import = '$id_inv_br_import'");
        $_SESSION['info'] = 'Disimpan';
        header("Location:../barang-masuk-reg-import.php"); 
    } else if ($status == "Kendala Di Pelabuhan"){
        $keterangan = $_POST['keterangan'];
        $update = mysqli_query($connect, "  UPDATE inv_br_import 
                                            SET 
                                            status_pengiriman = '$status',
                                            tgl_terima = '',
                                            keterangan = '$keterangan'
                                            WHERE id_inv_br_import = '$id_inv_br_import'");
        $_SESSION['info'] = 'Disimpan';
        header("Location:../barang-masuk-reg-import.php");
    }     
          
    // Hapus All Data dari Inv 
} else if (isset($_GET['id'])) {
    //tangkap URL dengan $_GET
    $idh = base64_decode($_GET['id']);

    // Menampilkan data berelasi
    $sql = mysqli_query($connect, "SELECT ibi.*, ibi.id_inv_br_import AS id_inv, iibi.*, iibi.id_inv_br_import AS id_inv_isi
                                    FROM inv_br_import AS ibi
                                    LEFT JOIN isi_inv_br_import iibi ON ibi.id_inv_br_import = iibi.id_inv_br_import
                                    LEFT JOIN act_br_import act ON (iibi.id_isi_inv_br_import = act.id_isi_inv_br_import)
                                    WHERE ibi.id_inv_br_import= '$idh'");
    $data = mysqli_fetch_array($sql);
    $id_inv = $data['id_inv'];
    $id_inv_isi = $data['id_isi_inv_br_import'];
    $id_inv_act = $data['id_isi_inv_br_import'];

    echo $id_inv;
    echo $id_inv_isi;
    echo $id_inv_act;


    if ($id_inv_act == '' && $id_inv_isi == '') {
        // //perintah queery sql untuk hapus data
        $sql = "DELETE FROM inv_br_import
                WHERE id_inv_br_import = '$id_inv'";
        $query_del = mysqli_query($connect, $sql) or die(mysqli_error($connect));
        $_SESSION['info'] = 'Dihapus';
        header("Location:../barang-masuk-reg-import.php");
    } else if ($id_inv_act == true) {
        $sql = "DELETE ibi, iibi 
                FROM inv_br_import ibi
                LEFT JOIN isi_inv_br_import iibi ON (ibi.id_inv_br_import = iibi.id_inv_br_import)
                WHERE ibi.id_inv_br_import = '$id_inv'";
        $query_del = mysqli_query($connect, $sql) or die(mysqli_error($connect));
        $_SESSION['info'] = 'Dihapus';
        header("Location:../barang-masuk-reg-import.php");
    } else {
        $sql = "DELETE ibi, iibi, act  
                FROM inv_br_import ibi
                LEFT JOIN isi_inv_br_import iibi ON (ibi.id_inv_br_import = iibi.id_inv_br_import)
                LEFT JOIN act_br_import act ON (iibi.id_isi_inv_br_import = act.id_isi_inv_br_import)
                WHERE ibi.id_inv_br_import = '$id_inv' AND iibi.id_inv_br_import = '$id_isi_inv' AND act.id_isi_inv_br_import = '$id_inv_act'";
        $query_del = mysqli_query($connect, $sql) or die(mysqli_error($connect));
        $_SESSION['info'] = 'Dihapus';
        header("Location:../barang-masuk-reg-import.php");
    }
}
