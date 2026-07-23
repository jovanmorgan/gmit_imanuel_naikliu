<?php include 'nama_halaman.php'; ?>

<div class="page-header">
    <h3 class="fw-bold mb-3"><?= htmlspecialchars($page_title) ?> </h3>
    <ul class="breadcrumbs mb-3">
        <li class="nav-home">
            <a href="dashboard">
                <i class="icon-home"></i>
            </a>
        </li>
        <li class="separator">
            <i class="icon-arrow-right"></i>
        </li>
        <!-- Kondisi untuk halaman selain Profile Sekolah, Galery, Berita, dan Sarana Prasarana -->
        <?php if ($page_title !== "Profile Saya" && $page_title !== "Profile Saya"): ?>
            <li class="nav-item">
                <a href="#">Sistem Gereja</a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
        <?php endif; ?>


        <?php if ($page_title === "Profile Saya"): ?>
            <li class="nav-item">
                <a href="#">Profile </a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
        <?php endif; ?>

        <li class="nav-item">
            <a href="#"><?= htmlspecialchars($page_title) ?> </a>
        </li>
    </ul>

    <!-- Tampilkan bagian ini jika bukan di halaman Dashboard atau Profile Saya -->
    <?php if ($page_title !== "Peserta" && $page_title !== "Profile Saya" && $page_title !== "Gereja" && $page_title !== "Galery" && $page_title !== "Laporan Jemaat" && $page_title !== "Laporan Pelayanan" && $page_title !== "Laporan Sidi" && $page_title !== "Laporan Babtis" && $page_title !== "Laporan Nikah"): ?>
        <div class="ms-md-auto py-2 py-md-0">

            <!-- Tampilkan tombol Export jika halaman bukan Galery -->
            <?php if ($page_title == "Laporan Keuangan"): ?>
                <a target="_blank" href="export/<?= htmlspecialchars($current_page) ?>"
                    class="btn btn-label-warning btn-round me-2">Export</a>
            <?php endif; ?>

            <!-- Hilangkan tombol tambah jika di halaman Pendaftar -->
            <?php if ($page_title !== "Dashboard"): ?>
                <button class="btn btn-success btn-round" data-bs-toggle="modal" data-bs-target="#tambahDataModal">Tambah
                    Data</button>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>