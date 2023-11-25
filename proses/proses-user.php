<?php 
	session_start();
	include "../koneksi.php";

	// Simpan
	if (isset($_POST["simpan-user"])) {
		$id_user = $_POST['id_user'];
		$nama_lengkap = $_POST['nama_lengkap'];
        $jenkel = $_POST['jenkel'];
        $email = $_POST['email'];
        $id_role = $_POST['role'];
        $username = $_POST['username'];
        $password = $_POST['password'];
		$created = $_POST['created'];

        // Hash password
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

		$cek_user = mysqli_query($connect, "SELECT username, email FROM user WHERE username = '$username' OR email = '$email' ");

		if ($cek_user->num_rows > 0) {
            echo "error";
			header("Location: ../registrasi-user.php?gagal");
		}else{
			mysqli_query($connect, "INSERT INTO user 
                      (id_user, nama_user, jenkel, email, id_user_role, username, password, created_date) 
                      VALUES 
                      ('$id_user', '$nama_lengkap', '$jenkel', '$email', '$id_role', '$username', '$password_hash', '$created')");

			echo "success";
			header("Location: ../registrasi-user.php");
		}

	//Edit 
	}elseif(isset($_POST["edit-user"])) {
		$id_update = $_POST['id_user_role'];
		$hak_akses = $_POST['role'];
		$update = mysqli_query($connect, "UPDATE user_role 
	                SET
	                role ='$hak_akses'
	                WHERE id_user_role='$id_update'");
    if($update){
            $_SESSION['info'] = 'Diupdate';
            echo "<script>document.location.href='../data-user-role.php'</script>";
        } else {
            $_SESSION['info'] = 'Data Gagal Diupdate';
            echo "<script>document.location.href='../data-user-role.php'</script>";
        }

    // Hapus
	}elseif($_GET['hapus-user']){
		//tangkap URL dengan $_GET
	    $idh = $_GET['hapus-user'];

	    // perintah queery sql untuk hapus data
	    $sql = "DELETE FROM user WHERE id_user='$idh'";
	    $query_del = mysqli_query($connect,$sql) or die (mysqli_error($connect));

	    if($query_del){
	        $_SESSION['info'] = 'Dihapus';
	        echo "<script>document.location.href='../data-user.php'</script>";
	    }else{
	        $_SESSION['info'] = 'Data Gagal Dihapus';
	        echo "<script>document.location.href='../data-user.php'</script>";
	    }
	}
?>