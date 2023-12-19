<?php  
include "../koneksi.php";
include "../page/resize-image.php";
session_start();

if(isset($_POST['simpan-pembayaran'])){
    date_default_timezone_set('Asia/Jakarta');
    $date = date('d/m/Y H:i:s');

    $uuid = uuid();
    $day = date('d');
    $month = date('m');
    $year = date('y');
    $id_bayar = "BYR" . $year . "" . $month . "" . $uuid . "" . $day ;
    $id_bank_cs = "BANK_CS" . $year . "" . $month . "" . $uuid . "" . $day ;
    $id_bukti = "BUKTI" . $year . "" . $month . "" . $uuid . "" . $day ;
    $id_cs = $_POST['id_cs'];
    $metode_bayar = $_POST['metode_pembayaran'];
    $nominal = str_replace('.', '', $_POST['nominal']); // Menghapus tanda ribuan (,)
    $nominal = intval($nominal); // Mengubah string harga menjadi integer
    $id_inv = $_POST['id_inv'];
    $tgl_bayar = $_POST['tgl_bayar'];
    $keterangan_bayar = $_POST['keterangan_bayar'];
    $user = $_POST['user'];
    $id_bill = $_POST['id_bill'];
    $id_bill_encode = base64_encode($id_bill);
    $id_inv_encode = base64_encode($id_inv);
    $nama_invoice = 'Invoice_Non_PPN';
    $jenis_inv = $_POST['jenis_inv'];
    $sisa_tagihan = $_POST['sisa_tagihan'];
    $id_finance = $_POST['id_finance'];
    $nama_pengirim = $_POST['nama_pengirim'];
    $rek_pengirim = $_POST['rek_pengirim'];
    $bank_pengirim = $_POST['bank_pengirim'];
    $created_by = $_SESSION['tiket_nama'];

    if($metode_bayar == 'transfer'){
        $id_bank = $_POST['id_bank'];
        if($jenis_inv == 'nonppn'){
            $sql_inv = mysqli_query($connect, " SELECT  nonppn.id_inv_nonppn, 
                                                        nonppn.no_inv, 
                                                        DAY(STR_TO_DATE(nonppn.tgl_inv, '%d/%m/%Y')) AS day_inv, 
                                                        LPAD(MONTH(STR_TO_DATE(tgl_inv, '%d/%m/%Y')), 2, '0') AS month_inv,
                                                        YEAR(STR_TO_DATE(nonppn.tgl_inv, '%d/%m/%Y')) AS year_inv,
        
                                                        fnc.id_inv,
                                                        fnc.id_tagihan,
        
                                                        bill.id_tagihan,
                                                        bill.no_tagihan,
        
                                                        cs.id_cs,
                                                        cs.nama_cs,
        
                                                        spk.id_inv,
                                                        spk.id_customer
                                                FROM inv_nonppn AS nonppn
                                                LEFT JOIN finance fnc ON (nonppn.id_inv_nonppn = fnc.id_inv)
                                                LEFT JOIN finance_tagihan bill ON (fnc.id_tagihan = bill.id_tagihan)
                                                LEFT JOIN spk_reg spk ON (nonppn.id_inv_nonppn = spk.id_inv)
                                                LEFT JOIN tb_customer cs ON (spk.id_customer = cs.id_cs)
                                                WHERE nonppn.id_inv_nonppn = '$id_inv'");
            $data_inv = mysqli_fetch_array($sql_inv);
        
            $no_inv_nonppn = $data_inv['no_inv'];
            $no_tagihan = $data_inv['no_tagihan'];
            $day_inv = $data_inv['day_inv'];
            $month_inv =  $data_inv['month_inv'];
            $year_inv =  $data_inv['year_inv'];
            $cs = $data_inv['nama_cs'];
        
        
            $nama_invoice = 'Invoice_Non_Ppn';
        
            // Convert $no_inv_nonppn to the desired format
            $no_inv_nonppn_converted = str_replace('/', '_', $no_inv_nonppn);
        
            // Generate folder name based on invoice details
            $folder_name = $no_inv_nonppn_converted;
        
            // Encode a portion of the folder name
            $encoded_portion = base64_encode($folder_name);
        
            // Combine the original $no_inv_nonppn, encoded portion, and underscore
            $encoded_folder_name = $no_inv_nonppn_converted . '_' . $encoded_portion;
        
            // untuk Membuat Folder Bukti Pembayaran
            $bukti_pembayaran = "Bukti_Transfer";
        
            // Set the path for the customer's folder
            $customer_folder_path = "../../Customer/" . $cs . "/" . $year_inv . "/" . $month_inv . "/" . $day_inv . "/" . ucwords(strtolower(str_replace('_', ' ', $nama_invoice))) . "/" . $encoded_folder_name ."/". $bukti_pembayaran ."/";
        
            // Create the customer's folder if it doesn't exist
            if (!is_dir($customer_folder_path)) {
                mkdir($customer_folder_path, 0777, true); // Set permission to 0777 to ensure the folder is writable
                
                // Mendapatkan informasi file bukti transfer
                $file1_name = $_FILES['fileku1']['name'];
                $file1_tmp = $_FILES['fileku1']['tmp_name'];
                $file1_destination =  $customer_folder_path . $file1_name;
        
                // Pindahkan file bukti transfer ke lokasi tujuan
                move_uploaded_file($file1_tmp, $file1_destination);
               
                if($file1_name != ''){
                    // Begin transaction
                    mysqli_begin_transaction($connect);
        
                    try{
                        $no_tagihan_converted = str_replace('/', '_', $no_tagihan);
                        $name_no_tagihan = $no_tagihan_converted;
                        
                        $no = 1;
                        $file_extension = ".jpg";
                        
                        do {
                            // Generate nama file baru dengan nomor yang bertambah
                            $new_file1_name = $name_no_tagihan . "_" . $no . $file_extension;
                            $compressed_file1_destination = $customer_folder_path . $new_file1_name;
                        
                            // Cek apakah file dengan nama tersebut sudah ada
                            if (!file_exists($compressed_file1_destination)) {
                                // Jika tidak ada, lakukan kompresi dan ubah ukuran gambar
                                compressAndResizeImage($file1_destination, $compressed_file1_destination, 500, 500, 100);
                                unlink($file1_destination); // Hapus file sumber yang tidak dikompresi
                                break; // Keluar dari loop karena nama file sudah unik
                            }
                        
                            $no++; // Jika nama file sudah ada, tambahkan nomor dan coba lagi
                        } while (true);
        
                        if($sisa_tagihan == 0 ){
                            $cek_data = mysqli_query($connect, "SELECT id_bank_cs, id_cs, id_bank, no_rekening, atas_nama FROM bank_cs WHERE id_cs = '$id_cs' AND id_bank = '$bank_pengirim' AND no_rekening = '$rek_pengirim' AND atas_nama = '$nama_pengirim'");

                            $sql_cs_bank = '';

                            if($cek_data->num_rows == 0){
                                $sql_cs_bank = mysqli_query($connect, "INSERT INTO bank_cs 
                                                            (id_bank_cs, id_cs, id_bank, no_rekening, atas_nama, created_by) 
                                                            VALUES 
                                                            ('$id_bank_cs', '$id_cs', '$bank_pengirim', '$rek_pengirim', '$nama_pengirim', '$created_by')");
                            } else {
                                $sql_cs_bank = '';
                            }

                            $sql_bayar = mysqli_query($connect, "INSERT INTO finance_bayar 
                                                            (id_bayar, id_bank_pt, id_tagihan, id_finance, id_bukti, metode_pembayaran, keterangan_bayar, total_bayar, tgl_bayar, created_by) 
                                                            VALUES 
                                                            ('$id_bayar', '$id_bank', '$id_bill', '$id_finance', '$id_bukti', '$metode_bayar', '$keterangan_bayar', '$nominal', '$tgl_bayar', '$user')");
                            $sql_bukti_tf = mysqli_query($connect, "INSERT INTO finance_bukti_tf
                                                                (id_bukti_tf, tf_bank, rek_pengirim, tf_an, bukti_tf, created_by) 
                                                                VALUES 
                                                                ('$id_bukti', '$bank_pengirim', '$rek_pengirim', '$nama_pengirim', '$new_file1_name', '$user')");
        
                            $sql_finance = mysqli_query($connect, "UPDATE finance SET status_pembayaran = 1, status_lunas = 1  WHERE id_finance = '$id_finance'");
        
        
                            if (!$sql_cs_bank && !$sql_bayar && !$sql_bukti_tf && !$sql_finance) {
                                throw new Exception("Error updating data");
                            }
        
                            // Commit the transaction
                            mysqli_commit($connect);
                            // Redirect to the invoice page
                            header("Location:../detail-bill.php?id=$id_bill_encode");
                            exit();
        
                        } else {
                            $cek_data = mysqli_query($connect, "SELECT id_bank_cs, id_cs, id_bank, no_rekening, atas_nama FROM bank_cs WHERE id_cs = '$id_cs' AND id_bank = '$bank_pengirim' AND no_rekening = '$rek_pengirim' AND atas_nama = '$nama_pengirim'");

                            $sql_cs_bank = '';

                            if($cek_data->num_rows == 0){
                                $sql_cs_bank = mysqli_query($connect, "INSERT INTO bank_cs 
                                                            (id_bank_cs, id_cs, id_bank, no_rekening, atas_nama, created_by) 
                                                            VALUES 
                                                            ('$id_bank_cs', '$id_cs', '$bank_pengirim', '$rek_pengirim', '$nama_pengirim', '$created_by')");
                            } else {
                                $sql_cs_bank = '';
                            }

                            $sql_bayar = mysqli_query($connect, "INSERT INTO finance_bayar 
                                                            (id_bayar, id_bank_pt, id_tagihan, id_finance, id_bukti, metode_pembayaran, keterangan_bayar, total_bayar, tgl_bayar, created_by) 
                                                            VALUES 
                                                            ('$id_bayar', '$id_bank', '$id_bill', '$id_finance', '$id_bukti', '$metode_bayar', '$keterangan_bayar', '$nominal', '$tgl_bayar', '$user')");
                            $sql_bukti_tf = mysqli_query($connect, "INSERT INTO finance_bukti_tf
                                                                (id_bukti_tf, tf_bank, rek_pengirim, tf_an, bukti_tf, created_by) 
                                                                VALUES 
                                                                ('$id_bukti', '$bank_pengirim', '$rek_pengirim', '$nama_pengirim', '$new_file1_name', '$user')");
        
                            $sql_finance = mysqli_query($connect, "UPDATE finance SET status_pembayaran = 1, status_lunas = 0 WHERE id_finance = '$id_finance'");
        
        
                        if (!$sql_cs_bank && !$sql_bayar && !$sql_bukti_tf && !$sql_finance) {
                            throw new Exception("Error updating data");
                        }
                            // Commit the transaction
                            mysqli_commit($connect);
                            // Redirect to the invoice page
                            ?>
                            <!-- Sweet Alert -->
                            <link rel="stylesheet" href="../assets/sweet-alert/dist/sweetalert2.min.css">
                            <script src="../assets/sweet-alert/dist/sweetalert2.all.min.js"></script>
                            <script>
                                document.addEventListener("DOMContentLoaded", function() {
                                    Swal.fire(
                                        'Berhasil',
                                        'Data Berhasil Disimpan',
                                        'success'
                                        ).then(function() {
                                    window.location.href = "../detail-bill.php?id=<?php echo $id_bill_encode ?>";
                                    });
                                });
                            </script>
                            <?php
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
                                    window.location.href = "../detail-bill.php?id=<?php echo $id_bill_encode ?>";
                                });
                                });
                            </script>
                            <?php
                        } 
                    
                }
            }else{
                // Mendapatkan informasi file bukti transfer
                $file1_name = $_FILES['fileku1']['name'];
                $file1_tmp = $_FILES['fileku1']['tmp_name'];
                $file1_destination =  $customer_folder_path . $file1_name;
        
                // Pindahkan file bukti transfer ke lokasi tujuan
                move_uploaded_file($file1_tmp, $file1_destination);
        
               
                if($file1_name != ''){
                    // Begin transaction
                    mysqli_begin_transaction($connect);
        
                    try{
                        $no_tagihan_converted = str_replace('/', '_', $no_tagihan);
                        $name_no_tagihan = $no_tagihan_converted;
                        
                        $no = 1;
                        $file_extension = ".jpg";
                        
                        do {
                            // Generate nama file baru dengan nomor yang bertambah
                            $new_file1_name = $name_no_tagihan . "_" . $no . $file_extension;
                            $compressed_file1_destination = $customer_folder_path . $new_file1_name;
                        
                            // Cek apakah file dengan nama tersebut sudah ada
                            if (!file_exists($compressed_file1_destination)) {
                                // Jika tidak ada, lakukan kompresi dan ubah ukuran gambar
                                compressAndResizeImage($file1_destination, $compressed_file1_destination, 500, 500, 100);
                                unlink($file1_destination); // Hapus file sumber yang tidak dikompresi
                                break; // Keluar dari loop karena nama file sudah unik
                            }
                        
                            $no++; // Jika nama file sudah ada, tambahkan nomor dan coba lagi
                        } while (true);
        
                        if($sisa_tagihan == 0 ){
                            $cek_data = mysqli_query($connect, "SELECT id_bank_cs, id_cs, id_bank, no_rekening, atas_nama FROM bank_cs WHERE id_cs = '$id_cs' AND id_bank = '$bank_pengirim' AND no_rekening = '$rek_pengirim' AND atas_nama = '$nama_pengirim'");

                            $sql_cs_bank = '';

                            if($cek_data->num_rows == 0){
                                $sql_cs_bank = mysqli_query($connect, "INSERT INTO bank_cs 
                                                            (id_bank_cs, id_cs, id_bank, no_rekening, atas_nama, created_by) 
                                                            VALUES 
                                                            ('$id_bank_cs', '$id_cs', '$bank_pengirim', '$rek_pengirim', '$nama_pengirim', '$created_by')");
                            } else {
                                $sql_cs_bank = '';
                            }

                            $sql_bayar = mysqli_query($connect, "INSERT INTO finance_bayar 
                                                            (id_bayar, id_bank_pt, id_tagihan, id_finance, id_bukti, metode_pembayaran, keterengan_bayar, total_bayar, tgl_bayar, created_by) 
                                                            VALUES 
                                                            ('$id_bayar', '$id_bank', '$id_bill', '$id_finance', '$id_bukti', '$metode_bayar', '$keterangan_bayar', '$nominal', '$tgl_bayar', '$user')");
                            $sql_bukti_tf = mysqli_query($connect, "INSERT INTO finance_bukti_tf
                                                                (id_bukti_tf, tf_bank, rek_pengirim, tf_an, bukti_tf, created_by) 
                                                                VALUES 
                                                                ('$id_bukti', '$bank_pengirim', '$rek_pengirim', '$nama_pengirim', '$new_file1_name', '$user')");
        
                            $sql_finance = mysqli_query($connect, "UPDATE finance SET status_pembayaran = 1, status_lunas = 1  WHERE id_finance = '$id_finance'");
        
        
                        if (!$sql_cs_bank && !$sql_bayar && !$sql_bukti_tf && !$sql_finance) {
                            throw new Exception("Error updating data");
                        }
                        // Commit the transaction
                        mysqli_commit($connect);
                        // Redirect to the invoice page
                        ?>
                        <!-- Sweet Alert -->
                        <link rel="stylesheet" href="../assets/sweet-alert/dist/sweetalert2.min.css">
                        <script src="../assets/sweet-alert/dist/sweetalert2.all.min.js"></script>
                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                Swal.fire(
                                    'Berhasil',
                                    'Data Berhasil Disimpan',
                                    'success'
                                    ).then(function() {
                                window.location.href = "../detail-bill.php?id=<?php echo $id_bill_encode ?>";
                                });
                            });
                        </script>
                        <?php
        
                        } else {
                            $cek_data = mysqli_query($connect, "SELECT id_bank_cs, id_cs, id_bank, no_rekening, atas_nama FROM bank_cs WHERE id_cs = '$id_cs' AND id_bank = '$bank_pengirim' AND no_rekening = '$rek_pengirim' AND atas_nama = '$nama_pengirim'");

                            $sql_cs_bank = '';

                            if($cek_data->num_rows == 0){
                                $sql_cs_bank = mysqli_query($connect, "INSERT INTO bank_cs 
                                                            (id_bank_cs, id_cs, id_bank, no_rekening, atas_nama, created_by) 
                                                            VALUES 
                                                            ('$id_bank_cs', '$id_cs', '$bank_pengirim', '$rek_pengirim', '$nama_pengirim', '$created_by')");
                            } else {
                                $sql_cs_bank = '';
                            }

                            $sql_bayar = mysqli_query($connect, "INSERT INTO finance_bayar 
                                                            (id_bayar, id_bank_pt, id_tagihan, id_finance, id_bukti, metode_pembayaran, keterangan_bayar, total_bayar, tgl_bayar, created_by) 
                                                            VALUES 
                                                            ('$id_bayar', '$id_bank', '$id_bill', '$id_finance', '$id_bukti', '$metode_bayar', '$keterangan_bayar', '$nominal', '$tgl_bayar', '$user')");
                            $sql_bukti_tf = mysqli_query($connect, "INSERT INTO finance_bukti_tf
                                                                (id_bukti_tf, tf_bank, rek_pengirim, tf_an, bukti_tf, created_by) 
                                                                VALUES 
                                                                ('$id_bukti', '$bank_pengirim', '$rek_pengirim', '$nama_pengirim', '$new_file1_name', '$user')");
        
                            $sql_finance = mysqli_query($connect, "UPDATE finance SET status_pembayaran = 1, status_lunas = 0 WHERE id_finance = '$id_finance'");
        
        
                        if (!$sql_cs_bank &&!$sql_bayar && !$sql_bukti_tf && !$sql_finance) {
                            throw new Exception("Error updating data");
                        }
                            // Commit the transaction
                            mysqli_commit($connect);
                            // Redirect to the invoice page
                            ?>
                            <!-- Sweet Alert -->
                            <link rel="stylesheet" href="../assets/sweet-alert/dist/sweetalert2.min.css">
                            <script src="../assets/sweet-alert/dist/sweetalert2.all.min.js"></script>
                            <script>
                                document.addEventListener("DOMContentLoaded", function() {
                                    Swal.fire(
                                        'Berhasil',
                                        'Data Berhasil Disimpan',
                                        'success'
                                        ).then(function() {
                                    window.location.href = "../detail-bill.php?id=<?php echo $id_bill_encode ?>";
                                    });
                                });
                            </script>
                            <?php 
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
                                    window.location.href = "../detail-bill.php?id=<?php echo $id_bill_encode ?>";
                                });
                                });
                            </script>
                            <?php
                        } 
                    
                }
                
            }
        
        }else if($jenis_inv == 'ppn'){
            $sql_inv = mysqli_query($connect, " SELECT  ppn.id_inv_ppn, 
                                                        ppn.no_inv, 
                                                        DAY(STR_TO_DATE(ppn.tgl_inv, '%d/%m/%Y')) AS day_inv, 
                                                        LPAD(MONTH(STR_TO_DATE(tgl_inv, '%d/%m/%Y')), 2, '0') AS month_inv,
                                                        YEAR(STR_TO_DATE(ppn.tgl_inv, '%d/%m/%Y')) AS year_inv,
        
                                                        fnc.id_inv,
                                                        fnc.id_tagihan,
        
                                                        bill.id_tagihan,
                                                        bill.no_tagihan,
        
                                                        cs.id_cs,
                                                        cs.nama_cs,
        
                                                        spk.id_inv,
                                                        spk.id_customer
                                                FROM inv_ppn AS ppn
                                                LEFT JOIN finance fnc ON (ppn.id_inv_ppn = fnc.id_inv)
                                                LEFT JOIN finance_tagihan bill ON (fnc.id_tagihan = bill.id_tagihan)
                                                LEFT JOIN spk_reg spk ON (ppn.id_inv_ppn = spk.id_inv)
                                                LEFT JOIN tb_customer cs ON (spk.id_customer = cs.id_cs)
                                                WHERE ppn.id_inv_ppn = '$id_inv'");
            $data_inv = mysqli_fetch_array($sql_inv);
        
            $no_inv_ppn = $data_inv['no_inv'];
            $no_tagihan = $data_inv['no_tagihan'];
            $day_inv = $data_inv['day_inv'];
            $month_inv =  $data_inv['month_inv'];
            $year_inv =  $data_inv['year_inv'];
            $cs = $data_inv['nama_cs'];
        
        
            $nama_invoice = 'Invoice_Ppn';
        
            // Convert $no_inv_ppn to the desired format
            $no_inv_ppn_converted = str_replace('/', '_', $no_inv_ppn);
        
            // Generate folder name based on invoice details
            $folder_name = $no_inv_ppn_converted;
        
            // Encode a portion of the folder name
            $encoded_portion = base64_encode($folder_name);
        
            // Combine the original $no_inv_ppn, encoded portion, and underscore
            $encoded_folder_name = $no_inv_ppn_converted . '_' . $encoded_portion;
        
            // untuk Membuat Folder Bukti Pembayaran
            $bukti_pembayaran = "Bukti_Transfer";
        
            // Set the path for the customer's folder
            $customer_folder_path = "../../Customer/" . $cs . "/" . $year_inv . "/" . $month_inv . "/" . $day_inv . "/" . ucwords(strtolower(str_replace('_', ' ', $nama_invoice))) . "/" . $encoded_folder_name ."/". $bukti_pembayaran ."/";
        
            // Create the customer's folder if it doesn't exist
            if (!is_dir($customer_folder_path)) {
                mkdir($customer_folder_path, 0777, true); // Set permission to 0777 to ensure the folder is writable
                
                // Mendapatkan informasi file bukti transfer
                $file1_name = $_FILES['fileku1']['name'];
                $file1_tmp = $_FILES['fileku1']['tmp_name'];
                $file1_destination =  $customer_folder_path . $file1_name;
        
                // Pindahkan file bukti transfer ke lokasi tujuan
                move_uploaded_file($file1_tmp, $file1_destination);
               
                if($file1_name != ''){
                    // Begin transaction
                    mysqli_begin_transaction($connect);
        
                    try{
                        $id_bank = $_POST['id_bank'];
                        $nama_pengirim = $_POST['nama_pengirim'];
                        $rek_pengirim = $_POST['rek_pengirim'];
                        $bank_pengirim = $_POST['bank_pengirim'];
                        $no_tagihan_converted = str_replace('/', '_', $no_tagihan);
                        $name_no_tagihan = $no_tagihan_converted;
                        
                        $no = 1;
                        $file_extension = ".jpg";
                        
                        do {
                            // Generate nama file baru dengan nomor yang bertambah
                            $new_file1_name = $name_no_tagihan . "_" . $no . $file_extension;
                            $compressed_file1_destination = $customer_folder_path . $new_file1_name;
                        
                            // Cek apakah file dengan nama tersebut sudah ada
                            if (!file_exists($compressed_file1_destination)) {
                                // Jika tidak ada, lakukan kompresi dan ubah ukuran gambar
                                compressAndResizeImage($file1_destination, $compressed_file1_destination, 500, 500, 100);
                                unlink($file1_destination); // Hapus file sumber yang tidak dikompresi
                                break; // Keluar dari loop karena nama file sudah unik
                            }
                        
                            $no++; // Jika nama file sudah ada, tambahkan nomor dan coba lagi
                        } while (true);
        
                        if($sisa_tagihan == 0){
                            $cek_data = mysqli_query($connect, "SELECT id_bank_cs, id_cs, id_bank, no_rekening, atas_nama FROM bank_cs WHERE id_cs = '$id_cs' AND id_bank = '$bank_pengirim' AND no_rekening = '$rek_pengirim' AND atas_nama = '$nama_pengirim'");

                            $sql_cs_bank = '';

                            if($cek_data->num_rows == 0){
                                $sql_cs_bank = mysqli_query($connect, "INSERT INTO bank_cs 
                                                            (id_bank_cs, id_cs, id_bank, no_rekening, atas_nama, created_by) 
                                                            VALUES 
                                                            ('$id_bank_cs', '$id_cs', '$bank_pengirim', '$rek_pengirim', '$nama_pengirim', '$created_by')");
                            } else {
                                $sql_cs_bank = '';
                            }

                            $sql_bayar = mysqli_query($connect, "INSERT INTO finance_bayar 
                                                            (id_bayar, id_bank_pt, id_tagihan, id_finance, id_bukti, metode_pembayaran, keterangan_bayar, total_bayar, tgl_bayar, created_by) 
                                                            VALUES 
                                                            ('$id_bayar', '$id_bank', '$id_bill', '$id_finance', '$id_bukti', '$metode_bayar', '$keterangan_bayar', '$nominal', '$tgl_bayar', '$user')");
                            $sql_bukti_tf = mysqli_query($connect, "INSERT INTO finance_bukti_tf
                                                                (id_bukti_tf, tf_bank, rek_pengirim, tf_an, bukti_tf, created_by) 
                                                                VALUES 
                                                                ('$id_bukti', '$bank_pengirim', '$rek_pengirim', '$nama_pengirim', '$new_file1_name', '$user')");
        
                            $sql_finance = mysqli_query($connect, "UPDATE finance SET status_pembayaran = 1, status_lunas = 1  WHERE id_finance = '$id_finance'");
        
        
                            if (!$sql_cs_bank && !$sql_bayar && !$sql_bukti_tf && !$sql_finance) {
                                throw new Exception("Error updating data");
                            }
        
                            // Commit the transaction
                            mysqli_commit($connect);
                            // Redirect to the invoice page
                            ?>
                            <!-- Sweet Alert -->
                            <link rel="stylesheet" href="../assets/sweet-alert/dist/sweetalert2.min.css">
                            <script src="../assets/sweet-alert/dist/sweetalert2.all.min.js"></script>
                            <script>
                                document.addEventListener("DOMContentLoaded", function() {
                                    Swal.fire(
                                        'Berhasil',
                                        'Data Berhasil Disimpan',
                                        'success'
                                        ).then(function() {
                                    window.location.href = "../detail-bill.php?id=<?php echo $id_bill_encode ?>";
                                    });
                                });
                            </script>
                            <?php
                            exit(); 
        
                        } else {
                            $cek_data = mysqli_query($connect, "SELECT id_bank_cs, id_cs, id_bank, no_rekening, atas_nama FROM bank_cs WHERE id_cs = '$id_cs' AND id_bank = '$bank_pengirim' AND no_rekening = '$rek_pengirim' AND atas_nama = '$nama_pengirim'");

                            $sql_cs_bank = '';

                            if($cek_data->num_rows == 0){
                                $sql_cs_bank = mysqli_query($connect, "INSERT INTO bank_cs 
                                                            (id_bank_cs, id_cs, id_bank, no_rekening, atas_nama, created_by) 
                                                            VALUES 
                                                            ('$id_bank_cs', '$id_cs', '$bank_pengirim', '$rek_pengirim', '$nama_pengirim', '$created_by')");
                            } else {
                                $sql_cs_bank = '';
                            }

                            $sql_bayar = mysqli_query($connect, "INSERT INTO finance_bayar 
                                                            (id_bayar, id_bank_pt, id_tagihan, id_finance, id_bukti, metode_pembayaran, keterangan_bayar, total_bayar, tgl_bayar, created_by) 
                                                            VALUES 
                                                            ('$id_bayar', '$id_bank', '$id_bill', '$id_finance', '$id_bukti', '$metode_bayar', '$keterangan_bayar', '$nominal', '$tgl_bayar', '$user')");
                            $sql_bukti_tf = mysqli_query($connect, "INSERT INTO finance_bukti_tf
                                                                (id_bukti_tf, tf_bank, rek_pengirim, tf_an, bukti_tf, created_by) 
                                                                VALUES 
                                                                ('$id_bukti', '$bank_pengirim', '$rek_pengirim', '$nama_pengirim', '$new_file1_name', '$user')");
        
                            $sql_finance = mysqli_query($connect, "UPDATE finance SET status_pembayaran = 1, status_lunas = 0 WHERE id_finance = '$id_finance'");
        
        
                        if (!$sql_cs_bank && !$sql_bayar && !$sql_bukti_tf && !$sql_finance) {
                            throw new Exception("Error updating data");
                        }
                            // Commit the transaction
                            mysqli_commit($connect);
                            // Redirect to the invoice page
                            ?>
                            <!-- Sweet Alert -->
                            <link rel="stylesheet" href="../assets/sweet-alert/dist/sweetalert2.min.css">
                            <script src="../assets/sweet-alert/dist/sweetalert2.all.min.js"></script>
                            <script>
                                document.addEventListener("DOMContentLoaded", function() {
                                    Swal.fire(
                                        'Berhasil',
                                        'Data Berhasil Disimpan',
                                        'success'
                                        ).then(function() {
                                    window.location.href = "../detail-bill.php?id=<?php echo $id_bill_encode ?>";
                                    });
                                });
                            </script>
                            <?php
                            exit(); 
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
                                    window.location.href = "../detail-bill.php?id=<?php echo $id_bill_encode ?>";
                                });
                                });
                            </script>
                            <?php
                        } 
                    
                }
            }else{
                // Mendapatkan informasi file bukti transfer
                $file1_name = $_FILES['fileku1']['name'];
                $file1_tmp = $_FILES['fileku1']['tmp_name'];
                $file1_destination =  $customer_folder_path . $file1_name;
        
                // Pindahkan file bukti transfer ke lokasi tujuan
                move_uploaded_file($file1_tmp, $file1_destination);
        
               
                if($file1_name != ''){
                    // Begin transaction
                    mysqli_begin_transaction($connect);
        
                    try{
                        $no_tagihan_converted = str_replace('/', '_', $no_tagihan);
                        $name_no_tagihan = $no_tagihan_converted;
                        
                        $no = 1;
                        $file_extension = ".jpg";
                        
                        do {
                            // Generate nama file baru dengan nomor yang bertambah
                            $new_file1_name = $name_no_tagihan . "_" . $no . $file_extension;
                            $compressed_file1_destination = $customer_folder_path . $new_file1_name;
                        
                            // Cek apakah file dengan nama tersebut sudah ada
                            if (!file_exists($compressed_file1_destination)) {
                                // Jika tidak ada, lakukan kompresi dan ubah ukuran gambar
                                compressAndResizeImage($file1_destination, $compressed_file1_destination, 500, 500, 100);
                                unlink($file1_destination); // Hapus file sumber yang tidak dikompresi
                                break; // Keluar dari loop karena nama file sudah unik
                            }
                        
                            $no++; // Jika nama file sudah ada, tambahkan nomor dan coba lagi
                        } while (true);
        
                        if($sisa_tagihan == 0 ){
                            $cek_data = mysqli_query($connect, "SELECT id_bank_cs, id_cs, id_bank, no_rekening, atas_nama FROM bank_cs WHERE id_cs = '$id_cs' AND id_bank = '$bank_pengirim' AND no_rekening = '$rek_pengirim' AND atas_nama = '$nama_pengirim'");

                            $sql_cs_bank = '';

                            if($cek_data->num_rows == 0){
                                $sql_cs_bank = mysqli_query($connect, "INSERT INTO bank_cs 
                                                            (id_bank_cs, id_cs, id_bank, no_rekening, atas_nama, created_by) 
                                                            VALUES 
                                                            ('$id_bank_cs', '$id_cs', '$bank_pengirim', '$rek_pengirim', '$nama_pengirim', '$created_by')");
                            } else {
                                $sql_cs_bank = '';
                            }

                            $sql_bayar = mysqli_query($connect, "INSERT INTO finance_bayar 
                                                            (id_bayar, id_bank_pt, id_tagihan, id_finance, id_bukti, metode_pembayaran, keterangan_bayar, total_bayar, tgl_bayar, created_by) 
                                                            VALUES 
                                                            ('$id_bayar', '$id_bank', '$id_bill', '$id_finance', '$id_bukti', '$metode_bayar', '$keterangan_bayar', '$nominal', '$tgl_bayar', '$user')");
                            $sql_bukti_tf = mysqli_query($connect, "INSERT INTO finance_bukti_tf
                                                                (id_bukti_tf, tf_bank, rek_pengirim, tf_an, bukti_tf, created_by) 
                                                                VALUES 
                                                                ('$id_bukti', '$bank_pengirim', '$rek_pengirim', '$nama_pengirim', '$new_file1_name', '$user')");
        
                            $sql_finance = mysqli_query($connect, "UPDATE finance SET status_pembayaran = 1, status_lunas = 1  WHERE id_finance = '$id_finance'");
        
        
                        if (!$sql_cs_bank && !$sql_bayar && !$sql_bukti_tf && !$sql_finance) {
                            throw new Exception("Error updating data");
                        }
                        // Commit the transaction
                        mysqli_commit($connect);
                        // Redirect to the invoice page
                        header("Location:../detail-bill.php?id=$id_bill_encode");
                        exit();
        
                        } else {
                            $cek_data = mysqli_query($connect, "SELECT id_bank_cs, id_cs, id_bank, no_rekening, atas_nama FROM bank_cs WHERE id_cs = '$id_cs' AND id_bank = '$bank_pengirim' AND no_rekening = '$rek_pengirim' AND atas_nama = '$nama_pengirim'");

                            $sql_cs_bank = '';

                            if($cek_data->num_rows == 0){
                                $sql_cs_bank = mysqli_query($connect, "INSERT INTO bank_cs 
                                                            (id_bank_cs, id_cs, id_bank, no_rekening, atas_nama, created_by) 
                                                            VALUES 
                                                            ('$id_bank_cs', '$id_cs', '$bank_pengirim', '$rek_pengirim', '$nama_pengirim', '$created_by')");
                            } else {
                                $sql_cs_bank = '';
                            }

                            $sql_bayar = mysqli_query($connect, "INSERT INTO finance_bayar 
                                                                (id_bayar, id_bank_pt, id_tagihan, id_finance, id_bukti, metode_pembayaran, keterangan_bayar, total_bayar, tgl_bayar, created_by) 
                                                                VALUES 
                                                                ('$id_bayar', '$id_bank', '$id_bill', '$id_finance', '$id_bukti', '$metode_bayar', '$keterangan_bayar', '$nominal', '$tgl_bayar', '$user')");
                            $sql_bukti_tf = mysqli_query($connect, "INSERT INTO finance_bukti_tf
                                                                (id_bukti_tf, tf_bank, rek_pengirim, tf_an, bukti_tf, created_by) 
                                                                VALUES 
                                                                ('$id_bukti', '$bank_pengirim', '$rek_pengirim', '$nama_pengirim', '$new_file1_name', '$user')");
        
                            $sql_finance = mysqli_query($connect, "UPDATE finance SET status_pembayaran = 1, status_lunas = 0 WHERE id_finance = '$id_finance'");
        
        
                        if (!$sql_cs_bank && !$sql_bayar && !$sql_bukti_tf && !$sql_finance) {
                            throw new Exception("Error updating data");
                        }
                            // Commit the transaction
                            mysqli_commit($connect);
                            // Redirect to the invoice page
                            ?>
                            <!-- Sweet Alert -->
                            <link rel="stylesheet" href="../assets/sweet-alert/dist/sweetalert2.min.css">
                            <script src="../assets/sweet-alert/dist/sweetalert2.all.min.js"></script>
                            <script>
                                document.addEventListener("DOMContentLoaded", function() {
                                    Swal.fire(
                                        'Berhasil',
                                        'Data Berhasil Disimpan',
                                        'success'
                                        ).then(function() {
                                    window.location.href = "../detail-bill.php?id=<?php echo $id_bill_encode ?>";
                                    });
                                });
                            </script>
                            <?php
                            exit(); 
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
                                    window.location.href = "../detail-bill.php?id=<?php echo $id_bill_encode ?>";
                                });
                                });
                            </script>
                            <?php
                        } 
                    
                }
                
            }
        
    
        }else if($jenis_inv == 'bum'){
            $sql_inv = mysqli_query($connect, " SELECT  bum.id_inv_bum, 
                                                        bum.no_inv, 
                                                        DAY(STR_TO_DATE(bum.tgl_inv, '%d/%m/%Y')) AS day_inv, 
                                                        LPAD(MONTH(STR_TO_DATE(tgl_inv, '%d/%m/%Y')), 2, '0') AS month_inv,
                                                        YEAR(STR_TO_DATE(bum.tgl_inv, '%d/%m/%Y')) AS year_inv,
    
                                                        fnc.id_inv,
                                                        fnc.id_tagihan,
    
                                                        bill.id_tagihan,
                                                        bill.no_tagihan,
    
                                                        cs.id_cs,
                                                        cs.nama_cs,
    
                                                        spk.id_inv,
                                                        spk.id_customer
                                                FROM inv_bum AS bum
                                                LEFT JOIN finance fnc ON (bum.id_inv_bum = fnc.id_inv)
                                                LEFT JOIN finance_tagihan bill ON (fnc.id_tagihan = bill.id_tagihan)
                                                LEFT JOIN spk_reg spk ON (bum.id_inv_bum = spk.id_inv)
                                                LEFT JOIN tb_customer cs ON (spk.id_customer = cs.id_cs)
                                                WHERE bum.id_inv_bum = '$id_inv'");
            $data_inv = mysqli_fetch_array($sql_inv);
    
            $no_inv_bum = $data_inv['no_inv'];
            $no_tagihan = $data_inv['no_tagihan'];
            $day_inv = $data_inv['day_inv'];
            $month_inv =  $data_inv['month_inv'];
            $year_inv =  $data_inv['year_inv'];
            $cs = $data_inv['nama_cs'];
    
            $nama_invoice = 'Invoice_Bum';
    
            // Convert $no_inv_bum to the desired format
            $no_inv_bum_converted = str_replace('/', '_', $no_inv_bum);
    
            // Generate folder name based on invoice details
            $folder_name = $no_inv_bum_converted;
    
            // Encode a portion of the folder name
            $encoded_portion = base64_encode($folder_name);
    
            // Combine the original $no_inv_bum, encoded portion, and underscore
            $encoded_folder_name = $no_inv_bum_converted . '_' . $encoded_portion;
    
            // untuk Membuat Folder Bukti Pembayaran
            $bukti_pembayaran = "Bukti_Transfer";
    
            // Set the path for the customer's folder
            $customer_folder_path = "../../Customer/" . $cs . "/" . $year_inv . "/" . $month_inv . "/" . $day_inv . "/" . ucwords(strtolower(str_replace('_', ' ', $nama_invoice))) . "/" . $encoded_folder_name ."/". $bukti_pembayaran ."/";
    
            // Create the customer's folder if it doesn't exist
            if (!is_dir($customer_folder_path)) {
                mkdir($customer_folder_path, 0777, true); // Set permission to 0777 to ensure the folder is writable
                
                // Mendapatkan informasi file bukti transfer
                $file1_name = $_FILES['fileku1']['name'];
                $file1_tmp = $_FILES['fileku1']['tmp_name'];
                $file1_destination =  $customer_folder_path . $file1_name;
    
                // Pindahkan file bukti transfer ke lokasi tujuan
                move_uploaded_file($file1_tmp, $file1_destination);
               
                if($file1_name != ''){
                    // Begin transaction
                    mysqli_begin_transaction($connect);
    
                    try{
                        $id_bank = $_POST['id_bank'];
                        $nama_pengirim = $_POST['nama_pengirim'];
                        $rek_pengirim = $_POST['rek_pengirim'];
                        $bank_pengirim = $_POST['bank_pengirim'];
                        $no_tagihan_converted = str_replace('/', '_', $no_tagihan);
                        $name_no_tagihan = $no_tagihan_converted;
                        
                        $no = 1;
                        $file_extension = ".jpg";
                        
                        do {
                            // Generate nama file baru dengan nomor yang bertambah
                            $new_file1_name = $name_no_tagihan . "_" . $no . $file_extension;
                            $compressed_file1_destination = $customer_folder_path . $new_file1_name;
                        
                            // Cek apakah file dengan nama tersebut sudah ada
                            if (!file_exists($compressed_file1_destination)) {
                                // Jika tidak ada, lakukan kompresi dan ubah ukuran gambar
                                compressAndResizeImage($file1_destination, $compressed_file1_destination, 500, 500, 100);
                                unlink($file1_destination); // Hapus file sumber yang tidak dikompresi
                                break; // Keluar dari loop karena nama file sudah unik
                            }
                        
                            $no++; // Jika nama file sudah ada, tambahkan nomor dan coba lagi
                        } while (true);
    
                        if($sisa_tagihan == 0 ){
                            $cek_data = mysqli_query($connect, "SELECT id_bank_cs, id_cs, id_bank, no_rekening, atas_nama FROM bank_cs WHERE id_cs = '$id_cs' AND id_bank = '$bank_pengirim' AND no_rekening = '$rek_pengirim' AND atas_nama = '$nama_pengirim'");

                            $sql_cs_bank = '';

                            if($cek_data->num_rows == 0){
                                $sql_cs_bank = mysqli_query($connect, "INSERT INTO bank_cs 
                                                            (id_bank_cs, id_cs, id_bank, no_rekening, atas_nama, created_by) 
                                                            VALUES 
                                                            ('$id_bank_cs', '$id_cs', '$bank_pengirim', '$rek_pengirim', '$nama_pengirim', '$created_by')");
                            } else {
                                $sql_cs_bank = '';
                            }

                            $sql_bayar = mysqli_query($connect, "INSERT INTO finance_bayar 
                                                            (id_bayar, id_bank_pt, id_tagihan, id_finance, id_bukti, metode_pembayaran, keterangan_bayar, total_bayar, tgl_bayar, created_by) 
                                                            VALUES 
                                                            ('$id_bayar', '$id_bank', '$id_bill', '$id_finance', '$id_bukti', '$metode_bayar', '$keterangan_bayar', '$nominal', '$tgl_bayar', '$user')");
                            $sql_bukti_tf = mysqli_query($connect, "INSERT INTO finance_bukti_tf
                                                                (id_bukti_tf, tf_bank, rek_pengirim, tf_an, bukti_tf, created_by) 
                                                                VALUES 
                                                                ('$id_bukti', '$bank_pengirim', '$rek_pengirim', '$nama_pengirim', '$new_file1_name', '$user')");
    
                            $sql_finance = mysqli_query($connect, "UPDATE finance SET status_pembayaran = 1, status_lunas = 1  WHERE id_finance = '$id_finance'");
    
    
                            if (!$sql_cs_bank &&!$sql_bayar && !$sql_bukti_tf && !$sql_finance) {
                                throw new Exception("Error updating data");
                            }
    
                            // Commit the transaction
                            mysqli_commit($connect);
                            // Redirect to the invoice page
                            ?>
                            <!-- Sweet Alert -->
                            <link rel="stylesheet" href="../assets/sweet-alert/dist/sweetalert2.min.css">
                            <script src="../assets/sweet-alert/dist/sweetalert2.all.min.js"></script>
                            <script>
                                document.addEventListener("DOMContentLoaded", function() {
                                    Swal.fire(
                                        'Berhasil',
                                        'Data Berhasil Disimpan',
                                        'success'
                                        ).then(function() {
                                    window.location.href = "../detail-bill.php?id=<?php echo $id_bill_encode ?>";
                                    });
                                });
                            </script>
                            <?php
                            exit(); 
    
                        } else {
                            $cek_data = mysqli_query($connect, "SELECT id_bank_cs, id_cs, id_bank, no_rekening, atas_nama FROM bank_cs WHERE id_cs = '$id_cs' AND id_bank = '$bank_pengirim' AND no_rekening = '$rek_pengirim' AND atas_nama = '$nama_pengirim'");

                            $sql_cs_bank = '';

                            if($cek_data->num_rows == 0){
                                $sql_cs_bank = mysqli_query($connect, "INSERT INTO bank_cs 
                                                            (id_bank_cs, id_cs, id_bank, no_rekening, atas_nama, created_by) 
                                                            VALUES 
                                                            ('$id_bank_cs', '$id_cs', '$bank_pengirim', '$rek_pengirim', '$nama_pengirim', '$created_by')");
                            } else {
                                $sql_cs_bank = '';
                            }

                            $sql_bayar = mysqli_query($connect, "INSERT INTO finance_bayar 
                                                                (id_bayar, id_bank_pt, id_tagihan, id_finance, id_bukti, metode_pembayaran, keterangan_bayar, total_bayar, tgl_bayar, created_by) 
                                                                VALUES 
                                                                ('$id_bayar', '$id_bank', '$id_bill', '$id_finance', '$id_bukti', '$metode_bayar', '$keterangan_bayar', '$nominal', '$tgl_bayar', '$user')");
                            $sql_bukti_tf = mysqli_query($connect, "INSERT INTO finance_bukti_tf
                                                                (id_bukti_tf, tf_bank, rek_pengirim, tf_an, bukti_tf, created_by) 
                                                                VALUES 
                                                                ('$id_bukti', '$bank_pengirim', '$rek_pengirim', '$nama_pengirim', '$new_file1_name', '$user')");
    
                            $sql_finance = mysqli_query($connect, "UPDATE finance SET status_pembayaran = 1, status_lunas = 0 WHERE id_finance = '$id_finance'");
    
    
                        if (!$sql_cs_bank && !$sql_bayar && !$sql_bukti_tf && !$sql_finance) {
                            throw new Exception("Error updating data");
                        }
                            // Commit the transaction
                            mysqli_commit($connect);
                            // Redirect to the invoice page
                            ?>
                            <!-- Sweet Alert -->
                            <link rel="stylesheet" href="../assets/sweet-alert/dist/sweetalert2.min.css">
                            <script src="../assets/sweet-alert/dist/sweetalert2.all.min.js"></script>
                            <script>
                                document.addEventListener("DOMContentLoaded", function() {
                                    Swal.fire(
                                        'Berhasil',
                                        'Data Berhasil Disimpan',
                                        'success'
                                        ).then(function() {
                                    window.location.href = "../detail-bill.php?id=<?php echo $id_bill_encode ?>";
                                    });
                                });
                            </script>
                            <?php
                            exit(); 
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
                                    window.location.href = "../detail-bill.php?id=<?php echo $id_bill_encode ?>";
                                });
                                });
                            </script>
                            <?php
                        } 
                    
                }
            }else{
                // Mendapatkan informasi file bukti transfer
                $file1_name = $_FILES['fileku1']['name'];
                $file1_tmp = $_FILES['fileku1']['tmp_name'];
                $file1_destination =  $customer_folder_path . $file1_name;
    
                // Pindahkan file bukti transfer ke lokasi tujuan
                move_uploaded_file($file1_tmp, $file1_destination);
    
               
                if($file1_name != ''){
                    // Begin transaction
                    mysqli_begin_transaction($connect);
    
                    try{
                        $no_tagihan_converted = str_replace('/', '_', $no_tagihan);
                        $name_no_tagihan = $no_tagihan_converted;
                        
                        $no = 1;
                        $file_extension = ".jpg";
                        
                        do {
                            // Generate nama file baru dengan nomor yang bertambah
                            $new_file1_name = $name_no_tagihan . "_" . $no . $file_extension;
                            $compressed_file1_destination = $customer_folder_path . $new_file1_name;
                        
                            // Cek apakah file dengan nama tersebut sudah ada
                            if (!file_exists($compressed_file1_destination)) {
                                // Jika tidak ada, lakukan kompresi dan ubah ukuran gambar
                                compressAndResizeImage($file1_destination, $compressed_file1_destination, 500, 500, 100);
                                unlink($file1_destination); // Hapus file sumber yang tidak dikompresi
                                break; // Keluar dari loop karena nama file sudah unik
                            }
                        
                            $no++; // Jika nama file sudah ada, tambahkan nomor dan coba lagi
                        } while (true);
    
                        if($sisa_tagihan == 0 ){
                            $cek_data = mysqli_query($connect, "SELECT id_bank_cs, id_cs, id_bank, no_rekening, atas_nama FROM bank_cs WHERE id_cs = '$id_cs' AND id_bank = '$bank_pengirim' AND no_rekening = '$rek_pengirim' AND atas_nama = '$nama_pengirim'");

                            $sql_cs_bank = '';

                            if($cek_data->num_rows == 0){
                                $sql_cs_bank = mysqli_query($connect, "INSERT INTO bank_cs 
                                                            (id_bank_cs, id_cs, id_bank, no_rekening, atas_nama, created_by) 
                                                            VALUES 
                                                            ('$id_bank_cs', '$id_cs', '$bank_pengirim', '$rek_pengirim', '$nama_pengirim', '$created_by')");
                            } else {
                                $sql_cs_bank = '';
                            }

                            $sql_bayar = mysqli_query($connect, "INSERT INTO finance_bayar 
                                                            (id_bayar, id_bank_pt, id_tagihan, id_finance, id_bukti, metode_pembayaran, keterangan_bayar, total_bayar, tgl_bayar, created_by) 
                                                            VALUES 
                                                            ('$id_bayar', '$id_bank', '$id_bill', '$id_finance', '$id_bukti', '$metode_bayar', '$keterangan_bayar', '$nominal', '$tgl_bayar', '$user')");
                            $sql_bukti_tf = mysqli_query($connect, "INSERT INTO finance_bukti_tf
                                                                (id_bukti_tf, tf_bank, rek_pengirim, tf_an, bukti_tf, created_by) 
                                                                VALUES 
                                                                ('$id_bukti', '$bank_pengirim', '$rek_pengirim', '$nama_pengirim', '$new_file1_name', '$user')");
    
                            $sql_finance = mysqli_query($connect, "UPDATE finance SET status_pembayaran = 1, status_lunas = 1  WHERE id_finance = '$id_finance'");
    
    
                        if (!$sql_cs_bank && !$sql_bayar && !$sql_bukti_tf && !$sql_finance) {
                            throw new Exception("Error updating data");
                        }
                        // Commit the transaction
                        mysqli_commit($connect);
                        // Redirect to the invoice page
                        ?>
                        <!-- Sweet Alert -->
                        <link rel="stylesheet" href="../assets/sweet-alert/dist/sweetalert2.min.css">
                        <script src="../assets/sweet-alert/dist/sweetalert2.all.min.js"></script>
                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                Swal.fire(
                                    'Berhasil',
                                    'Data Berhasil Disimpan',
                                    'success'
                                    ).then(function() {
                                window.location.href = "../detail-bill.php?id=<?php echo $id_bill_encode ?>";
                                });
                            });
                        </script>
                        <?php
                        exit(); 
    
                        } else {
                            $cek_data = mysqli_query($connect, "SELECT id_bank_cs, id_cs, id_bank, no_rekening, atas_nama FROM bank_cs WHERE id_cs = '$id_cs' AND id_bank = '$bank_pengirim' AND no_rekening = '$rek_pengirim' AND atas_nama = '$nama_pengirim'");

                            $sql_cs_bank = '';

                            if($cek_data->num_rows == 0){
                                $sql_cs_bank = mysqli_query($connect, "INSERT INTO bank_cs 
                                                            (id_bank_cs, id_cs, id_bank, no_rekening, atas_nama, created_by) 
                                                            VALUES 
                                                            ('$id_bank_cs', '$id_cs', '$bank_pengirim', '$rek_pengirim', '$nama_pengirim', '$created_by')");
                            } else {
                                $sql_cs_bank = '';
                            }

                            $sql_bayar = mysqli_query($connect, "INSERT INTO finance_bayar 
                                                            (id_bayar, id_bank_pt, id_tagihan, id_finance, id_bukti, metode_pembayaran, keterangan_bayar, total_bayar, tgl_bayar, created_by) 
                                                            VALUES 
                                                            ('$id_bayar', '$id_bank', '$id_bill', '$id_finance', '$id_bukti', '$metode_bayar', '$keterangan_bayar', '$nominal', '$tgl_bayar', '$user')");
                            $sql_bukti_tf = mysqli_query($connect, "INSERT INTO finance_bukti_tf
                                                                (id_bukti_tf, tf_bank, rek_pengirim, tf_an, bukti_tf, created_by) 
                                                                VALUES 
                                                                ('$id_bukti', '$bank_pengirim', '$rek_pengirim', '$nama_pengirim', '$new_file1_name', '$user')");
    
                            $sql_finance = mysqli_query($connect, "UPDATE finance SET status_pembayaran = 1, status_lunas = 0 WHERE id_finance = '$id_finance'");
    
    
                        if (!$sql_cs_bank && !$sql_bayar && !$sql_bukti_tf && !$sql_finance) {
                            throw new Exception("Error updating data");
                        }
                            // Commit the transaction
                            mysqli_commit($connect);
                            // Redirect to the invoice page
                            ?>
                            <!-- Sweet Alert -->
                            <link rel="stylesheet" href="../assets/sweet-alert/dist/sweetalert2.min.css">
                            <script src="../assets/sweet-alert/dist/sweetalert2.all.min.js"></script>
                            <script>
                                document.addEventListener("DOMContentLoaded", function() {
                                    Swal.fire(
                                        'Berhasil',
                                        'Data Berhasil Disimpan',
                                        'success'
                                        ).then(function() {
                                    window.location.href = "../detail-bill.php?id=<?php echo $id_bill_encode ?>";
                                    });
                                });
                            </script>
                            <?php
                            exit(); 
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
                                    window.location.href = "../detail-bill.php?id=<?php echo $id_bill_encode ?>";
                                });
                                });
                            </script>
                            <?php
                        } 
                    
                }
                
            }
        }
    } else {
        // Begin transaction
        mysqli_begin_transaction($connect);
    
        try{
            if($sisa_tagihan == 0 ){
                $sql_bayar = mysqli_query($connect, "INSERT INTO finance_bayar 
                                                (id_bayar, id_tagihan, id_finance, metode_pembayaran, keterangan_bayar, total_bayar, tgl_bayar, created_by) 
                                                 VALUES 
                                                 ('$id_bayar', '$id_bill', '$id_finance', '$metode_bayar', '$keterangan_bayar', '$nominal', '$tgl_bayar', '$user')");

                $sql_finance = mysqli_query($connect, "UPDATE finance SET status_pembayaran = 1, status_lunas = 1  WHERE id_finance = '$id_finance'");


                if (!$sql_bayar && !$sql_finance) {
                    throw new Exception("Error updating data");
                }

                // Commit the transaction
                mysqli_commit($connect);
                ?>
                <!-- Sweet Alert -->
                <link rel="stylesheet" href="../assets/sweet-alert/dist/sweetalert2.min.css">
                <script src="../assets/sweet-alert/dist/sweetalert2.all.min.js"></script>
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        Swal.fire(
                            'Berhasil',
                            'Data Berhasil Disimpan',
                            'success'
                            ).then(function() {
                        window.location.href = "../detail-bill.php?id=<?php echo $id_bill_encode ?>";
                        });
                    });
                </script>
                <?php
                exit();

            } else {
                $sql_bayar = mysqli_query($connect, "INSERT INTO finance_bayar 
                                                (id_bayar, id_tagihan, id_finance, metode_pembayaran, keterangan_bayar, total_bayar, tgl_bayar, created_by) 
                                                 VALUES 
                                                 ('$id_bayar', '$id_bill', '$id_finance', '$metode_bayar', '$keterangan_bayar', '$nominal', '$tgl_bayar', '$user')");

                $sql_finance = mysqli_query($connect, "UPDATE finance SET status_pembayaran = 1, status_lunas = 0 WHERE id_finance = '$id_finance'");


            if (!$sql_bayar && !$sql_bukti_tf && !$sql_finance) {
                throw new Exception("Error updating data");
            }
                // Commit the transaction
                mysqli_commit($connect);
                // Redirect to the invoice page
                ?>
                <!-- Sweet Alert -->
                <link rel="stylesheet" href="../assets/sweet-alert/dist/sweetalert2.min.css">
                <script src="../assets/sweet-alert/dist/sweetalert2.all.min.js"></script>
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        Swal.fire(
                            'Berhasil',
                            'Data Berhasil Disimpan',
                            'success'
                            ).then(function() {
                        window.location.href = "../detail-bill.php?id=<?php echo $id_bill_encode ?>";
                        });
                    });
                </script>
                <?php
                exit(); 
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
                        window.location.href = "../detail-bill.php?id=<?php echo $id_bill_encode ?>";
                    });
                    });
                </script>
                <?php
        } 
    }
    // End Kondisi Metode Bayar
}




function uuid() {
    $data = openssl_random_pseudo_bytes(16);
    assert(strlen($data) == 16);

    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

    return vsprintf('%s%s%s', str_split(bin2hex($data), 4));
}

?>