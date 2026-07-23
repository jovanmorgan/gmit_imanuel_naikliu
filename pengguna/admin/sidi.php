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
                                                        placeholder="Cari jemaat atau akta atau baptis..." name="search"
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

                        // ===========================
                        // QUERY DATA SIDi + JEMAAT
                        // ===========================
                        $query = "
        SELECT 
            sidi.id_sidi,
            sidi.akta_kelahiran,
            sidi.surat_babtis,
            sidi.id_jemaat,
            jemaat.nama_lengkap,
            jemaat.jenis_kelamin,
            jemaat.tanggal_lahir
        FROM sidi
        INNER JOIN jemaat ON sidi.id_jemaat = jemaat.id_jemaat
        WHERE 
            jemaat.nama_lengkap LIKE ?
            OR sidi.akta_kelahiran LIKE ?
            OR sidi.surat_babtis LIKE ?
        ORDER BY sidi.id_sidi DESC
        LIMIT ?, ?
    ";

                        $stmt = $koneksi->prepare($query);
                        $param = "%$search%";
                        $stmt->bind_param("sssii", $param, $param, $param, $offset, $limit);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        // =====================================
                        // HITUNG TOTAL DATA
                        // =====================================
                        $countQuery = "
        SELECT COUNT(*) AS total
        FROM sidi
        INNER JOIN jemaat ON sidi.id_jemaat = jemaat.id_jemaat
        WHERE 
            jemaat.nama_lengkap LIKE ?
            OR sidi.akta_kelahiran LIKE ?
            OR sidi.surat_babtis LIKE ?
    ";

                        $stmt2 = $koneksi->prepare($countQuery);
                        $stmt2->bind_param("sss", $param, $param, $param);
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
                                                            <th>Akta Kelahiran</th>
                                                            <th>Surat Baptis</th>
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
                                                                    // format tanggal lahir
                                                                    $tanggal = date("d-m-Y", strtotime($row['tanggal_lahir']));
                                                                    ?>
                                                            <td><?= $tanggal ?></td>

                                                            <td>
                                                                <?php
                                                                        $file1 = htmlspecialchars($row['akta_kelahiran']);
                                                                        $ext1  = strtolower(pathinfo($file1, PATHINFO_EXTENSION));

                                                                        // Icon sesuai tipe file
                                                                        $icon1 = ($ext1 === 'pdf')
                                                                            ? '<i class="fa-solid fa-file-pdf me-1";d></i>'
                                                                            : '<i class="fa-solid fa-image me-1"></i>';
                                                                        ?>

                                                                <a href="../../assets/file/<?= $file1 ?>"
                                                                    target="_blank"
                                                                    class="btn btn-sm btn-primary d-flex align-items-center justify-content-center gap-1">
                                                                    Lihat Akta
                                                                </a>
                                                            </td>

                                                            <td>
                                                                <?php
                                                                        $file2 = htmlspecialchars($row['surat_babtis']);
                                                                        $ext2  = strtolower(pathinfo($file2, PATHINFO_EXTENSION));


                                                                        ?>

                                                                <a href="../../assets/file/<?= $file2 ?>"
                                                                    target="_blank"
                                                                    class="btn btn-sm btn-success d-flex align-items-center justify-content-center gap-1">
                                                                    Surat Babtis
                                                                </a>
                                                            </td>

                                                            <td style="display:flex; gap:5px; justify-content:center;">
                                                                <button class="btn btn-warning btn-sm" onclick="openEditModal(
        '<?= $row['id_sidi'] ?>',
        '<?= $row['id_jemaat'] ?>',
        '<?= $row['akta_kelahiran'] ?>',
        '<?= $row['surat_babtis'] ?>'
    )">
                                                                    Edit
                                                                </button>


                                                                <button class="btn btn-danger btn-sm"
                                                                    onclick="hapus('<?= $row['id_sidi'] ?>')">Hapus</button>
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

            <!-- Modal -->
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

                                <!-- akta_kelahiran -->
                                <div class="mb-3">
                                    <label class="form-label">Akta Kelahiran</label>
                                    <input type="file" class="form-control" name="akta_kelahiran" required>
                                </div>

                                <!-- surat_babtis -->
                                <div class="mb-3">
                                    <label class="form-label">Surat Babtis</label>
                                    <input type="file" class="form-control" name="surat_babtis" required>
                                </div>
                                <!-- Submit Button -->
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

                                <input type="hidden" id="edit_id" name="id_sidi">

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

                                <!-- Akta Kelahiran -->
                                <div class="mb-3">
                                    <label class="form-label">Akta Kelahiran</label>
                                    <div id="preview_akta_kelahiran" class="mb-2"></div>
                                    <input type="file" class="form-control" name="akta_kelahiran">
                                </div>

                                <!-- Surat Baptis -->
                                <div class="mb-3">
                                    <label class="form-label">Surat Babtis</label>
                                    <div id="preview_surat_babtis" class="mb-2"></div>
                                    <input type="file" class="form-control" name="surat_babtis">
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
            function openEditModal(id_sidi, id_jemaat, akta_kelahiran, surat_babtis) {

                console.log("DEBUG:", id_sidi, id_jemaat, akta_kelahiran, surat_babtis);

                let modal = new bootstrap.Modal(document.getElementById('editModal'));

                // Hidden id
                document.getElementById('edit_id').value = id_sidi;

                // Nama jemaat
                document.getElementById('edit_id_jemaat').value = id_jemaat;

                // === PREVIEW AKTA ===
                let aktaPreview = document.getElementById('preview_akta_kelahiran');
                aktaPreview.innerHTML =
                    akta_kelahiran && akta_kelahiran !== '' ?
                    `<a href="../../assets/file/${akta_kelahiran}" target="_blank" class="btn btn-sm btn-primary">
               Lihat Akta Lama
           </a>` :
                    `<span class="text-muted">Tidak ada file</span>`;

                // === PREVIEW BAPTIS ===
                let baptisPreview = document.getElementById('preview_surat_babtis');
                baptisPreview.innerHTML =
                    surat_babtis && surat_babtis !== '' ?
                    `<a href="../../assets/file/${surat_babtis}" target="_blank" class="btn btn-sm btn-success">
               Lihat Surat Baptis Lama
           </a>` :
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