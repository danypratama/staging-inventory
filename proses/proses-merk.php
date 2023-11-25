<?php
session_start();
include "../koneksi.php";
// Simpan
if (isset($_POST["simpan-merk"])) {
	$id_merk = $_POST['id_merk'];
	$id_user = $_POST['id_user'];
	$nama_merk = $_POST['nama_merk'];
	$created = $_POST['created'];

	$cek_kat = mysqli_query($connect, "SELECT nama_merk FROM tb_merk WHERE nama_merk = '$nama_merk'");

	if ($cek_kat->num_rows > 0) {
		$_SESSION['info'] = 'Nama merk sudah ada';
		echo "<script>document.location.href='../merk-produk.php'</script>";
	} else {
		mysqli_query($connect, "INSERT INTO tb_merk
                      (id_merk, id_user, nama_merk, created_date) 
                      VALUES 
                      ('$id_merk', '$id_user', '$nama_merk', '$created')");

		$_SESSION['info'] = 'Disimpan';
		echo "<script>document.location.href='../merk-produk.php'</script>";
	}

	//Edit
} elseif (isset($_POST["edit-merk"])) {
	$id_merk = $_POST['id_merk'];
	$nama_merk = $_POST['nama_merk'];

	// menampilkan data
	$query = "SELECT * FROM tb_merk WHERE id_merk = '$id_merk'";
	$result = mysqli_query($connect, $query);
	$data_lama = mysqli_fetch_assoc($result);

	if ($data_lama['nama_merk'] == $nama_merk) {
		// Nama tidak berubah, simpan data langsung
		$update = mysqli_query($connect, "UPDATE tb_merk
	                SET
					nama_merk = '$nama_merk'
	                WHERE  id_merk='$id_merk'");
		$_SESSION['info'] = 'Tidak Ada Perubahan Data';
		echo "<script>document.location.href='../merk-produk.php'</script>";
	} else {
		// Nama berubah, cek apakah ada nama yang sama di database
		$cek_kat = mysqli_query($connect, "SELECT nama_merk FROM  tb_merk WHERE nama_merk = '$nama_merk'");

		if ($cek_kat->num_rows > 0) {
			// Ada nama yang sama di database, tampilkan pesan error
			$_SESSION['info'] = 'Nama merk sudah ada';
			echo "<script>document.location.href='../merk-produk.php'</script>";
		} else {
			// Nama belum digunakan, simpan data
			$update = mysqli_query($connect, "UPDATE tb_merk 
	                SET
					nama_merk = '$nama_merk'
	                WHERE  id_merk='$id_merk'");

			$_SESSION['info'] = 'Diupdate';
			echo "<script>document.location.href='../merk-produk.php'</script>";
		}
	}

	// Hapus 
} elseif ($_GET['hapus-merk']) {
	//tangkap URL dengan $_GET
	$idh = base64_decode($_GET['hapus-merk']);

	// perintah queery sql untuk hapus data
	$sql = "DELETE FROM  tb_merk WHERE  id_merk='$idh'";
	$query_del = mysqli_query($connect, $sql) or die(mysqli_error($connect));

	if ($query_del) {
		$_SESSION['info'] = 'Dihapus';
		echo "<script>document.location.href='../merk-produk.php'</script>";
	} else {
		$_SESSION['info'] = 'Data Gagal Dihapus';
		echo "<script>document.location.href='../merk-produk.php'</script>";
	}
}
