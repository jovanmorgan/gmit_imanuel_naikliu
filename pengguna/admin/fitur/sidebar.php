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

                <!-- Informasi -->
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#informasiMenu"
                        aria-expanded="<?= in_array($current_page, ['pendeta', 'majelis', 'rayon', 'jemaat']) ? 'true' : 'false'; ?>">
                        <i class="fas fa-info-circle"></i>
                        <p>Informasi</p>
                        <span class="caret"></span>
                    </a>

                    <div class="collapse <?= in_array($current_page, ['pendeta', 'majelis', 'rayon', 'jemaat']) ? 'show' : ''; ?>"
                        id="informasiMenu">
                        <ul class="nav nav-collapse">
                            <li class="<?= ($current_page == 'pendeta') ? 'active' : ''; ?>">
                                <a href="pendeta"><span class="sub-item">Pendeta</span></a>
                            </li>
                            <li class="<?= ($current_page == 'majelis') ? 'active' : ''; ?>">
                                <a href="majelis"><span class="sub-item">Majelis</span></a>
                            </li>
                            <li class="<?= ($current_page == 'rayon') ? 'active' : ''; ?>">
                                <a href="rayon"><span class="sub-item">Rayon</span></a>
                            </li>
                            <li class="<?= ($current_page == 'jemaat') ? 'active' : ''; ?>">
                                <a href="jemaat"><span class="sub-item">Jemaat</span></a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Galery -->
                <li class="nav-item <?= ($current_page == 'galery') ? 'active' : ''; ?>">
                    <a href="galery">
                        <i class="<?= getIconForPage('galery'); ?>"></i>
                        <p>Galery</p>
                    </a>
                </li>

                <!-- Berita -->
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#beritaMenu"
                        aria-expanded="<?= in_array($current_page, ['pelayanan', 'sidi', 'babtis', 'nikah']) ? 'true' : 'false'; ?>">
                        <i class="fas fa-newspaper"></i>
                        <p>Berita</p>
                        <span class="caret"></span>
                    </a>

                    <div class="collapse <?= in_array($current_page, ['pelayanan', 'sidi', 'babtis', 'nikah']) ? 'show' : ''; ?>"
                        id="beritaMenu">
                        <ul class="nav nav-collapse">
                            <li class="<?= ($current_page == 'pelayanan') ? 'active' : ''; ?>">
                                <a href="pelayanan"><span class="sub-item">Pelayanan / Ibadah</span></a>
                            </li>
                            <li class="<?= ($current_page == 'sidi') ? 'active' : ''; ?>">
                                <a href="sidi"><span class="sub-item">Sidi</span></a>
                            </li>
                            <li class="<?= ($current_page == 'babtis') ? 'active' : ''; ?>">
                                <a href="babtis"><span class="sub-item">Babtis</span></a>
                            </li>
                            <li class="<?= ($current_page == 'nikah') ? 'active' : ''; ?>">
                                <a href="nikah"><span class="sub-item">Nikah</span></a>
                            </li>
                        </ul>
                    </div>
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