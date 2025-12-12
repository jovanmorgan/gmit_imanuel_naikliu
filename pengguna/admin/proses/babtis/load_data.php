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
                                     placeholder="Cari jemaat, akta, atau surat nikah..." name="search"
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

        // ===========================================
        // QUERY DATA BABTIS + JEMAAT
        // ===========================================
        $query = "
        SELECT 
            babtis.id_babtis,
            babtis.id_jemaat,
            babtis.tempat_lahir,
            babtis.tanggal_lahir,
            babtis.surat_nikah_orang_tua,
            babtis.akta_kelahiran,
            jemaat.nama_lengkap,
            jemaat.jenis_kelamin
        FROM babtis
        INNER JOIN jemaat ON babtis.id_jemaat = jemaat.id_jemaat
        WHERE 
            jemaat.nama_lengkap LIKE ?
            OR babtis.tempat_lahir LIKE ?
            OR babtis.surat_nikah_orang_tua LIKE ?
            OR babtis.akta_kelahiran LIKE ?
        ORDER BY babtis.id_babtis DESC
        LIMIT ?, ?
    ";

        $stmt = $koneksi->prepare($query);
        $param = "%$search%";
        $stmt->bind_param("ssssii", $param, $param, $param, $param, $offset, $limit);
        $stmt->execute();
        $result = $stmt->get_result();

        // ===========================================
        // HITUNG TOTAL DATA
        // ===========================================
        $countQuery = "
        SELECT COUNT(*) AS total
        FROM babtis
        INNER JOIN jemaat ON babtis.id_jemaat = jemaat.id_jemaat
        WHERE 
            jemaat.nama_lengkap LIKE ?
            OR babtis.tempat_lahir LIKE ?
            OR babtis.surat_nikah_orang_tua LIKE ?
            OR babtis.akta_kelahiran LIKE ?
    ";

        $stmt2 = $koneksi->prepare($countQuery);
        $stmt2->bind_param("ssss", $param, $param, $param, $param);
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
                                             <th>Tempat Lahir</th>
                                             <th>Tanggal Lahir</th>
                                             <th>Surat Nikah Orang Tua</th>
                                             <th>Akta Kelahiran</th>
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
                                                 <td><?= htmlspecialchars($row['tempat_lahir']) ?></td>

                                                 <td>
                                                     <?= date("d-m-Y", strtotime($row['tanggal_lahir'])) ?>
                                                 </td>

                                                 <!-- SURAT NIKAH ORTU -->
                                                 <td>
                                                     <a href="../../assets/file/<?= htmlspecialchars($row['surat_nikah_orang_tua']) ?>"
                                                         target="_blank"
                                                         class="btn btn-sm btn-warning d-flex align-items-center justify-content-center gap-1">
                                                         Surat Nikah
                                                     </a>
                                                 </td>

                                                 <!-- AKTA KELAHIRAN -->
                                                 <td>
                                                     <a href="../../assets/file/<?= htmlspecialchars($row['akta_kelahiran']) ?>"
                                                         target="_blank"
                                                         class="btn btn-sm btn-primary d-flex align-items-center justify-content-center gap-1">
                                                         Akta Kelahiran
                                                     </a>
                                                 </td>

                                                 <!-- BUTTON EDIT/HAPUS -->
                                                 <td style="display:flex; gap:5px; justify-content:center;">

                                                     <button class="btn btn-warning btn-sm" onclick="openEditModal(
                                                    '<?= $row['id_babtis'] ?>',
                                                    '<?= $row['id_jemaat'] ?>',
                                                    '<?= $row['tempat_lahir'] ?>',
                                                    '<?= $row['tanggal_lahir'] ?>',
                                                    '<?= $row['surat_nikah_orang_tua'] ?>',
                                                    '<?= $row['akta_kelahiran'] ?>'
                                                )">
                                                         Edit
                                                     </button>

                                                     <button class="btn btn-danger btn-sm"
                                                         onclick="hapus('<?= $row['id_babtis'] ?>')">
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