<?php
include '../../../../keamanan/koneksi.php';

$id_jemaat = $_POST['id_jemaat'];
$id_rayon = $_POST['id_rayon'];
$nama_lengkap = $_POST['nama_lengkap'];
$username = $_POST['username'];
$password = $_POST['password'];
$jenis_kelamin = $_POST['jenis_kelamin'];
$status_keluarga = $_POST['status_keluarga'];
$tempat_lahir = $_POST['tempat_lahir'];
$tanggal_lahir = $_POST['tanggal_lahir'];

// Lakukan validasi data
if (empty($id_jemaat) || empty($id_rayon) || empty($nama_lengkap) || empty($username) || empty($password) || empty($jenis_kelamin) || empty($status_keluarga) || empty($tempat_lahir) || empty($tanggal_lahir)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk mengedit data kepsek yang sudah ada berdasarkan id_kepsek
$query = "UPDATE jemaat 
            SET id_rayon = '$id_rayon', 
                nama_lengkap = '$nama_lengkap', 
                username = '$username', 
                password = '$password', 
                jenis_kelamin = '$jenis_kelamin', 
                status_keluarga = '$status_keluarga', 
                tempat_lahir = '$tempat_lahir', 
                tanggal_lahir = '$tanggal_lahir'
          WHERE id_jemaat = '$id_jemaat'";

// Jalankan query
if (mysqli_query($koneksi, $query)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
