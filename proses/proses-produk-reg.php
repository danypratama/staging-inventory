<?php 
	session_start();
	include "../koneksi.php";
	include '../assets/Qrcode/qrlib.php';

	// Simpan
	if (isset($_POST["simpan-produk-reg"])) {
		$id_produk = $_POST['id_produk'];
        $kode = $_POST['kode_produk'];
        $nama = htmlspecialchars($_POST['nama_produk']);
		$kode_katalog = htmlspecialchars($_POST['kode_katalog']);
		$no_batch = htmlspecialchars($_POST['no_batch']);
		$satuan = $_POST['satuan']; 
        $merk = $_POST['merk'];
        $harga = $_POST['harga'];
        $lokasi = htmlspecialchars($_POST['id_lokasi']);
        $kat_produk = $_POST['kategori_produk'];
        $kat_penjualan = htmlspecialchars($_POST['kategori_penjualan']);
        $grade = htmlspecialchars($_POST['grade']);
		$jenis_produk = $_POST['jenis_produk'];
        $created = $_POST['created'];
		$created_by = $_POST['id_user'];

		if($jenis_produk == 'reg'){
			$cek_data = mysqli_query($connect, "SELECT * FROM tb_produk_reguler WHERE kode_produk = '$kode' AND nama_produk = '$nama' AND id_merk = '$merk' AND kode_katalog = '$kode_katalog'");

			if ($cek_data->num_rows > 0) {
				$_SESSION['info'] = 'Data sudah ada';
				echo "<script>document.location.href='../data-produk-reg.php'</script>";
			}else{
				// Untuk proses simpan QR Code

				$url_qr = "https://$_SERVER[HTTP_HOST]/detail-produk-ecat.php?id=$id_produk";

				// Nama file output
				$nama_qr_image = preg_replace('/[^\w]+/', '_', $nama) . '.png';
				$outputFile = "../gambar/QRcode/$nama_qr_image";

 
				// Ukuran QR code (pixels)
				$size = 300;

				// Tingkat koreksi kesalahan: L (Low), M (Medium), Q (Quartile), H (High)
				$correctionLevel = 'M';

				// Logo dan ukuran logo (pixels)
				$logoPath = '../assets/img/KMA.png';  // Ganti dengan path logo Anda
				$logoSize = 120;  // Ganti dengan ukuran logo yang diinginkan

				// Membuat QR code
				QRcode::png($url_qr, $outputFile, $correctionLevel, $size, 2);

				// Menambahkan logo ke QR code
				$QR = imagecreatefrompng($outputFile);
				$logo = imagecreatefrompng($logoPath);
				$QR_width = imagesx($QR);
				$QR_height = imagesy($QR);
				$logo_width = imagesx($logo);
				$logo_height = imagesy($logo);
				$centerX = ($QR_width - $logo_width) / 2;
				$centerY = ($QR_height - $logo_height) / 2;
				imagecopy($QR, $logo, $centerX, $centerY, 0, 0, $logo_width, $logo_height);
				imagepng($QR, $outputFile);

				// Membebaskan memori
				imagedestroy($QR);
				imagedestroy($logo);
				// End Proses QR Code

				
				// Convert budget to integer
				$harga = intval(preg_replace("/[^0-9]/", "", $harga));

				// Mendapatkan informasi file
				$nama_file = $_FILES["fileku"]["name"];
				$tipe_file = $_FILES["fileku"]["type"];
				$ukuran_file = $_FILES["fileku"]["size"];
				$tmp_file = $_FILES["fileku"]["tmp_name"];

				// Enkripsi nama file
				$ubah_nama = 'IMG';
				$nama_file_baru = $ubah_nama . uniqid() . '.jpg';

				// Simpan file ke direktori tujuan
				$direktori_tujuan = "../gambar/upload-produk-reg/";
				$target_file = $direktori_tujuan . $nama_file_baru;
				move_uploaded_file($tmp_file, $target_file);

				$sql = "INSERT INTO tb_produk_reguler
				(id_produk_reg, id_merk, id_kat_produk, id_kat_penjualan, id_grade, id_lokasi, kode_produk, nama_produk, no_batch, kode_katalog, satuan, harga_produk, gambar, created_date, created_by)
				VALUES
				('$id_produk', '$merk', '$kat_produk', '$kat_penjualan', '$grade', '$lokasi', '$kode', '$nama', '$no_batch', '$kode_katalog', '$satuan', '$harga', '$nama_file_baru', '$created', '$created_by')";
				$query = mysqli_query($connect, $sql) or die(mysqli_error($connect, $sql));

				$qr = mysqli_query($connect, "INSERT INTO qr_link
				(id_produk_qr, url_qr, qr_img) VALUES ('$id_produk', '$url_qr', '$nama_qr_image')
				");

				$_SESSION['info'] = 'Disimpan';
				echo "<script>document.location.href='../data-produk-reg.php'</script>";
				
			}
		} else {
			$cek_data = mysqli_query($connect, "SELECT * FROM tb_produk_ecat WHERE kode_produk = '$kode' AND nama_produk = '$nama' AND id_merk = '$merk' AND kode_katalog = '$kode_katalog'");

			if ($cek_data->num_rows > 0) {
				$_SESSION['info'] = 'Data sudah ada';
				echo "<script>document.location.href='../data-produk-reg.php'</script>";
			}else{
				// Untuk proses simpan QR Code
				$url_qr = "https://$_SERVER[HTTP_HOST]/detail-produk-ecat.php?id=$id_produk";

				// Nama file output
				$nama_qr_image = preg_replace('/[^\w]+/', '_', $nama) . '.png';
				$outputFile = "../gambar/QRcode-ecat/$nama_qr_image";



				// Ukuran QR code (pixels)
				$size = 300;

				// Tingkat koreksi kesalahan: L (Low), M (Medium), Q (Quartile), H (High)
				$correctionLevel = 'M';

				// Membuat QR code
				QRcode::png($url_qr, $outputFile, $correctionLevel, $size);
				// End Proses QR Code

				
				// Convert budget to integer
				$harga = intval(preg_replace("/[^0-9]/", "", $harga));

				// Mendapatkan informasi file
				$nama_file = $_FILES["fileku"]["name"];
				$tipe_file = $_FILES["fileku"]["type"];
				$ukuran_file = $_FILES["fileku"]["size"];
				$tmp_file = $_FILES["fileku"]["tmp_name"];

				// Enkripsi nama file
				$ubah_nama = 'IMG';
				$nama_file_baru = $ubah_nama . uniqid() . '.jpg';

				// Simpan file ke direktori tujuan
				$direktori_tujuan = "../gambar/upload-produk-ecat/";
				$target_file = $direktori_tujuan . $nama_file_baru;
				move_uploaded_file($tmp_file, $target_file);
				$sql = "INSERT INTO tb_produk_ecat
				(id_produk_ecat, id_merk, id_kat_produk, id_kat_penjualan, id_grade, id_lokasi, kode_produk, nama_produk, no_batch, kode_katalog, satuan, harga_produk, gambar, created_date, created_by)
				VALUES
				('$id_produk', '$merk', '$kat_produk', '$kat_penjualan', '$grade', '$lokasi', '$kode', '$nama', '$no_batch', '$kode_katalog', '$satuan', '$harga', '$nama_file_baru', '$created', '$created_by')";
 				$query = mysqli_query($connect, $sql) or die(mysqli_error($connect, $sql));

				
				$qr = mysqli_query($connect, "INSERT INTO qr_link_ecat
					(id_produk_qr, url_qr, qr_img) VALUES ('$id_produk', '$url_qr', '$nama_qr_image')
					");
				$_SESSION['info'] = 'Disimpan';
				echo "<script>document.location.href='../data-produk-ecat.php'</script>";
			
			}
		}

	//Edit
	}elseif(isset($_POST["edit-produk-reg"])) {
		$id_produk = htmlspecialchars($_POST['id_produk']);
        $kode = htmlspecialchars($_POST['kode_produk']);
		$no_batch = htmlspecialchars($_POST['no_batch']);
        $nama = htmlspecialchars($_POST['nama_produk']);
		$kode_katalog = htmlspecialchars($_POST['kode_katalog']);
		$satuan = $_POST['satuan'];
        $merk = $_POST['merk'];
        $harga = $_POST['harga'];
        $lokasi = htmlspecialchars($_POST['id_lokasi']);
        $kat_produk = htmlspecialchars($_POST['id_kat_produk']);
        $kat_penjualan = htmlspecialchars($_POST['kategori_penjualan']);
        $grade = htmlspecialchars($_POST['grade']);
        $updated_by = $_POST['id_user'];
        $updated = $_POST['updated'];
		// Convert budget to integer
		$harga = intval(preg_replace("/[^0-9]/", "", $harga));

		// Mendapatkan informasi file
		$nama_file = $_FILES["fileku"]["name"];
		$tipe_file = $_FILES["fileku"]["type"];
		$ukuran_file = $_FILES["fileku"]["size"];
		$tmp_file = $_FILES["fileku"]["tmp_name"];

		//cek data sebelum update (Jika gambar tidak di ubah)
		if($nama_file == '') {
			//data di simpan
			$update = mysqli_query($connect, "UPDATE tb_produk_reguler
									SET 
									id_merk = '$merk',
									id_kat_produk = '$kat_produk',
									id_kat_penjualan = '$kat_penjualan',
									id_grade = '$grade',
									id_lokasi = '$lokasi',
									kode_produk = '$kode',
									no_batch = '$no_batch',
									nama_produk = '$nama',
									kode_katalog = '$kode_katalog',
									satuan = '$satuan',
									harga_produk = '$harga',
									updated_date = '$updated',
									updated_by = '$updated_by'
									WHERE id_produk_reg = '$id_produk'");
			$_SESSION['info'] = 'Disimpan';
			echo "<script>document.location.href='../data-produk-reg.php'</script>";
		} else {
			$sql = "SELECT * FROM tb_produk_reguler WHERE id_produk_reg = '$id_produk'";
			$result = mysqli_query($connect, $sql);
			$row = mysqli_fetch_assoc($result);
			$gambar = $row['gambar'];
			unlink("../gambar/upload-produk-reg/$gambar");

			// Enkripsi nama file
			$ubah_nama = 'IMG';
			$nama_file_baru = $ubah_nama . uniqid() . '.jpg';

			// Simpan file ke direktori tujuan
			$direktori_tujuan = "../gambar/upload-produk-reg/";
			$target_file = $direktori_tujuan . $nama_file_baru;
			move_uploaded_file($tmp_file, $target_file);

			$update = mysqli_query($connect, "UPDATE tb_produk_reguler
									SET 
									id_merk = '$merk',
									id_kat_produk = '$kat_produk',
									id_kat_penjualan = '$kat_penjualan',
									id_grade = '$grade',
									id_lokasi = '$lokasi',
									kode_produk = '$kode',
									no_batch = '$no_batch',
									nama_produk = '$nama',
									kode_katalog = '$kode_katalog',
									satuan = '$satuan',
									harga_produk = '$harga',
									gambar = '$nama_file_baru',
									updated_date = '$updated',
									updated_by = '$updated_by'
									WHERE id_produk_reg = '$id_produk'");
			
			$_SESSION['info'] = 'Diupdate';
			echo "<script>document.location.href='../data-produk-reg.php'</script>";
		}

	//Edit Ecat
	}elseif(isset($_POST["edit-produk-ecat"])) {
		$id_produk = htmlspecialchars($_POST['id_produk']);
		$kode = htmlspecialchars($_POST['kode_produk']);
		$no_batch = htmlspecialchars($_POST['no_batch']);
		$nama = htmlspecialchars($_POST['nama_produk']);
		$kode_katalog = htmlspecialchars($_POST['kode_katalog']);
		$satuan = $_POST['satuan'];
		$merk = $_POST['merk'];
		$harga = $_POST['harga'];
		$lokasi = htmlspecialchars($_POST['id_lokasi']);
		$kat_produk = htmlspecialchars($_POST['id_kat_produk']);
		$kat_penjualan = htmlspecialchars($_POST['kategori_penjualan']);
		$grade = htmlspecialchars($_POST['grade']);
		$updated_by = $_POST['id_user'];
		$updated = $_POST['updated'];
		// Convert budget to integer
		$harga = intval(preg_replace("/[^0-9]/", "", $harga));

		// Mendapatkan informasi file
		$nama_file = $_FILES["fileku"]["name"];
		$tipe_file = $_FILES["fileku"]["type"];
		$ukuran_file = $_FILES["fileku"]["size"];
		$tmp_file = $_FILES["fileku"]["tmp_name"];

		//cek data sebelum update (Jika gambar tidak di ubah)
		if($nama_file == '') {
			//data di simpan
			$update = mysqli_query($connect, "	UPDATE tb_produk_ecat
												SET 
													id_merk = '$merk',
													id_kat_produk = '$kat_produk',
													id_kat_penjualan = '$kat_penjualan',
													id_grade = '$grade',
													id_lokasi = '$lokasi',
													kode_produk = '$kode',
													no_batch = '$no_batch',
													nama_produk = '$nama',
													kode_katalog = '$kode_katalog',
													satuan = '$satuan',
													harga_produk = '$harga',
													updated_date = '$updated',
													updated_by = '$updated_by'
												WHERE id_produk_ecat = '$id_produk'");

			$url_qr = "https://$_SERVER[HTTP_HOST]/detail-produk-ecat.php?id=$id_produk";

			// Nama file output
			$nama_qr_image = preg_replace('/[^\w]+/', '_', $nama) . '.png';
			$outputFile = "../gambar/QRcode-ecat/$nama_qr_image";



			// Ukuran QR code (pixels)
			$size = 300;

			// Tingkat koreksi kesalahan: L (Low), M (Medium), Q (Quartile), H (High)
			$correctionLevel = 'M';

			// Membuat QR code
			QRcode::png($url_qr, $outputFile, $correctionLevel, $size);

			$_SESSION['info'] = 'Disimpan';
			echo "<script>document.location.href='../data-produk-ecat.php'</script>";
		} else {
			$sql = "SELECT * FROM tb_produk_ecat WHERE id_produk_ecat = '$id_produk'";
			$result = mysqli_query($connect, $sql);
			$row = mysqli_fetch_assoc($result);
			$gambar = $row['gambar'];
			unlink("../gambar/upload-produk-ecat/$gambar");

			// Enkripsi nama file
			$ubah_nama = 'IMG';
			$nama_file_baru = $ubah_nama . uniqid() . '.jpg';

			// Simpan file ke direktori tujuan
			$direktori_tujuan = "../gambar/upload-produk-ecat/";
			$target_file = $direktori_tujuan . $nama_file_baru;
			move_uploaded_file($tmp_file, $target_file);

			$update = mysqli_query($connect, "UPDATE tb_produk_ecat
									SET 
									id_merk = '$merk',
									id_kat_produk = '$kat_produk',
									id_kat_penjualan = '$kat_penjualan',
									id_grade = '$grade',
									id_lokasi = '$lokasi',
									kode_produk = '$kode',
									no_batch = '$no_batch',
									nama_produk = '$nama',
									kode_katalog = '$kode_katalog',
									satuan = '$satuan',
									harga_produk = '$harga',
									gambar = '$nama_file_baru',
									updated_date = '$updated',
									updated_by = '$updated_by'
									WHERE id_produk_ecat = '$id_produk'");
			
			$_SESSION['info'] = 'Diupdate';
			echo "<script>document.location.href='../data-produk-ecat.php'</script>";
		}
    // Hapus 
	}elseif(isset($_POST['hapus-produk-reg'])){
		$idh = base64_decode($_POST['id_produk']);

		// Mengambil nama gambar yang terkait
		$sql = "SELECT 
					pr.id_produk_reg, pr.gambar, qr.id_produk_qr, qr.qr_img 
				FROM tb_produk_reguler AS pr
				LEFT JOIN qr_link qr ON (pr.id_produk_reg = qr.id_produk_qr)
				WHERE id_produk_reg = '$idh'";

		// Membuat prepared statement
		$query = mysqli_query($connect, $sql);
		$row = mysqli_fetch_array($query);
		$gambar = $row['gambar'];
		$gambar_qr = $row['qr_img'];

		try {
			// Memulai transaksi
			mysqli_begin_transaction($connect);

			// Menghapus data dari tabel tb_produk_reguler
			$sql_delete_produk = "DELETE FROM tb_produk_reguler WHERE id_produk_reg = '$idh'";
			$stmt_delete_produk = mysqli_query($connect, $sql_delete_produk);

			$sql_delete_produk = "DELETE FROM stock_produk_reguler WHERE id_produk_reg = '$idh'";
			$stmt_delete_stock = mysqli_query($connect, $sql_delete_produk);


			// Menghapus data dari tabel qr_link
			$sql_delete_qr = "DELETE FROM qr_link WHERE id_produk_qr = '$idh'";
			$stmt_delete_qr = mysqli_query($connect, $sql_delete_qr);

			// Menjalankan penghapusan
			if ($stmt_delete_produk && $stmt_delete_qr && $stmt_delete_stock) {
				// Hapus gambar terkait
				unlink("../gambar/upload-produk-reg/$gambar");
				unlink("../gambar/QRcode/$gambar_qr");

				// Commit transaksi
				mysqli_commit($connect);

				$_SESSION['info'] = 'Dihapus';
				echo "<script>document.location.href='../data-produk-reg.php'</script>";
			} else {
				// Rollback transaksi jika ada kesalahan
				mysqli_rollback($connect);

				$_SESSION['info'] = 'Data Gagal Dihapus';
				echo "<script>document.location.href='../data-produk-reg.php'</script>";
			}
		} catch (Exception $e) {
			// Tangani pengecualian di sini, misalnya:
			$_SESSION['info'] = 'Terjadi kesalahan: ' . $e->getMessage();
			echo "<script>document.location.href='../data-produk-reg.php'</script>";
		}
    // Hapus Ecat
	}elseif(isset($_POST['hapus-produk-ecat'])){
		$idh = base64_decode($_POST['id_produk']);

		// Mengambil nama gambar yang terkait
		$sql = "SELECT 
					pr.id_produk_ecat, pr.gambar, qr.id_produk_qr, qr.qr_img 
				FROM tb_produk_ecat AS pr
				LEFT JOIN qr_link_ecat qr ON (pr.id_produk_ecat = qr.id_produk_qr)
				WHERE id_produk_ecat = '$idh'";

		// Membuat prepared statement
		$query = mysqli_query($connect, $sql);
		$row = mysqli_fetch_array($query);
		$gambar = $row['gambar'];
		$gambar_qr = $row['qr_img'];

		try {
			// Memulai transaksi
			mysqli_begin_transaction($connect);

			// Menghapus data dari tabel tb_produk_reguler
			$sql_delete_produk = "DELETE FROM tb_produk_ecat WHERE id_produk_ecat = '$idh'";
			$stmt_delete_produk = mysqli_query($connect, $sql_delete_produk);

			// Menghapus data dari tabel tb_produk_reguler
			$sql_delete_produk = "DELETE FROM stock_produk_ecat WHERE id_produk_ecat = '$idh'";
			$stmt_delete_stock = mysqli_query($connect, $sql_delete_produk);


			// Menghapus data dari tabel qr_link
			$sql_delete_qr = "DELETE FROM qr_link_ecat WHERE id_produk_qr = '$idh'";
			$stmt_delete_qr = mysqli_query($connect, $sql_delete_qr);

			// Menjalankan penghapusan
			if ($stmt_delete_produk && $stmt_delete_qr && $stmt_delete_stock) {
				// Hapus gambar terkait
				unlink("../gambar/upload-produk-ecat/$gambar");
				unlink("../gambar/QRcode-ecat/$gambar_qr");

				// Commit transaksi
				mysqli_commit($connect);

				$_SESSION['info'] = 'Dihapus';
				echo "<script>document.location.href='../data-produk-ecat.php'</script>";
			} else {
				// Rollback transaksi jika ada kesalahan
				mysqli_rollback($connect);

				$_SESSION['info'] = 'Data Gagal Dihapus';
				echo "<script>document.location.href='../data-produk-ecat.php'</script>";
			}
		} catch (Exception $e) {
			// Tangani pengecualian di sini, misalnya:
			$_SESSION['info'] = 'Terjadi kesalahan: ' . $e->getMessage();
			echo "<script>document.location.href='../data-produk-ecat.php'</script>";
		}
	}
