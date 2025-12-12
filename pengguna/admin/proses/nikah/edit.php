<?php
include '../../../../keamanan/koneksi.php';

// ------------------------------------------------------
// TERIMA DATA
// ------------------------------------------------------
$id_nikah  = $_POST['id_nikah'];
$id_jemaat = $_POST['id_jemaat'];

// Lokasi file
$target_dir = "../../../../assets/file/";

// Ambil data lama dari database
$sql_old = "SELECT * FROM nikah WHERE id_nikah = ?";
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
// FUNGSI UPLOAD FILE
// ------------------------------------------------------
function uploadFileEdit($fileInput, $target_dir, $old_file)
{
    if (!isset($_FILES[$fileInput]) || $_FILES[$fileInput]['error'] !== UPLOAD_ERR_OK) {
        return $old_file; // Tidak upload baru → pakai file lama
    }

    $file_name = $_FILES[$fileInput]['name'];
    $file_tmp  = $_FILES[$fileInput]['tmp_name'];
    $file_ext  = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    $allowed_ext = ['pdf', 'jpg', 'jpeg', 'png'];
    if (!in_array($file_ext, $allowed_ext)) {
        return $old_file;
    }

    // Rename file agar unik
    $new_name = time() . "_" . uniqid() . "." . $file_ext;
    $destination = $target_dir . $new_name;

    if (move_uploaded_file($file_tmp, $destination)) {
        // Hapus file lama
        if (!empty($old_file) && file_exists($target_dir . $old_file)) {
            unlink($target_dir . $old_file);
        }
        return $new_name;
    }

    return $old_file;
}

// ------------------------------------------------------
// PROSES UPLOAD FILE (PAKAI FILE LAMA JIKA TIDAK UPLOAD BARU)
// ------------------------------------------------------
$surat_sidi_pengantin   = uploadFileEdit("surat_sidi_pengantin", $target_dir, $data_old['surat_sidi_pengantin']);
$surat_babtis_pengantin = uploadFileEdit("surat_babtis_pengantin", $target_dir, $data_old['surat_babtis_pengantin']);
$surat_nikah_saksi      = uploadFileEdit("surat_nikah_saksi", $target_dir, $data_old['surat_nikah_saksi']);
$akta_kelahiran_saksi   = uploadFileEdit("akta_kelahiran_saksi", $target_dir, $data_old['akta_kelahiran_saksi']);

// ------------------------------------------------------
// VALIDASI
// ------------------------------------------------------
if (empty($id_jemaat)) {
    echo "data_tidak_lengkap";
    exit();
}

// ------------------------------------------------------
// UPDATE DATABASE
// ------------------------------------------------------
$sql_update = "UPDATE nikah SET 
                id_jemaat = ?, 
                surat_sidi_pengantin = ?, 
                surat_babtis_pengantin = ?, 
                surat_nikah_saksi = ?, 
                akta_kelahiran_saksi = ?
              WHERE id_nikah = ?";

$stmt_upd = mysqli_prepare($koneksi, $sql_update);
mysqli_stmt_bind_param(
    $stmt_upd,
    "sssssi",
    $id_jemaat,
    $surat_sidi_pengantin,
    $surat_babtis_pengantin,
    $surat_nikah_saksi,
    $akta_kelahiran_saksi,
    $id_nikah
);

if (mysqli_stmt_execute($stmt_upd)) {
    echo "success";
} else {
    echo "error";
}

mysqli_stmt_close($stmt_old);
mysqli_stmt_close($stmt_upd);
mysqli_close($koneksi);
