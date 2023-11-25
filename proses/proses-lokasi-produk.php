<?php 
	session_start();
	include "../koneksi.php";

	// Simpan
	if (isset($_POST["simpan-lokasi-produk"])) {
		$id_lokasi_produk = $_POST['id_lokasi_produk'];
        $lokasi = $_POST['lokasi'];
        $no_lantai = $_POST['no_lantai'];
		$area = $_POST['area'];
        $no_rak = $_POST['no_rak'];
        $id_user = $_POST['id_user'];
		$created = $_POST['created'];

		$cek_lok = mysqli_query($connect, "SELECT * FROM tb_lokasi_produk WHERE nama_lokasi = '$lokasi' AND no_lantai = '$no_lantai' AND nama_area = '$area' AND no_rak = '$no_rak'");

		if ($cek_lok->num_rows > 0) {
			$_SESSION['info'] = 'Data sudah ada';
            echo "<script>document.location.href='../lokasi-produk.php'</script>";
		}else{
			mysqli_query($connect, "INSERT INTO tb_lokasi_produk
                      (id_lokasi, id_user, nama_lokasi, no_lantai, nama_area, no_rak, created_date) 
                      VALUES 
                      ('$id_lokasi_produk', '$id_user', '$lokasi', '$no_lantai', '$area', '$no_rak', '$created')");

			$_SESSION['info'] = 'Disimpan';
            echo "<script>document.location.href='../lokasi-produk.php'</script>";
		}

	//Edit
	}elseif(isset($_POST["edit-lokasi-produk"])) {
		$id_lokasi_produk = $_POST['id_lokasi_produk'];
        $lokasi = $_POST['lokasi'];
        $no_lantai = $_POST['no_lantai'];
		$area = $_POST['area'];
        $no_rak = $_POST['no_rak'];
        $user_updated = $_POST['user_updated'];
		$updated = $_POST['updated'];

		// cek data sebelum update
		$cek_lok = mysqli_query($connect, "SELECT * FROM tb_lokasi_produk WHERE nama_lokasi = '$lokasi' AND no_lantai = '$no_lantai' AND nama_area = '$area' AND no_rak = '$no_rak'");
	
		if($cek_lok->num_rows > 0) {
			// Ada nama yang sama di database, tampilkan pesan error
			$_SESSION['info'] = 'Data sudah ada';
			echo "<script>document.location.href='../lokasi-produk.php'</script>";
		} else {
			// Data belum ada, simpan data
			$update = mysqli_query($connect, "UPDATE tb_lokasi_produk 
				SET
				nama_lokasi = '$lokasi',
				no_lantai = '$no_lantai',
				nama_area = '$area',
				no_rak = '$no_rak',
				updated_date = '$updated',
				user_updated = '$user_updated'
				WHERE id_lokasi='$id_lokasi_produk'");
				
			$_SESSION['info'] = 'Diupdate';
			echo "<script>document.location.href='../lokasi-produk.php'</script>";
		}

    // Hapus 
	}else if(isset($_POST["hapus-lokasi-produk"])){
		//tangkap URL dengan $_GET
	    $idh = $_POST['id_lokasi_produk'];

	    // perintah queery sql untuk hapus data
	    $sql = "DELETE FROM tb_lokasi_produk WHERE id_lokasi ='$idh'";
	    $query_del = mysqli_query($connect,$sql) or die (mysqli_error($connect));

	    if($query_del){
	        $_SESSION['info'] = 'Dihapus';
	        echo "<script>document.location.href='../lokasi-produk.php'</script>";
	    }else{
	        $_SESSION['info'] = 'Data Gagal Dihapus';
	        echo "<script>document.location.href='../lokasi-produk.php'</script>";
	    }
	}
