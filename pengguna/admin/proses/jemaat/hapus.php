<?php
include '../../../../keamanan/koneksi.php';

// Terima ID jemaat yang akan dihapus dari formulir HTML
$id_jemaat = $_POST['id']; // Ubah menjadi $_GET jika menggunakan metode GET

// Lakukan validasi data
if (empty($id_jemaat)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk menghapus data jemaat berdasarkan ID
$query_delete_jemaat = "DELETE FROM jemaat WHERE id_jemaat = '$id_jemaat'";

// Jalankan query untuk menghapus data
if (mysqli_query($koneksi, $query_delete_jemaat)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
