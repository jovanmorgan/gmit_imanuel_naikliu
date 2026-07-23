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
                                <button class="btn btn-outline-secondary" type="submit">Cari</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
    session_start();

    $id_jemaat = $_SESSION['id_jemaat'];
    include '../../../../keamanan/koneksi.php';

    $search = isset($_GET['search']) ? $_GET['search'] : '';
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = 10;
    $offset = ($page - 1) * $limit;

    // ===========================
    // QUERY SIDi + JEMAAT + PENDAFTARAN
    // ===========================
    $query = "
    SELECT 
        sidi.id_sidi,
        sidi.akta_kelahiran,
        sidi.surat_babtis,
        sidi.id_jemaat,
        jemaat.nama_lengkap,
        jemaat.jenis_kelamin,
        jemaat.tanggal_lahir,
        pendaftaran.status_pendaftaran,
        pendaftaran.alasan_dibatalkan

    FROM sidi
    INNER JOIN jemaat ON sidi.id_jemaat = jemaat.id_jemaat

    LEFT JOIN pendaftaran 
        ON pendaftaran.id_table = sidi.id_sidi
        AND pendaftaran.type_table = 'sidi'

    WHERE 
        sidi.id_jemaat = ?
        AND (
            jemaat.nama_lengkap LIKE ?
            OR sidi.akta_kelahiran LIKE ?
            OR sidi.surat_babtis LIKE ?
        )

    ORDER BY sidi.id_sidi DESC
    LIMIT ?, ?
";

    $stmt = $koneksi->prepare($query);
    $param = "%$search%";
    $stmt->bind_param("isssii", $id_jemaat, $param, $param, $param, $offset, $limit);
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
        sidi.id_jemaat = ?
        AND (
            jemaat.nama_lengkap LIKE ?
            OR sidi.akta_kelahiran LIKE ?
            OR sidi.surat_babtis LIKE ?
        )
";

    $stmt2 = $koneksi->prepare($countQuery);
    $stmt2->bind_param("isss", $id_jemaat, $param, $param, $param);
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
                                            <th>Status Pendaftaran</th>
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
                                                    <?php $file1 = htmlspecialchars($row['akta_kelahiran']); ?>
                                                    <a href="../../assets/file/<?= $file1 ?>" target="_blank"
                                                        class="btn btn-sm btn-primary">Lihat
                                                        Akta</a>
                                                </td>

                                                <td>
                                                    <?php $file2 = htmlspecialchars($row['surat_babtis']); ?>
                                                    <a href="../../assets/file/<?= $file2 ?>" target="_blank"
                                                        class="btn btn-sm btn-success">Surat
                                                        Babtis</a>
                                                </td>

                                                <!-- STATUS PENDAFTARAN -->
                                                <td>
                                                    <?php
                                                    if (is_null($row['status_pendaftaran'])) {
                                                        echo '<span class="badge bg-secondary">Dalam Proses</span>';
                                                    } else {
                                                        if ($row['status_pendaftaran'] == 'disetujui') {
                                                            echo '<span class="badge bg-success">Disetujui</span>';
                                                        } else {
                                                            echo '<span class="badge bg-danger">Dibatalkan</span><br>';
                                                            echo '<small class="text-danger">Alasan: '
                                                                . htmlspecialchars($row['alasan_dibatalkan'])
                                                                . '</small>';
                                                        }
                                                    }
                                                    ?>
                                                </td>

                                                <!-- AKSI -->
                                                <td style="display:flex; gap:5px; justify-content:center;">
                                                    <button class="btn btn-warning btn-sm" onclick="openEditModal(
                                                '<?= $row['id_sidi'] ?>',
                                                '<?= $row['id_jemaat'] ?>',
                                                '<?= $row['akta_kelahiran'] ?>',
                                                '<?= $row['surat_babtis'] ?>'
                                            )">Edit</button>

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