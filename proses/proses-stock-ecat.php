<?php
session_start();
include "../koneksi.php";

if (isset($_POST['simpan-stock-ecat'])) {
    $id_stock_ecat = $_POST['id_stock_ecat'];
    $id_produk = $_POST['id_produk'];
    $id_kat_jual = $_POST['id_kat_jual'];
    $stock = $_POST['stock'];
    $nama_user = $_POST['nama_user'];
    $created = $_POST['created_date'];
    $register_value = '1';

    $stock = intval(preg_replace("/[^0-9]/", "", $stock));

    $cek_data = "SELECT id_produk_ecat FROM stock_produk_ecat WHERE id_produk_ecat = '$id_produk'";
    $query = mysqli_query($connect, $cek_data);

    if ($query->num_rows > 0) {
        $_SESSION['info'] = 'Data sudah ada';
        echo "<script>document.location.href='../stock-produk-ecat.php'</script>";
    } else {
        $cek_produk = "SELECT id_produk_ecat FROM tb_produk_ecat WHERE id_produk_ecat = '$id_produk'";
        $query_cek = mysqli_query($connect, $cek_produk);
        if($query_cek->num_rows > 0){
            mysqli_query($connect, "INSERT INTO stock_produk_ecat
                        (id_stock_prod_ecat, id_produk_ecat, id_kat_penjualan, stock, created_date, created_by)
                        values
                        ('$id_stock_ecat', '$id_produk', '$id_kat_jual', '$stock', '$created', '$nama_user')");

            mysqli_query($connect, "UPDATE tb_produk_ecat 
                                                    SET
                                                    register_value = '$register_value'
                                                    WHERE id_produk_ecat = '$id_produk'");

            echo $id_produk;
            $_SESSION['info'] = 'Disimpan';
            echo "<script>document.location.href='../stock-produk-ecat.php'</script>"; 
        } else {
            mysqli_query($connect, "INSERT INTO stock_produk_ecat
                        (id_stock_prod_ecat, id_produk_ecat, id_kat_penjualan, stock, created_date, created_by)
                        values
                        ('$id_stock_ecat', '$id_produk', '$id_kat_jual', '$stock', '$created', '$nama_user')");

            $update = mysqli_query($connect, "UPDATE tb_produk_set_ecat
                                                SET
                                                register_value = '$register_value'
                                                WHERE id_set_ecat='$id_produk'");
             echo $id_produk;
            $_SESSION['info'] = 'Disimpan';
            echo "<script>document.location.href='../stock-produk-ecat.php'</script>";
        }
    }
} elseif (isset($_GET['hapus-stock-ecat'])) {
    $idh = base64_decode($_GET['hapus-stock-ecat']);
    $idu = base64_decode($_GET['id_produk']);
    $register_val = 0;

    $cek_id = mysqli_query($connect, "SELECT id_produk_ecat FROM tb_produk_ecat WHERE id_produk_ecat = '$idu'");

    if($cek_id->num_rows > 0){
        $update = mysqli_query($connect, "UPDATE tb_produk_ecat 
                                          SET
                                          register_value = '$register_val'
                                          WHERE id_produk_ecat ='$idu'");
        $hapus_data = "DELETE FROM stock_produk_ecat WHERE id_stock_prod_ecat = '$idh'";
        $query = mysqli_query($connect, $hapus_data);
    
        if ($query) {
            $_SESSION['info'] = 'Dihapus';
            echo "<script>document.location.href='../stock-produk-ecat.php'</script>";
        } else {
            $_SESSION['info'] = 'Data Gagal Dihapus';
            echo "<script>document.location.href='../stock-produk-ecat.php'</script>";
        }
        
    }else{
        $update = mysqli_query($connect, "UPDATE tb_produk_set_ecat 
                                          SET
                                          register_value = '$register_val'
                                          WHERE id_set_ecat='$idu'");

        $hapus_data = "DELETE FROM stock_produk_ecat WHERE id_stock_prod_ecat = '$idh'";
        $query = mysqli_query($connect, $hapus_data);

        if ($query) {
            $_SESSION['info'] = 'Dihapus';
            echo "<script>document.location.href='../stock-produk-ecat.php'</script>";
        } else {
            $_SESSION['info'] = 'Data Gagal Dihapus';
            echo "<script>document.location.href='../stock-produk-ecat.php'</script>";
        }
    }
}
