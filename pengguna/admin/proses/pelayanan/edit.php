<?php
include '../../../../keamanan/koneksi.php';

$id_pelayanan = $_POST['id_pelayanan'];
$id_rayon = $_POST['id_rayon'];
$id_jemaat = $_POST['id_jemaat'];
$hari_tanggal_bulan = $_POST['hari_tanggal_bulan'];
$waktu = $_POST['waktu'];
$tempat = $_POST['tempat'];
$pemimpin = $_POST['pemimpin'];

// Validasi data
if (
    empty($id_pelayanan) ||
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

/*
|--------------------------------------------------------------------------
| VALIDASI JEMAAT SESUAI RAYON
|--------------------------------------------------------------------------
*/
$cek_jemaat = mysqli_query(
    $koneksi,
    "SELECT *
     FROM jemaat
     WHERE id_jemaat = '$id_jemaat'
     AND id_rayon = '$id_rayon'"
);

if (mysqli_num_rows($cek_jemaat) == 0) {
    echo "jemaat_tidak_sesuai_rayon";
    exit();
}

/*
|--------------------------------------------------------------------------
| UPDATE DATA
|--------------------------------------------------------------------------
*/
$query = "
    UPDATE pelayanan
    SET
        id_rayon = '$id_rayon',
        id_jemaat = '$id_jemaat',
        hari_tanggal_bulan = '$hari_tanggal_bulan',
        waktu = '$waktu',
        tempat = '$tempat',
        pemimpin = '$pemimpin'
    WHERE id_pelayanan = '$id_pelayanan'
";

/*
|--------------------------------------------------------------------------
| EKSEKUSI QUERY
|--------------------------------------------------------------------------
*/
if (mysqli_query($koneksi, $query)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi
mysqli_close($koneksi);
?>