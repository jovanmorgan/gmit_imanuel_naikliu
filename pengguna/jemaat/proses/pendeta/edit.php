<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari formulir
$id_pendeta     = $_POST['id_pendeta']; // wajib ada untuk update
$nama_lengkap   = $_POST['nama_lengkap'];
$jenis_kelamin  = $_POST['jenis_kelamin'];
$username       = $_POST['username'];
$password       = $_POST['password'];
$tempat_lahir   = $_POST['tempat_lahir'];
$tanggal_lahir  = $_POST['tanggal_lahir'];
$priode_jabatan = $_POST['priode_jabatan'];
$nomor_hp       = $_POST['nomor_hp'];

// Validasi data kosong
if (
    empty($id_pendeta) || empty($nama_lengkap) || empty($jenis_kelamin) ||
    empty($username) || empty($password) || empty($tempat_lahir) || empty($tanggal_lahir) ||
    empty($priode_jabatan) || empty($nomor_hp)
) {
    echo "data_tidak_lengkap";
    exit();
}

// Validasi panjang password minimal 8
if (strlen($password) < 8) {
    echo "error_password_length";
    exit();
}

// Validasi password harus mengandung huruf besar, huruf kecil, angka
if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/", $password)) {
    echo "error_password_strength";
    exit();
}

// CEK USERNAME DI 4 TABEL NAMUN TIDAK MENGHITUNG DIRINYA SENDIRI
$tables = ['admin', 'majelis', 'jemaat'];

// cek username di tabel lain (admin, majelis, jemaat)
foreach ($tables as $tbl) {
    $stmt = $koneksi->prepare("SELECT username FROM $tbl WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "data_sudah_ada";
        exit();
    }
}

// Cek username di tabel pendeta TAPI kecuali dirinya sendiri
$stmt = $koneksi->prepare("
    SELECT username FROM pendeta 
    WHERE username = ? AND id_pendeta != ?
");
$stmt->bind_param("si", $username, $id_pendeta);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo "data_sudah_ada";
    exit();
}

// UPDATE DATA
$stmt = $koneksi->prepare("
    UPDATE pendeta SET
        nama_lengkap = ?,
        jenis_kelamin = ?,
        username = ?,
        password = ?,
        tempat_lahir = ?,
        tanggal_lahir = ?,
        priode_jabatan = ?,
        nomor_hp = ?
    WHERE id_pendeta = ?
");

$stmt->bind_param(
    "ssssssssi",
    $nama_lengkap,
    $jenis_kelamin,
    $username,
    $password,
    $tempat_lahir,
    $tanggal_lahir,
    $priode_jabatan,
    $nomor_hp,
    $id_pendeta
);

if ($stmt->execute()) {
    echo "success";
} else {
    echo "error";
}

$stmt->close();
$koneksi->close();
