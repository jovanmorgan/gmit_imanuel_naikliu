<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari formulir HTML
$nama_lengkap = $_POST['nama_lengkap'];
$username = $_POST['username'];
$password = $_POST['password'];
$jenis_kelamin = $_POST['jenis_kelamin'];
$tempat_lahir = $_POST['tempat_lahir'];
$tanggal_lahir = $_POST['tanggal_lahir'];

// Lakukan validasi data
if (empty($nama_lengkap) || empty($username) || empty($password) || empty($jenis_kelamin) || empty($tempat_lahir) || empty($tanggal_lahir) || empty($jenis_kelamin)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk menambahkan data masyarakat ke dalam database
$query = "INSERT INTO majelis (nama_lengkap, username, password, tempat_lahir, tanggal_lahir, jenis_kelamin)
        VALUES ('$nama_lengkap', '$username', '$password', '$tempat_lahir', '$tanggal_lahir', '$jenis_kelamin')";

// Jalankan query
if (mysqli_query($koneksi, $query)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
