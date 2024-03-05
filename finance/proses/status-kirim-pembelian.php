<?php  
    session_start();
    include "../koneksi.php";

    if(isset($_POST['simpan-pengiriman'])){
        $id_status_kirim = htmlspecialchars($_POST['id_status_kirim']);
        $id_inv_pembelian = htmlspecialchars($_POST['id_inv_pembelian']);
        $id_inv_pembelian_encode = base64_encode($id_inv_pembelian);
        $jenis_pengiriman = $_POST['jenis_pengiriman'];
        echo $jenis_pengiriman;
        $diambil_oleh = htmlspecialchars($_POST['diambil_oleh']);
        $nama_kurir_pengirim = htmlspecialchars($_POST['nama_kurir_pengirim']);
        $ongkir = $_POST['ongkir'];
        $nominal_ongkir = str_replace(',', '', $ongkir); // Menghapus tanda ribuan (,)
        $nominal_ongkir = intval($nominal_ongkir); // Mengubah string harga menjadi integer
        $tanggal = htmlspecialchars($_POST['tanggal']);
        $created_by = $_SESSION['tiket_nama'];
        // Kondisi dikirim oleh
        if (isset($_POST['dikirim_oleh'])) {
            $dikirim_oleh = htmlspecialchars($_POST['dikirim_oleh']);
        } else {
            $dikirim_oleh = '';
        }
        // Kondisi Ekspedisi
        if (isset($_POST['ekspedisi'])) {
            $ekspedisi = htmlspecialchars($_POST['ekspedisi']);
        } else {
            $ekspedisi = '';
        }
        // Kondisi jenis ongkir
        if (isset($_POST['jenis_ongkir'])) {
            $jenis_ongkir = htmlspecialchars($_POST['jenis_ongkir']);
        } else {
            $jenis_ongkir = '';
        }
        // kondisi free ongkir
        if (isset($_POST['free_ongkir'])) {
            $free_ongkir = htmlspecialchars($_POST['free_ongkir']);
        } else {
            $free_ongkir = '';
        }

        if ($jenis_pengiriman == 'Diambil'){
            $simpan_data = $connect->query("INSERT INTO status_kirim_pembelian 
                                                (id_status_kirim, id_inv_pembelian, jenis_pengiriman, diambil_oleh, tanggal, status, created_by)
                                                VALUES
                                                ('$id_status_kirim', '$id_inv_pembelian', '$jenis_pengiriman', '$diambil_oleh', '$tanggal', '1', '$created_by')    
                                            ");
            if($simpan_data){
                $_SESSION['info'] = "Disimpan";
                header("Location:../detail-produk-pembelian-lokal.php?id=$id_inv_pembelian_encode");
            } else {
                $_SESSION['info'] = "Data Gagal Disimpan";
                header("Location:../detail-produk-pembelian-lokal.php?id=$id_inv_pembelian_encode");
            }
            

        } else if ($jenis_pengiriman == 'Dikirim'){
            $simpan_data = $connect->query("INSERT INTO status_kirim_pembelian 
                                                (id_status_kirim, id_inv_pembelian, jenis_pengiriman, dikirim_oleh, nama_kurir_pengirim, nama_ekspedisi, jenis_ongkir, nominal_ongkir, free_ongkir, tanggal, status, created_by)
                                                VALUES
                                                ('$id_status_kirim', '$id_inv_pembelian', '$jenis_pengiriman', '$dikirim_oleh', '$nama_kurir_pengirim', '$ekspedisi', '$jenis_ongkir', '$nominal_ongkir', '$free_ongkir', '$tanggal', '1', '$created_by')    
                                            ");
            if($simpan_data){
                $_SESSION['info'] = "Disimpan";
                header("Location:../detail-produk-pembelian-lokal.php?id=$id_inv_pembelian_encode");
            } else {
                $_SESSION['info'] = "Data Gagal Disimpan";
                header("Location:../detail-produk-pembelian-lokal.php?id=$id_inv_pembelian_encode");
            }
        }
    } else if ($_GET['edit-pengiriman']){
        $idh = base64_decode($_GET['edit-pengiriman']);
        $id_inv_pembelian_encode = base64_encode($idh);
        $delete = $connect->query("DELETE FROM status_kirim_pembelian WHERE id_inv_pembelian = '$idh'");

        if($delete){
            $_SESSION['info'] = "Diupdate";
            header("Location:../detail-produk-pembelian-lokal.php?id=$id_inv_pembelian_encode");
        } else {
            $_SESSION['info'] = "Data Gagal Diupdate";
            header("Location:../detail-produk-pembelian-lokal.php?id=$id_inv_pembelian_encode");
        }
    }


?>