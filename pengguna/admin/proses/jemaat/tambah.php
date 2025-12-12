<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari formulir HTML
$id_rayon = $_POST['id_rayon'];
$nama_lengkap = $_POST['nama_lengkap'];
$username = $_POST['username'];
$password = $_POST['password'];
$jenis_kelamin = $_POST['jenis_kelamin'];
$status_keluarga = $_POST['status_keluarga'];
$tempat_lahir = $_POST['tempat_lahir'];
$tanggal_lahir = $_POST['tanggal_lahir'];

// Lakukan validasi data
if (empty($id_rayon) || empty($nama_lengkap) || empty($username) || empty($password) || empty($jenis_kelamin) || empty($status_keluarga) || empty($tempat_lahir) || empty($tanggal_lahir)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk menambahkan data masyarakat ke dalam database
$query = "INSERT INTO jemaat (id_rayon, nama_lengkap, username, password, jenis_kelamin, status_keluarga, tempat_lahir, tanggal_lahir)
        VALUES ('$id_rayon', '$nama_lengkap', '$username', '$password', '$jenis_kelamin', '$status_keluarga', '$tempat_lahir', '$tanggal_lahir')";

// Jalankan query
if (mysqli_query($koneksi, $query)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
