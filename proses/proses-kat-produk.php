<?php
session_start();
include "../koneksi.php";

// Simpan
if (isset($_POST["simpan-kat-produk"])) {
	$id_kat_produk = $_POST['id_kat_produk'];
	$id_user = $_POST['id_user'];
	$nama_kategori = $_POST['nama_kat_produk'];
	$merk = $_POST['merk'];
	$nie = $_POST['nie'];
	$created = $_POST['created'];
	$user_created = $_POST['user_created'];

	$cek_kat = mysqli_query($connect, "SELECT nama_kategori FROM tb_kat_produk WHERE nama_kategori = '$nama_kategori' AND id_merk = '$merk'");

	if ($cek_kat->num_rows > 0) {
		$_SESSION['info'] = 'Data sudah ada';
		echo "<script>document.location.href='../kategori-produk.php'</script>";
	} else {
		mysqli_query($connect, "INSERT INTO tb_kat_produk
                      (id_kat_produk, id_user, nama_kategori, id_merk, no_izin_edar, created_date) 
                      VALUES 
                      ('$id_kat_produk', '$id_user', '$nama_kategori', '$merk', '$nie', '$created')");

		$_SESSION['info'] = 'Disimpan';
		echo "<script>document.location.href='../kategori-produk.php'</script>";
	}

	//Edit
} elseif (isset($_POST["edit-kat-produk"])) {
	$id_kat_produk = $_POST['id_kat_produk'];
	$nama_kategori = $_POST['nama_kat_produk'];
	$merk = $_POST['merk'];
	$nie = $_POST['no_izin_edar'];
	$updated = $_POST['updated'];
	$user_updated = $_POST['user_updated'];

	// menampilkan data
	$query = "SELECT * FROM tb_kat_produk WHERE id_kat_produk = '$id_kat_produk'";
	$result = mysqli_query($connect, $query);
	$data_lama = mysqli_fetch_assoc($result);

	if ($data_lama['nama_kategori'] == $nama_kategori) {
		// Nama Kategori tidak di ubah dan NIE di ubah, simpan data
		$update = mysqli_query($connect, "UPDATE tb_kat_produk 
			SET
			nama_kategori = '$nama_kategori',
			id_merk = '$merk',
			no_izin_edar = '$nie',
			updated_date = '$updated',
			user_updated = '$user_updated'	
			WHERE id_kat_produk='$id_kat_produk'");
		$_SESSION['info'] = 'No Izin Edar Berhasil Diubah';
		echo "<script>document.location.href='../kategori-produk.php'</script>";
	} else {
		// Nama berubah, cek apakah ada nama yang sama di database
		$cek_kat = mysqli_query($connect, "SELECT nama_kategori FROM tb_kat_produk WHERE nama_kategori = '$nama_kategori'");

		if ($cek_kat->num_rows > 0) {
			// Ada nama yang sama di database, tampilkan pesan error
			$_SESSION['info'] = 'Nama kategori sudah ada';
			echo "<script>document.location.href='../kategori-produk.php'</script>";
		} else {
			// Nama belum digunakan, simpan data
			$update = mysqli_query($connect, "UPDATE tb_kat_produk 
	                SET
					nama_kategori = '$nama_kategori',
					id_merk = '$merk',
					no_izin_edar = '$nie',
					updated_date = '$updated',
					user_updated = '$user_updated'
	                WHERE id_kat_produk='$id_kat_produk'");

			$_SESSION['info'] = 'Diupdate';
			echo "<script>document.location.href='../kategori-produk.php'</script>";
		}
	}

	// Hapus 
} elseif ($_GET['hapus-kat-produk']) {
	//tangkap URL dengan $_GET
	$idh = $_GET['hapus-kat-produk'];
	$id_kat = base64_decode($idh);

	// perintah queery sql untuk hapus data
	$sql = "DELETE FROM tb_kat_produk WHERE id_kat_produk='$id_kat'";
	$query_del = mysqli_query($connect, $sql) or die(mysqli_error($connect));

	if ($query_del) {
		$_SESSION['info'] = 'Dihapus';
		echo "<script>document.location.href='../kategori-produk.php'</script>";
	} else {
		$_SESSION['info'] = 'Data Gagal Dihapus';
		echo "<script>document.location.href='../kategori-produk.php'</script>";
	}
}
