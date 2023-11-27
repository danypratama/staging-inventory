<?php
session_start();
include "../koneksi.php";

if (isset($_POST["simpan-cs"])) {
	$id_cs = $_POST['id_cs'];
	$nama_cs = $_POST['nama_cs'];
	$alamat = $connect->real_escape_string($_POST['alamat_cs']);
	$telp = $_POST['telp_cs'];
	$email = $_POST['email'];
    $user = $_SESSION['tiket_nama'];
  
	$cek_cs = mysqli_query($connect, "SELECT nama_cs FROM tb_customer_sph WHERE nama_cs = '$nama_cs'");
  
	if ($cek_cs->num_rows > 0) {
	  $_SESSION['info'] = 'Data Gagal Disimpan';
	  header("Location:../data-customer-sph.php");
	} else {
		// Membuat folder baru
		$simpan_cs = mysqli_query($connect, "INSERT INTO tb_customer_sph
							(id_cs, nama_cs, alamat, no_telp, email, created_by) 
                            VALUES 
                            ('$id_cs', '$nama_cs', '$alamat', '$telp', '$email', '$user')");
		
		// Data hasil
		$result = array(
			'query' => true
		);

		// Mengonversi data ke format JSON
		$json_result = json_encode($result);

		// Menampilkan hasil JSON ke console log browser
		echo "<script>";
		echo "console.log(" . $json_result . ");";
		echo "</script>";
	
		$_SESSION['info'] = 'Disimpan';
		echo "<script>document.location.href='../data-customer-sph.php'</script>";
	}

	//Edit
} elseif (isset($_POST["edit-cs"])) {
	$id_cs = $_POST['id_cs'];
	$nama_cs = $_POST['nama_cs'];
	$alamat = $connect->real_escape_string($_POST['alamat_cs']);
	$telp = $_POST['telp_cs'];
	$email = $_POST['email'];
	$updated = $_POST['updated'];
    $user = $_SESSION['tiket_nama'];

	// menampilkan data
	$query = "SELECT * FROM tb_customer_sph WHERE id_cs = '$id_cs'";
	$result = mysqli_query($connect, $query);
	$data_lama = mysqli_fetch_assoc($result);

	if ($data_lama['nama_cs'] == $nama_cs) {
		// Nama tidak berubah, simpan data langsung
		$update = mysqli_query($connect, "UPDATE tb_customer_sph
	                SET
					nama_cs = '$nama_cs',
					alamat = '$alamat',
					no_telp = '$telp',
                    email = '$email',
					updated_date = '$updated',
                    updated_by = '$user'
	                WHERE id_cs='$id_cs'");
		$_SESSION['info'] = 'Disimpan';
		echo "<script>document.location.href='../data-customer-sph.php'</script>";
	} else {
		// Nama berubah, cek apakah ada nama yang sama di database
		$cek_cs = mysqli_query($connect, "SELECT nama_cs FROM tb_customer_sph WHERE nama_cs = '$nama_cs'");

		if ($cek_cs->num_rows > 0) {
			// Ada nama yang sama di database, tampilkan pesan error
			$_SESSION['info'] = 'Nama customer sudah ada';
			echo "<script>document.location.href='../data-customer_sph.php'</script>";
		} else {
			// Nama belum digunakan, simpan data
			$update = mysqli_query($connect, "UPDATE tb_customer_sph 
							SET
							nama_cs = '$nama_cs',
							alamat = '$alamat',
							no_telp = '$telp',
							email = '$email',
							updated_date = '$updated',
                            updated_by = '$user'
							WHERE id_cs='$id_cs'");

			$_SESSION['info'] = 'Diupdate';
			echo "<script>document.location.href='../data-customer-sph.php'</script>";
		}
	}

	// Hapus
} elseif ($_GET['hapus-cs']) {
	//tangkap URL dengan $_GET
	$idh = $_GET['hapus-cs'];
	$id_cs = base64_decode($idh);
    
	// perintah queery sql untuk hapus data
	$sql = "DELETE FROM tb_customer_sph WHERE id_cs='$id_cs'";
	$query_del = mysqli_query($connect, $sql) or die(mysqli_error($connect));


	if ($query_del) {
		$_SESSION['info'] = 'Dihapus';
		echo "<script>document.location.href='../data-customer-sph.php'</script>";
	} else {
		$_SESSION['info'] = 'Data Gagal Dihapus';
		echo "<script>document.location.href='../data-customer-sph.php'</script>";
	}
}