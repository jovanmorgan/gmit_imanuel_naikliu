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
                                                        placeholder="Cari Data majelis..." name="search"
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

                        // Query untuk mendapatkan data majelis dengan pencarian dan pagination
                        $query = "
                                SELECT * 
                                FROM majelis 
                                WHERE jenis_kelamin LIKE ? OR nama_lengkap LIKE ? OR tempat_lahir LIKE ? OR tanggal_lahir LIKE ?
                                LIMIT ?, ?
                            ";
                        $stmt = $koneksi->prepare($query);
                        $search_param = '%' . $search . '%';
                        $stmt->bind_param("ssssii", $search_param, $search_param, $search_param, $search_param, $offset, $limit);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        // Hitung total halaman
                        $total_query = "
                                            SELECT COUNT(*) as total 
                                            FROM majelis 
                                            WHERE jenis_kelamin LIKE ? OR nama_lengkap LIKE ? OR tempat_lahir LIKE ? OR tanggal_lahir LIKE ?
                                        ";
                        $stmt_total = $koneksi->prepare($total_query);
                        $stmt_total->bind_param("ssss", $search_param, $search_param, $search_param, $search_param);
                        $stmt_total->execute();
                        $total_result = $stmt_total->get_result();
                        $total_row = $total_result->fetch_assoc();
                        $total_pages = ceil($total_row['total'] / $limit);
                        ?>

                        <!-- Tabel Data majelis -->
                        <section class="section">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body" style="overflow-x: hidden;">
                                            <div style="overflow-x: auto;">
                                                <?php if ($result->num_rows > 0): ?>
                                                    <table class="table table-hover text-center mt-3"
                                                        style="border-collapse: separate; border-spacing: 0;">
                                                        <thead>
                                                            <tr>
                                                                <th style="white-space: nowrap;">Nomor</th>
                                                                <th style="white-space: nowrap;">Nama Lengkap</th>
                                                                <th style="white-space: nowrap;">Username</th>
                                                                <th style="white-space: nowrap;">Password</th>
                                                                <th style="white-space: nowrap;">Tempat Lahir</th>
                                                                <th style="white-space: nowrap;">Tanggal Lahir</th>
                                                                <th style="white-space: nowrap;">Jenis Kelamin</th>
                                                                <th style="white-space: nowrap;">Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $nomor = $offset + 1;
                                                            while ($row = $result->fetch_assoc()) :
                                                            ?>
                                                                <tr>
                                                                    <td><?php echo $nomor++; ?></td>
                                                                    <td><?php echo htmlspecialchars($row['nama_lengkap']); ?>
                                                                    </td>
                                                                    <td><?php echo htmlspecialchars($row['username']); ?></td>
                                                                    <td><?php echo htmlspecialchars($row['password']); ?></td>
                                                                    <td><?php echo htmlspecialchars($row['tempat_lahir']); ?>
                                                                    </td>
                                                                    <td><?php echo htmlspecialchars($row['tanggal_lahir']); ?>
                                                                    </td>
                                                                    <td><?php echo htmlspecialchars($row['jenis_kelamin']); ?>
                                                                    </td>
                                                                    <td
                                                                        style="display: flex; justify-content: center; gap: 10px;">
                                                                        <button class="btn btn-primary btn-sm"
                                                                            onclick="openEditModal('<?php echo $row['id_majelis']; ?>','<?php echo $row['nama_lengkap']; ?>', '<?php echo $row['username']; ?>', '<?php echo $row['password']; ?>','<?php echo $row['tempat_lahir']; ?>','<?php echo $row['tanggal_lahir']; ?>','<?php echo $row['jenis_kelamin']; ?>')">Edit</button>
                                                                        <button class="btn btn-danger btn-sm"
                                                                            onclick="hapus('<?php echo $row['id_majelis']; ?>')">Hapus</button>
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
                                                            <li
                                                                class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                                                <a class="page-link"
                                                                    href="?page=<?php echo $i; ?>&search=<?php echo $search; ?>"><?php echo $i; ?></a>
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
                                <!-- Nama Lengkap -->
                                <div class="mb-3">
                                    <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        <input type="text" id="nama_lengkap" name="nama_lengkap" class="form-control"
                                            placeholder="Masukkan nama lengkap" required>
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
                                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                                        <select class="form-select" name="jenis_kelamin" id="jenis_kelamin" required>
                                            <option value="" disabled selected>Pilih jenis kelamin</option>
                                            <option value="pria">Pria</option>
                                            <option value="wanita">Wanita</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Tempat Lahir -->
                                <div class="mb-3">
                                    <label class="form-label">Tempat Lahir</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-city"></i></span>
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
                            <button type="button" class="btn-close" id="closeEditModal" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="editForm" method="POST" action="proses/<?= $current_page ?>/edit.php"
                                enctype="multipart/form-data">
                                <input type="hidden" id="edit_id" name="id_majelis">
                                <!-- Nama Lengkap -->
                                <div class="mb-3">
                                    <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        <input type="text" id="edit_nama_lengkap" name="nama_lengkap"
                                            class="form-control" placeholder="Masukkan nama lengkap" required>
                                    </div>
                                </div>


                                <!-- Username -->
                                <div class="mb-3">
                                    <label class="form-label">Username</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user-circle"></i></span>
                                        <input type="text" id="edit_username" name="username" class="form-control"
                                            required>
                                    </div>
                                </div>

                                <!-- Password -->
                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        <input type="text" id="edit_password" name="password" class="form-control"
                                            required>
                                    </div>
                                </div>

                                <!-- Jenis Kelamin -->
                                <div class="mb-3">
                                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                                        <select class="form-select" name="jenis_kelamin" id="edit_jenis_kelamin"
                                            required>
                                            <option value="" disabled selected>Pilih jenis kelamin</option>
                                            <option value="pria">Pria</option>
                                            <option value="wanita">Wanita</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Tempat Lahir -->
                                <div class="mb-3">
                                    <label class="form-label">Tempat Lahir</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-city"></i></span>
                                        <input type="text" id="edit_tempat_lahir" name="tempat_lahir"
                                            class="form-control" required>
                                    </div>
                                </div>

                                <!-- Tanggal Lahir -->
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Lahir</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                        <input type="date" id="edit_tanggal_lahir" name="tanggal_lahir"
                                            class="form-control" required>
                                    </div>
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

            <?php include 'fitur/footer.php'; ?>
        </div>
    </div>
    <script>
        function openEditModal(id, nama_lengkap, username, password, tempat_lahir, tanggal_lahir, jenis_kelamin) {
            let editModal = new bootstrap.Modal(document.getElementById('editModal'));
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_nama_lengkap').value = nama_lengkap;
            document.getElementById('edit_username').value = username;
            document.getElementById('edit_password').value = password;
            document.getElementById('edit_tempat_lahir').value = tempat_lahir;
            document.getElementById('edit_tanggal_lahir').value = tanggal_lahir;
            document.getElementById('edit_jenis_kelamin').value = jenis_kelamin;
            editModal.show();
        }
    </script>

    <?php include 'fitur/js.php'; ?>
</body>

</html>