<?php
include '../../../../keamanan/koneksi.php';

// Terima ID nikah yang akan dihapus
$id_nikah = $_POST['id'];

if (empty($id_nikah)) {
    echo "data_tidak_lengkap";
    exit();
}

// Lokasi file tersimpan
$target_dir = "../../../../assets/file/";

// ------------------------------------------------------
// 1. Ambil data lama terlebih dahulu
// ------------------------------------------------------
$sql_old = "SELECT surat_sidi_pengantin, surat_babtis_pengantin, surat_nikah_saksi, akta_kelahiran_saksi 
            FROM nikah WHERE id_nikah = ?";
$stmt_old = mysqli_prepare($koneksi, $sql_old);
mysqli_stmt_bind_param($stmt_old, "i", $id_nikah);
mysqli_stmt_execute($stmt_old);
$result_old = mysqli_stmt_get_result($stmt_old);
$data_old = mysqli_fetch_assoc($result_old);

if (!$data_old) {
    echo "data_tidak_ditemukan";
    exit();
}

// ------------------------------------------------------
// 2. Hapus file lama jika ada
// ------------------------------------------------------
function hapusFileJikaAda($namaFile, $folder)
{
    if (!empty($namaFile)) {
        $path = $folder . $namaFile;
        if (file_exists($path)) {
            unlink($path);
        }
    }
}

hapusFileJikaAda($data_old['surat_sidi_pengantin'], $target_dir);
hapusFileJikaAda($data_old['surat_babtis_pengantin'], $target_dir);
hapusFileJikaAda($data_old['surat_nikah_saksi'], $target_dir);
hapusFileJikaAda($data_old['akta_kelahiran_saksi'], $target_dir);

// ------------------------------------------------------
// 3. Hapus data di database
// ------------------------------------------------------
$sql_delete = "DELETE FROM nikah WHERE id_nikah = ?";
$stmt_del = mysqli_prepare($koneksi, $sql_delete);
mysqli_stmt_bind_param($stmt_del, "i", $id_nikah);

if (mysqli_stmt_execute($stmt_del)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi
mysqli_stmt_close($stmt_old);
mysqli_stmt_close($stmt_del);
mysqli_close($koneksi);
