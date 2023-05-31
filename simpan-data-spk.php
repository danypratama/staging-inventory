<?php
// simpan_data.php
include "koneksi.php";
// Ambil ID dari permintaan Ajax
$id = $_POST['id'];
$spk = trim($_POST['spk']);

// Simpan data ke dalam database
// Lakukan operasi database sesuai dengan kebutuhan aplikasi Anda

// Contoh koneksi ke database dan penyimpanan data

// Lakukan operasi penyimpanan ke database sesuai dengan tabel dan struktur database Anda
$sql = mysqli_query($connect, "INSERT INTO tmp_produk_spk (id_spk, id_produk) VALUES ('$spk', '$id')");

if (mysqli_query($koneksi, $sql)) {
    echo 'Data berhasil disimpan.';
} else {
    echo 'Terjadi kesalahan saat menyimpan data: ' . mysqli_error($koneksi);
}
