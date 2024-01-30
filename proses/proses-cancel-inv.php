<?php  
    session_start();
    include "../koneksi.php";
    date_default_timezone_set('Asia/Jakarta');

    if(isset($_POST['cancel-inv-nonppn'])){
        $id_inv = $_POST['id_inv'];
        $alasan = $_POST['alasan'];
        $menu_cancel = 'Invoice Sudah Diterbitkan';
        $user = $_SESSION['tiket_nama'];
        $time = date('d/m/Y, H:i:s');
        // Cek data terlebih dahulu 
        $cek_data = mysqli_query($connect, "SELECT id_spk_reg FROM spk_reg WHERE id_inv = '$id_inv'");
        $id_spk_array = array();
        while($data = mysqli_fetch_array($cek_data)){
            $id_spk = $data['id_spk_reg'];
            // Setelah data di dapatkan, simpan di dalam array
            $id_spk_array[] = $id_spk;


        }
        // Implode data yang di dapatkan agar menjadi '123', 'abc'
        $id_spk_implode = "'" . implode("', '", $id_spk_array) . "'";

        // Lakukan Proses CRUD
        mysqli_begin_transaction($connect);

        try {
            $insert = mysqli_query($connect, "INSERT INTO trx_cancel (id_trx_cancel, id_spk, id_produk, harga, qty, disc, total_harga) SELECT id_transaksi, id_spk, id_produk, harga, qty, disc, total_harga FROM transaksi_produk_reg WHERE id_spk IN ($id_spk_implode)");

            $delete = mysqli_query($connect, "DELETE FROM transaksi_produk_reg WHERE id_spk IN ($id_spk_implode)");

            $update = mysqli_query($connect, "UPDATE spk_reg SET status_spk = 'Cancel Order', note = '$alasan', menu_cancel = '$menu_cancel', user_cancel = '$user', date_cancel = '$time' WHERE id_spk_reg IN ($id_spk_implode)");

            $update_invoice = mysqli_query($connect, "UPDATE inv_nonppn SET status_transaksi = 'Cancel Order' WHERE id_inv_nonppn = '$id_inv'");

            if (!$insert && !$delete && !$update && !$update_invoice) {
                throw new Exception("Terjadi kesalahan saat menyimpan data.");
            }
            // Jika tidak terjadi kesalahan, commit transaksi
            mysqli_commit($connect);
            $_SESSION['info'] = 'Dicancel';
            header("Location:../spk-dalam-proses.php?sort=baru");
        } catch (Exception $e) {
            // Jika terjadi kesalahan, rollback transaksi
            mysqli_rollback($connect);
            $_SESSION['info'] = 'Silahkan Ulangi Kembali';
            header("Location:../spk-dalam-proses.php?sort=baru");
        }
    } else if(isset($_POST['cancel-inv-ppn'])){
        $id_inv = $_POST['id_inv'];
        $alasan = $_POST['alasan'];
        $menu_cancel = 'Invoice Sudah Diterbitkan';
        $user = $_SESSION['tiket_nama'];
        $time = date('d/m/Y, H:i:s');

        $cek_data = mysqli_query($connect, "SELECT id_spk_reg FROM spk_reg WHERE id_inv = '$id_inv'");
        $id_spk_array = array();
        while($data = mysqli_fetch_array($cek_data)){
            $id_spk = $data['id_spk_reg'];

            $id_spk_array[] = $id_spk;


        }
        $id_spk_implode = "'" . implode("', '", $id_spk_array) . "'";
        mysqli_begin_transaction($connect);

        try {
            $insert = mysqli_query($connect, "INSERT INTO trx_cancel (id_trx_cancel, id_spk, id_produk, harga, qty, disc, total_harga) SELECT id_transaksi, id_spk, id_produk, harga, qty, disc, total_harga FROM transaksi_produk_reg WHERE id_spk IN ($id_spk_implode)");
        
            var_dump($insert);

            $delete = mysqli_query($connect, "DELETE FROM transaksi_produk_reg WHERE id_spk IN ($id_spk_implode)");

            $update = mysqli_query($connect, "UPDATE spk_reg SET status_spk = 'Cancel Order', note = '$alasan', menu_cancel = '$menu_cancel', user_cancel = '$user', date_cancel = '$time' WHERE id_spk_reg IN ($id_spk_implode)");

            $update_invoice = mysqli_query($connect, "UPDATE inv_ppn SET status_transaksi = 'Cancel Order' WHERE id_inv_ppn = '$id_inv'");

            if (!$insert && !$delete && !$update && !$update_invoice) {
                throw new Exception("Terjadi kesalahan saat menyimpan data.");
            }
            // Jika tidak terjadi kesalahan, commit transaksi
            mysqli_commit($connect);
            $_SESSION['info'] = 'Dicancel';
            header("Location:../spk-dalam-proses.php?sort=baru");
        } catch (Exception $e) {
            // Jika terjadi kesalahan, rollback transaksi
            mysqli_rollback($connect);
            $_SESSION['info'] = 'Silahkan Ulangi Kembali';
            header("Location:../spk-dalam-proses.php?sort=baru");
        }

    } else if(isset($_POST['cancel-inv-bum'])){
        $id_inv = $_POST['id_inv'];
        $alasan = $_POST['alasan'];
        $menu_cancel = 'Invoice Sudah Diterbitkan';
        $user = $_SESSION['tiket_nama'];
        $time = date('d/m/Y, H:i:s');

        $cek_data = mysqli_query($connect, "SELECT id_spk_reg FROM spk_reg WHERE id_inv = '$id_inv'");
        $id_spk_array = array();
        while($data = mysqli_fetch_array($cek_data)){
            $id_spk = $data['id_spk_reg'];

            $id_spk_array[] = $id_spk;


        }
        $id_spk_implode = "'" . implode("', '", $id_spk_array) . "'";
        mysqli_begin_transaction($connect);

        try {
            $insert = mysqli_query($connect, "INSERT INTO trx_cancel (id_trx_cancel, id_spk, id_produk, harga, qty, disc, total_harga) SELECT id_transaksi, id_spk, id_produk, harga, qty, disc, total_harga FROM transaksi_produk_reg WHERE id_spk IN ($id_spk_implode)");
        
            var_dump($insert);

            $delete = mysqli_query($connect, "DELETE FROM transaksi_produk_reg WHERE id_spk IN ($id_spk_implode)");

            $update = mysqli_query($connect, "UPDATE spk_reg SET status_spk = 'Cancel Order', note = '$alasan', menu_cancel = '$menu_cancel', user_cancel = '$user', date_cancel = '$time' WHERE id_spk_reg IN ($id_spk_implode)");

            $update_invoice = mysqli_query($connect, "UPDATE inv_bum SET status_transaksi = 'Cancel Order' WHERE id_inv_bum = '$id_inv'");

            if (!$insert && !$delete && !$update && !$update_invoice) {
                throw new Exception("Terjadi kesalahan saat menyimpan data.");
            }
            // Jika tidak terjadi kesalahan, commit transaksi
            mysqli_commit($connect);
            $_SESSION['info'] = 'Dicancel';
            header("Location:../spk-dalam-proses.php?sort=baru");
        } catch (Exception $e) {
            // Jika terjadi kesalahan, rollback transaksi
            mysqli_rollback($connect);
            $_SESSION['info'] = 'Silahkan Ulangi Kembali';
            header("Location:../spk-dalam-proses.php?sort=baru");
        }

    }
?>