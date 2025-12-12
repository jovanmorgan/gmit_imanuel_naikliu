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
                                                        placeholder="Cari jemaat, akta, atau surat nikah..."
                                                        name="search"
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

                        <?php
                        include '../../keamanan/koneksi.php';

                        $search = isset($_GET['search']) ? $_GET['search'] : '';
                        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                        $limit = 10;
                        $offset = ($page - 1) * $limit;

                        // ===========================================
                        // QUERY DATA BABTIS + JEMAAT
                        // ===========================================
                        $query = "
        SELECT 
            babtis.id_babtis,
            babtis.id_jemaat,
            babtis.tempat_lahir,
            babtis.tanggal_lahir,
            babtis.surat_nikah_orang_tua,
            babtis.akta_kelahiran,
            jemaat.nama_lengkap,
            jemaat.jenis_kelamin
        FROM babtis
        INNER JOIN jemaat ON babtis.id_jemaat = jemaat.id_jemaat
        WHERE 
            jemaat.nama_lengkap LIKE ?
            OR babtis.tempat_lahir LIKE ?
            OR babtis.surat_nikah_orang_tua LIKE ?
            OR babtis.akta_kelahiran LIKE ?
        ORDER BY babtis.id_babtis DESC
        LIMIT ?, ?
    ";

                        $stmt = $koneksi->prepare($query);
                        $param = "%$search%";
                        $stmt->bind_param("ssssii", $param, $param, $param, $param, $offset, $limit);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        // ===========================================
                        // HITUNG TOTAL DATA
                        // ===========================================
                        $countQuery = "
        SELECT COUNT(*) AS total
        FROM babtis
        INNER JOIN jemaat ON babtis.id_jemaat = jemaat.id_jemaat
        WHERE 
            jemaat.nama_lengkap LIKE ?
            OR babtis.tempat_lahir LIKE ?
            OR babtis.surat_nikah_orang_tua LIKE ?
            OR babtis.akta_kelahiran LIKE ?
    ";

                        $stmt2 = $koneksi->prepare($countQuery);
                        $stmt2->bind_param("ssss", $param, $param, $param, $param);
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
                                                                <th>Tempat Lahir</th>
                                                                <th>Tanggal Lahir</th>
                                                                <th>Surat Nikah Orang Tua</th>
                                                                <th>Akta Kelahiran</th>
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
                                                                    <td><?= htmlspecialchars($row['tempat_lahir']) ?></td>

                                                                    <td>
                                                                        <?= date("d-m-Y", strtotime($row['tanggal_lahir'])) ?>
                                                                    </td>

                                                                    <!-- SURAT NIKAH ORTU -->
                                                                    <td>
                                                                        <a href="../../assets/file/<?= htmlspecialchars($row['surat_nikah_orang_tua']) ?>"
                                                                            target="_blank"
                                                                            class="btn btn-sm btn-warning d-flex align-items-center justify-content-center gap-1">
                                                                            Surat Nikah
                                                                        </a>
                                                                    </td>

                                                                    <!-- AKTA KELAHIRAN -->
                                                                    <td>
                                                                        <a href="../../assets/file/<?= htmlspecialchars($row['akta_kelahiran']) ?>"
                                                                            target="_blank"
                                                                            class="btn btn-sm btn-primary d-flex align-items-center justify-content-center gap-1">
                                                                            Akta Kelahiran
                                                                        </a>
                                                                    </td>

                                                                    <!-- BUTTON EDIT/HAPUS -->
                                                                    <td style="display:flex; gap:5px; justify-content:center;">

                                                                        <button class="btn btn-warning btn-sm" onclick="openEditModal(
                                                    '<?= $row['id_babtis'] ?>',
                                                    '<?= $row['id_jemaat'] ?>',
                                                    '<?= $row['tempat_lahir'] ?>',
                                                    '<?= $row['tanggal_lahir'] ?>',
                                                    '<?= $row['surat_nikah_orang_tua'] ?>',
                                                    '<?= $row['akta_kelahiran'] ?>'
                                                )">
                                                                            Edit
                                                                        </button>

                                                                        <button class="btn btn-danger btn-sm"
                                                                            onclick="hapus('<?= $row['id_babtis'] ?>')">
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
                            <button type="button" class="btn-close" id="closeTambahModal"
                                data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <form id="tambahForm" method="POST" action="proses/<?= $current_page ?>/tambah.php"
                                enctype="multipart/form-data">

                                <!-- id_jemaat -->
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

                                <!-- Tempat Lahir -->
                                <div class="mb-3">
                                    <label class="form-label">Tempat Lahir</label>
                                    <input type="text" class="form-control" name="tempat_lahir" required>
                                </div>

                                <!-- Tanggal Lahir -->
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Lahir</label>
                                    <input type="date" class="form-control" name="tanggal_lahir" required>
                                </div>

                                <!-- Surat Nikah Orang Tua -->
                                <div class="mb-3">
                                    <label class="form-label">Surat Nikah Orang Tua</label>
                                    <input type="file" class="form-control" name="surat_nikah_orang_tua" required>
                                </div>

                                <!-- Akta Kelahiran -->
                                <div class="mb-3">
                                    <label class="form-label">Akta Kelahiran</label>
                                    <input type="file" class="form-control" name="akta_kelahiran" required>
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

                                <input type="hidden" id="edit_id" name="id_babtis">

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

                                <!-- Tempat Lahir -->
                                <div class="mb-3">
                                    <label class="form-label">Tempat Lahir</label>
                                    <input type="text" id="edit_tempat_lahir" name="tempat_lahir" class="form-control"
                                        required>
                                </div>

                                <!-- Tanggal Lahir -->
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Lahir</label>
                                    <input type="date" id="edit_tanggal_lahir" name="tanggal_lahir" class="form-control"
                                        required>
                                </div>

                                <!-- Surat Nikah Orang Tua -->
                                <div class="mb-3">
                                    <label class="form-label">Surat Nikah Orang Tua</label>
                                    <div id="preview_surat_nikah" class="mb-2"></div>
                                    <input type="file" class="form-control" name="surat_nikah_orang_tua">
                                </div>

                                <!-- Akta Kelahiran -->
                                <div class="mb-3">
                                    <label class="form-label">Akta Kelahiran</label>
                                    <div id="preview_akta_kelahiran" class="mb-2"></div>
                                    <input type="file" class="form-control" name="akta_kelahiran">
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
                function openEditModal(id, id_jemaat, tempat_lahir, tanggal_lahir, surat_nikah, akta) {

                    let modal = new bootstrap.Modal(document.getElementById('editModal'));

                    document.getElementById('edit_id').value = id;
                    document.getElementById('edit_id_jemaat').value = id_jemaat;

                    document.getElementById('edit_tempat_lahir').value = tempat_lahir;
                    document.getElementById('edit_tanggal_lahir').value = tanggal_lahir;

                    // Preview Surat Nikah Orang Tua
                    document.getElementById('preview_surat_nikah').innerHTML =
                        surat_nikah ?
                        `<a href="../../assets/file/${surat_nikah}" target="_blank" class="btn btn-sm btn-warning">Lihat Surat Nikah Lama</a>` :
                        `<span class="text-muted">Tidak ada file</span>`;

                    // Preview Akta Kelahiran
                    document.getElementById('preview_akta_kelahiran').innerHTML =
                        akta ?
                        `<a href="../../assets/file/${akta}" target="_blank" class="btn btn-sm btn-primary">Lihat Akta Lama</a>` :
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