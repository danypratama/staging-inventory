<?php
session_start();
include "../koneksi.php";
date_default_timezone_set('Asia/Jakarta');

if (isset($_POST['simpan-set-ecat'])) {
    $id_set_ecat = htmlspecialchars($_POST['id_set_ecat']);
    $kode_set = htmlspecialchars($_POST['kode_barang']);
    $no_batch = htmlspecialchars($_POST['no_batch']);
    $nama_set_ecat = htmlspecialchars($_POST['nama_set_ecat']);
    $id_lokasi = htmlspecialchars($_POST['id_lokasi']);
    $katjual = htmlspecialchars($_POST['kategori_penjualan']);
    $merk = htmlspecialchars($_POST['merk']);
    $harga = htmlspecialchars($_POST['harga']);
    $nama_user = htmlspecialchars($_POST['nama_user']);
    $created = htmlspecialchars($_POST['created_date']);

    // Mengubah format menjadi int
    $harga = intval(preg_replace("/[^0-9]/", "", $harga));

    $cek_data = mysqli_query($connect, "SELECT * FROM tb_produk_set_ecat WHERE kode_set_ecat = '$kode_set'");

    if ($cek_data->num_rows > 0) {
        $_SESSION['info'] = 'Data sudah ada';
        echo "<script>document.location.href='../data-produk-set-ecat.php'</script>";
    } else {
        mysqli_query($connect, "INSERT INTO tb_produk_set_ecat
                    (id_set_ecat, kode_set_ecat, no_batch, nama_set_ecat, id_lokasi, id_kat_penjualan, id_merk, harga_set_ecat, created_date, created_by) 
                    VALUES 
                    ('$id_set_ecat', '$kode_set', '$no_batch', '$nama_set_ecat', '$id_lokasi', '$katjual', '$merk', '$harga', '$created', '$nama_user')");

        $_SESSION['info'] = 'Disimpan';
        echo "<script>document.location.href='../data-produk-set-ecat.php'</script>";
    }
} elseif (isset($_POST['edit-set-ecat'])) {
    $id_set_ecat = htmlspecialchars($_POST['id_set_ecat']);
    $kode_set = htmlspecialchars($_POST['kode_barang']);
    $no_batch = htmlspecialchars($_POST['no_batch']);
    $nama_set_ecat = htmlspecialchars($_POST['nama_set_ecat']);
    $id_lokasi = htmlspecialchars($_POST['id_lokasi']);
    $katjual = htmlspecialchars($_POST['kategori_penjualan']);
    $merk = htmlspecialchars($_POST['merk']);
    $harga = htmlspecialchars($_POST['harga']);
    $nama_user = $_SESSION['tiket_nama'];
    $updated = htmlspecialchars($_POST['updated_date']);
    $updated_date = date('d/m/Y H:i:s');
    $harga = intval(preg_replace("/[^0-9]/", "", $harga));

    $update = mysqli_query($connect, "UPDATE tb_produk_set_ecat
    								  SET 
                                      kode_set_ecat = '$kode_set',
                                      no_batch = '$no_batch',
                                      nama_set_ecat = '$nama_set_ecat',
                                      id_lokasi = '$id_lokasi',
                                      id_kat_penjualan = '$katjual',
                                      id_merk = '$merk',
                                      harga_set_ecat = '$harga',
                                      updated_date = '$updated_date',
                                      updated_by = '$nama_user'
                                      WHERE id_set_ecat = '$id_set_ecat'");
    if ($update) {
        $_SESSION['info'] = 'Diupdate';
        echo "<script>document.location.href='../data-produk-set-ecat.php'</script>";
    } else {
        $_SESSION['info'] = 'Data Gagal Diupdate';
        echo "<script>document.location.href='../data-produk-set-ecat.php'</script>";
    }
} elseif (isset($_GET['hapus-set-ecat'])) {
    //tangkap URL dengan $_GET
    $idh = base64_decode($_GET['hapus-set-ecat']);

    // perintah queery sql untuk hapus data 
    $sql = "DELETE tpsm, ipsm
            FROM tb_produk_set_ecat tpsm
            LEFT JOIN isi_produk_set_ecat ipsm ON (tpsm.id_set_ecat = ipsm.id_set_ecat)
            WHERE tpsm.id_set_ecat = '$idh'";

    $query_del = mysqli_query($connect, $sql) or die(mysqli_error($connect));

    if ($query_del) {
        $_SESSION['info'] = 'Dihapus';
        echo "<script>document.location.href='../data-produk-set-ecat.php'</script>";
    } else {
        $_SESSION['info'] = 'Data Gagal Dihapus';
        echo "<script>document.location.href='../data-produk-set-ecat.php'</script>";
    }

    // Proses CRUD isi set ecat
} elseif (isset($_POST['simpan-isi-set-ecat'])) {
    $id_isi_set_ecat = $_POST['id_isi_set_ecat'];
    $id_set_ecat = $_POST['id_set_ecat'];
    $encode = base64_encode($id_set_ecat);
    $id_produk = $_POST['id_produk'];
    $qty = $_POST['qty'];
    $qty = intval(preg_replace("/[^0-9]/", "", $qty));

    $cek_data = mysqli_query($connect, "SELECT * FROM isi_produk_set_ecat WHERE id_set_ecat = '$id_set_ecat'");
    $data = mysqli_fetch_array($cek_data);
    $num_rows = mysqli_num_rows($cek_data);

    if ($num_rows > 0) {
        if ($data['id_set_ecat'] == $id_set_ecat && $data['id_produk'] == $id_produk) {
            $_SESSION['info'] = "Data sudah ada";
            echo "<script>document.location.href='../detail-set-ecat.php?detail-id=$encode'</script>";
        } else {
            $simpan_data = "INSERT INTO isi_produk_set_ecat 
                            (id_isi_set_ecat, id_set_ecat, id_produk, qty) 
                            VALUES 
                            ('$id_isi_set_ecat', '$id_set_ecat', '$id_produk', '$qty')";
            $query = mysqli_query($connect, $simpan_data);
            $_SESSION['info'] = 'Disimpan';
            echo "<script>document.location.href='../detail-set-ecat.php?detail-id=$encode'</script>";
        }
    } else if ($num_rows == 0) {
        $simpan_data = "INSERT INTO isi_produk_set_ecat 
                    (id_isi_set_ecat, id_set_ecat, id_produk, qty) 
                    VALUES 
                    ('$id_isi_set_ecat', '$id_set_ecat', '$id_produk', '$qty')";
        $query = mysqli_query($connect, $simpan_data);
        $_SESSION['info'] = 'Disimpan';
        echo "<script>document.location.href='../detail-set-ecat.php?detail-id=$encode'</script>";
    }
} elseif (isset($_POST['edit-isi-set-ecat'])) {
    $id_isi_set_ecat = $_POST['id_isi_set_ecat'];
    $id_set_ecat = $_POST['id_set_ecat'];
    $encode = base64_encode($id_set_ecat);
    $id_produk = $_POST['id_produk'];
    $qty = $_POST['qty'];

    $update = "UPDATE isi_produk_set_ecat
               SET 
               id_set_ecat = '$id_set_ecat',
               id_produk = '$id_produk',
               qty = '$qty'
               WHERE id_isi_set_ecat = '$id_isi_set_ecat'";
    $query_update = mysqli_query($connect, $update);
    if ($query_update) {
        $_SESSION['info'] = 'Diupdate';
        echo "<script>document.location.href='../detail-set-ecat.php?detail-id=$encode'</script>";
    } else {
        $_SESSION['info'] = 'Data Gagal Diupdate';
        echo "<script>document.location.href='../detail-set-ecat.php?detail-id=$encode'</script>";
    }
} elseif (isset($_GET['hapus-isi-set'])) {
    //tangkap URL dengan $_GET
    $idh = base64_decode($_GET['hapus-isi-set']);
    $kode = base64_decode($_GET['kode']);
    $encode = base64_encode($kode);
    // perintah queery sql untuk hapus data
    $sql = "DELETE FROM isi_produk_set_ecat WHERE id_isi_set_ecat='$idh'";
    $query_del = mysqli_query($connect, $sql) or die(mysqli_error($connect));

    if ($query_del) {
        $_SESSION['info'] = 'Dihapus';
        echo "<script>document.location.href='../detail-set-ecat.php?detail-id=$encode'</script>";
    } else {
        $_SESSION['info'] = 'Data Gagal Dihapus';
        echo "<script>document.location.href='../detail-set-ecat.php?detail-id=$encode'</script>";
    }
}
