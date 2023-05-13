<?php
session_start();
include "../koneksi.php";

// Simpan
if (isset($_POST["simpan-grade-produk"])) {
	$id_grade = $_POST['id_grade'];
	$grade = $_POST['grade'];
	$id_user = $_POST['id_user'];
	$created = $_POST['created'];

	$cek_grade = mysqli_query($connect, "SELECT * FROM tb_produk_grade WHERE nama_grade = '$grade'");

	if ($cek_grade->num_rows > 0) {
		$_SESSION['info'] = 'Data sudah ada';
		echo "<script>document.location.href='../grade-produk.php'</script>";
	} else {
		mysqli_query($connect, "INSERT INTO tb_produk_grade
                      (id_grade, id_user, nama_grade, created_date) 
                      VALUES 
                      ('$id_grade', '$id_user', '$grade', '$created')");

		$_SESSION['info'] = 'Disimpan';
		echo "<script>document.location.href='../grade-produk.php'</script>";
	}

	//Edit
} elseif (isset($_POST["edit-grade-produk"])) {
	$id_grade = $_POST['id_grade'];
	$grade = $_POST['grade'];

	// cek data sebelum update
	$cek_grade = mysqli_query($connect, "SELECT * FROM tb_produk_grade WHERE nama_grade = '$grade'");

	if ($cek_grade->num_rows > 0) {
		// Ada nama yang sama di database, tampilkan pesan error
		$_SESSION['info'] = 'Data sudah ada';
		echo "<script>document.location.href='../grade-produk.php'</script>";
	} else {
		// Data belum ada, simpan data
		$update = mysqli_query($connect, "UPDATE tb_produk_grade 
				SET
				nama_grade = '$grade'
				WHERE id_grade='$id_grade'");

		$_SESSION['info'] = 'Diupdate';
		echo "<script>document.location.href='../grade-produk.php'</script>";
	}

	// Hapus 
} elseif ($_GET['hapus-grade-produk']) {
	//tangkap URL dengan $_GET
	$idh = base64_decode($_GET['hapus-grade-produk']);

	// perintah queery sql untuk hapus data
	$sql = "DELETE FROM tb_produk_grade WHERE id_grade ='$idh'";
	$query_del = mysqli_query($connect, $sql) or die(mysqli_error($connect));

	if ($query_del) {
		$_SESSION['info'] = 'Dihapus';
		echo "<script>document.location.href='../grade-produk.php'</script>";
	} else {
		$_SESSION['info'] = 'Data Gagal Dihapus';
		echo "<script>document.location.href='../grade-produk.php'</script>";
	}
}
