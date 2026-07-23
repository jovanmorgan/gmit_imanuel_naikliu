<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari formulir HTML
<<<<<<< HEAD
$id_rayon = $_POST['id_rayon'];
$id_jemaat = $_POST['id_jemaat'];
=======
>>>>>>> 4103a0366611edb09f83497d66e49d67f25169a0
$hari_tanggal_bulan = $_POST['hari_tanggal_bulan'];
$waktu = $_POST['waktu'];
$tempat = $_POST['tempat'];
$pemimpin = $_POST['pemimpin'];
<<<<<<< HEAD

// Validasi data
if (
    empty($id_rayon) ||
    empty($id_jemaat) ||
    empty($hari_tanggal_bulan) ||
    empty($waktu) ||
    empty($tempat) ||
    empty($pemimpin)
) {
=======
// Lakukan validasi data
if (empty($hari_tanggal_bulan) || empty($waktu) || empty($tempat) || empty($pemimpin)) {
>>>>>>> 4103a0366611edb09f83497d66e49d67f25169a0
    echo "data_tidak_lengkap";
    exit();
}

<<<<<<< HEAD
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
=======
// Buat query SQL untuk menambahkan data masyarakat ke dalam database
$query = "INSERT INTO pelayanan (hari_tanggal_bulan, waktu, tempat, pemimpin)
        VALUES ('$hari_tanggal_bulan', '$waktu', '$tempat', '$pemimpin')";
>>>>>>> 4103a0366611edb09f83497d66e49d67f25169a0

// Jalankan query
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
