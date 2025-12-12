<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari formulir
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
    empty($nama_lengkap) || empty($jenis_kelamin) ||
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

// CEK USERNAME DI 3 TABEL
$tables = ['admin', 'pendeta', 'majelis', 'jemaat'];
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

// INSERT DATA BARU
$stmt = $koneksi->prepare(
    "INSERT INTO pendeta 
    (nama_lengkap, jenis_kelamin, username, password, tempat_lahir, tanggal_lahir, priode_jabatan, nomor_hp)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
);

$stmt->bind_param(
    "ssssssss",
    $nama_lengkap,
    $jenis_kelamin,
    $username,
    $password,
    $tempat_lahir,
    $tanggal_lahir,
    $priode_jabatan,
    $nomor_hp
);

if ($stmt->execute()) {
    echo "success";
} else {
    echo "error";
}

$stmt->close();
$koneksi->close();
