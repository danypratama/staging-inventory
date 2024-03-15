<?php  
    session_start();
    include "../koneksi.php";

    if(isset($_POST['hapus-list'])){
        $id_finance = htmlspecialchars($_POST['id_finance']);
        $id_bill = htmlspecialchars($_POST['id_bill']);
        $id_bill_encode = base64_encode($id_bill);
        $total_tagihan = htmlspecialchars($_POST['total_tagihan']);
        $total_inv = htmlspecialchars($_POST['total_inv']);
        $total_akhir = $total_tagihan - $total_inv;

        mysqli_begin_transaction($connect);

        try {
            $update_finance = $connect->query("UPDATE finance SET id_tagihan = '', status_tagihan = '0' WHERE id_finance = '$id_finance'");
            $update_bill = $connect->query("UPDATE finance_tagihan SET total_tagihan = '$total_akhir' WHERE id_tagihan = '$id_bill'");
            
            if($update_finance && $update_bill){
                // Jika tidak terjadi kesalahan, commit transaksi
                mysqli_commit($connect);
                $_SESSION['info'] = "Dihapus";
                header("Location:../detail-bill.php?id='$id_bill_encode'");
            }
        } catch (Exception $e) {
            // Jika terjadi kesalahan, rollback transaksi
            mysqli_rollback($connect);
            $_SESSION['info'] = "Data Gagal Dihapus";
            header("Location:../detail-bill.php?id='$id_bill_encode'");
        }
    }

?>