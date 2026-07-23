<?php include 'fitur/penggunah.php'; ?>
<!DOCTYPE html>
<html lang="en">
<?php include 'fitur/head.php'; ?>

<body>
<<<<<<< HEAD
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
=======
>>>>>>> 4103a0366611edb09f83497d66e49d67f25169a0
    <div class="wrapper">
        <?php include 'fitur/sidebar.php'; ?>
        <div class="main-panel">
            <?php include 'fitur/navbar.php'; ?>
            <div class="container">
                <div class="page-inner">
                    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                        <div>
                            <h3 class="fw-bold mb-3">Dashboard</h3>
                            <h6 class="op-7 mb-2">Halaman Dasboard</h6>
                        </div>
                    </div>

                    <?php
                    include '../../keamanan/koneksi.php';
                    $tables = [
                        'pendeta' => [
                            'label' => 'Pendeta',
                            'icon' => 'fas fa-user',
                            'color' => '#007bff'
                        ],
                        'majelis' => [
                            'label' => 'Majelis',
                            'icon' => 'fas fa-users',
                            'color' => '#5c0aa3ff'
                        ],
                        'rayon' => [
                            'label' => 'Rayon',
                            'icon' => 'fas fa-map',
                            'color' => '#dc3545'
                        ],
                        'jemaat' => [
                            'label' => 'Jemaat',
                            'icon' => 'fas fa-bullhorn',
                            'color' => '#28a745'
                        ],
                        'pelayanan' => [
                            'label' => 'Pelayanan',
                            'icon' => 'fas fa-bullhorn',
                            'color' => '#def325ff'
                        ],
                        'sidi' => [
                            'label' => 'Sidi',
                            'icon' => 'fas fa-bullhorn',
                            'color' => '#ec3065ff'
                        ],
                        'nikah' => [
                            'label' => 'Nikah',
                            'icon' => 'fas fa-bullhorn',
                            'color' => '#de702cff'
                        ],
                        'babtis' => [
                            'label' => 'Babtis',
                            'icon' => 'fas fa-bullhorn',
                            'color' => '#43a0e1ff'
                        ],
                    ];
                    // Menghitung total data dari setiap tabel
                    $counts = [];
                    foreach ($tables as $table => $details) {
                        $query = "SELECT COUNT(*) as count FROM $table";
                        $result = mysqli_query($koneksi, $query);
                        $row = mysqli_fetch_assoc($result);
                        $counts[$table] = $row['count'];
                        mysqli_free_result($result);
                    }

                    mysqli_close($koneksi);
                    ?>
                    <?php include 'fitur/nama_halaman.php'; ?>

<<<<<<< HEAD
                    <section class="gereja-hero">
                        <div class="gereja-hero-overlay">
                            <h1 class="hero-title">GMIT Imanuel Naikliu</h1>
                            <p class="hero-subtitle">Klasis Amfoang Utara · Kabupaten Kupang, NTT</p>
                        </div>
                    </section>

                    <section class="section mt-3">
=======
                    <section class="section">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <h5 class="card-title" style="font-size: 30px;">Selamat Datang</h5>
                                        <p>
                                            Silakan lihat informsi yang kami sajikan pada website ini, Berikut
                                            adalah
                                            informasi data pada Halaman
                                            <?= $page_title ?>.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="section">
>>>>>>> 4103a0366611edb09f83497d66e49d67f25169a0
                        <div class="row">

                            <div class="row">
                                <!-- Kartu untuk tiap tabel -->
                                <?php foreach ($tables as $table => $details): ?>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="card card-stats card-round">
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col-icon">
                                                        <div class="icon-big text-center icon-secondary bubble-shadow-small"
                                                            style="background-color: <?= $details['color']; ?>;">
                                                            <i class="<?= $details['icon']; ?>"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col col-stats ms-3 ms-sm-0">
                                                        <div class="numbers">
                                                            <p class="card-category"><?= $details['label']; ?></p>
                                                            <h4 class="card-title"><?= $counts[$table]; ?></h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>


                            </div>

                        </div>
                    </section>

                </div>
            </div>

            <?php include 'fitur/footer.php'; ?>
        </div>

    </div>
    <?php include 'fitur/js.php'; ?>
</body>

</html>