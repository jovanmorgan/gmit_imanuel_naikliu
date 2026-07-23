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

                    <div id="load_data">

                        <!-- SEARCH -->
                        <section class="section">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body text-center">

                                            <form method="GET" action="">
                                                <div class="input-group mt-3">
                                                    <input type="text" class="form-control"
                                                        placeholder="Cari jemaat atau file..." name="search"
                                                        value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                                                    <button class="btn btn-outline-secondary"
                                                        type="submit">Cari</button>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

<<<<<<< HEAD
                   <?php
include '../../keamanan/koneksi.php';

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

                    </div>

                </div>
            </div>

        </div>
    </div>
</section>
=======
                        <?php
                        include '../../keamanan/koneksi.php';

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
                                                            <a class="page-link"
                                                                href="?page=<?= $i ?>&search=<?= $search ?>">
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



                </div>
            </div>

            <!-- bagian pop up edit dan tambah -->
            <!-- Modal Tambah -->
            <div class="modal fade" id="tambahDataModal" tabindex="-1" aria-labelledby="tambahDataModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="tambahDataModalLabel">Tambah <?= $page_title ?></h5>
                            <button type="button" class="btn-close" id="closeTambahModal" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="tambahForm" method="POST" action="proses/<?= $current_page ?>/tambah.php"
                                enctype="multipart/form-data">

                                <!-- PILIH JEMAAT -->
                                <div class="mb-3">
                                    <label class="form-label">Nama Jemaat</label>
                                    <select name="id_jemaat" class="form-control" required>
                                        <option value="">-- Pilih Jemaat --</option>
                                        <?php
                                        $jemaat = $koneksi->query("SELECT id_jemaat, nama_lengkap FROM jemaat ORDER BY nama_lengkap ASC");
                                        while ($j = $jemaat->fetch_assoc()):
                                        ?>
                                        <option value="<?= $j['id_jemaat'] ?>">
                                            <?= htmlspecialchars($j['nama_lengkap']) ?>
                                        </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>

                                <!-- SURAT SIDI PENGANTIN -->
                                <div class="mb-3">
                                    <label class="form-label">Surat Sidi Pengantin</label>
                                    <input type="file" class="form-control" name="surat_sidi_pengantin" required>
                                </div>

                                <!-- SURAT BABTIS PENGANTIN -->
                                <div class="mb-3">
                                    <label class="form-label">Surat Babtis Pengantin</label>
                                    <input type="file" class="form-control" name="surat_babtis_pengantin" required>
                                </div>

                                <!-- SURAT NIKAH SAKSI -->
                                <div class="mb-3">
                                    <label class="form-label">Surat Nikah Saksi</label>
                                    <input type="file" class="form-control" name="surat_nikah_saksi" required>
                                </div>

                                <!-- AKTA KELAHIRAN SAKSI -->
                                <div class="mb-3">
                                    <label class="form-label">Akta Kelahiran Saksi</label>
                                    <input type="file" class="form-control" name="akta_kelahiran_saksi" required>
                                </div>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal Edit -->
            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editDataModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title" id="editDataModalLabel">Edit <?= $page_title ?></h5>
                            <button type="button" class="btn-close" id="closeEditModal"
                                data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <form id="editForm" method="POST" action="proses/<?= $current_page ?>/edit.php"
                                enctype="multipart/form-data">

                                <input type="hidden" id="edit_id" name="id_nikah">

                                <!-- Nama Jemaat -->
                                <div class="mb-3">
                                    <label class="form-label">Nama Jemaat</label>
                                    <select name="id_jemaat" id="edit_id_jemaat" class="form-control" required>
                                        <?php
                                        $jemaat = $koneksi->query("SELECT id_jemaat, nama_lengkap FROM jemaat ORDER BY nama_lengkap ASC");
                                        while ($j = $jemaat->fetch_assoc()):
                                        ?>
                                        <option value="<?= $j['id_jemaat'] ?>">
                                            <?= htmlspecialchars($j['nama_lengkap']) ?>
                                        </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>

                                <!-- Surat Sidi Pengantin -->
                                <div class="mb-3">
                                    <label class="form-label">Surat Sidi Pengantin</label>
                                    <div id="preview_sidi_pengantin" class="mb-2"></div>
                                    <input type="file" class="form-control" name="surat_sidi_pengantin">
                                </div>

                                <!-- Surat Babtis Pengantin -->
                                <div class="mb-3">
                                    <label class="form-label">Surat Babtis Pengantin</label>
                                    <div id="preview_babtis_pengantin" class="mb-2"></div>
                                    <input type="file" class="form-control" name="surat_babtis_pengantin">
                                </div>

                                <!-- Surat Nikah Saksi -->
                                <div class="mb-3">
                                    <label class="form-label">Surat Nikah Saksi</label>
                                    <div id="preview_nikah_saksi" class="mb-2"></div>
                                    <input type="file" class="form-control" name="surat_nikah_saksi">
                                </div>

                                <!-- Akta Kelahiran Saksi -->
                                <div class="mb-3">
                                    <label class="form-label">Akta Kelahiran Saksi</label>
                                    <div id="preview_akta_kelahiran_saksi" class="mb-2"></div>
                                    <input type="file" class="form-control" name="akta_kelahiran_saksi">
                                </div>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>

                            </form>
                        </div>

                    </div>
                </div>
            </div>


            <script>
            function openEditModal(id_nikah, id_jemaat, sidi, babtis, nikah_saksi, akta_saksi) {

                let modal = new bootstrap.Modal(document.getElementById('editModal'));

                document.getElementById('edit_id').value = id_nikah;
                document.getElementById('edit_id_jemaat').value = id_jemaat;

                // PREVIEW FILE
                document.getElementById('preview_sidi_pengantin').innerHTML =
                    sidi ?
                    `<a href="../../assets/file/${sidi}" target="_blank" class="btn btn-sm btn-primary">Lihat Surat Sidi</a>` :
                    `<span class="text-muted">Tidak ada file</span>`;

                document.getElementById('preview_babtis_pengantin').innerHTML =
                    babtis ?
                    `<a href="../../assets/file/${babtis}" target="_blank" class="btn btn-sm btn-success">Lihat Surat Babtis</a>` :
                    `<span class="text-muted">Tidak ada file</span>`;

                document.getElementById('preview_nikah_saksi').innerHTML =
                    nikah_saksi ?
                    `<a href="../../assets/file/${nikah_saksi}" target="_blank" class="btn btn-sm btn-warning">Lihat Surat Nikah Saksi</a>` :
                    `<span class="text-muted">Tidak ada file</span>`;

                document.getElementById('preview_akta_kelahiran_saksi').innerHTML =
                    akta_saksi ?
                    `<a href="../../assets/file/${akta_saksi}" target="_blank" class="btn btn-sm btn-info">Lihat Akta Kelahiran Saksi</a>` :
                    `<span class="text-muted">Tidak ada file</span>`;

                modal.show();
            }
            </script>
            <?php include 'fitur/footer.php'; ?>
        </div>
    </div>


    <?php include 'fitur/js.php'; ?>
</body>

</html>