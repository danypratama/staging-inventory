<?php
session_start();
include "../koneksi.php";

if (isset($_POST["simpan-cs"])) {
	$id_cs = $_POST['id_cs'];
	$jenis_usaha = $_POST['jenis_usaha'];
	$nama_cs = $_POST['nama_cs'];
	$alamat = $connect->real_escape_string($_POST['alamat_cs']);
	$nama_cp = $_POST['nama_cp'];
	$telp = $_POST['telp_cs'];
	$email = $_POST['email'];
	$npwp = $_POST['npwp'];
	$created = $_POST['created'];
	$created_by = $_SESSION['tiket_id'];
  
	$cek_cs = mysqli_query($connect, "SELECT nama_cs FROM tb_customer WHERE nama_cs = '$nama_cs'");
  
	if ($cek_cs->num_rows > 0) {
	  $_SESSION['info'] = 'Data Gagal Disimpan';
	  header("Location:../data-customer.php");
	} else {
		// Membuat folder baru
		$path = "../Customer/".$nama_cs;
		mkdir($path, 0777, true);
		$simpan_cs = mysqli_query($connect, "INSERT INTO tb_customer
							(id_cs, jenis_usaha, nama_cs, alamat, nama_cp, no_telp, email, npwp, created_date, created_by) VALUES ('$id_cs', '$jenis_usaha', '$nama_cs', '$alamat', '$nama_cp', '$telp', '$email', '$npwp', '$created', '$created_by')");
		
		// Data hasil
		$result = array(
			'query' => true
		);

		// Mengonversi data ke format JSON
		$json_result = json_encode($result);

		// Menampilkan hasil JSON ke console log browser
		$_SESSION['info'] = 'Disimpan';
		echo "<script>document.location.href='../data-customer.php'</script>";
	}

	//Edit
} elseif (isset($_POST["edit-cs"])) {
	$id_cs = $_POST['id_cs'];
	$jenis_usaha = $_POST['jenis_usaha'];
	$nama_cs = $_POST['nama_cs'];
	$alamat = $connect->real_escape_string($_POST['alamat_cs']);
	$nama_cp = $_POST['nama_cp'];
	$telp = $_POST['telp_cs'];
	$email = $_POST['email'];
	$npwp = $_POST['npwp'];
	$updated = $_POST['updated'];
	$updated_by = $_SESSION['tiket_id'];

	// menampilkan data
	$query = "SELECT * FROM tb_customer WHERE id_cs = '$id_cs'";
	$result = mysqli_query($connect, $query);
	$data_lama = mysqli_fetch_array($result);

	if ($data_lama['nama_cs'] == $nama_cs) {
		// Nama tidak berubah, simpan data langsung
		$update = mysqli_query($connect, "UPDATE tb_customer 
	                SET
					jenis_usaha = '$jenis_usaha',
					nama_cs = '$nama_cs', 
					alamat = '$alamat',
					nama_cp = '$nama_cp',
					no_telp = '$telp',
                    email = '$email',
					npwp = '$npwp',
					updated_date = '$updated',
					updated_by = '$updated_by'
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
							jenis_usaha = '$jenis_usaha',
							nama_cs = '$nama_cs',
							alamat = '$alamat',
							nama_cp = '$nama_cp',
							no_telp = '$telp',
							email = '$email',
							npwp = '$npwp',
							updated_date = '$updated',
							updated_by = '$updated_by'
							WHERE id_cs = '$id_cs'");

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