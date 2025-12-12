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

                    <?php
                    include '../../keamanan/koneksi.php';

                    $search = isset($_GET['search']) ? $_GET['search'] : '';
                    $page   = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                    $limit  = 10;
                    $offset = ($page - 1) * $limit;

                    // Parameter pencarian
                    $search_param = '%' . $search . '%';

                    // =========================
                    // QUERY GET DATA PENDETA
                    // =========================
                    $query = "
    SELECT * FROM pendeta
    WHERE 
        nama_lengkap LIKE ?
        OR username LIKE ?
        OR password LIKE ?
        OR jenis_kelamin LIKE ?
        OR tempat_lahir LIKE ?
        OR tanggal_lahir LIKE ?
        OR priode_jabatan LIKE ?
        OR nomor_hp LIKE ?
        OR fp LIKE ?
    ORDER BY id_pendeta DESC
    LIMIT ?, ?
";

                    $stmt = $koneksi->prepare($query);
                    if ($stmt === false) {
                        die("Prepare failed: " . htmlspecialchars($koneksi->error));
                    }

                    // ===== CORRECTION =====
                    // ada 9 placeholder untuk LIKE (strings) + 2 untuk LIMIT/OFFSET (integers) => total 11 params
                    // tipe yang benar: 9x 's' lalu 2x 'i' -> "sssssssssii"
                    $stmt->bind_param(
                        "sssssssssii",
                        $search_param, // nama_lengkap
                        $search_param, // username
                        $search_param, // password
                        $search_param, // jenis_kelamin
                        $search_param, // tempat_lahir
                        $search_param, // tanggal_lahir
                        $search_param, // priode_jabatan
                        $search_param, // nomor_hp
                        $search_param, // fp
                        $offset,       // LIMIT offset (int)
                        $limit         // LIMIT count  (int)
                    );

                    $stmt->execute();
                    $result = $stmt->get_result();

                    // =========================
                    // HITUNG TOTAL DATA
                    // =========================
                    $total_query = "
    SELECT COUNT(*) as total FROM pendeta
    WHERE 
        nama_lengkap LIKE ?
        OR username LIKE ?
        OR password LIKE ?
        OR jenis_kelamin LIKE ?
        OR tempat_lahir LIKE ?
        OR tanggal_lahir LIKE ?
        OR priode_jabatan LIKE ?
        OR nomor_hp LIKE ?
        OR fp LIKE ?
";

                    $stmt_total = $koneksi->prepare($total_query);
                    if ($stmt_total === false) {
                        die("Prepare failed (total): " . htmlspecialchars($koneksi->error));
                    }

                    // 9 placeholders -> 9 's'
                    $stmt_total->bind_param(
                        "sssssssss",
                        $search_param,
                        $search_param,
                        $search_param,
                        $search_param,
                        $search_param,
                        $search_param,
                        $search_param,
                        $search_param,
                        $search_param
                    );

                    $stmt_total->execute();
                    $total_result = $stmt_total->get_result();
                    $total_row = $total_result->fetch_assoc();
                    $total_pages = ($total_row && $total_row['total'] > 0) ? ceil($total_row['total'] / $limit) : 1;
                    ?>

                    <!-- HTML bagian search + table (boleh gabungkan dengan bagian UI anda) -->
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
                                                        placeholder="Cari Data pendeta..." name="search"
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
                    </div>

                    <!-- ========================= -->
                    <!-- TABEL DATA PENDETA BARU  -->
                    <!-- ========================= -->
                    <section class="section">
                        <div class="row">
                            <div class="col-lg-12">

                                <div class="card">
                                    <div class="card-body" style="overflow-x: hidden;">
                                        <div style="overflow-x: auto;">

                                            <?php if ($result && $result->num_rows > 0): ?>
                                                <table class="table table-hover text-center mt-3">
                                                    <thead>
                                                        <tr>
                                                            <th>Nomor</th>
                                                            <th>Nama Lengkap</th>
                                                            <th>Jenis Kelamin</th>
                                                            <th>Tempat Lahir</th>
                                                            <th>Tanggal Lahir</th>
                                                            <th>Periode Jabatan</th>
                                                            <th>Nomor HP</th>
                                                            <th>Username</th>
                                                            <th>Password</th>
                                                            <th>Foto</th>
                                                            <th>Aksi</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        <?php
                                                        $nomor = $offset + 1;
                                                        while ($row = $result->fetch_assoc()):
                                                            // siapkan data untuk dikirim ke fungsi JS dengan aman

                                                        ?>
                                                            <tr>
                                                                <td><?= $nomor++; ?></td>
                                                                <td><?= htmlspecialchars($row['nama_lengkap']); ?></td>
                                                                <td><?= htmlspecialchars($row['jenis_kelamin']); ?></td>
                                                                <td><?= htmlspecialchars($row['tempat_lahir']); ?></td>
                                                                <td><?= htmlspecialchars($row['tanggal_lahir']); ?></td>
                                                                <td><?= htmlspecialchars($row['priode_jabatan']); ?></td>
                                                                <td><?= htmlspecialchars($row['nomor_hp']); ?></td>
                                                                <td><?= htmlspecialchars($row['username']); ?></td>
                                                                <td><?= htmlspecialchars($row['password']); ?></td>

                                                                <td>
                                                                    <?php if (!empty($row['fp'])): ?>
                                                                        <img src="../../assets/foto/<?= htmlspecialchars($row['fp']); ?>"
                                                                            width="50" height="50"
                                                                            style="object-fit:cover; border-radius:5px;">
                                                                    <?php else: ?>
                                                                        <span class="text-muted">Tidak ada</span>
                                                                    <?php endif; ?>
                                                                </td>

                                                                <td style="display:flex; gap:10px; justify-content:center;">
                                                                    <button class="btn btn-primary btn-sm"
                                                                        onclick="openEditModal('<?php echo $row['id_pendeta']; ?>','<?php echo $row['nama_lengkap']; ?>', '<?php echo $row['jenis_kelamin']; ?>', '<?php echo $row['tempat_lahir']; ?>', '<?php echo $row['tanggal_lahir']; ?>', '<?php echo $row['priode_jabatan']; ?>', '<?php echo $row['nomor_hp']; ?>', '<?php echo $row['username']; ?>', '<?php echo $row['password']; ?>')">Edit</button>
                                                                    <button class="btn btn-danger btn-sm"
                                                                        onclick="hapus(<?= $js_id; ?>)">Hapus</button>
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
                                                        <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
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

        <!-- bagian pop up edit dan tambah -->

        <!-- Modal Tambah -->
        <div class="modal fade" id="tambahDataModal" tabindex="-1" aria-labelledby="tambahDataModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahDataModalLabel">Tambah Pendeta</h5>
                        <button type="button" class="btn-close" id="closeTambahModal" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form id="tambahForm" method="POST" action="proses/pendeta/tambah.php"
                            enctype="multipart/form-data">

                            <!-- Nama Lengkap -->
                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" name="nama_lengkap" class="form-control" required>
                                </div>
                            </div>

                            <!-- Username -->
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user-circle"></i></span>
                                    <input type="text" name="username" class="form-control" required>
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="text" name="password" class="form-control" required>
                                </div>
                            </div>

                            <!-- Jenis Kelamin -->
                            <div class="mb-3">
                                <label class="form-label">Jenis Kelamin</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                                    <select name="jenis_kelamin" class="form-select" required>
                                        <option value="" disabled selected>Pilih</option>
                                        <option value="pria">Pria</option>
                                        <option value="wanita">Wanita</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Tempat Lahir -->
                            <div class="mb-3">
                                <label class="form-label">Tempat Lahir</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-map"></i></span>
                                    <input type="text" name="tempat_lahir" class="form-control" required>
                                </div>
                            </div>

                            <!-- Tanggal Lahir -->
                            <div class="mb-3">
                                <label class="form-label">Tanggal Lahir</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                    <input type="date" name="tanggal_lahir" class="form-control" required>
                                </div>
                            </div>

                            <!-- Priode Jabatan -->
                            <div class="mb-3">
                                <label class="form-label">Priode Jabatan</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-id-badge"></i></span>
                                    <input type="text" name="priode_jabatan" class="form-control" required>
                                </div>
                            </div>

                            <!-- Nomor HP -->
                            <div class="mb-3">
                                <label class="form-label">Nomor HP</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    <input type="text" name="nomor_hp" class="form-control" required>
                                </div>
                            </div>

                            <!-- Submit -->
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Edit -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editDataModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editDataModalLabel">Edit Pendeta</h5>
                        <button type="button" class="btn-close" id="closeEditModal" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form id="editForm" method="POST" action="proses/pendeta/edit.php"
                            enctype="multipart/form-data">

                            <input type="hidden" name="id_pendeta" id="edit_id">

                            <!-- Nama Lengkap -->
                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" name="nama_lengkap" id="edit_nama_lengkap" class="form-control"
                                        required>
                                </div>
                            </div>

                            <!-- Username -->
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user-circle"></i></span>
                                    <input type="text" name="username" id="edit_username" class="form-control" required>
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="text" name="password" id="edit_password" class="form-control" required>
                                </div>
                            </div>

                            <!-- Jenis Kelamin -->
                            <div class="mb-3">
                                <label class="form-label">Jenis Kelamin</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                                    <select name="jenis_kelamin" id="edit_jenis_kelamin" class="form-select" required>
                                        <option value="" disabled>Pilih</option>
                                        <option value="pria">Pria</option>
                                        <option value="wanita">Wanita</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Tempat Lahir -->
                            <div class="mb-3">
                                <label class="form-label">Tempat Lahir</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-map"></i></span>
                                    <input type="text" name="tempat_lahir" id="edit_tempat_lahir" class="form-control"
                                        required>
                                </div>
                            </div>

                            <!-- Tanggal Lahir -->
                            <div class="mb-3">
                                <label class="form-label">Tanggal Lahir</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                    <input type="date" name="tanggal_lahir" id="edit_tanggal_lahir" class="form-control"
                                        required>
                                </div>
                            </div>

                            <!-- Priode Jabatan -->
                            <div class="mb-3">
                                <label class="form-label">Priode Jabatan</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-id-badge"></i></span>
                                    <input type="text" name="priode_jabatan" id="edit_priode_jabatan"
                                        class="form-control" required>
                                </div>
                            </div>

                            <!-- Nomor HP -->
                            <div class="mb-3">
                                <label class="form-label">Nomor HP</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    <input type="text" name="nomor_hp" id="edit_nomor_hp" class="form-control" required>
                                </div>
                            </div>
                            <!-- Submit -->
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function openEditModal(id, nama_lengkap, jenis_kelamin, tempat_lahir, tanggal_lahir, priode_jabatan, nomor_hp,
                username, password) {
                let editModal = new bootstrap.Modal(document.getElementById('editModal'));
                document.getElementById('edit_id').value = id;
                document.getElementById('edit_nama_lengkap').value = nama_lengkap;
                document.getElementById('edit_jenis_kelamin').value = jenis_kelamin;
                document.getElementById('edit_tempat_lahir').value = tempat_lahir;
                document.getElementById('edit_tanggal_lahir').value = tanggal_lahir;
                document.getElementById('edit_priode_jabatan').value = priode_jabatan;
                document.getElementById('edit_nomor_hp').value = nomor_hp;
                document.getElementById('edit_username').value = username;
                document.getElementById('edit_password').value = password;
                editModal.show();
            }
        </script>u
        b

        <?php include 'fitur/footer.php'; ?>
    </div>
    </div>

    <?php include 'fitur/js.php'; ?>
</body>

</html>