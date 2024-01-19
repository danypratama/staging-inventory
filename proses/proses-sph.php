<?php  
    session_start();
    include "../koneksi.php";

    if(isset($_POST['simpan-sph'])){
        $uuid = uuid();
        $day = date('d');
        $month = date('m');
        $year = date('y');
        $id_sph = "SPH" . $year . "" . $month . "" . $uuid . "" . $day ;
        $id_sph_encode = base64_encode($id_sph);
        $no_sph = $_POST['no_sph'];
        $tgl = $_POST['tgl'];
        $up = $_POST['up'];
        $id_cs = $_POST['id_cs'];
        $alamat = $_POST['alamat'];
        $ttd = $_POST['ttd'];
        $jabatan = $_POST['jabatan'];
        $perihal = $_POST['perihal'];
        $note = $_POST['note'];
        $user = $_SESSION['tiket_nama'];

        // Begin transaction
        mysqli_begin_transaction($connect);

        try{
            $simpan_sph = mysqli_query($connect, "INSERT INTO sph
                                                (id_sph, no_sph, tanggal, up, id_cs, alamat, ttd_oleh, jabatan, perihal, note, created_by)
                                                values
                                                ('$id_sph', '$no_sph', '$tgl', '$up', '$id_cs', '$alamat', '$ttd', '$jabatan', '$perihal', '$note', '$user')              
                                            ");
        
        // Commit the transaction
        mysqli_commit($connect);
        // Redirect to the invoice page
        header("Location:../tampil-data-sph.php?id=$id_sph_encode");
        exit();
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
                    window.location.href = "../sph.php";
                });
            });
            </script>
            <?php
        }   
    }else if(isset($_POST['simpan-cek-produk'])){
        $id_trx = $_POST['id_trx'];
        $id_sph = $_POST['id_sph'];
        $qty = $_POST['qty']; // Mengambil nilai qty yang diperbarui
        $harga = $_POST['harga'];
        $id_trx_array = count($id_trx);
        for($i=0; $i < $id_trx_array; $i++ ){
            $currentId = $id_trx[$i];   
            $newQtyInt = str_replace(',', '', $qty[$i]); // Menghapus tanda ribuan (,)
            $newQtyInt = intval($newQtyInt); // Mengubah string harga menjadi integer
            $newHarga = str_replace(',', '', $harga[$i]); // Menghapus tanda ribuan (,)
            $newHarga = intval($newHarga); // Mengubah string harga menjadi integer
            $id_sph_encode = base64_encode($id_sph[$i]); 
            // Membuat query update untuk setiap id_trx
            $sql_update = mysqli_query($connect, "UPDATE transaksi_produk_sph SET harga = '$newHarga', qty = '$newQtyInt', status_trx = 1 WHERE id_transaksi = '$currentId'");

    
            // Menjalankan query update
            if($sql_update){
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
                        window.location.href = "../tampil-data-sph.php?id=<?php echo $id_sph_encode ?>";
                        });
                    });
                </script>
                <?php
            }else{
                ?>
                <!-- Sweet Alert -->
                <link rel="stylesheet" href="../assets/sweet-alert/dist/sweetalert2.min.css">
                <script src="../assets/sweet-alert/dist/sweetalert2.all.min.js"></script>
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        title: "Error!",
                        text: "Gagal Update",
                        icon: "error",
                    }).then(function() {
                        window.location.href = "../tampil-data-sph.php?id=<?php echo $id_sph?>";
                    });
                    });
                </script>
                <?php
            }
        }
    }else if(isset($_POST['ubah-cs-sph'])){
        $id_sph = $_POST['id_sph'];
        $tanggal = $_POST['tanggal'];
        $up = $_POST['up'];
        $id_cs = $_POST['id_cs'];
        $alamat = $_POST['alamat'];
        $ttd = $_POST['ttd'];
        $jabatan = $_POST['jabatan'];
        $perihal = $_POST['perihal'];
        $note = $_POST['note'];

        $sph_update = mysqli_query($connect, "UPDATE sph SET 
                                                tanggal = '$tanggal',
                                                up = '$up',
                                                id_cs = '$id_cs',
                                                alamat = '$alamat',
                                                ttd_oleh = '$ttd',
                                                jabatan = '$jabatan',
                                                perihal = '$perihal',
                                                note = '$note'
                                                WHERE id_sph = '$id_sph'");
        if($sph_update){
            ?>
            <!-- Sweet Alert -->
            <link rel="stylesheet" href="../assets/sweet-alert/dist/sweetalert2.min.css">
            <script src="../assets/sweet-alert/dist/sweetalert2.all.min.js"></script>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire(
                        'Berhasil',
                        'Data Berhasil Diupdate',
                        'success'
                        ).then(function() {
                    window.location.href = "../tampil-data-sph.php?id=<?php echo base64_encode($id_sph)?> ";
                    });
                });
            </script>
            <?php
        }else{
            ?>
            <!-- Sweet Alert -->
            <link rel="stylesheet" href="../assets/sweet-alert/dist/sweetalert2.min.css">
            <script src="../assets/sweet-alert/dist/sweetalert2.all.min.js"></script>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: "Error!",
                    text: "Gagal Update",
                    icon: "error",
                }).then(function() {
                    window.location.href = "../tampil-data-sph.php?id=<?php echo $id_sph?>";
                });
                });
            </script>
            <?php
        }

    }else if(isset($_POST['edit-br'])){
        $id_trx = $_POST['id_trx'];
        $id_sph = $_POST['id_sph'];
        $qty_edit = $_POST['qty_edit'];
        $qty = str_replace(',', '', $qty_edit); // Menghapus tanda ribuan (,)
        $qty = intval($qty); // Mengubah string harga menjadi integer
        $harga_edit = $_POST['harga'];
        $harga = str_replace(',', '', $harga_edit); // Menghapus tanda ribuan (,)
        $harga = intval($harga); // Mengubah string harga menjadi integer

        $trx_edit = mysqli_query($connect, "UPDATE transaksi_produk_sph SET harga = '$harga', qty = '$qty' WHERE id_transaksi = '$id_trx'");

        if($trx_edit){
            ?>
            <!-- Sweet Alert -->
            <link rel="stylesheet" href="../assets/sweet-alert/dist/sweetalert2.min.css">
            <script src="../assets/sweet-alert/dist/sweetalert2.all.min.js"></script>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire(
                        'Berhasil',
                        'Data Berhasil Diupdate',
                        'success'
                        ).then(function() {
                    window.location.href = "../tampil-data-sph.php?id=<?php echo base64_encode($id_sph)?> ";
                    });
                });
            </script>
            <?php
        }else{
            ?>
            <!-- Sweet Alert -->
            <link rel="stylesheet" href="../assets/sweet-alert/dist/sweetalert2.min.css">
            <script src="../assets/sweet-alert/dist/sweetalert2.all.min.js"></script>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: "Error!",
                    text: "Gagal Update",
                    icon: "error",
                }).then(function() {
                    window.location.href = "../tampil-data-sph.php?id=<?php echo $id_sph?>";
                });
                });
            </script>
            <?php
        }
        
    }else if(isset($_GET['hapus'])){
        $id_trx = $_GET['hapus'];
        $id_sph = $_GET['id_sph'];
        $id_trx_decode = base64_decode($id_trx);
        
        $sql_del = mysqli_query($connect, "DELETE FROM transaksi_produk_sph WHERE id_transaksi = '$id_trx_decode'");

        if($sql_del){
            ?>
            <!-- Sweet Alert -->
            <link rel="stylesheet" href="../assets/sweet-alert/dist/sweetalert2.min.css">
            <script src="../assets/sweet-alert/dist/sweetalert2.all.min.js"></script>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire(
                        'Berhasil',
                        'Data Berhasil Dihapus',
                        'success'
                        ).then(function() {
                    window.location.href = "../tampil-data-sph.php?id=<?php echo $id_sph?>";
                    });
                });
            </script>
            <?php
        }else{
            ?>
            <!-- Sweet Alert -->
            <link rel="stylesheet" href="../assets/sweet-alert/dist/sweetalert2.min.css">
            <script src="../assets/sweet-alert/dist/sweetalert2.all.min.js"></script>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: "Error!",
                    text: "Gagal Delete",
                    icon: "error",
                }).then(function() {
                    window.location.href = "../tampil-data-sph.php?id=<?php echo $id_sph?>";
                });
                });
            </script>
            <?php
        }

    }else if(isset($_POST['cancel'])){
        $id_sph = $_POST['id_sph'];
        $id_sph_decode = base64_decode($id_sph); 
        $cancel_sph = mysqli_query($connect, "UPDATE sph SET status_cancel = 1 WHERE id_sph = '$id_sph_decode'");

        if($cancel_sph){
            ?>
            <!-- Sweet Alert -->
            <link rel="stylesheet" href="../assets/sweet-alert/dist/sweetalert2.min.css">
            <script src="../assets/sweet-alert/dist/sweetalert2.all.min.js"></script>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire(
                        'Berhasil',
                        'Data Berhasil Dicancel',
                        'success'
                        ).then(function() {
                    window.location.href = "../sph.php";
                    });
                });
            </script>
            <?php
        }else{
            ?>
            <!-- Sweet Alert -->
            <link rel="stylesheet" href="../assets/sweet-alert/dist/sweetalert2.min.css">
            <script src="../assets/sweet-alert/dist/sweetalert2.all.min.js"></script>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: "Error!",
                    text: "Proses Cancel Gagal",
                    icon: "error",
                }).then(function() {
                    window.location.href = "../sph.php";
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
    
        return vsprintf('%s%s', str_split(bin2hex($data), 4));
    }

?>