<?php
include '../../../../keamanan/koneksi.php';

$id_pelayanan = $_POST['id_pelayanan']; // Pastikan ID pendeta dikirim untuk proses update
$hari_tanggal_bulan = $_POST['hari_tanggal_bulan'];
$waktu = $_POST['waktu'];
$tempat = $_POST['tempat'];
$pemimpin = $_POST['pemimpin'];
// Lakukan validasi data
if (empty($id_pelayanan) || empty($hari_tanggal_bulan) || empty($waktu) || empty($tempat) || empty($pemimpin)) {
    echo "data_tidak_lengkap";
    exit();
}


// Buat query SQL untuk mengedit data kepsek yang sudah ada berdasarkan id_kepsek
$query = "UPDATE pelayanan 
            SET hari_tanggal_bulan = '$hari_tanggal_bulan', 
                waktu = '$waktu', 
                tempat = '$tempat', 
                pemimpin = '$pemimpin'
          WHERE id_pelayanan = '$id_pelayanan'";

// Jalankan query
if (mysqli_query($koneksi, $query)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
