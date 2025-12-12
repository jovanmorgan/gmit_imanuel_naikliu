<?php include 'fitur/penggunah.php'; ?>
<!DOCTYPE html>
<html lang="en">
<?php include 'fitur/head.php'; ?>
<?php include 'fitur/nama_halaman.php'; ?>


<body>
    <div class="wrapper">
        <?php include 'fitur/sidebar.php'; ?>
        <div class="main-panel">
            <?php include 'fitur/navbar.php'; ?>
            <div class="container">
                <div class="page-inner">
                    <?php include 'fitur/papan_halaman.php'; ?>

                    <section class="gereja-hero">
                        <div class="gereja-hero-overlay">
                            <h1 class="hero-title">GMIT Imanuel Naikliu</h1>
                            <p class="hero-subtitle">Klasis Amfoang Utara · Kabupaten Kupang, NTT</p>
                        </div>
                    </section>

                    <section class="gereja-section py-5">
                        <div class="container">

                            <div class="text-center mb-5">
                                <h2 class="fw-bold display-6 text-gradient">Profil & Informasi Gereja</h2>
                                <p class="text-muted mt-2">Sejarah · Struktur Organisasi · Pelayanan</p>
                            </div>

                            <div class="row g-4">

                                <!-- Card Sejarah -->
                                <div class="col-lg-6">
                                    <div class="gereja-card">
                                        <img src="../../assets/img/gereja/gereja.jpg" class="card-img-top rounded-4"
                                            alt="Sejarah Gereja">

                                        <div class="gereja-card-body">
                                            <h4 class="fw-bold mb-3">Sejarah Gereja</h4>
                                            <p>
                                                Gereja Masehi Injili di Timor (GMIT) Klasis Amfoang Utara-Jemaat GMIT
                                                Imanuel Naikliu adalah sebuah jemaat gereja Protestan yang berlokasi di
                                                Kelurahan Naikliu, Kecamatan Amfoang Utara, Kabupaten Kupang, Nusa
                                                Tenggara Timur.

                                            </p>
                                            <p>
                                                GMIT adalah gereja yang terdaftar sebagai anggota Persekutuan
                                                Gereja-gereja di Indonesia (PGI) sejak tanggal 25 Mei 1950. Fokus
                                                pelayanan GMIT seringkali mencakup konteks budaya lokal yang beragam di
                                                NTT.
                                                Untuk informasi lebih rinci mengenai jadwal ibadah, kepengurusan, atau
                                                program spesifik jemaat Imanuel Naikliu, Anda dapat menghubungi langsung
                                                pihak gereja atau mengunjungi situs resmi Sinode GMIT.

                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="gereja-card">

                                        <!-- Gambar -->
                                        <div class="card-img-wrapper">
                                            <img src="../../assets/img/gereja/struktur.jpg"
                                                class="card-img-top rounded-4 shadow-sm" alt="Struktur Organisasi">
                                            <div class="img-overlay"></div>
                                        </div>

                                        <div class="gereja-card-body">
                                            <h4 class="fw-bold mb-3 text-gradient">Struktur Organisasi</h4>

                                            <p class="text-muted">
                                                Struktur organisasi
                                                <strong>Gereja Masehi Injili di Timor (GMIT)</strong> bersifat
                                                <strong>Presbiterial–Sinodal</strong>, yaitu kepemimpinan yang
                                                dijalankan
                                                <em>secara kolegial, bertingkat, dan saling melayani</em>.
                                                Hal ini juga diterapkan di <strong>Jemaat GMIT Imanuel Naikliu</strong>.
                                            </p>

                                            <h6 class="fw-bold mt-3">📌 Hierarki Kepemimpinan GMIT</h6>
                                            <ul class="struktur-list">
                                                <li><strong>Majelis Sinode (Pusat)</strong> — Mengatur pelayanan seluruh
                                                    GMIT di NTT.</li>
                                                <li><strong>Majelis Klasis (Wilayah)</strong> — Mengawasi jemaat dalam
                                                    satu wilayah, termasuk Klasis Amfoang Utara.</li>
                                                <li><strong>Majelis Jemaat (Lokal)</strong> — Pemimpin pelayanan di
                                                    Jemaat GMIT Imanuel Naikliu.</li>
                                            </ul>

                                            <h6 class="fw-bold mt-3">📘 Struktur Majelis Jemaat Imanuel Naikliu</h6>
                                            <ul class="struktur-list">
                                                <li>Ketua (Pendeta Gereja)</li>
                                                <li>Wakil Ketua</li>
                                                <li>Sekretaris & Wakil Sekretaris</li>
                                                <li>Bendahara</li>
                                                <li>Penatua & Diaken (Pelayan sektor/rayon)</li>
                                            </ul>

                                            <h6 class="fw-bold mt-3">🤝 Unit Pembantu Pelayanan (UPP)</h6>
                                            <ul class="struktur-list">
                                                <li>Persekutuan Kaum Bapak (PKB)</li>
                                                <li>Persekutuan Kaum Perempuan (PKP)</li>
                                                <li>Pemuda GMIT</li>
                                                <li>Remaja GMIT</li>
                                                <li>Sekolah Minggu (SM)</li>
                                            </ul>

                                            <p class="text-muted mt-3">
                                                Keseluruhan struktur ini memastikan pelayanan gereja berjalan teratur,
                                                terarah, dan menjangkau setiap kelompok usia serta kebutuhan jemaat.
                                            </p>
                                        </div>
                                    </div>
                                </div>


                            </div>

                        </div>
                    </section>


                </div>
            </div>
            <style>
                /* Hero Section */
                .gereja-hero {
                    height: 45vh;
                    background: url('../../assets/img/gereja/bg3.jpg') center/cover fixed;
                    position: relative;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }

                .gereja-hero-overlay {
                    background: rgba(0, 0, 0, 0.45);
                    backdrop-filter: blur(4px);
                    width: 100%;
                    height: 100%;
                    color: white;
                    text-align: center;
                    padding-top: 9%;
                }

                .hero-title {
                    font-size: 3rem;
                    font-weight: 800;
                    letter-spacing: 1px;
                }

                .hero-subtitle {
                    font-size: 1.2rem;
                    opacity: .9;
                }

                /* Gradient Text */
                .text-gradient {
                    background: linear-gradient(45deg, #6246ea, #d658ff, #ff8a00);
                    -webkit-background-clip: text;
                    -webkit-text-fill-color: transparent;
                }

                /* Card Style */
                .gereja-card {
                    background: rgba(255, 255, 255, 0.78);
                    border-radius: 22px;
                    box-shadow: 0 10px 35px rgba(0, 0, 0, 0.12);
                    backdrop-filter: blur(14px);
                    border: 1px solid rgba(255, 255, 255, 0.55);
                    overflow: hidden;
                    transition: all .35s ease;
                }

                .gereja-card:hover {
                    transform: translateY(-8px);
                    box-shadow: 0 15px 45px rgba(98, 70, 234, 0.35);
                    border-color: #6246ea;
                }

                /* Card Body */
                .gereja-card-body {
                    padding: 25px;
                }

                /* Struktur List */
                .struktur-list li {
                    margin-bottom: 6px;
                    font-size: 1rem;
                }

                /* Section BG */
                .gereja-section {
                    background: linear-gradient(145deg, #f2f3ff, #ffffff, #eef0ff);
                }
            </style>
            <!-- bagian pop up edit dan tambah -->

            <?php include 'fitur/js.php'; ?>
</body>

</html>