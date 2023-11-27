<?php
session_start(); // memulai sebuah sesi

$UUID = 'HIS' . generate_uuid();
$encoded_id = base64_encode($UUID);
// Menampilkan IP, Jenis Perangkat, Lokasi
$ip_address = $_SERVER['REMOTE_ADDR'];
$os = $_SERVER['HTTP_USER_AGENT'];

$device = "Desktop";
if (preg_match("/(iPhone|iPod|iPad|Android|BlackBerry|Windows Phone)/i", $os)) {
    $device = "Mobile";
}
echo "Jenis Perangkat: $device";

// Menampilkan Lokasi
$url = 'http://ip-api.com/json/' . $ip_address;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$result = curl_exec($ch);
curl_close($ch);

$location = json_decode($result);


$url = 'http://ip-api.com/json/' . $ip_address;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$result = curl_exec($ch);
curl_close($ch);

$location = json_decode($result);
$locationString = json_encode($location);
$locationString = '';
$locationString .= $location->city . ',' . $location->country . PHP_EOL;

// ============================================================================
include "koneksi.php";

if (isset($_POST['login'])) {
    // Ambil data dari formulir login
    $username = mysqli_real_escape_string($connect, $_POST['username']);
    $password = mysqli_real_escape_string($connect, $_POST['password']);

    // Query untuk mencari data user dari database
    $query = "SELECT * FROM user 
            --   JOIN user_history ON (user_history.id_user = user.id_user) 
              WHERE username = '$username'";
    $result = mysqli_query($connect, $query);

    // Periksa apakah username ditemukan
    if (mysqli_num_rows($result) == 1) {
        // Ambil data password dari database
        $row = mysqli_fetch_assoc($result);
        $password_hash = $row['password'];

        // Verifikasi password
        if (password_verify($password, $password_hash)) {
            // Password benar, simpan data user ke session dan arahkan ke halaman dashboard
            //ambil data dari nama kolom operator
            $_SESSION['tiket_id'] = $row['id_user'];
            $_SESSION['tiket_user'] = $row['username'];
            $_SESSION['tiket_pass'] = $row['password'];
            $_SESSION['tiket_nama'] = $row['nama_user'];
            $_SESSION['tiket_role'] = $row['id_user_role'];
            $_SESSION['tiket_jenkel'] = $row['jenkel'];
            $_SESSION['ip'] = $ip_address;
            $_SESSION['last_login'] = $row['last_login'];
            $_SESSION['os'] = $row['perangkat'];
            $_SESSION['lokasi'] = $row['lokasi'];
            $_SESSION['encoded_id'] = $encoded_id;
            $id_role =  $_SESSION['tiket_role'];


            // Update User Login Session
            $id_history =  $_SESSION['encoded_id'];
            $id_user = $_SESSION['tiket_id'];
            $online = 'Online';
            $timezone = time() + (60 * 60 * 7);
            $today = gmdate('d/m/Y G:i:s', $timezone);

            // Simpan History
            $history = mysqli_query($connect, "INSERT INTO user_history 
                                        (id_history, id_user, login_time, ip_login, perangkat, jenis_perangkat, lokasi, status_perangkat) 
                                        VALUES 
                                        ('$UUID', '$id_user', '$today', '$ip_address', '$os', '$device', '$locationString', '$online')");
            
            $sql_role = " SELECT u.id_user_role, d.id_user_role, d.role FROM user AS u 
                            JOIN user_role AS d ON (u.id_user_role = d.id_user_role)
                            WHERE u.id_user_role = '$id_role'";
             $query_role = mysqli_query($connect, $sql_role) or die(mysqli_error($connect));
             $data_role = mysqli_fetch_array($query_role);
             $role = $data_role['role']; 
             echo $role;
            if($role == 'Finance'){
                header("Location: finance/dashboard.php");
            } else if ($role == 'Driver'){
                header("Location: driver/dashboard.php");
            } else if ($role == 'Admin Gudang'){
                header("Location: gudang/dashboard.php");
            } else {
                header("Location: dashboard.php");
            }
        } else {
            // Password salah, kembali ke halaman login
            header("Location: login.php?gagal");
        }
    } else {
        // Username tidak ditemukan, kembali ke halaman login
        header("Location: login.php?gagal");
    }
}

// <!-- Generate UUID -->

function generate_uuid()
{
    return sprintf(
        '%04x%04x%04x',
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0x0fff) | 0x4000,
        mt_rand(0, 0x3fff) | 0x8000,
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff)
    );
}
// <!-- End Generate UUID -->
