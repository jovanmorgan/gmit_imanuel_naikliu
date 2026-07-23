<?php include 'fitur/penggunah.php'; ?>
<!DOCTYPE html>
<html lang="en">
<?php include 'fitur/head.php'; ?>
<style>
    .gereja-gallery h2 {
    color: #2c3e50;
}

.gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 25px;
}

.gallery-item {
    position: relative;
    overflow: hidden;
    border-radius: 25px;
    height: 300px;
    cursor: pointer;
    box-shadow: 0 15px 35px rgba(0,0,0,.15);
    transition: all .4s ease;
}

.gallery-item:hover {
    transform: translateY(-10px);
    box-shadow: 0 25px 45px rgba(0,0,0,.25);
}

.gallery-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: .6s ease;
}

.gallery-item:hover img {
    transform: scale(1.15);
}

.gallery-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(
        to top,
        rgba(0,0,0,.85),
        rgba(0,0,0,.1)
    );

    display: flex;
    flex-direction: column;
    justify-content: end;
    padding: 25px;

    color: white;
    opacity: 0;
    transition: .4s;
}

.gallery-item:hover .gallery-overlay {
    opacity: 1;
}

.gallery-overlay h5 {
    font-weight: 700;
    margin-bottom: 5px;
}

.gallery-overlay p {
    margin: 0;
    opacity: .85;
}

/* LIGHTBOX */
#lightbox {
    display: none;
    position: fixed;
    z-index: 99999;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,.9);
    backdrop-filter: blur(5px);
}

#lightbox img {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%,-50%);
    max-width: 90%;
    max-height: 90%;
    border-radius: 20px;
    box-shadow: 0 0 40px rgba(255,255,255,.2);
}
.dashboard-card{
    border-radius:20px;
    transition:0.3s;
}

.dashboard-card:hover{
    transform:translateY(-8px);
    box-shadow:0 15px 35px rgba(0,0,0,.15)!important;
}

.icon-circle{
    width:65px;
    height:65px;
    border-radius:50%;
    display:flex;
    justify-content:center;
    align-items:center;
    color:white;
    font-size:24px;
}

.gallery-card{
    border-radius:20px;
    overflow:hidden;
    transition:0.3s;
}

.gallery-card:hover{
    transform:scale(1.03);
}

.gallery-card img{
    height:220px;
    object-fit:cover;
}
</style>
<body>
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
                        
                        // Ambil 5 pelayanan terbaru
$pelayananTerbaru = mysqli_query(
    $koneksi,
    "SELECT * FROM pelayanan
     ORDER BY hari_tanggal_bulan DESC, waktu DESC
     LIMIT 5"
);
                        $query = "SELECT COUNT(*) as count FROM $table";
                        $result = mysqli_query($koneksi, $query);
                        $row = mysqli_fetch_assoc($result);
                        $counts[$table] = $row['count'];
                        mysqli_free_result($result);
                    }

                    ?>
                    <?php include 'fitur/nama_halaman.php'; ?>

                  <section class="mb-4">
    <div class="card border-0 shadow-lg overflow-hidden"
         style="border-radius:25px;
                background: linear-gradient(135deg,#0d6efd,#6610f2);">
        <div class="card-body p-5 text-white">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="fw-bold mb-3">
                        Selamat Datang di Dashboard Gereja
                    </h1>

                    <p class="fs-5 opacity-75">
                        Kelola data gereja, jemaat, pelayanan,
                        dan administrasi dengan mudah dan profesional.
                    </p>

                    <div class="mt-4">
                        <span class="badge bg-light text-dark p-2 me-2">
                            Total Jemaat: <?= $counts['jemaat']; ?>
                        </span>

                        <span class="badge bg-warning text-dark p-2">
                            Pelayanan: <?= $counts['pelayanan']; ?>
                        </span>
                    </div>
                </div>

                <div class="col-lg-4 text-center">
                    <i class="fas fa-church"
                       style="font-size:120px;opacity:0.3"></i>
                </div>
            </div>
        </div>
    </div>
</section>
                    
                            
          

<!-- LIGHTBOX -->
<div id="lightbox" onclick="closeLightbox()">
    <img id="lightbox-img">
</div>
                    
                 <div class="card shadow-lg border-0 mt-5"
     style="border-radius:20px; overflow:hidden;">

    <div class="card-header border-0 text-white"
         style="background: linear-gradient(135deg,#0d6efd,#6610f2);">
        <h4 class="fw-bold mb-0">
            <i class="fas fa-church me-2"></i>
            Pelayanan Terbaru
        </h4>
    </div>

    <div class="card-body">

        <?php if(mysqli_num_rows($pelayananTerbaru) > 0): ?>

            <?php while($p = mysqli_fetch_assoc($pelayananTerbaru)): ?>

                <div class="d-flex align-items-start mb-4 p-3 shadow-sm rounded"
                     style="transition:.3s;background:#f8f9fa;">

                    <div class="me-3">
                        <div style="
                            width:55px;
                            height:55px;
                            border-radius:50%;
                            background:linear-gradient(135deg,#0d6efd,#6610f2);
                            color:white;
                            display:flex;
                            align-items:center;
                            justify-content:center;
                            font-size:22px;">
                            <i class="fas fa-cross"></i>
                        </div>
                    </div>

                    <div class="flex-grow-1">

                        <h5 class="fw-bold mb-1">
                            <?= htmlspecialchars($p['pemimpin']); ?>
                        </h5>

                        <p class="mb-1 text-muted">
                            <i class="fas fa-map-marker-alt text-danger"></i>
                            <?= htmlspecialchars($p['tempat']); ?>
                        </p>

                        <small class="text-secondary">
                            <i class="fas fa-calendar-alt"></i>
                            <?= date('d F Y', strtotime($p['hari_tanggal_bulan'])); ?>

                            &nbsp; | &nbsp;

                            <i class="fas fa-clock"></i>
                            <?= htmlspecialchars($p['waktu']); ?>
                        </small>

                    </div>

                </div>

            <?php endwhile; ?>

        <?php else: ?>

            <div class="text-center py-5">
                <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">
                    Belum ada data pelayanan
                </h5>
            </div>

        <?php endif; ?>

    </div>
</div>

                    <section class="section">
                        <div class="row">

                            <div class="row">
                                <!-- Kartu untuk tiap tabel -->
                                <?php foreach ($tables as $table => $details): ?>
                                    <div class="col-md-3 mb-4">
    <div class="card border-0 shadow-lg h-100 dashboard-card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted">
                        <?= $details['label']; ?>
                    </h6>

                    <h2 class="fw-bold">
                        <?= $counts[$table]; ?>
                    </h2>
                </div>

                <div class="icon-circle"
                     style="background: <?= $details['color']; ?>;">
                    <i class="<?= $details['icon']; ?>"></i>
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

            <?php
                                mysqli_close($koneksi);
include 'fitur/footer.php'; ?>
        </div>

    </div>
    <?php include 'fitur/js.php'; ?>
    <script>
function openLightbox(src) {
    document.getElementById("lightbox").style.display = "block";
    document.getElementById("lightbox-img").src = src;
}

function closeLightbox() {
    document.getElementById("lightbox").style.display = "none";
}
</script>
</body>

</html>