<?php
include '../../../../keamanan/koneksi.php';

// Terima ID majelis yang akan dihapus dari formulir HTML
$id_majelis = $_POST['id']; // Ubah menjadi $_GET jika menggunakan metode GET

// Lakukan validasi data
if (empty($id_majelis)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk menghapus data majelis berdasarkan ID
$query_delete_majelis = "DELETE FROM majelis WHERE id_majelis = '$id_majelis'";

// Jalankan query untuk menghapus data
if (mysqli_query($koneksi, $query_delete_majelis)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
