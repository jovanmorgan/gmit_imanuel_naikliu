    <div id="load_data">

        <!-- Search -->
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body text-center">

                            <form method="GET" action="">
                                <div class="input-group mt-3">
                                    <input type="text" class="form-control" placeholder="Cari data rayon / majelis..."
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

        <?php
                        include '../../../../keamanan/koneksi.php';

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

    </div>