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
    $nama_sp = htmlspecialchars($_POST['nama_sp']);
    $note = htmlspecialchars($_POST['note']);
    $sp_disc = htmlspecialchars($_POST['sp_disc']);

    // Periksa karakter nama supplier yang tidak valid
    $nama_sp_replace = preg_replace("/[^a-zA-Z0-9]/", "_", $nama_sp);
    
    // Convert $no_inv_bum to the desired format
    $no_inv_converted = str_replace('/', '_', $no_inv);

    // Generate folder name based on invoice details
    $folder_name = $no_inv_converted;

    // Encode a portion of the folder name
    $encoded_portion = base64_encode($folder_name);

    // Combine the original $no_inv, encoded portion, and underscore
    $encoded_folder_name = $no_inv_converted . '_' . $encoded_portion;

    // Set the path for the customer's folder
    $customer_folder_path = "../gambar/pembelian/" .  $nama_sp_replace . "/" . $encoded_folder_name . "/";

    // Create the customer's folder if it doesn't exist
    if (!is_dir($customer_folder_path)) {
        mkdir($customer_folder_path, 0777, true); // Set permission to 0777 to ensure the folder is writable
    }
    
    $simpan_data = $connect->query("INSERT INTO inv_pembelian_lokal 
                                        (id_inv_pembelian, id_sp, no_trx, tgl_pembelian, no_inv, kategori_pembelian, jenis_trx, tgl_tempo, jenis_disc, sp_disc, note)
                                        VALUES
                                        ('$id_inv_pembelian', '$id_sp', '$no_trx', '$tgl_pembelian', '$no_inv', '$kat_pembelian', '$jenis_trx', '$tgl_tempo', '$jenis_disc', '$sp_disc', '$note')");
    if($simpan_data){
        $_SESSION['info'] = 'Disimpan';
        header("Location:../data-pembelian.php");
    }
} else if (isset($_POST['edit-details'])){
    $id_inv_penjualan = htmlspecialchars($_POST['id_inv']);
    $tgl_pembelian = htmlspecialchars($_POST['tgl_pembelian']);
    $no_inv_pembelian = htmlspecialchars($_POST['no_inv_pembelian']);
    $jenis_trx = htmlspecialchars($_POST['jenis_trx']);
    $tgl_tempo = htmlspecialchars($_POST['tgl_tempo']);
    $jenis_disc = htmlspecialchars($_POST['jenis_diskon']);
    $sp_disc = htmlspecialchars($_POST['sp_disc']);
}

function uuid() {
    $data = openssl_random_pseudo_bytes(16);
    assert(strlen($data) == 16);

    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

    return vsprintf('%s%s%s', str_split(bin2hex($data), 4));
}

?>