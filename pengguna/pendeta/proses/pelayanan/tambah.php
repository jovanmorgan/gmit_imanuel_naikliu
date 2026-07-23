<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari formulir HTML
$hari_tanggal_bulan = $_POST['hari_tanggal_bulan'];
$waktu = $_POST['waktu'];
$tempat = $_POST['tempat'];
$pemimpin = $_POST['pemimpin'];
// Lakukan validasi data
if (empty($hari_tanggal_bulan) || empty($waktu) || empty($tempat) || empty($pemimpin)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk menambahkan data masyarakat ke dalam database
$query = "INSERT INTO pelayanan (hari_tanggal_bulan, waktu, tempat, pemimpin)
        VALUES ('$hari_tanggal_bulan', '$waktu', '$tempat', '$pemimpin')";

// Jalankan query
if (mysqli_query($koneksi, $query)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
