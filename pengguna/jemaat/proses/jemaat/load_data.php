  <div id="load_data">
      <section class="section">
          <div class="row">
              <div class="col-lg-12">
                  <div class="card">
                      <div class="card-body text-center">
                          <!-- Search Form -->
                          <form method="GET" action="">
                              <div class="input-group mt-3">
                                  <input type="text" class="form-control" placeholder="Cari Data Jemaat..."
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
                                                  <td><?= htmlspecialchars($row['jenis_kelamin']); ?></td>
                                                  <td><?= htmlspecialchars($row['status_keluarga']); ?></td>
                                                  <td><?= htmlspecialchars($row['tempat_lahir']); ?></td>
                                                  <td><?= htmlspecialchars($row['tanggal_lahir']); ?></td>

                                                  <td>
                                                      <?php if (!empty($row['fp'])): ?>
                                                          <img src="../../assets/img/jemaat/<?= htmlspecialchars($row['fp']); ?>"
                                                              width="50" height="50" style="border-radius: 50%; object-fit: cover;">
                                                      <?php else: ?>
                                                          <span class="text-muted">Tidak Ada</span>
                                                      <?php endif; ?>
                                                  </td>

                                                  <td style="display: flex; justify-content: center; gap: 10px;">
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