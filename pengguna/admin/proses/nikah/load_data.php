    <div id="load_data">

        <!-- SEARCH -->
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body text-center">

                            <form method="GET" action="">
                                <div class="input-group mt-3">
                                    <input type="text" class="form-control" placeholder="Cari jemaat atau file..."
                                        name="search"
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

/*
|--------------------------------------------------------------------------
| FUNGSI TOMBOL FILE
|--------------------------------------------------------------------------
*/
function tombolFile($file, $label, $class)
{
    if (empty($file)) {
        return '<span class="badge bg-secondary">Tidak Ada</span>';
    }

    return '
        <a href="../../assets/file/' . htmlspecialchars($file) . '" 
           target="_blank" 
           class="btn btn-sm ' . $class . '">
           Lihat
        </a>
    ';
}

/*
|--------------------------------------------------------------------------
| QUERY DATA
|--------------------------------------------------------------------------
*/
$query = "
SELECT 
    nikah.id_nikah,
    nikah.surat_sidi_pengantin,
    nikah.surat_babtis_pengantin,
    nikah.surat_nikah_saksi,
    nikah.akta_kelahiran_saksi,
    jemaat.id_jemaat,
    jemaat.nama_lengkap,
    jemaat.jenis_kelamin,
    jemaat.tanggal_lahir
FROM nikah
INNER JOIN jemaat 
    ON nikah.id_jemaat = jemaat.id_jemaat
WHERE
    jemaat.nama_lengkap LIKE ?
    OR nikah.surat_sidi_pengantin LIKE ?
    OR nikah.surat_babtis_pengantin LIKE ?
    OR nikah.surat_nikah_saksi LIKE ?
    OR nikah.akta_kelahiran_saksi LIKE ?
ORDER BY nikah.id_nikah DESC
LIMIT ?, ?
";

$stmt = $koneksi->prepare($query);

$param = "%$search%";

/* PERBAIKAN DISINI */
$stmt->bind_param(
    "sssssii",
    $param,
    $param,
    $param,
    $param,
    $param,
    $offset,
    $limit
);

$stmt->execute();
$result = $stmt->get_result();

/*
|--------------------------------------------------------------------------
| TOTAL DATA
|--------------------------------------------------------------------------
*/
$countQuery = "
SELECT COUNT(*) AS total
FROM nikah
INNER JOIN jemaat 
    ON nikah.id_jemaat = jemaat.id_jemaat
WHERE
    jemaat.nama_lengkap LIKE ?
    OR nikah.surat_sidi_pengantin LIKE ?
    OR nikah.surat_babtis_pengantin LIKE ?
    OR nikah.surat_nikah_saksi LIKE ?
    OR nikah.akta_kelahiran_saksi LIKE ?
";

$stmt2 = $koneksi->prepare($countQuery);

$stmt2->bind_param(
    "sssss",
    $param,
    $param,
    $param,
    $param,
    $param
);

$stmt2->execute();

$total = $stmt2->get_result()->fetch_assoc();
$total_pages = ceil($total['total'] / $limit);
?>

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">

                    <div style="overflow-x:auto;">

                        <?php if ($result->num_rows > 0): ?>

                        <table class="table table-hover text-center mt-3">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Jemaat</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Surat Sidi</th>
                                    <th>Surat Babtis</th>
                                    <th>Surat Nikah Saksi</th>
                                    <th>Akta Kelahiran Saksi</th>
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

                                    <td><?= htmlspecialchars($row['nama_lengkap']); ?></td>

                                    <td><?= htmlspecialchars($row['jenis_kelamin']); ?></td>

                                    <td>
                                        <?= date('d-m-Y', strtotime($row['tanggal_lahir'])); ?>
                                    </td>

                                    <td>
                                        <?= tombolFile(
                                            $row['surat_sidi_pengantin'],
                                            'Surat Sidi',
                                            'btn-primary'
                                        ); ?>
                                    </td>

                                    <td>
                                        <?= tombolFile(
                                            $row['surat_babtis_pengantin'],
                                            'Surat Babtis',
                                            'btn-success'
                                        ); ?>
                                    </td>

                                    <td>
                                        <?= tombolFile(
                                            $row['surat_nikah_saksi'],
                                            'Surat Nikah Saksi',
                                            'btn-warning'
                                        ); ?>
                                    </td>

                                    <td>
                                        <?= tombolFile(
                                            $row['akta_kelahiran_saksi'],
                                            'Akta Saksi',
                                            'btn-info'
                                        ); ?>
                                    </td>

                                    <td>
                                        <div class="d-flex justify-content-center gap-1">

                                            <button
                                                class="btn btn-warning btn-sm"
                                                onclick="openEditModal(
                                                    '<?= $row['id_nikah'] ?>',
                                                    '<?= $row['id_jemaat'] ?>',
                                                    '<?= htmlspecialchars($row['surat_sidi_pengantin'], ENT_QUOTES) ?>',
                                                    '<?= htmlspecialchars($row['surat_babtis_pengantin'], ENT_QUOTES) ?>',
                                                    '<?= htmlspecialchars($row['surat_nikah_saksi'], ENT_QUOTES) ?>',
                                                    '<?= htmlspecialchars($row['akta_kelahiran_saksi'], ENT_QUOTES) ?>'
                                                )">
                                                Edit
                                            </button>

                                            <button
                                                class="btn btn-danger btn-sm"
                                                onclick="hapus('<?= $row['id_nikah'] ?>')">
                                                Hapus
                                            </button>

                                        </div>
                                    </td>

                                </tr>
                                <?php endwhile; ?>

                            </tbody>
                        </table>

                        <?php else: ?>

                        <div class="text-center mt-4">
                            Data tidak ditemukan.
                        </div>

                        <?php endif; ?>

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

=======
        <?php
        include '../../../../keamanan/koneksi.php';

        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;

        // ============================
        // QUERY DATA NIKAH + JEMAAT
        // ============================
        $query = "
        SELECT 
            nikah.id_nikah,
            nikah.surat_sidi_pengantin,
            nikah.surat_babtis_pengantin,
            nikah.surat_nikah_saksi,
            nikah.akta_kelahiran_saksi,
            jemaat.id_jemaat,
            jemaat.nama_lengkap,
            jemaat.jenis_kelamin,
            jemaat.tanggal_lahir
        FROM nikah
        INNER JOIN jemaat ON nikah.id_jemaat = jemaat.id_jemaat
        WHERE 
            jemaat.nama_lengkap LIKE ?
            OR nikah.surat_sidi_pengantin LIKE ?
            OR nikah.surat_babtis_pengantin LIKE ?
            OR nikah.surat_nikah_saksi LIKE ?
            OR nikah.akta_kelahiran_saksi LIKE ?
        ORDER BY nikah.id_nikah DESC
        LIMIT ?, ?
    ";

        $stmt = $koneksi->prepare($query);
        $param = "%$search%";
        $stmt->bind_param("ssssssi", $param, $param, $param, $param, $param, $offset, $limit);
        $stmt->execute();
        $result = $stmt->get_result();

        // ============================
        // HITUNG TOTAL DATA
        // ============================
        $countQuery = "
        SELECT COUNT(*) AS total
        FROM nikah
        INNER JOIN jemaat ON nikah.id_jemaat = jemaat.id_jemaat
        WHERE 
            jemaat.nama_lengkap LIKE ?
            OR nikah.surat_sidi_pengantin LIKE ?
            OR nikah.surat_babtis_pengantin LIKE ?
            OR nikah.surat_nikah_saksi LIKE ?
            OR nikah.akta_kelahiran_saksi LIKE ?
    ";

        $stmt2 = $koneksi->prepare($countQuery);
        $stmt2->bind_param("sssss", $param, $param, $param, $param, $param);
        $stmt2->execute();
        $total = $stmt2->get_result()->fetch_assoc();
        $total_pages = ceil($total['total'] / $limit);
        ?>

        <!-- TABEL -->
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
                                            <th>Nama Jemaat</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Tanggal Lahir</th>
                                            <th>Surat Sidi Pengantin</th>
                                            <th>Surat Babtis Pengantin</th>
                                            <th>Surat Nikah Saksi</th>
                                            <th>Akta Kelahiran Saksi</th>
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
                                            <td><?= htmlspecialchars($row['nama_lengkap']) ?></td>
                                            <td><?= htmlspecialchars($row['jenis_kelamin']) ?></td>

                                            <?php
                                                    $tanggal = date("d-m-Y", strtotime($row['tanggal_lahir']));
                                                    ?>
                                            <td><?= $tanggal ?></td>

                                            <!-- FILE TOMBOL -->
                                            <?php
                                                    function tombolFile($file, $label, $class)
                                                    {
                                                        if ($file == "") {
                                                            return '<span class="badge bg-secondary">Tidak Ada</span>';
                                                        }
                                                        return '
                                                        <a href="../../assets/file/' . $file . '" 
                                                            target="_blank" 
                                                            class="btn btn-sm ' . $class . '">
                                                            ' . $label . '
                                                        </a>';
                                                    }
                                                    ?>

                                            <td><?= tombolFile($row['surat_sidi_pengantin'], "Surat Sidi", "btn-primary") ?>
                                            </td>
                                            <td><?= tombolFile($row['surat_babtis_pengantin'], "Surat Babtis", "btn-success") ?>
                                            </td>
                                            <td><?= tombolFile($row['surat_nikah_saksi'], "Surat Nikah Saksi", "btn-warning") ?>
                                            </td>
                                            <td><?= tombolFile($row['akta_kelahiran_saksi'], "Akta Saksi", "btn-info") ?>
                                            </td>

                                            <td style="display:flex; gap:5px; justify-content:center;">
                                                <button class="btn btn-warning btn-sm" onclick="openEditModal(
                                                            '<?= $row['id_nikah'] ?>',
                                                            '<?= $row['id_jemaat'] ?>',
                                                            '<?= $row['surat_sidi_pengantin'] ?>',
                                                            '<?= $row['surat_babtis_pengantin'] ?>',
                                                            '<?= $row['surat_nikah_saksi'] ?>',
                                                            '<?= $row['akta_kelahiran_saksi'] ?>'
                                                        )">
                                                    Edit
                                                </button>

                                                <button class="btn btn-danger btn-sm"
                                                    onclick="hapus('<?= $row['id_nikah'] ?>')">Hapus</button>
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
>>>>>>> 4103a0366611edb09f83497d66e49d67f25169a0
                    </div>

                </div>
            </div>
<<<<<<< HEAD

        </div>
    </div>
</section>
=======
        </section>
>>>>>>> 4103a0366611edb09f83497d66e49d67f25169a0

    </div>