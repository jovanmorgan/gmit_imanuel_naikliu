<?php
include '../../../../keamanan/koneksi.php';

// Terima ID sidi yang akan dihapus dari formulir HTML
$id_sidi = $_POST['id']; // Ubah menjadi $_GET jika menggunakan metode GET

// Lakukan validasi data
if (empty($id_sidi)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk menghapus data sidi berdasarkan ID
$query_delete_sidi = "DELETE FROM sidi WHERE id_sidi = '$id_sidi'";

// Jalankan query untuk menghapus data
if (mysqli_query($koneksi, $query_delete_sidi)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
