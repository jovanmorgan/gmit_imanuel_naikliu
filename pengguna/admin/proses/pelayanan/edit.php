<?php
include '../../../../keamanan/koneksi.php';

<<<<<<< HEAD
$id_pelayanan = $_POST['id_pelayanan'];
$id_rayon = $_POST['id_rayon'];
$id_jemaat = $_POST['id_jemaat'];
=======
$id_pelayanan = $_POST['id_pelayanan']; // Pastikan ID pendeta dikirim untuk proses update
>>>>>>> 4103a0366611edb09f83497d66e49d67f25169a0
$hari_tanggal_bulan = $_POST['hari_tanggal_bulan'];
$waktu = $_POST['waktu'];
$tempat = $_POST['tempat'];
$pemimpin = $_POST['pemimpin'];
<<<<<<< HEAD

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
=======
// Lakukan validasi data
if (empty($id_pelayanan) || empty($hari_tanggal_bulan) || empty($waktu) || empty($tempat) || empty($pemimpin)) {
>>>>>>> 4103a0366611edb09f83497d66e49d67f25169a0
    echo "data_tidak_lengkap";
    exit();
}

<<<<<<< HEAD
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
=======

// Buat query SQL untuk mengedit data kepsek yang sudah ada berdasarkan id_kepsek
$query = "UPDATE pelayanan 
            SET hari_tanggal_bulan = '$hari_tanggal_bulan', 
                waktu = '$waktu', 
                tempat = '$tempat', 
                pemimpin = '$pemimpin'
          WHERE id_pelayanan = '$id_pelayanan'";

// Jalankan query
>>>>>>> 4103a0366611edb09f83497d66e49d67f25169a0
if (mysqli_query($koneksi, $query)) {
    echo "success";
} else {
    echo "error";
}

<<<<<<< HEAD
// Tutup koneksi
mysqli_close($koneksi);
?>
=======
// Tutup koneksi ke database
mysqli_close($koneksi);
>>>>>>> 4103a0366611edb09f83497d66e49d67f25169a0
