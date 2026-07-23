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
                    <style>
                        body {
                            background: #f7f7f7;
                            font-family: "Times New Roman", serif;
                        }

                        #pdfContent {
                            background: white;
                            padding: 40px 50px;
                            border-radius: 12px;
                            box-shadow: 0px 0px 18px rgba(0, 0, 0, 0.15);
                        }

                        /* Kop Surat */
                        .kop-surat {
                            border-bottom: 3px solid #000;
                            padding-bottom: 15px;
                            margin-bottom: 30px;
                        }

                        .kop-surat img {
                            width: 95px;
                            height: auto;
                        }

                        .kop-surat h4,
                        .kop-surat h5 {
                            font-weight: bold;
                        }

                        /* Judul */
                        .judul-laporan {
                            font-size: 28px;
                            font-weight: bold;
                            text-transform: uppercase;
                            margin-bottom: 25px;
                            color: #333;
                        }

                        /* Tabel */
                        table {
                            width: 100%;
                            border-radius: 8px;
                            overflow: hidden;
                            font-size: 14px;
                        }

                        thead {
                            background: #343a40;
                            color: white;
                        }

                        tbody tr:nth-child(even) {
                            background: #f2f2f2;
                        }

                        th,
                        td {
                            padding: 10px 12px;
                            border: 1px solid #ddd;
                        }

                        td img {
                            border-radius: 8px;
                            box-shadow: 0px 0px 6px rgba(0, 0, 0, 0.25);
                        }

                        /* Tanda tangan */
                        .ttd {
                            margin-top: 40px;
                            text-align: right;
                            padding-right: 40px;
                        }

                        .ttd p {
                            margin: 2px 0;
                            font-size: 16px;
                        }

                        #downloadPDF {
                            border-radius: 8px;
                            padding: 10px 20px;
                            font-weight: bold;
                        }
                    </style>
                    <?php
                    include '../../keamanan/koneksi.php';

                    /* -----------------------------
   AMBIL DATA PENDETA UNTUK TTD
-------------------------------- */
                    $q_pendeta = mysqli_query(
                        $koneksi,
                        "SELECT id_pendeta, nama_lengkap FROM pendeta ORDER BY id_pendeta ASC LIMIT 1"
                    );
                    $data_pendeta = mysqli_fetch_assoc($q_pendeta);

                    $nama_pendeta = $data_pendeta['nama_lengkap'] ?? 'Pendeta';
                    ?>

                    <div class="container" id="pdfContent">

                        <!-- KOP SURAT -->
                        <div class="row kop-surat">
                            <div class="col-2 text-right">
                                <img src="../../assets/img/gereja/logo.png">
                            </div>

                            <div class="col-8 text-center">
                                <h4>GEREJA GMIT</h4>
                                <h5>DATA JEMAAT</h5>
                                <p style="margin:0;">Laporan Jemaat Sistem Informasi Gereja</p>
                            </div>
                        </div>

                        <!-- JUDUL -->
                        <h3 class="text-center judul-laporan">
                            LAPORAN DATA JEMAAT
                        </h3>

                        <!-- TABEL -->
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Rayon</th>
                                        <th>Nama Lengkap</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Status Keluarga</th>
                                        <th>Tempat Lahir</th>
                                        <th>Tanggal Lahir</th>
                                        <th>Foto Profil</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    $query = "
                        SELECT jemaat.*, rayon.nama_rayon 
                        FROM jemaat 
                        LEFT JOIN rayon ON rayon.id_rayon = jemaat.id_rayon
                        ORDER BY jemaat.id_jemaat DESC
                    ";
                                    $result = mysqli_query($koneksi, $query);

                                    $no = 1;
                                    while ($row = mysqli_fetch_assoc($result)):
                                        $tgl = date('d-m-Y', strtotime($row['tanggal_lahir']));
                                    ?>

                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= htmlspecialchars($row['nama_rayon'] ?? '-'); ?></td>
                                            <td><?= htmlspecialchars($row['nama_lengkap']); ?></td>
                                            <td><?= htmlspecialchars($row['jenis_kelamin']); ?></td>
                                            <td><?= htmlspecialchars($row['status_keluarga']); ?></td>
                                            <td><?= htmlspecialchars($row['tempat_lahir']); ?></td>
                                            <td><?= $tgl; ?></td>
                                            <td>
                                                <?php if (!empty($row['fp'])): ?>
                                                    <img src="../../assets/img/foto_jemaat/<?= $row['fp']; ?>"
                                                        style="width:60px; height:60px; object-fit:cover;">
                                                <?php else: ?>
                                                    -
                                                <?php endif; ?>
                                            </td>
                                        </tr>

                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- TANDA TANGAN -->
                        <div class="text-right mt-5" style="width: 280px; margin-right:10px;">
                            <p id="date" class="mb-1"></p>
                            <p class="mb-1">Mengetahui,</p>
                            <p class="mb-3"><strong>Pendeta Gereja</strong></p>

                            <!-- Gambar Tanda Tangan -->
                            <?php
                            $ttd_path = "../../assets/img/gereja/tanda_tangan.png";
                            if (file_exists($ttd_path)):
                            ?>
                                <img src="<?= $ttd_path ?>" style="width: 120px; height:auto; margin-bottom: 5px;">
                            <?php endif; ?>

                            <!-- Nama Pendeta -->
                            <p class="mt-1"><strong><?= $nama_pendeta; ?></strong></p>
                        </div>


                    </div>

                    <!-- BUTTON DOWNLOAD -->
                    <div class="text-center mt-4 mb-4">
                        <button id="downloadPDF" class="btn btn-primary">Download PDF</button>
                    </div>

                    <!-- html2pdf -->
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js">
                    </script>

                    <script>
                        document.addEventListener("DOMContentLoaded", () => {
                            const dateElement = document.getElementById("date");
                            const today = new Date();
                            const options = {
                                day: 'numeric',
                                month: 'long',
                                year: 'numeric'
                            };
                            dateElement.textContent = "Kupang, " + today.toLocaleDateString('id-ID', options);
                        });

                        document.getElementById("downloadPDF").addEventListener("click", function() {
                            const element = document.getElementById("pdfContent");

                            const opt = {
                                margin: 10,
                                filename: "Laporan_<?php echo $page_title; ?>.pdf",
                                image: {
                                    type: "jpeg",
                                    quality: 1
                                },
                                html2canvas: {
                                    scale: 2,
                                    scrollY: 0,
                                    scrollX: 0
                                },
                                jsPDF: {
                                    unit: "mm",
                                    format: [297, 210], // Landscape A4
                                    orientation: "landscape",
                                },
                            };

                            html2pdf().from(element).set(opt).save();
                        });
                    </script>



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