<?php
include '../../../../keamanan/koneksi.php';

// Terima ID rayon yang akan dihapus dari formulir HTML
$id_rayon = $_POST['id']; // Ubah menjadi $_GET jika menggunakan metode GET

// Lakukan validasi data
if (empty($id_rayon)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk menghapus data rayon berdasarkan ID
$query_delete_rayon = "DELETE FROM rayon WHERE id_rayon = '$id_rayon'";

// Jalankan query untuk menghapus data
if (mysqli_query($koneksi, $query_delete_rayon)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
