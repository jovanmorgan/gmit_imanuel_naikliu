<div id="load_data">

    <!-- Search -->
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body text-center">

                        <form method="GET" action="">
                            <div class="input-group mt-3">
                                <input type="text" class="form-control" placeholder="Cari pelayanan..." name="search"
                                    value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                                <button class="btn btn-outline-secondary" type="submit">Cari</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>

<<<<<<< HEAD
   
                     <?php
include '../../../../keamanan/koneksi.php';

$search = isset($_GET['search']) ? $_GET['search'] : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

// -----------------------
// QUERY DATA + SEARCH
// -----------------------
$query = "
    SELECT
        pelayanan.*,
        rayon.nama_rayon,
        jemaat.nama_lengkap
    FROM pelayanan

    LEFT JOIN rayon
        ON pelayanan.id_rayon = rayon.id_rayon

    LEFT JOIN jemaat
        ON pelayanan.id_jemaat = jemaat.id_jemaat

    WHERE
        pelayanan.hari_tanggal_bulan LIKE ?
        OR pelayanan.waktu LIKE ?
        OR pelayanan.tempat LIKE ?
        OR pelayanan.pemimpin LIKE ?
        OR rayon.nama_rayon LIKE ?
        OR jemaat.nama_lengkap LIKE ?

    ORDER BY pelayanan.hari_tanggal_bulan DESC
    LIMIT ?, ?
";

$stmt = $koneksi->prepare($query);

$search_param = "%$search%";

$stmt->bind_param(
    "ssssssii",
    $search_param,
    $search_param,
    $search_param,
    $search_param,
    $search_param,
    $search_param,
    $offset,
    $limit
);

$stmt->execute();
$result = $stmt->get_result();

// -----------------------
// HITUNG TOTAL DATA
// -----------------------
$countQuery = "
    SELECT COUNT(*) AS total
    FROM pelayanan

    LEFT JOIN rayon
        ON pelayanan.id_rayon = rayon.id_rayon

    LEFT JOIN jemaat
        ON pelayanan.id_jemaat = jemaat.id_jemaat

    WHERE
        pelayanan.hari_tanggal_bulan LIKE ?
        OR pelayanan.waktu LIKE ?
        OR pelayanan.tempat LIKE ?
        OR pelayanan.pemimpin LIKE ?
        OR rayon.nama_rayon LIKE ?
        OR jemaat.nama_lengkap LIKE ?
";

$stmt2 = $koneksi->prepare($countQuery);

$stmt2->bind_param(
    "ssssss",
    $search_param,
    $search_param,
    $search_param,
    $search_param,
    $search_param,
    $search_param
);

$stmt2->execute();

$total = $stmt2->get_result()->fetch_assoc();
$total_pages = ceil($total['total'] / $limit);
?>

<!-- Tabel -->
<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body" style="overflow-x: hidden;">

                    <div style="overflow-x: auto;">

                        <?php if ($result->num_rows > 0): ?>

                        <table class="table table-hover text-center mt-3">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Hari / Tanggal / Bulan</th>
                                    <th>Waktu</th>
                                    <th>Tempat</th>
                                    <th>Pemimpin</th>
                                    <th>Rayon</th>
                                    <th>Jemaat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tbody>

                                <?php
                                $no = $offset + 1;

                                while ($row = $result->fetch_assoc()):
                                ?>

                                <tr>

                                    <td><?= $no++; ?></td>

                                    <?php
                                    setlocale(LC_TIME, 'id_ID.UTF-8', 'Indonesian', 'ID');

                                    $tanggal_db = $row['hari_tanggal_bulan'];
                                    $tanggal_timestamp = strtotime($tanggal_db);

                                    $format_tanggal = strftime(
                                        "%A, %d %B %Y",
                                        $tanggal_timestamp
                                    );
                                    ?>

                                    <td><?= htmlspecialchars($format_tanggal) ?></td>

                                    <td><?= htmlspecialchars($row['waktu']) ?></td>

                                    <td><?= htmlspecialchars($row['tempat']) ?></td>

                                    <td><?= htmlspecialchars($row['pemimpin']) ?></td>

                                    <td>
                                        <?= !empty($row['nama_rayon']) 
                                            ? 'Rayon ' . htmlspecialchars($row['nama_rayon']) 
                                            : '-' ?>
                                    </td>

                                    <td>
                                        <?= !empty($row['nama_lengkap']) 
                                            ? htmlspecialchars($row['nama_lengkap']) 
                                            : '-' ?>
                                    </td>

                                    <td style="display:flex; gap:5px; justify-content:center;">

                                        <button
                                            class="btn btn-primary btn-sm"
                                            onclick="openEditModal(
                                                '<?= $row['id_pelayanan'] ?>',
                                                '<?= $row['hari_tanggal_bulan'] ?>',
                                                '<?= $row['waktu'] ?>',
                                                '<?= htmlspecialchars($row['tempat'], ENT_QUOTES) ?>',
                                                '<?= htmlspecialchars($row['pemimpin'], ENT_QUOTES) ?>',
                                                '<?= $row['id_rayon'] ?>',
                                                '<?= $row['id_jemaat'] ?>'
                                            )">
                                            Edit
                                        </button>

                                        <button
                                            class="btn btn-danger btn-sm"
                                            onclick="hapus('<?= $row['id_pelayanan'] ?>')">
                                            Hapus
                                        </button>

                                    </td>

                                </tr>

                                <?php endwhile; ?>

                            </tbody>
                        </table>

                        <?php else: ?>

                        <p class="text-center mt-4">
                            Data tidak ditemukan.
                        </p>

                        <?php endif; ?>

                        <!-- PAGINATION -->
                        <nav>
                            <ul class="pagination justify-content-center">

                                <?php for ($i = 1; $i <= $total_pages; $i++): ?>

                                <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">

                                    <a class="page-link"
                                        href="?page=<?= $i ?>&search=<?= urlencode($search) ?>">

                                        <?= $i ?>

                                    </a>

                                </li>

                                <?php endfor; ?>

                            </ul>
                        </nav>

                    </div>

                </div>
            </div>

        </div>
    </div>
</section>
=======
    <?php
    include '../../../../keamanan/koneksi.php';

    $search = isset($_GET['search']) ? $_GET['search'] : '';
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = 10;
    $offset = ($page - 1) * $limit;

    // -----------------------
    // QUERY DATA + SEARCH
    // -----------------------
    $query = "
        SELECT 
            id_pelayanan,
            hari_tanggal_bulan,
            waktu,
            tempat,
            pemimpin
        FROM pelayanan
        WHERE 
            hari_tanggal_bulan LIKE ?
            OR waktu LIKE ?
            OR tempat LIKE ?
            OR pemimpin LIKE ?
        ORDER BY hari_tanggal_bulan DESC
        LIMIT ?, ?
    ";

    $stmt = $koneksi->prepare($query);
    $search_param = "%$search%";
    $stmt->bind_param(
        "ssssii",
        $search_param,
        $search_param,
        $search_param,
        $search_param,
        $offset,
        $limit
    );
    $stmt->execute();
    $result = $stmt->get_result();

    // -----------------------
    // HITUNG TOTAL DATA
    // -----------------------
    $countQuery = "
        SELECT COUNT(*) AS total 
        FROM pelayanan
        WHERE 
            hari_tanggal_bulan LIKE ?
            OR waktu LIKE ?
            OR tempat LIKE ?
            OR pemimpin LIKE ?
    ";

    $stmt2 = $koneksi->prepare($countQuery);
    $stmt2->bind_param(
        "ssss",
        $search_param,
        $search_param,
        $search_param,
        $search_param
    );
    $stmt2->execute();
    $total = $stmt2->get_result()->fetch_assoc();
    $total_pages = ceil($total['total'] / $limit);
    ?>

    <!-- Tabel -->
    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body" style="overflow-x: hidden;">

                        <div style="overflow-x: auto;">
                            <?php if ($result->num_rows > 0): ?>
                                <table class="table table-hover text-center mt-3">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Hari / Tanggal / Bulan</th>
                                            <th>Waktu</th>
                                            <th>Tempat</th>
                                            <th>Pemimpin</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        $no = $offset + 1;
                                        while ($row = $result->fetch_assoc()):
                                        ?>
                                            <tr>
                                                <td><?= $no++; ?></td>
                                                <?php
                                                // Pastikan locale Indonesia aktif
                                                setlocale(LC_TIME, 'id_ID.UTF-8', 'Indonesian', 'ID');

                                                // Ambil tanggal dari database (format: YYYY-MM-DD)
                                                $tanggal_db = $row['hari_tanggal_bulan'];

                                                // Konversi ke timestamp
                                                $tanggal_timestamp = strtotime($tanggal_db);

                                                // Format menjadi: Senin, 25 Desember 2025
                                                $format_tanggal = strftime("%A, %d %B %Y", $tanggal_timestamp);
                                                ?>

                                                <td><?= htmlspecialchars($format_tanggal) ?></td>

                                                <td><?= htmlspecialchars($row['waktu']) ?></td>
                                                <td><?= htmlspecialchars($row['tempat']) ?></td>
                                                <td><?= htmlspecialchars($row['pemimpin']) ?></td>

                                                <td style="display:flex; gap:5px; justify-content:center;">
                                                    <button class="btn btn-primary btn-sm" onclick="openEditModal(
                                                    '<?= $row['id_pelayanan'] ?>',
                                                    '<?= $row['hari_tanggal_bulan'] ?>',
                                                    '<?= $row['waktu'] ?>',
                                                    '<?= $row['tempat'] ?>',
                                                    '<?= $row['pemimpin'] ?>'
                                                )">
                                                        Edit
                                                    </button>

                                                    <button class="btn btn-danger btn-sm"
                                                        onclick="hapus('<?= $row['id_pelayanan'] ?>')">
                                                        Hapus
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            <?php else: ?>
                                <p class="text-center mt-4">Data tidak ditemukan.</p>
                            <?php endif; ?>

                            <!-- PAGINATION -->
                            <nav>
                                <ul class="pagination justify-content-center">
                                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                        <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                                            <a class="page-link" href="?page=<?= $i ?>&search=<?= $search ?>">
                                                <?= $i ?>
                                            </a>
                                        </li>
                                    <?php endfor; ?>
                                </ul>
                            </nav>

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>
>>>>>>> 4103a0366611edb09f83497d66e49d67f25169a0

</div>