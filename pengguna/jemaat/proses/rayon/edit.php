<?php
include '../../../../keamanan/koneksi.php';

$id_rayon = $_POST['id_rayon']; // Pastikan ID pendeta dikirim untuk proses update
$nama_rayon = $_POST['nama_rayon'];
$id_majelis = $_POST['id_majelis'];
$alamat = $_POST['alamat'];
// Lakukan validasi data
if (empty($nama_rayon) || empty($id_majelis) || empty($alamat)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk mengedit data kepsek yang sudah ada berdasarkan id_kepsek
$query = "UPDATE rayon 
            SET nama_rayon = '$nama_rayon', 
                id_majelis = '$id_majelis', 
                alamat = '$alamat'
          WHERE id_rayon = '$id_rayon'";

// Jalankan query
if (mysqli_query($koneksi, $query)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
