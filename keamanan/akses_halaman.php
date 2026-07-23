<?php
include '../assets/akses/akses.php';

// Menjalankan perintah sistem untuk mendapatkan serial number
$serialNumber = shell_exec("wmic bios get serialnumber");

// Menghapus spasi, baris baru, dan karakter tambahan lainnya dari output
$serialNumber = trim(preg_replace('/\s+/', '', $serialNumber));

// Serial number laptop Anda (ganti dengan yang sesuai)
$validSerialNumber = 'SerialNumber' . $nomor_serial;

// Membatasi akses jika serial number cocok
if ($serialNumber === $validSerialNumber) {
    echo "akses_diperbolehkan";
} else {
    echo "akses_ditolak";
    // echo "$serialNumber";
}
