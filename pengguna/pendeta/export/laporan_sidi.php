<?php include '../fitur/nama_halaman.php'; ?>
<!DOCTYPE html>
<html lang="id">

<?php
include '../../../keamanan/koneksi.php';

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

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan <?php echo $page_title; ?></title>

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- STYLE FULL CUSTOM -->
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
</head>

<body>

    <div class="container" id="pdfContent">

        <!-- KOP SURAT -->
        <div class="row kop-surat">
            <div class="col-2 text-right">
                <img src="../../../assets/img/gereja/logo.png">
            </div>

            <div class="col-8 text-center">
                <h4>GEREJA GMIT</h4>
                <h5>DATA SIDI</h5>
                <p style="margin:0;">Laporan Sidi Sistem Informasi Gereja</p>
            </div>
        </div>

        <!-- JUDUL -->
        <h3 class="text-center judul-laporan">
            LAPORAN DATA SIDI
        </h3>

        <!-- TABEL -->
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID Sidi</th>
                        <th>ID Rayon</th>
                        <th>Nama Jemaat</th>
                        <th>Username</th>
                        <th>Jenis Kelamin</th>
                        <th>Status Keluarga</th>
                        <th>Tempat Lahir</th>
                        <th>Tanggal Lahir</th>
                        <th>Akta Kelahiran</th>
                        <th>Surat Babtis</th>
                        <th>Foto FP</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $search = isset($_GET['search']) ? $_GET['search'] : '';
                    $page   = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                    $limit  = 10;
                    $offset = ($page - 1) * $limit;

                    // ==========================================
                    // QUERY JOIN SIDI + JEMAAT (SEMUA KOLOM)
                    // ==========================================
                    $query = "
                SELECT 
                    sidi.id_sidi,
                    sidi.akta_kelahiran,
                    sidi.surat_babtis,

                    jemaat.id_jemaat,
                    jemaat.id_rayon,
                    jemaat.nama_lengkap,
                    jemaat.username,
                    jemaat.jenis_kelamin,
                    jemaat.status_keluarga,
                    jemaat.tempat_lahir,
                    jemaat.tanggal_lahir,
                    jemaat.fp

                FROM sidi
                INNER JOIN jemaat ON jemaat.id_jemaat = sidi.id_jemaat

                WHERE 
                    jemaat.nama_lengkap LIKE ?
                    OR jemaat.username LIKE ?
                    OR jemaat.jenis_kelamin LIKE ?
                    OR jemaat.status_keluarga LIKE ?

                ORDER BY sidi.id_sidi DESC
                LIMIT ?, ?
            ";

                    $param = "%$search%";
                    $stmt = $koneksi->prepare($query);
                    $stmt->bind_param("ssssii", $param, $param, $param, $param, $offset, $limit);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    // ============================
                    // HITUNG TOTAL DATA
                    // ============================
                    $count = "
                SELECT COUNT(*) AS total
                FROM sidi
                INNER JOIN jemaat ON jemaat.id_jemaat = sidi.id_jemaat
                WHERE 
                    jemaat.nama_lengkap LIKE ?
                    OR jemaat.username LIKE ?
                    OR jemaat.jenis_kelamin LIKE ?
                    OR jemaat.status_keluarga LIKE ?
            ";
                    $stmt2 = $koneksi->prepare($count);
                    $stmt2->bind_param("ssss", $param, $param, $param, $param);
                    $stmt2->execute();
                    $total = $stmt2->get_result()->fetch_assoc();
                    $total_pages = ceil($total['total'] / $limit);

                    $no = $offset + 1;

                    while ($row = $result->fetch_assoc()):
                    ?>

                        <tr>
                            <td><?= $no++; ?></td>

                            <td><?= $row['id_sidi'] ?></td>
                            <td><?= $row['id_rayon'] ?></td>
                            <td><?= htmlspecialchars($row['nama_lengkap']) ?></td>
                            <td><?= htmlspecialchars($row['username']) ?></td>
                            <td><?= htmlspecialchars($row['jenis_kelamin']) ?></td>
                            <td><?= htmlspecialchars($row['status_keluarga']) ?></td>
                            <td><?= htmlspecialchars($row['tempat_lahir']) ?></td>

                            <td>
                                <?php
                                $tgl = date("d-m-Y", strtotime($row['tanggal_lahir']));
                                echo $tgl;
                                ?>
                            </td>

                            <td>
                                <a href="../../../../assets/sidi/<?= $row['akta_kelahiran'] ?>" target="_blank"
                                    class="btn btn-sm btn-info">
                                    Lihat Akta
                                </a>
                            </td>

                            <td>
                                <a href="../../../../assets/sidi/<?= $row['surat_babtis'] ?>" target="_blank"
                                    class="btn btn-sm btn-primary">
                                    Lihat Babtis
                                </a>
                            </td>

                            <td>
                                <?php if (!empty($row['fp'])): ?>
                                    <a href="../../../../assets/fp/<?= $row['fp'] ?>" target="_blank"
                                        class="btn btn-sm btn-success">
                                        Lihat FP
                                    </a>
                                <?php else: ?>
                                    <span class="text-danger">Tidak Ada</span>
                                <?php endif; ?>
                            </td>

                        </tr>

                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>


        <!-- TANDA TANGAN -->
        <div class="text-right mt-5" style="width: 280px; margin-left:auto;">
            <p id="date" class="mb-1"></p>
            <p class="mb-1">Mengetahui,</p>
            <p class="mb-3"><strong>Pendeta Gereja</strong></p>

            <!-- Gambar Tanda Tangan -->
            <?php
            $ttd_path = "../../../assets/img/gereja/tanda_tangan.png";
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>

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

</body>

</html>