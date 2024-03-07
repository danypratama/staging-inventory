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
} else if (isset($_POST['edit-detail'])){
    $id_inv_pembelian = htmlspecialchars($_POST['id_inv']);
    $nama_sp = htmlspecialchars($_POST['nama_sp']);
    $id_inv_pembelian_encode = base64_encode($id_inv_pembelian);
    $tgl_pembelian = htmlspecialchars($_POST['tgl_pembelian']);
    $no_inv_pembelian_lama = htmlspecialchars($_POST['no_inv_pembelian_lama']);
    $no_inv_pembelian = htmlspecialchars($_POST['no_inv_pembelian']);
    $jenis_trx = htmlspecialchars($_POST['jenis_trx']);
    $tgl_tempo = htmlspecialchars($_POST['tgl_tempo']);
    $jenis_disc = htmlspecialchars($_POST['jenis_diskon']);
    $sp_disc = htmlspecialchars($_POST['sp_disc']);
    echo $nama_sp;
    echo $no_inv_pembelian_lama;

    // Begin transaction
    mysqli_begin_transaction($connect);

    try{
        // Periksa karakter nama supplier yang tidak valid
        $nama_sp_replace = preg_replace("/[^a-zA-Z0-9]/", "_", $nama_sp);
        // Convert $no_inv_bum to the desired format
        $no_inv_lama_converted = str_replace('/', '_', $no_inv_pembelian_lama);
        $no_inv_baru_converted = str_replace('/', '_', $no_inv_pembelian);

        // Generate folder name based on invoice details for both old and new values
        $folder_name_lama = $no_inv_lama_converted;

        // Encode a portion of the folder name for both old and new values
        $encoded_portion_lama = base64_encode($folder_name_lama);

        // Combine the original $no_inv, encoded portion, and underscore for both old value
        $encoded_folder_name_lama = $no_inv_lama_converted . '_' . $encoded_portion_lama;

        // Set the path for the customer's folder for old value
        $customer_folder_path_lama = "../gambar/pembelian/" .  $nama_sp_replace . "/" . $encoded_folder_name_lama . "/";

        // Generate folder name based on invoice details for new value
        $folder_name_baru = $no_inv_baru_converted;

        // Encode a portion of the folder name for new value
        $encoded_portion_baru = base64_encode($folder_name_baru);

        // Combine the original $no_inv, encoded portion, and underscore for new value
        $encoded_folder_name_baru = $no_inv_baru_converted . '_' . $encoded_portion_baru;

        // Set the path for the customer's folder for new value
        $customer_folder_path_baru = "../gambar/pembelian/" .  $nama_sp_replace . "/" . $encoded_folder_name_baru . "/";

        // Rename the customer's folder if it exists for the old value
        if (is_dir($customer_folder_path_lama)) {
            if (rename($customer_folder_path_lama, $customer_folder_path_baru)) {
                echo 'Folder berhasil diubah nama dari ' . $encoded_folder_name_lama . ' menjadi ' . $encoded_folder_name_baru;
            } else {
                echo 'Gagal mengubah nama folder.';
                print_r(error_get_last()); // Menampilkan pesan kesalahan
            }
        } else {
            echo 'Folder dengan nama ' . $encoded_folder_name_lama . ' tidak ditemukan.';
        }
       
        if($jenis_disc == 'Tanpa Diskon'){
            $update_data_produk = $connect->query("UPDATE trx_produk_pembelian SET 
                                            disc = '0'  b 
                                            WHERE id_inv_pembelian = '$id_inv_pembelian'
                                        ");
            $update_data = $connect->query("UPDATE inv_pembelian_lokal SET 
                                                tgl_pembelian = '$tgl_pembelian',
                                                no_inv = '$no_inv_pembelian',
                                                jenis_trx = '$jenis_trx',
                                                tgl_tempo = '$tgl_tempo',
                                                jenis_disc = '$jenis_disc',
                                                sp_disc = '0'
                                                WHERE id_inv_pembelian = '$id_inv_pembelian'
                                            ");
            if($update_data_produk && $update_data){
                mysqli_commit($connect);
                $_SESSION['info'] = 'Diupdate';
                header("Location:../detail-produk-pembelian-lokal.php?id=$id_inv_pembelian_encode");
            }
        } else if ($jenis_disc == 'Spesial Diskon'){
            $update_data_produk = $connect->query("UPDATE trx_produk_pembelian SET 
                                            disc = '0'
                                            WHERE id_inv_pembelian = '$id_inv_pembelian'
                                        ");
            $update_data = $connect->query("UPDATE inv_pembelian_lokal SET 
                                                tgl_pembelian = '$tgl_pembelian',
                                                no_inv = '$no_inv_pembelian',
                                                jenis_trx = '$jenis_trx',
                                                tgl_tempo = '$tgl_tempo',
                                                jenis_disc = '$jenis_disc',
                                                sp_disc = '$sp_disc'
                                                WHERE id_inv_pembelian = '$id_inv_pembelian'
                                            ");
            if($update_data_produk && $update_data){
                mysqli_commit($connect);
                $_SESSION['info'] = 'Diupdate';
                header("Location:../detail-produk-pembelian-lokal.php?id=$id_inv_pembelian_encode");
            }
        } else if ($jenis_disc == 'Diskon Satuan'){
            $update_data_produk = $connect->query("UPDATE trx_produk_pembelian SET 
                                            disc = '0'
                                            WHERE id_inv_pembelian = '$id_inv_pembelian'
                                        ");
            $update_data = $connect->query("UPDATE inv_pembelian_lokal SET 
                                                tgl_pembelian = '$tgl_pembelian',
                                                no_inv = '$no_inv_pembelian',
                                                jenis_trx = '$jenis_trx',
                                                tgl_tempo = '$tgl_tempo',
                                                jenis_disc = '$jenis_disc',
                                                sp_disc = '0'
                                                WHERE id_inv_pembelian = '$id_inv_pembelian'
                                            ");
            if($update_data_produk && $update_data){
                mysqli_commit($connect);
                $_SESSION['info'] = 'Diupdate';
                header("Location:../detail-produk-pembelian-lokal.php?id=$id_inv_pembelian_encode");
            }
        }
    } catch (Exception $e) {
        // Rollback the transaction if an error occurs
        mysqli_rollback($connect);
        // Handle the error (e.g., display an error message)
        $error_message = "Terjadi kesalahan saat melakukan transaksi: " . $e->getMessage();
            ?>
            <!-- Sweet Alert -->
            <link rel="stylesheet" href="../assets/sweet-alert/dist/sweetalert2.min.css">
            <script src="../assets/sweet-alert/dist/sweetalert2.all.min.js"></script>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: "Error!",
                    text: "<?php echo $error_message; ?>",
                    icon: "error",
                }).then(function() {
                    window.location.href = "..//detail-produk-pembelian-lokal.php?id=<?php echo $id_inv_pembelian_encode ?>";
                });
                });
            </script>
            <?php
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