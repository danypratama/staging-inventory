<?php  
session_start();
include "../koneksi.php";

if(isset($_POST['simpan-pembelian'])){
    $uuid = uuid();
    $day = date('d');
    $month = date('m');
    $year = date('y');
    $id_inv_pembelian = "PB" . $year . "" . $month . "" . $uuid . "" . $day ;
    $no_trx = htmlspecialchars($_POST['no_trx']);
    $tgl_pembelian = htmlspecialchars($_POST['tgl_pembelian']);
    $no_inv = htmlspecialchars($_POST['no_inv']);
    $kat_pembelian = htmlspecialchars($_POST['kat_pembelian']);
    $jenis_trx = htmlspecialchars($_POST['jenis_trx']);
    $tgl_tempo = htmlspecialchars($_POST['tgl_tempo']);
    $jenis_disc = htmlspecialchars($_POST['jenis_diskon']);
    $id_sp = htmlspecialchars($_POST['id_sp']);
    $note = htmlspecialchars($_POST['note']);
    $sp_disc = htmlspecialchars($_POST['sp_disc']);
    
    $simpan_data = $connect->query("INSERT INTO inv_pembelian_lokal 
                                        (id_inv_pembelian, id_sp, no_trx, tgl_pembelian, no_inv, kategori_pembelian, jenis_trx, tgl_tempo, jenis_disc, sp_disc, note)
                                        VALUES
                                        ('$id_inv_pembelian', '$id_sp', '$no_trx', '$tgl_pembelian', '$no_inv', '$kat_pembelian', '$jenis_trx', '$tgl_tempo', '$jenis_disc', '$sp_disc', '$note')");
    if($simpan_data){
        $_SESSION['info'] = 'Disimpan';
        header("Location:../data-pembelian.php");
    }
}

function uuid() {
    $data = openssl_random_pseudo_bytes(16);
    assert(strlen($data) == 16);

    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

    return vsprintf('%s%s%s', str_split(bin2hex($data), 4));
}

?>