<?php
include '../../../../keamanan/koneksi.php';

$id_majelis = $_POST['id_majelis']; // Pastikan ID majelis dikirim untuk proses update
$nama_lengkap = $_POST['nama_lengkap'];
$username = $_POST['username'];
$password = $_POST['password'];
$jenis_kelamin = $_POST['jenis_kelamin'];
$tempat_lahir = $_POST['tempat_lahir'];
$tanggal_lahir = $_POST['tanggal_lahir'];
$jenis_kelamin = $_POST['jenis_kelamin'];
// Lakukan validasi data
if (empty($id_majelis) || empty($nama_lengkap) || empty($username) || empty($password) || empty($jenis_kelamin) || empty($tempat_lahir) || empty($tanggal_lahir) || empty($jenis_kelamin)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk mengedit data kepsek yang sudah ada berdasarkan id_kepsek
$query = "UPDATE majelis 
            SET nama_lengkap = '$nama_lengkap',
                username = '$username',
                password = '$password',
                jenis_kelamin = '$jenis_kelamin',
                tempat_lahir = '$tempat_lahir',
                tanggal_lahir = '$tanggal_lahir',
                jenis_kelamin = '$jenis_kelamin'
          WHERE id_majelis = '$id_majelis'";

// Jalankan query
if (mysqli_query($koneksi, $query)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);