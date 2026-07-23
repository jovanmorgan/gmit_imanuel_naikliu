<<<<<<< HEAD

                    <?php
                    include '../../../../keamanan/koneksi.php';

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
=======
     <?php
        include '../../../../keamanan/koneksi.php';

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
>>>>>>> 4103a0366611edb09f83497d66e49d67f25169a0
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

<<<<<<< HEAD
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
=======
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
>>>>>>> 4103a0366611edb09f83497d66e49d67f25169a0
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

<<<<<<< HEAD
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
                                                                        onclick="hapus('<?php echo $row['id_pendeta']; ?>')">Hapus</button>
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
=======
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
                                     <input type="text" class="form-control" placeholder="Cari Data pendeta..."
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
                                                    $js_id = json_encode($row['id_pendeta']);
                                                    $js_nama = json_encode($row['nama_lengkap']);
                                                    $js_jenis = json_encode($row['jenis_kelamin']);
                                                    $js_tempat = json_encode($row['tempat_lahir']);
                                                    $js_tgl = json_encode($row['tanggal_lahir']);
                                                    $js_priode = json_encode($row['priode_jabatan']);
                                                    $js_hp = json_encode($row['nomor_hp']);
                                                    $js_user = json_encode($row['username']);
                                                    $js_pass = json_encode($row['password']);
                                                    $js_fp = json_encode($row['fp']);
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
                                                         <!-- Panggil openEditModal dengan argumen yang sudah di-json_encode (aman untuk kutip) -->
                                                         <button class="btn btn-primary btn-sm"
                                                             onclick="openEditModal(<?= $js_id; ?>, <?= $js_nama; ?>, <?= $js_jenis; ?>, <?= $js_tempat; ?>, <?= $js_tgl; ?>, <?= $js_priode; ?>, <?= $js_hp; ?>, <?= $js_user; ?>, <?= $js_pass; ?>, <?= $js_fp; ?>)">
                                                             Edit
                                                         </button>

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
>>>>>>> 4103a0366611edb09f83497d66e49d67f25169a0
