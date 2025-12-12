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
                        <section class="section">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <!-- Search Form -->
                                            <form method="GET" action="">
                                                <div class="input-group mt-3">
                                                    <input type="text" class="form-control"
                                                        placeholder="Cari Data Jemaat..." name="search"
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
                        $limit = 100;
                        $offset = ($page - 1) * $limit;

                        // PREPARE QUERY (sesuai tabel jemaat)
                        $query = "
                                SELECT 
                                    jemaat.id_jemaat,
                                    jemaat.id_rayon,
                                    jemaat.nama_lengkap,
                                    jemaat.username,
                                    jemaat.password,
                                    jemaat.jenis_kelamin,
                                    jemaat.status_keluarga,
                                    jemaat.tempat_lahir,
                                    jemaat.tanggal_lahir,
                                    jemaat.fp,
                                    rayon.nama_rayon
                                FROM jemaat
                                INNER JOIN rayon ON rayon.id_rayon = jemaat.id_rayon
                                WHERE 
                                    jemaat.nama_lengkap LIKE ?
                                    OR rayon.nama_rayon LIKE ?
                                    OR jemaat.jenis_kelamin LIKE ?
                                    OR jemaat.status_keluarga LIKE ?
                                    OR jemaat.tempat_lahir LIKE ?
                                ORDER BY rayon.nama_rayon ASC
                                LIMIT ?, ?
                                ";

                        $stmt = $koneksi->prepare($query);
                        if ($stmt === false) {
                            die("Prepare failed: " . htmlspecialchars($koneksi->error));
                        }

                        $search_param = '%' . $search . '%';

                        // Perhatikan: 5 placeholder LIKE (5x 's') + 2 placeholder limit (2x 'i') => "sssssii"
                        $stmt->bind_param(
                            "sssssii",
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

                        // HITUNG TOTAL
                        $total_query = "
                                    SELECT COUNT(*) AS total
                                    FROM jemaat
                                    INNER JOIN rayon ON rayon.id_rayon = jemaat.id_rayon
                                    WHERE 
                                        jemaat.nama_lengkap LIKE ?
                                        OR rayon.nama_rayon LIKE ?
                                        OR jemaat.jenis_kelamin LIKE ?
                                        OR jemaat.status_keluarga LIKE ?
                                        OR jemaat.tempat_lahir LIKE ?
                                ";

                        $stmt_total = $koneksi->prepare($total_query);
                        if ($stmt_total === false) {
                            die("Prepare failed (total): " . htmlspecialchars($koneksi->error));
                        }
                        $stmt_total->bind_param(
                            "sssss",
                            $search_param,
                            $search_param,
                            $search_param,
                            $search_param,
                            $search_param
                        );
                        $stmt_total->execute();
                        $total_result = $stmt_total->get_result()->fetch_assoc();
                        $total_pages = ($total_result && $total_result['total'] > 0) ? ceil($total_result['total'] / $limit) : 1;
                        ?>

                        <!-- Tabel Data Jemaat -->
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
                                                            <th>Nomor</th>
                                                            <th>Nama Rayon</th>
                                                            <th>Nama Jemaat</th>
                                                            <th>Username</th>
                                                            <th>Password</th>
                                                            <th>Jenis Kelamin</th>
                                                            <th>Status Keluarga</th>
                                                            <th>Tempat Lahir</th>
                                                            <th>Tanggal Lahir</th>
                                                            <th>Foto Profil</th>
                                                            <th>Aksi</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        <?php
                                                            $nomor = $offset + 1;
                                                            while ($row = $result->fetch_assoc()):
                                                            ?>
                                                        <tr>
                                                            <td><?= $nomor++; ?></td>
                                                            <td>Rayon <?= htmlspecialchars($row['nama_rayon']); ?></td>
                                                            <td><?= htmlspecialchars($row['nama_lengkap']); ?></td>
                                                            <td><?= htmlspecialchars($row['username']); ?></td>
                                                            <td><?= htmlspecialchars($row['password']); ?></td>
                                                            <td><?= htmlspecialchars($row['jenis_kelamin']); ?></td>
                                                            <td><?= htmlspecialchars($row['status_keluarga']); ?></td>
                                                            <td><?= htmlspecialchars($row['tempat_lahir']); ?></td>
                                                            <td><?= htmlspecialchars($row['tanggal_lahir']); ?></td>

                                                            <td>
                                                                <?php if (!empty($row['fp'])): ?>
                                                                <img src="../../assets/img/jemaat/<?= htmlspecialchars($row['fp']); ?>"
                                                                    width="50" height="50"
                                                                    style="border-radius: 50%; object-fit: cover;">
                                                                <?php else: ?>
                                                                <span class="text-muted">Tidak Ada</span>
                                                                <?php endif; ?>
                                                            </td>

                                                            <td
                                                                style="display: flex; justify-content: center; gap: 10px;">
                                                                <button class="btn btn-primary btn-sm" onclick="openEditModal(
                                                '<?= $row['id_jemaat']; ?>',
                                                '<?= $row['id_rayon']; ?>',
                                                '<?= addslashes($row['nama_lengkap']); ?>',
                                                '<?= addslashes($row['username']); ?>',
                                                '<?= addslashes($row['password']); ?>',
                                                '<?= addslashes($row['jenis_kelamin']); ?>',
                                                '<?= addslashes($row['status_keluarga']); ?>',
                                                '<?= addslashes($row['tempat_lahir']); ?>',
                                                '<?= $row['tanggal_lahir']; ?>'
                                            )">Edit</button>

                                                                <button class="btn btn-danger btn-sm"
                                                                    onclick="hapus('<?= $row['id_jemaat']; ?>')">Hapus</button>
                                                            </td>
                                                        </tr>
                                                        <?php endwhile; ?>
                                                    </tbody>
                                                </table>

                                                <?php else: ?>
                                                <p class="text-center mt-4">Data tidak ditemukan.</p>
                                                <?php endif; ?>

                                                <!-- Pagination -->
                                                <nav>
                                                    <ul class="pagination justify-content-center">
                                                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                                        <li class="page-item <?= ($i == $page) ? 'active' : ''; ?>">
                                                            <a class="page-link"
                                                                href="?page=<?= $i; ?>&search=<?= urlencode($search); ?>">
                                                                <?= $i; ?>
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
            <!-- Modal Tambah -->
            <div class="modal fade" id="tambahDataModal" tabindex="-1" aria-labelledby="tambahDataModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="tambahDataModalLabel">Tambah <?= $page_title ?></h5>
                            <button type="button" class="btn-close" id="closeTambahModal" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="tambahForm" method="POST" action="proses/<?= $current_page ?>/tambah.php"
                                enctype="multipart/form-data">

                                <div class="row g-3">

                                    <div class="col-md-6">
                                        <label class="form-label">Rayon</label>
                                        <select name="id_rayon" class="form-select" required>
                                            <option value="">-- Pilih Rayon --</option>
                                            <?php
                                $rayon = $koneksi->query("SELECT * FROM rayon ORDER BY nama_rayon ASC");
                                while ($r = $rayon->fetch_assoc()):
                                ?>
                                            <option value="<?= $r['id_rayon'] ?>"><?= $r['nama_rayon'] ?></option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Nama Lengkap</label>
                                        <input type="text" name="nama_lengkap" class="form-control" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Username</label>
                                        <input type="text" name="username" class="form-control" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Password</label>
                                        <input type="text" name="password" class="form-control" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Jenis Kelamin</label>
                                        <select name="jenis_kelamin" class="form-select" required>
                                            <option value="">-- Pilih --</option>
                                            <option value="pria">Pria</option>
                                            <option value="wanita">Wanita</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Status Keluarga</label>
                                        <select name="status_keluarga" class="form-select" required>
                                            <option value="">-- Pilih --</option>
                                            <option value="kepala_keluarga">Kepala Keluarga</option>
                                            <option value="istri">Istri</option>
                                            <option value="anak">Anak</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Tempat Lahir</label>
                                        <input type="text" name="tempat_lahir" class="form-control" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Tanggal Lahir</label>
                                        <input type="date" name="tanggal_lahir" class="form-control" required>
                                    </div>

                                </div>

                                <!-- Submit Button -->
                                <div class="text-end mt-3">
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
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editDataModalLabel">Edit <?= $page_title ?></h5>
                            <button type="button" class="btn-close" id="closeEditModal" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="editForm" method="POST" action="proses/<?= $current_page ?>/edit.php"
                                enctype="multipart/form-data">

                                <input type="hidden" id="edit_id" name="id_jemaat">

                                <div class="row g-3">

                                    <div class="col-md-6">
                                        <label class="form-label">Rayon</label>
                                        <select name="id_rayon" id="edit_id_rayon" class="form-select" required>
                                            <option value="">-- Pilih Rayon --</option>
                                            <?php
                                $rayon = $koneksi->query("SELECT * FROM rayon ORDER BY nama_rayon ASC");
                                while ($r = $rayon->fetch_assoc()):
                                ?>
                                            <option value="<?= $r['id_rayon'] ?>"><?= $r['nama_rayon'] ?></option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Nama Lengkap</label>
                                        <input type="text" id="edit_nama_lengkap" name="nama_lengkap"
                                            class="form-control" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Username</label>
                                        <input type="text" id="edit_username" name="username" class="form-control"
                                            required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Password</label>
                                        <input type="text" id="edit_password" name="password" class="form-control"
                                            required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Jenis Kelamin</label>
                                        <select id="edit_jenis_kelamin" name="jenis_kelamin" class="form-select"
                                            required>
                                            <option value="">-- Pilih --</option>
                                            <option value="pria">Pria</option>
                                            <option value="wanita">Wanita</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Status Keluarga</label>
                                        <select id="edit_status_keluarga" name="status_keluarga" class="form-select"
                                            required>
                                            <option value="">-- Pilih --</option>
                                            <option value="kepala_keluarga">Kepala Keluarga</option>
                                            <option value="istri">Istri</option>
                                            <option value="anak">Anak</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Tempat Lahir</label>
                                        <input type="text" id="edit_tempat_lahir" name="tempat_lahir"
                                            class="form-control" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Tanggal Lahir</label>
                                        <input type="date" id="edit_tanggal_lahir" name="tanggal_lahir"
                                            class="form-control" required>
                                    </div>

                                </div>

                                <div class="text-end mt-3">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <script>
            function openEditModal(id, id_rayon, nama_lengkap, username, password, jenis_kelamin, status_keluarga,
                tempat_lahir, tanggal_lahir) {

                let editModal = new bootstrap.Modal(document.getElementById('editModal'));

                document.getElementById('edit_id').value = id;
                document.getElementById('edit_id_rayon').value = id_rayon;
                document.getElementById('edit_nama_lengkap').value = nama_lengkap;
                document.getElementById('edit_username').value = username;
                document.getElementById('edit_password').value = password;
                document.getElementById('edit_jenis_kelamin').value = jenis_kelamin;
                document.getElementById('edit_status_keluarga').value = status_keluarga;
                document.getElementById('edit_tempat_lahir').value = tempat_lahir;
                document.getElementById('edit_tanggal_lahir').value = tanggal_lahir;

                editModal.show();
            }
            </script>

            <!-- bagian pop up edit dan tambah -->
            <?php include 'fitur/footer.php'; ?>
        </div>
    </div>


    <?php include 'fitur/js.php'; ?>
</body>

</html>