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
        include '../../../../keamanan/koneksi.php';

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

                                                       <a href="../../assets/file/<?= $file1 ?>" target="_blank"
                                                           class="btn btn-sm btn-primary d-flex align-items-center justify-content-center gap-1">
                                                           Lihat Akta
                                                       </a>
                                                   </td>

                                                   <td>
                                                       <?php
                                                        $file2 = htmlspecialchars($row['surat_babtis']);
                                                        $ext2  = strtolower(pathinfo($file2, PATHINFO_EXTENSION));


                                                        ?>

                                                       <a href="../../assets/file/<?= $file2 ?>" target="_blank"
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