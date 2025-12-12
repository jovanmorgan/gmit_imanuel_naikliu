<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari formulir HTML
$nama_rayon = $_POST['nama_rayon'];
$id_majelis = $_POST['id_majelis'];
$alamat = $_POST['alamat'];
// Lakukan validasi data
if (empty($nama_rayon) || empty($id_majelis) || empty($alamat)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk menambahkan data masyarakat ke dalam database
$query = "INSERT INTO rayon (nama_rayon, id_majelis, alamat)
        VALUES ('$nama_rayon', '$id_majelis', '$alamat')";

// Jalankan query
if (mysqli_query($koneksi, $query)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);