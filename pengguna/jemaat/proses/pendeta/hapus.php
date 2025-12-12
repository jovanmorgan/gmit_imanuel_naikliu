<?php
include '../../../../keamanan/koneksi.php';

// Terima ID pendeta yang akan dihapus dari formulir HTML
$id_pendeta = $_POST['id']; // Ubah menjadi $_GET jika menggunakan metode GET

// Lakukan validasi data
if (empty($id_pendeta)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk menghapus data pendeta berdasarkan ID
$query_delete_pendeta = "DELETE FROM pendeta WHERE id_pendeta = '$id_pendeta'";

// Jalankan query untuk menghapus data
if (mysqli_query($koneksi, $query_delete_pendeta)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
