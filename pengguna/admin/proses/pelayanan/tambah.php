<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari formulir HTML
$id_rayon = $_POST['id_rayon'];
$id_jemaat = $_POST['id_jemaat'];
$hari_tanggal_bulan = $_POST['hari_tanggal_bulan'];
$waktu = $_POST['waktu'];
$tempat = $_POST['tempat'];
$pemimpin = $_POST['pemimpin'];

// Validasi data
if (
    empty($id_rayon) ||
    empty($id_jemaat) ||
    empty($hari_tanggal_bulan) ||
    empty($waktu) ||
    empty($tempat) ||
    empty($pemimpin)
) {
    echo "data_tidak_lengkap";
    exit();
}

// Validasi bahwa jemaat benar-benar berasal dari rayon yang dipilih
$cek = mysqli_query(
    $koneksi,
    "SELECT * FROM jemaat 
     WHERE id_jemaat='$id_jemaat' 
     AND id_rayon='$id_rayon'"
);

if (mysqli_num_rows($cek) == 0) {
    echo "jemaat_tidak_sesuai_rayon";
    exit();
}

// Simpan data
$query = "INSERT INTO pelayanan (
            id_rayon,
            id_jemaat,
            hari_tanggal_bulan,
            waktu,
            tempat,
            pemimpin
        ) VALUES (
            '$id_rayon',
            '$id_jemaat',
            '$hari_tanggal_bulan',
            '$waktu',
            '$tempat',
            '$pemimpin'
        )";

// Jalankan query
if (mysqli_query($koneksi, $query)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi
mysqli_close($koneksi);
?>