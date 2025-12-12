<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari form
$id_jemaat = $_POST['id_jemaat'];

// LOKASI PENYIMPANAN FILE
$target_dir = "../../../../assets/file/";

// Validasi folder
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

    // Ekstensi file yang diizinkan
    $allowed_ext = ['pdf', 'jpg', 'jpeg', 'png'];

    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    if (!in_array($file_ext, $allowed_ext)) {
        return ["status" => false, "msg" => "Format file tidak didukung"];
    }

    // Rename file: timestamp_nama_random.ext
    $new_name = time() . "_" . uniqid() . "." . $file_ext;

    $destination = $target_dir . $new_name;

    if (move_uploaded_file($file_tmp, $destination)) {
        return ["status" => true, "filename" => $new_name];
    } else {
        return ["status" => false, "msg" => "Gagal menyimpan file"];
    }
}

// =======================================================
// UPLOAD FILE
// =======================================================

$upload_akta = uploadFile("akta_kelahiran", $target_dir);
$upload_babtis = uploadFile("surat_babtis", $target_dir);

if (!$upload_akta["status"] || !$upload_babtis["status"]) {
    echo "upload_gagal";
    exit();
}

$akta_kelahiran = $upload_akta["filename"];
$surat_babtis   = $upload_babtis["filename"];

// Validasi data
if (empty($id_jemaat)) {
    echo "data_tidak_lengkap";
    exit();
}

// =======================================================
// INSERT KE DATABASE
// =======================================================
$query = "INSERT INTO sidi (id_jemaat, akta_kelahiran, surat_babtis)
          VALUES (?, ?, ?)";

$stmt = mysqli_prepare($koneksi, $query);
mysqli_stmt_bind_param($stmt, "sss", $id_jemaat, $akta_kelahiran, $surat_babtis);

if (mysqli_stmt_execute($stmt)) {
    echo "success";
} else {
    echo "error";
}

mysqli_stmt_close($stmt);
mysqli_close($koneksi);
