<?php 
	session_start();
	include "../koneksi.php";

	// Simpan
	if (isset($_POST["simpan-kat-penjualan"])) {
		$id_kat_penjualan = $_POST['id_kat_penjualan'];
		$id_user = $_POST['id_user'];
		$nama_kategori = $_POST['nama_kategori'];
		$min_stock = $_POST['min_stock'];
		$max_stock = $_POST['max_stock'];
		$created = $_POST['created'];

		$min_stock = intval(preg_replace("/[^0-9]/", "", $min_stock));
		$max_stock = intval(preg_replace("/[^0-9]/", "", $max_stock));

		$cek_kat = mysqli_query($connect, "SELECT nama_kategori FROM tb_kat_penjualan WHERE nama_kategori = '$nama_kategori'");

		if ($cek_kat->num_rows > 0) {
			$_SESSION['info'] = 'Data Gagal Disimpan';
            echo "<script>document.location.href='../kategori-penjualan.php'</script>";
		}else{
			mysqli_query($connect, "INSERT INTO tb_kat_penjualan
                      (id_kat_penjualan, id_user, nama_kategori, min_stock, max_stock, created_date) 
                      VALUES 
                      ('$id_kat_penjualan', '$id_user', '$nama_kategori', '$min_stock', '$max_stock', '$created')");

			$_SESSION['info'] = 'Disimpan';
            echo "<script>document.location.href='../kategori-penjualan.php'</script>";
		}

	//Edit
	}elseif(isset($_POST["edit-kat-penjualan"])) {
		$id_kat_penjualan = $_POST['id_kat_penjualan'];
		$nama_kategori = $_POST['nama_kategori'];
		$min_stock = $_POST['min_stock'];
		$max_stock = $_POST['max_stock'];
		$updated = $_POST['updated'];
        $user_updated = $_POST['user_updated'];
		
		$min_stock = intval(preg_replace("/[^0-9]/", "", $min_stock));
		$max_stock = intval(preg_replace("/[^0-9]/", "", $max_stock));
        // menampilkan data
        $query = "SELECT * FROM tb_kat_penjualan WHERE id_kat_penjualan = '$id_kat_penjualan'";
        $result = mysqli_query($connect, $query);
        $data_lama = mysqli_fetch_assoc($result);

        if($data_lama['nama_kategori'] == $nama_kategori) {
            // Nama tidak berubah, simpan data langsung
            $update = mysqli_query($connect, "UPDATE tb_kat_penjualan 
	                SET
					nama_kategori = '$nama_kategori',
					min_stock = '$min_stock',
					max_stock = '$max_stock',
					updated_date = '$updated',
					user_updated = '$user_updated'
	                WHERE id_kat_penjualan='$id_kat_penjualan'");
            $_SESSION['info'] = 'Disimpan';
            echo "<script>document.location.href='../kategori-penjualan.php'</script>";
          }else{
            // Nama berubah, cek apakah ada nama yang sama di database
            $cek_kat = mysqli_query($connect, "SELECT nama_kategori FROM tb_kat_penjualan WHERE nama_kategori = '$nama_kategori'");
        
            if($cek_kat->num_rows > 0) {
                // Ada nama yang sama di database, tampilkan pesan error
                $_SESSION['info'] = 'Nama kategori sudah ada';
                echo "<script>document.location.href='../kategori-penjualan.php'</script>";
            } else {
                // Nama belum digunakan, simpan data
                $update = mysqli_query($connect, "UPDATE tb_kat_penjualan 
	                SET
					nama_kategori = '$nama_kategori',
					min_stock = '$min_stock',
					max_stock = '$max_stock',
					updated_date = '$updated',
                    user_updated = '$user_updated'
	                WHERE id_kat_penjualan='$id_kat_penjualan'");
                    
                $_SESSION['info'] = 'Diupdate';
                echo "<script>document.location.href='../kategori-penjualan.php'</script>";
            }
          }

    // Hapus 
	}elseif($_GET['hapus-kat-penjualan']){
		//tangkap URL dengan $_GET
	    $idh = base64_decode($_GET['hapus-kat-penjualan']);

	    // perintah queery sql untuk hapus data
	    $sql = "DELETE FROM tb_kat_penjualan WHERE id_kat_penjualan='$idh'";
	    $query_del = mysqli_query($connect,$sql) or die (mysqli_error($connect));

	    if($query_del){
	        $_SESSION['info'] = 'Dihapus';
	        echo "<script>document.location.href='../kategori-penjualan.php'</script>";
	    }else{
	        $_SESSION['info'] = 'Data Gagal Dihapus';
	        echo "<script>document.location.href='../kategori-penjualan.php'</script>";
	    }
	}
