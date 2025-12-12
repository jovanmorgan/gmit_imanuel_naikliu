<?php
// Dapatkan nama halaman dari URL saat ini tanpa ekstensi .php
$current_page = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), ".php");

// Ikon halaman
function getIconForPage($page)
{
    switch ($page) {
        case 'dashboard':
            return 'fas fa-tachometer-alt';
        case 'gereja':
            return 'fas fa-church';
        case 'informasi':
            return 'fas fa-info-circle';
        case 'berita':
            return 'fas fa-newspaper';
        case 'galery':
            return 'fas fa-images';
        case 'laporan':
            return 'fas fa-file-alt';
        case 'profile':
            return 'fas fa-user-circle';
        case 'log_out':
            return 'fas fa-sign-out-alt';
        default:
            return 'fas fa-folder';
    }
}
?>

<!-- Sidebar -->
<div class="sidebar" data-background-color="white">
    <div class="sidebar-logo">
        <div class="logo-header" data-background-color="white">
            <a href="dashboard" class="logo">
                <img src="../../assets/img/gereja/logo.png" alt="navbar brand" class="navbar-brand gbr" height="50px" />
                <h5 class="text-black judul">Gmit Imanuel Naikliu</h5>
            </a>
        </div>
    </div>

    <div class="sidebar-wrapper scrollbar-inner" data-background-color="white">
        <div class="sidebar-content">

            <ul class="nav nav-secondary">

                <!-- Dashboard -->
                <li class="nav-item <?= ($current_page == 'dashboard') ? 'active' : ''; ?>">
                    <a href="dashboard">
                        <i class="<?= getIconForPage('dashboard'); ?>"></i>
                        <p>Beranda</p>
                    </a>
                </li>

                <!-- Gereja -->
                <li class="nav-item <?= ($current_page == 'gereja') ? 'active' : ''; ?>">
                    <a href="gereja">
                        <i class="<?= getIconForPage('gereja'); ?>"></i>
                        <p>Gereja</p>
                    </a>
                </li>

                <!-- Laporan -->
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#laporanMenu"
                        aria-expanded="<?= in_array($current_page, ['laporan_jemaat', 'laporan_pelayanan', 'laporan_sidi', 'laporan_nikah', 'laporan_babtis']) ? 'true' : 'false'; ?>">
                        <i class="fas fa-file-alt"></i>
                        <p>Laporan</p>
                        <span class="caret"></span>
                    </a>

                    <div class="collapse <?= in_array($current_page, ['laporan_jemaat', 'laporan_pelayanan', 'laporan_sidi', 'laporan_nikah', 'laporan_babtis']) ? 'show' : ''; ?>"
                        id="laporanMenu">
                        <ul class="nav nav-collapse">
                            <li class="<?= ($current_page == 'laporan_jemaat') ? 'active' : ''; ?>">
                                <a href="laporan_jemaat"><span class="sub-item">Laporan
                                        Jemaat</span></a>
                            </li>
                            <li class="<?= ($current_page == 'laporan_pelayanan') ? 'active' : ''; ?>">
                                <a href="laporan_pelayanan"><span class="sub-item">Laporan
                                        Ibadah/Pelayanan</span></a>
                            </li>
                            <li class="<?= ($current_page == 'laporan_sidi') ? 'active' : ''; ?>">
                                <a href="laporan_sidi"><span class="sub-item">Laporan
                                        Sidi</span></a>
                            </li>
                            <li class="<?= ($current_page == 'laporan_nikah') ? 'active' : ''; ?>">
                                <a href="laporan_nikah"><span class="sub-item">Laporan
                                        Nikah</span></a>
                            </li>
                            <li class="<?= ($current_page == 'laporan_babtis') ? 'active' : ''; ?>">
                                <a href="laporan_babtis"><span class="sub-item">Laporan
                                        Babtis</span></a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Akun -->
                <li class="nav-section">
                    <span class="sidebar-mini-icon"><i class="fas fa-id-card"></i></span>
                    <h4 class="text-section">Akun dan Pengaturan</h4>
                </li>

                <li class="nav-item <?= ($current_page == 'profile') ? 'active' : ''; ?>">
                    <a href="profile">
                        <i class="<?= getIconForPage('profile'); ?>"></i>
                        <p>Profile Saya</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="log_out">
                        <i class="<?= getIconForPage('log_out'); ?>"></i>
                        <p>Log Out</p>
                    </a>
                </li>

            </ul>

        </div>
    </div>
</div>

<style>
.gbr {
    position: relative;
    right: 10px;
}

.judul {
    font-size: 17px;
    position: relative;
    right: 5px;
    margin-top: 10px;
    font-weight: 500;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* media untuk hp */

@media only screen and (max-width: 600px) {
    .gbr {
        position: relative;
        right: 5px;
    }

    .judul {
        font-size: 25px;
        position: relative;
        right: 5px;
    }
}
</style>