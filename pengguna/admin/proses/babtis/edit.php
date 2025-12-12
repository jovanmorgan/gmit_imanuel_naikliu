<?php
include '../../../../keamanan/koneksi.php';

// Ambil data dari form
$id_babtis      = $_POST['id_babtis'];
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

    if ($_FILES[$fileInput]['error'] === UPLOAD_ERR_NO_FILE) {
        return ["status" => false, "msg" => "no_file"]; // Tidak upload file baru
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

    $new_name = time() . "_" . uniqid() . "." . $file_ext;

    $destination = $target_dir . $new_name;

    if (move_uploaded_file($file_tmp, $destination)) {
        return ["status" => true, "filename" => $new_name];
    } else {
        return ["status" => false, "msg" => "Gagal memindahkan file"];
    }
}

// =======================================================
// AMBIL DATA LAMA
// =======================================================
$query_old = $koneksi->query("SELECT * FROM babtis WHERE id_babtis = '$id_babtis'");
$data_old  = $query_old->fetch_assoc();

$old_surat_nikah = $data_old['surat_nikah_orang_tua'];
$old_akta        = $data_old['akta_kelahiran'];

// =======================================================
// UPLOAD FILE (JIKA ADA FILE BARU)
// =======================================================
$upload_surat_nikah = uploadFile("surat_nikah_orang_tua", $target_dir);
$upload_akta        = uploadFile("akta_kelahiran", $target_dir);

if ($upload_surat_nikah["msg"] !== "no_file" && !$upload_surat_nikah["status"]) {
    echo "upload_gagal";
    exit();
}

if ($upload_akta["msg"] !== "no_file" && !$upload_akta["status"]) {
    echo "upload_gagal";
    exit();
}

// Tentukan file yang dipakai (baru atau lama)
$surat_nikah_orang_tua = ($upload_surat_nikah["status"]) ? $upload_surat_nikah["filename"] : $old_surat_nikah;
$akta_kelahiran        = ($upload_akta["status"]) ? $upload_akta["filename"] : $old_akta;

// =======================================================
// UPDATE DATA
// =======================================================
$query = "UPDATE babtis SET 
            id_jemaat = ?, 
            tempat_lahir = ?, 
            tanggal_lahir = ?, 
            surat_nikah_orang_tua = ?, 
            akta_kelahiran = ?
          WHERE id_babtis = ?";

$stmt = mysqli_prepare($koneksi, $query);
mysqli_stmt_bind_param(
    $stmt,
    "sssssi",
    $id_jemaat,
    $tempat_lahir,
    $tanggal_lahir,
    $surat_nikah_orang_tua,
    $akta_kelahiran,
    $id_babtis
);

if (mysqli_stmt_execute($stmt)) {
    echo "success";
} else {
    echo "error";
}

mysqli_stmt_close($stmt);
mysqli_close($koneksi);
