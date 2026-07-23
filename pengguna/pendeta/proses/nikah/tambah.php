<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari form
$id_jemaat = $_POST['id_jemaat'];

// Lokasi penyimpanan file
$target_dir = "../../../../assets/file/";

// Pastikan folder ada
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0777, true);
}

// =======================================================
// FUNGSI UPLOAD FILE
// =======================================================
function uploadFile($fileInput, $target_dir)
{
    if (!isset($_FILES[$fileInput])) {
        return ["status" => false, "msg" => "File tidak ditemukan"];
    }

    $file_name  = $_FILES[$fileInput]['name'];
    $file_tmp   = $_FILES[$fileInput]['tmp_name'];
    $file_error = $_FILES[$fileInput]['error'];

    if ($file_error !== UPLOAD_ERR_OK) {
        return ["status" => false, "msg" => "Gagal upload file"];
    }

    // Ekstensi yang diizinkan
    $allowed_ext = ['pdf', 'jpg', 'jpeg', 'png'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    if (!in_array($file_ext, $allowed_ext)) {
        return ["status" => false, "msg" => "Format file tidak didukung"];
    }

    // Rename file agar unik
    $new_name = time() . "_" . uniqid() . "." . $file_ext;

    $destination = $target_dir . $new_name;

    if (move_uploaded_file($file_tmp, $destination)) {
        return ["status" => true, "filename" => $new_name];
    } else {
        return ["status" => false, "msg" => "Gagal menyimpan file"];
    }
}

// =======================================================
// UPLOAD 4 FILE NIKAH
// =======================================================

// File pengantin
$upload_sidi_pengantin   = uploadFile("surat_sidi_pengantin", $target_dir);
$upload_babtis_pengantin = uploadFile("surat_babtis_pengantin", $target_dir);

// File saksi
$upload_surat_nikah_saksi    = uploadFile("surat_nikah_saksi", $target_dir);
$upload_akta_kelahiran_saksi = uploadFile("akta_kelahiran_saksi", $target_dir);

// Jika ada upload gagal
if (
    !$upload_sidi_pengantin["status"] ||
    !$upload_babtis_pengantin["status"] ||
    !$upload_surat_nikah_saksi["status"] ||
    !$upload_akta_kelahiran_saksi["status"]
) {
    echo "upload_gagal";
    exit();
}

// Ambil nama file hasil upload
$surat_sidi_pengantin     = $upload_sidi_pengantin["filename"];
$surat_babtis_pengantin   = $upload_babtis_pengantin["filename"];
$surat_nikah_saksi        = $upload_surat_nikah_saksi["filename"];
$akta_kelahiran_saksi     = $upload_akta_kelahiran_saksi["filename"];

// Validasi input wajib
if (empty($id_jemaat)) {
    echo "data_tidak_lengkap";
    exit();
}

// =======================================================
// INSERT KE DATABASE
// =======================================================
$query = "INSERT INTO nikah 
            (id_jemaat, 
             surat_sidi_pengantin, 
             surat_babtis_pengantin, 
             surat_nikah_saksi, 
             akta_kelahiran_saksi)
          VALUES (?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($koneksi, $query);
mysqli_stmt_bind_param(
    $stmt,
    "sssss",
    $id_jemaat,
    $surat_sidi_pengantin,
    $surat_babtis_pengantin,
    $surat_nikah_saksi,
    $akta_kelahiran_saksi
);

if (mysqli_stmt_execute($stmt)) {
    echo "success";
} else {
    echo "error";
}

mysqli_stmt_close($stmt);
mysqli_close($koneksi);
