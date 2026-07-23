<?php
include '../../../../keamanan/koneksi.php';
$id_rayon = $_GET['id_rayon'];

$query = mysqli_query($koneksi, "
    SELECT *
    FROM jemaat
    WHERE id_rayon='$id_rayon'
    ORDER BY nama_lengkap ASC
");

echo '<option value="">-- Pilih Jemaat --</option>';

while ($row = mysqli_fetch_assoc($query)) {
    echo '<option value="' . $row['id_jemaat'] . '">'
        . htmlspecialchars($row['nama_lengkap']) .
        '</option>';
}
?>