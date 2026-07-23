<?php
// Dapatkan nama halaman dari URL saat ini tanpa ekstensi .php
$current_page = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), ".php");

// Tentukan judul halaman berdasarkan nama file
switch ($current_page) {
    case 'dashboard':
        $page_title = 'Home';
        break;
    case 'pendeta':
        $page_title = 'Pendeta';
        break;
    case 'majelis':
        $page_title = 'Majelis';
        break;
    case 'rayon':
        $page_title = 'Rayon';
        break;
    case 'jemaat':
        $page_title = 'Jemaat';
        break;
    case 'pelayanan':
        $page_title = 'Pelayanan';
        break;
    case 'sidi':
        $page_title = 'Sidi';
        break;
    case 'babtis':
        $page_title = 'Babtis';
        break;
    case 'nikah':
        $page_title = 'Nikah';
        break;
    case 'galery':
        $page_title = 'Galery';
        break;
    case 'laporan_jemaat':
        $page_title = 'Laporan Jemaat';
        break;
    case 'laporan_pelayanan':
        $page_title = 'Laporan Pelayanan';
        break;
    case 'laporan_sidi':
        $page_title = 'Laporan Sidi';
        break;
    case 'laporan_nikah':
        $page_title = 'Laporan Nikah';
        break;
    case 'laporan_babtis':
        $page_title = 'Laporan Babtis';
        break;
    case 'berita':
        $page_title = 'Berita';
        break;
    case 'gereja':
        $page_title = 'Gereja';
        break;
    case 'profile':
        $page_title = 'Profile Saya';
        break;
    case 'log_out':
        $page_title = 'Log Out';
        break;
    default:
        $page_title = 'Admin Gereja ';
        break;
}

?>

<style>
    /* Agar table tidak membungkus teks */
    .table td,
    .table th {
        white-space: nowrap !important;
        /* Cegah teks turun baris */
        overflow: hidden !important;
        /* Sembunyikan teks berlebih */
        text-overflow: ellipsis !important;
        /* Tambahkan ... */
        max-width: 180px;
        /* Batas lebar cell */
    }

    /* Bungkus table agar bisa scroll ke samping jika terlalu besar */
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        white-space: nowrap;
    }

    /* Supaya link tombol tidak membesar */
    .table a.btn {
        white-space: nowrap !important;
    }
</style>