<?php  
    session_start();
    include "../koneksi.php";

    if(isset($_POST['simpan-reg'])){
        $id_ganti_merk_out = $_POST['id_ganti_merk_out'];
        $id_prod_awal = $_POST['id_produk_awal'];
        $merk_awal = $_POST['merk_awal'];
        $qty_awal = $_POST['qty_awal'];
        $id_ganti_merk_in = $_POST['id_ganti_merk_in'];
        $id_prod_akhir = $_POST['id_produk_akhir'];
        $merk_akhir = $_POST['merk_akhir'];
        $qty_akhir = $_POST['qty_akhir'];
        $id_user = $_POST['id_user'];
        $created = $_POST['created'];

        $qty_awal = intval(preg_replace("/[^0-9]/", "", $qty_awal));
        $qty_akhir = intval(preg_replace("/[^0-9]/", "", $qty_akhir));

        if($merk_awal == $merk_akhir){
            $_SESSION['info'] = 'Merk Tidak Boleh Sama';
            echo "<script>document.location.href='../input-ganti-merk-reg.php'</script>";
        }else{
            //mulai transaksi
            mysqli_begin_transaction($connect);

            //simpan data pada tabel pertama
            $sql1 = "INSERT INTO ganti_merk_reg_out (id_ganti_merk_out, id_user, id_produk_reg, qty, created_date) VALUES ('$id_ganti_merk_out', '$id_user', '$id_prod_awal', '$qty_awal', '$created')";
            mysqli_query($connect, $sql1);

            //simpan data pada tabel kedua
            $sql2 = "INSERT INTO ganti_merk_reg_in (id_ganti_merk_in, id_user, id_produk_reg, qty, created_date) VALUES ('$id_ganti_merk_in', '$id_user', '$id_prod_akhir', '$qty_akhir', '$created')";
            mysqli_query($connect, $sql2);

            //jika semua query berhasil, commit transaksi
            mysqli_commit($connect);

            //jika terjadi kesalahan pada salah satu query, rollback transaksi
            mysqli_rollback($connect);

            //tutup koneksi
            mysqli_close($connect);

            $_SESSION['info'] = 'Disimpan';
            echo "<script>document.location.href='../input-ganti-merk-reg.php'</script>";
        }
    }elseif($_GET['hapus_id']){
        //tangkap URL dengan $_GET
        $idh = $_GET['hapus_id'];

        // perintah queery sql untuk hapus data
        $sql = "DELETE a.*, b.* FROM ganti_merk_reg_out a, ganti_merk_reg_in b WHERE a.id_ganti_merk_out='$idh' AND b.id_ganti_merk_in='$idh'";
        $query_del = mysqli_query($connect,$sql) or die (mysqli_error($connect));

        if($query_del){
            $_SESSION['info'] = 'Dihapus';
            echo "<script>document.location.href='../ganti-merk-reg.php'</script>";
        }else{
            $_SESSION['info'] = 'Data Gagal Dihapus';
            echo "<script>document.location.href='../ganti-merk-reg.php'</script>";
        }
    }


?>