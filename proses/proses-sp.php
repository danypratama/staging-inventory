<?php 
	session_start();
	include "../koneksi.php";

	// Simpan
	if (isset($_POST["simpan-sp"])) {
		$id_sp = $_POST['id_sp'];
		$nama_sp = $_POST['nama_sp'];
		$alamat = $_POST['alamat_sp'];
		$telp = $_POST['telp_sp'];
		$created = $_POST['created'];

		$cek_sp = mysqli_query($connect, "SELECT nama_sp FROM tb_supplier WHERE nama_sp = '$nama_sp'");

		if ($cek_sp->num_rows > 0) {
			$_SESSION['info'] = 'Nama supplier sudah ada';
            echo "<script>document.location.href='../data-supplier.php'</script>";
		}else{
			mysqli_query($connect, "INSERT INTO tb_supplier
                      (id_sp, nama_sp, alamat, no_telp, created_date) VALUES ('$id_sp', '$nama_sp', '$alamat', '$telp', '$created')");

			$_SESSION['info'] = 'Disimpan';
            echo "<script>document.location.href='../data-supplier.php'</script>";
		}

	//Edit
	}elseif(isset($_POST["edit-sp"])) {
		$id_sp = $_POST['id_sp'];
		$nama_sp = $_POST['nama_sp'];
		$alamat = $_POST['alamat_sp'];
		$telp = $_POST['telp_sp'];
		$updated = $_POST['updated'];

		// menampilkan data
        $query = "SELECT * FROM tb_supplier WHERE id_sp = '$id_sp'";
        $result = mysqli_query($connect, $query);
        $data_lama = mysqli_fetch_assoc($result);

		if($data_lama['nama_sp'] == $nama_sp) {
            // Nama tidak berubah, simpan data langsung
            $update = mysqli_query($connect, "UPDATE tb_supplier 
	                SET
					nama_sp = '$nama_sp',
					alamat = '$alamat',
					no_telp = '$telp',
					updated_date = '$updated'
	                WHERE id_sp='$id_sp'");
            $_SESSION['info'] = 'Disimpan';
            echo "<script>document.location.href='../data-supplier.php'</script>";
          }else{
            // Nama berubah, cek apakah ada nama yang sama di database
            $cek_sp = mysqli_query($connect, "SELECT nama_sp FROM tb_supplier WHERE nama_sp = '$nama_sp'");
        
            if($cek_sp->num_rows > 0) {
                // Ada nama yang sama di database, tampilkan pesan error
                $_SESSION['info'] = 'Nama supplier sudah ada';
                echo "<script>document.location.href='../data-supplier.php'</script>";
            } else {
                // Nama belum digunakan, simpan data
				$update = mysqli_query($connect, "UPDATE tb_supplier 
							SET
							nama_sp = '$nama_sp',
							alamat = '$alamat',
							no_telp = '$telp',
							updated_date = '$updated'
							WHERE id_sp='$id_sp'");
                    
                $_SESSION['info'] = 'Diupdate';
                echo "<script>document.location.href='../data-supplier.php'</script>";
            }
          }
		  
    // Hapus
	}elseif($_GET['hapus-sp']){
		//tangkap URL dengan $_GET
	    $idh = $_GET['hapus-sp'];

	    // perintah queery sql untuk hapus data
	    $sql = "DELETE FROM tb_supplier WHERE id_sp='$idh'";
	    $query_del = mysqli_query($connect,$sql) or die (mysqli_error($connect));

	    if($query_del){
	        $_SESSION['info'] = 'Dihapus';
	        echo "<script>document.location.href='../data-supplier.php'</script>";
	    }else{
	        $_SESSION['info'] = 'Data Gagal Dihapus';
	        echo "<script>document.location.href='../data-supplier.php'</script>";
	    }
	}
?>