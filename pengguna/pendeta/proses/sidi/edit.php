<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari form
$id_sidi   = $_POST['id_sidi'];
$id_jemaat = $_POST['id_jemaat'];

// Folder penyimpanan file
$target_dir = "../../../../assets/file/";

// Pastikan folder ada
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0777, true);
}

// =======================================================
// FUNGSI UPLOAD FILE OPSIONAL
// =======================================================
function uploadFileOptional($fileInput, $target_dir)
{
    if (!isset($_FILES[$fileInput]) || $_FILES[$fileInput]['error'] === UPLOAD_ERR_NO_FILE) {
        return ["status" => true, "filename" => null];
    }

    $file_name  = $_FILES[$fileInput]['name'];
    $file_tmp   = $_FILES[$fileInput]['tmp_name'];
    $file_error = $_FILES[$fileInput]['error'];

    if ($file_error !== UPLOAD_ERR_OK) {
        return ["status" => false, "msg" => "Gagal upload file"];
    }

    $allowed_ext = ['pdf', 'jpg', 'jpeg', 'png'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    if (!in_array($file_ext, $allowed_ext)) {
        return ["status" => false, "msg" => "Format file tidak didukung"];
    }

    $new_name = time() . "_" . uniqid() . "." . $file_ext;
    $destination = $target_dir . $new_name;

    if (move_uploaded_file($file_tmp, $destination)) {
        return ["status" => true, "filename" => $new_name];
    }

    return ["status" => false, "msg" => "Gagal menyimpan file"];
}


// =======================================================
// AMBIL DATA LAMA
// =======================================================
$getOld = mysqli_query($koneksi, "SELECT akta_kelahiran, surat_babtis FROM sidi WHERE id_sidi = '$id_sidi'");
$oldData = mysqli_fetch_assoc($getOld);

$old_akta   = $oldData['akta_kelahiran'];
$old_babtis = $oldData['surat_babtis'];


// =======================================================
// PROSES UPLOAD FILE
// =======================================================
$upload_akta   = uploadFileOptional("akta_kelahiran", $target_dir);
$upload_babtis = uploadFileOptional("surat_babtis", $target_dir);

if (!$upload_akta["status"] || !$upload_babtis["status"]) {
    echo "upload_gagal";
    exit();
}

// Jika tidak upload baru, pakai file lama
$akta_kelahiran = $upload_akta["filename"] ?: $old_akta;
$surat_babtis   = $upload_babtis["filename"] ?: $old_babtis;


// =======================================================
// HAPUS FILE LAMA (jika diganti)
// =======================================================
if ($upload_akta["filename"] && $old_akta && file_exists($target_dir . $old_akta)) {
    unlink($target_dir . $old_akta);
}

if ($upload_babtis["filename"] && $old_babtis && file_exists($target_dir . $old_babtis)) {
    unlink($target_dir . $old_babtis);
}


// =======================================================
// UPDATE DATABASE
// =======================================================
$query = "UPDATE sidi 
          SET id_jemaat = ?, 
              akta_kelahiran = ?, 
              surat_babtis = ?
          WHERE id_sidi = ?";

$stmt = mysqli_prepare($koneksi, $query);
mysqli_stmt_bind_param($stmt, "ssss", $id_jemaat, $akta_kelahiran, $surat_babtis, $id_sidi);

if (mysqli_stmt_execute($stmt)) {
    echo "success";
} else {
    echo "error";
}

mysqli_stmt_close($stmt);
mysqli_close($koneksi);