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

                        <!-- Search -->
                        <section class="section">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body text-center">

                                            <form method="GET" action="">
                                                <div class="input-group mt-3">
                                                    <input type="text" class="form-control"
                                                        placeholder="Cari data rayon / majelis..." name="search"
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

                        // ============================
                        // QUERY DATA + PENCARIAN
                        // ============================
                        $query = "
                                                                                        SELECT 
                                                                                            rayon.id_rayon,
                                                                                            rayon.nama_rayon,
                                                                                            rayon.alamat AS alamat_rayon,
                                                                                            majelis.id_majelis,
                                                                                            majelis.nama_lengkap,
                                                                                            majelis.username,
                                                                                            majelis.password,
                                                                                            majelis.jenis_kelamin,
                                                                                            majelis.tempat_lahir,
                                                                                            majelis.tanggal_lahir,
                                                                                            majelis.fp
                                                                                        FROM rayon
                                                                                        INNER JOIN majelis ON rayon.id_majelis = majelis.id_majelis
                                                                                        WHERE 
                                                                                            majelis.nama_lengkap LIKE ?
                                                                                            OR majelis.username LIKE ?
                                                                                            OR majelis.jenis_kelamin LIKE ?
                                                                                            OR majelis.tempat_lahir LIKE ?
                                                                                            OR rayon.nama_rayon LIKE ?
                                                                                            OR rayon.alamat LIKE ?
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

                                                                                                        // ============================
                                                                                                        // HITUNG TOTAL DATA
                                                                                                        // ============================
                                                                                                        $countQuery = "
                                                                                        SELECT COUNT(*) AS total 
                                                                                        FROM rayon
                                                                                        INNER JOIN majelis ON rayon.id_majelis = majelis.id_majelis
                                                                                        WHERE 
                                                                                            majelis.nama_lengkap LIKE ?
                                                                                            OR majelis.username LIKE ?
                                                                                            OR majelis.jenis_kelamin LIKE ?
                                                                                            OR majelis.tempat_lahir LIKE ?
                                                                                            OR rayon.nama_rayon LIKE ?
                                                                                            OR rayon.alamat LIKE ?
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
                                                            <th>Nomor</th>
                                                            <th>Nama Rayon</th>
                                                            <th>Alamat Rayon</th>
                                                            <th>Majelis / Koordinator</th>
                                                            <th>Username</th>
                                                            <th>Password</th>
                                                            <th>Jenis Kelamin</th>
                                                            <th>Tempat Lahir</th>
                                                            <th>Tanggal Lahir</th>
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
                                                            <td>Rayon <?= htmlspecialchars($row['nama_rayon']) ?></td>
                                                            <td><?= htmlspecialchars($row['alamat_rayon']) ?></td>
                                                            <td><?= htmlspecialchars($row['nama_lengkap']) ?></td>
                                                            <td><?= htmlspecialchars($row['username']) ?></td>
                                                            <td><?= htmlspecialchars($row['password']) ?></td>
                                                            <td><?= htmlspecialchars($row['jenis_kelamin']) ?></td>
                                                            <td><?= htmlspecialchars($row['tempat_lahir']) ?></td>
                                                            <td><?= htmlspecialchars($row['tanggal_lahir']) ?></td>

                                                            <td style="display:flex; gap:5px; justify-content:center;">
                                                                <button class="btn btn-primary btn-sm" onclick="openEditModal(
                                                            '<?= $row['id_rayon'] ?>',
                                                            '<?= $row['id_majelis'] ?>',
                                                            '<?= $row['nama_rayon'] ?>',
                                                            '<?= $row['alamat_rayon'] ?>'
                                                        )">
                                                                    Edit
                                                                </button>

                                                                <button class="btn btn-danger btn-sm"
                                                                    onclick="hapus('<?= $row['id_rayon'] ?>')">
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

                                <!-- Nama Rayon -->
                                <div class="mb-3">
                                    <label for="nama_rayon" class="form-label">Nama Rayon</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        <input type="number" min="1" id="nama_rayon" name="nama_rayon"
                                            class="form-control" placeholder="Masukkan nama lengkap" required>
                                    </div>
                                </div>

                                <!-- Select Majelis -->
                                <div class="mb-3">
                                    <label for="majelis" class="form-label">Majelis</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        <select class="form-select" name="id_majelis" id="majelis" required>
                                            <option value="" disabled selected>Pilih Majelis</option>
                                            <?php
                                            include '../../keamanan/koneksi.php';
                                            $query_majelis = "SELECT * FROM majelis";
                                            $result_majelis = $koneksi->query($query_majelis);
                                            while ($row_majelis = $result_majelis->fetch_assoc()) {
                                                $nama_majelis = $row_majelis['nama_lengkap'];
                                                $id_majelis = $row_majelis['id_majelis'];
                                                echo "<option value='$id_majelis'>Majelis $nama_majelis</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- alamat -->
                                <div class="mb-3">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        <input type="text" id="alamat" name="alamat" class="form-control"
                                            placeholder="Masukkan alamat" required>
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
                                <input type="hidden" id="edit_id" name="id_rayon">

                                <!-- Nama Rayon -->
                                <div class="mb-3">
                                    <label for="nama_rayon" class="form-label">Nama Rayon</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        <input type="number" min="1" id="edit_nama_rayon" name="nama_rayon"
                                            class="form-control" placeholder="Masukkan nama lengkap" required>
                                    </div>
                                </div>

                                <!-- Select Majelis -->
                                <div class="mb-3">
                                    <label for="majelis" class="form-label">Majelis</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        <select class="form-select" name="id_majelis" id="edit_id_majelis" required>
                                            <option value="" disabled selected>Pilih Majelis</option>
                                            <?php
                                            include '../../keamanan/koneksi.php';
                                            $query_majelis = "SELECT * FROM majelis m
                                            INNER JOIN rayon r ON m.id_majelis = r.id_majelis";
                                            $result_majelis = $koneksi->query($query_majelis);
                                            while ($row_majelis = $result_majelis->fetch_assoc()) {
                                                $nama_rayon = $row_majelis['nama_rayon'];
                                                $id_majelis = $row_majelis['id_majelis'];
                                                $nama_lengkap = $row_majelis['nama_lengkap'];
                                                $umut = $row_majelis['umur'];
                                                $jenis_kelamin = $row_majelis['jenis_kelamin'];
                                                echo "<option value='$id_majelis'>$nama_lengkap (Rayon : $nama_rayon)</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- alamat -->
                                <div class="mb-3">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        <input type="text" id="edit_alamat" name="alamat" class="form-control"
                                            placeholder="Masukkan alamat" required>
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
    function openEditModal(id, id_majelis, nama_rayon, alamat) {
        let editModal = new bootstrap.Modal(document.getElementById('editModal'));
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_id_majelis').value = id_majelis;
        document.getElementById('edit_nama_rayon').value = nama_rayon;
        document.getElementById('edit_alamat').value = alamat;
        editModal.show();
    }
    </script>

    <?php include 'fitur/js.php'; ?>
</body>

</html>