<?php
include '../../../../keamanan/koneksi.php';

// Terima ID babtis yang akan dihapus dari formulir HTML
$id_babtis = $_POST['id']; // Ubah menjadi $_GET jika menggunakan metode GET

// Lakukan validasi data
if (empty($id_babtis)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk menghapus data babtis berdasarkan ID
$query_delete_babtis = "DELETE FROM babtis WHERE id_babtis = '$id_babtis'";

// Jalankan query untuk menghapus data
if (mysqli_query($koneksi, $query_delete_babtis)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
