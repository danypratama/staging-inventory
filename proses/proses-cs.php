<?php
session_start();
include "../koneksi.php";

// Simpan
if (isset($_POST["simpan-cs"])) {
	$id_cs = $_POST['id_cs'];
	$nama_cs = $_POST['nama_cs'];
	$alamat = $_POST['alamat_cs'];
	$telp = $_POST['telp_cs'];
	$email = $_POST['email'];
	$created = $_POST['created'];

	$cek_cs = mysqli_query($connect, "SELECT nama_cs FROM tb_customer WHERE nama_cs = '$nama_cs'");

	if ($cek_cs->num_rows > 0) {
		$_SESSION['info'] = 'Data Gagal Disimpan';
		echo "<script>document.location.href='../data-customer.php'</script>";
	} else {
		mysqli_query($connect, "INSERT INTO tb_customer
                      (id_cs, nama_cs, alamat, no_telp, email, created_date) VALUES ('$id_cs', '$nama_cs', '$alamat', '$telp', '$email', '$created')");

		$_SESSION['info'] = 'Disimpan';
		echo "<script>document.location.href='../data-customer.php'</script>";
	}

	//Edit
} elseif (isset($_POST["edit-cs"])) {
	$id_cs = $_POST['id_cs'];
	$nama_cs = $_POST['nama_cs'];
	$alamat = $_POST['alamat_cs'];
	$telp = $_POST['telp_cs'];
	$email = $_POST['email'];
	$updated = $_POST['updated'];

	// menampilkan data
	$query = "SELECT * FROM tb_customer WHERE id_cs = '$id_cs'";
	$result = mysqli_query($connect, $query);
	$data_lama = mysqli_fetch_assoc($result);

	if ($data_lama['nama_cs'] == $nama_cs) {
		// Nama tidak berubah, simpan data langsung
		$update = mysqli_query($connect, "UPDATE tb_customer 
	                SET
					nama_cs = '$nama_cs',
					alamat = '$alamat',
					no_telp = '$telp',
                    email = '$email',
					updated_date = '$updated'
	                WHERE id_cs='$id_cs'");
		$_SESSION['info'] = 'Disimpan';
		echo "<script>document.location.href='../data-customer.php'</script>";
	} else {
		// Nama berubah, cek apakah ada nama yang sama di database
		$cek_cs = mysqli_query($connect, "SELECT nama_cs FROM tb_customer WHERE nama_cs = '$nama_cs'");

		if ($cek_cs->num_rows > 0) {
			// Ada nama yang sama di database, tampilkan pesan error
			$_SESSION['info'] = 'Nama customer sudah ada';
			echo "<script>document.location.href='../data-customer.php'</script>";
		} else {
			// Nama belum digunakan, simpan data
			$update = mysqli_query($connect, "UPDATE tb_customer 
							SET
							nama_cs = '$nama_cs',
							alamat = '$alamat',
							no_telp = '$telp',
							email = '$email',
							updated_date = '$updated'
							WHERE id_cs='$id_cs'");

			$_SESSION['info'] = 'Diupdate';
			echo "<script>document.location.href='../data-customer.php'</script>";
		}
	}

	// Hapus
} elseif ($_GET['hapus-cs']) {
	//tangkap URL dengan $_GET
	$idh = $_GET['hapus-cs'];
	$id_cs = base64_decode($idh);

	// perintah queery sql untuk hapus data
	$sql = "DELETE FROM tb_customer WHERE id_cs='$id_cs'";
	$query_del = mysqli_query($connect, $sql) or die(mysqli_error($connect));


	if ($query_del) {
		$_SESSION['info'] = 'Dihapus';
		echo "<script>document.location.href='../data-customer.php'</script>";
	} else {
		$_SESSION['info'] = 'Data Gagal Dihapus';
		echo "<script>document.location.href='../data-customer.php'</script>";
	}
}
