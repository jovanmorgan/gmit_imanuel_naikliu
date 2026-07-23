<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari form
$id_jemaat      = $_POST['id_jemaat'];
$tempat_lahir   = $_POST['tempat_lahir'];
$tanggal_lahir  = $_POST['tanggal_lahir'];

// Lokasi penyimpanan file
$target_dir = "../../../../assets/file/";

// Buat folder jika belum ada
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
    $file_size  = $_FILES[$fileInput]['size'];
    $file_error = $_FILES[$fileInput]['error'];

    if ($file_error !== UPLOAD_ERR_OK) {
        return ["status" => false, "msg" => "Gagal upload file"];
    }

    $allowed_ext = ['pdf', 'jpg', 'jpeg', 'png'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    if (!in_array($file_ext, $allowed_ext)) {
        return ["status" => false, "msg" => "Format file tidak didukung"];
    }

    // Rename file unik
    $new_name = time() . "_" . uniqid() . "." . $file_ext;

    $destination = $target_dir . $new_name;

    if (move_uploaded_file($file_tmp, $destination)) {
        return ["status" => true, "filename" => $new_name];
    } else {
        return ["status" => false, "msg" => "Gagal memindahkan file"];
    }
}

// =======================================================
// UPLOAD FILE
// =======================================================
$upload_surat_nikah = uploadFile("surat_nikah_orang_tua", $target_dir);
$upload_akta        = uploadFile("akta_kelahiran", $target_dir);

if (!$upload_surat_nikah["status"] || !$upload_akta["status"]) {
    echo "upload_gagal";
    exit();
}

$surat_nikah_orang_tua = $upload_surat_nikah["filename"];
$akta_kelahiran        = $upload_akta["filename"];

// =======================================================
// VALIDASI DATA
// =======================================================
if (
    empty($id_jemaat) ||
    empty($tempat_lahir) ||
    empty($tanggal_lahir)
) {
    echo "data_tidak_lengkap";
    exit();
}

// =======================================================
// INSERT KE DATABASE
// =======================================================
$query = "INSERT INTO babtis 
(id_jemaat, tempat_lahir, tanggal_lahir, surat_nikah_orang_tua, akta_kelahiran)
VALUES (?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($koneksi, $query);
mysqli_stmt_bind_param(
    $stmt,
    "sssss",
    $id_jemaat,
    $tempat_lahir,
    $tanggal_lahir,
    $surat_nikah_orang_tua,
    $akta_kelahiran
);

// Eksekusi
if (mysqli_stmt_execute($stmt)) {
    echo "success";
} else {
    echo "error";
}

mysqli_stmt_close($stmt);
mysqli_close($koneksi);