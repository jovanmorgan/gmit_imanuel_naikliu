    <?php
    // Lakukan koneksi ke database
    include '../../keamanan/koneksi.php';

    // Periksa apakah session id_pendeta telah diset
    if (isset($_SESSION['id_pendeta'])) {
        $id_pendeta = $_SESSION['id_pendeta'];

        // Query SQL untuk mengambil data pendeta berdasarkan id_pendeta dari session
        $query = "SELECT * FROM pendeta WHERE id_pendeta = '$id_pendeta'";
        $result = mysqli_query($koneksi, $query);

        // Periksa apakah query berhasil dieksekusi
        if ($result) {
            // Periksa apakah terdapat data pendeta
            if (mysqli_num_rows($result) > 0) {
                // Ambil data pendeta sebagai array asosiatif
                $pendeta = mysqli_fetch_assoc($result);
    ?>
    <div class="main-header">
        <div class="main-header-logo">
            <!-- Logo Header -->
            <div class="logo-header" data-background-color="white">
                <a href="index.html" class="logo">
                    <img src="../../assets/img/akademik/3.png" alt="navbar brand" class="navbar-brand" height="20" />
                </a>
                <div class="nav-toggle">
                    <button class="btn btn-toggle toggle-sidebar">
                        <i class="gg-menu-right"></i>
                    </button>
                    <button class="btn btn-toggle sidenav-toggler">
                        <i class="gg-menu-left"></i>
                    </button>
                </div>
                <button class="topbar-toggler more">
                    <i class="gg-more-vertical-alt"></i>
                </button>
            </div>
            <!-- End Logo Header -->
        </div>
        <!-- Navbar Header -->
        <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom"
            data-background-color="white">
            <div class="container-fluid">
                <nav class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <button type="submit" class="btn btn-search pe-1">
                                <i class="fa fa-search search-icon"></i>
                            </button>
                        </div>
                        <form class="search-form d-flex align-items-center" method="POST" action="fitur/search.php">
                            <input type="text" name="query" placeholder="Search ..." class="form-control" />
                        </form>
                    </div>
                </nav>

                <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                    <li class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                            aria-expanded="false" aria-haspopup="true">
                            <i class="fa fa-search"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-search animated fadeIn">
                            <form class="search-form d-flex align-items-center" method="POST" action="fitur/search.php">
                                <div class="input-group">

                                    <input type="text" name="query" placeholder="Search ..." class="form-control" />
                                </div>
                            </form>
                        </ul>
                    </li>

                    <li class="nav-item topbar-user dropdown hidden-caret">
                        <a class="dropdown-toggle profile-pic" id="dropdownProfile" href="#">
                            <div class="avatar-sm">
                                <?php if (!empty($pendeta['fp'])): ?>
                                <img src="../../assets/img/fp_pengguna/pendeta/<?php echo $pendeta['fp']; ?>" alt="..."
                                    class="avatar-img rounded-circle" />
                                <?php else: ?>
                                <img src="../../assets/img/avatar/avatar.png" alt="..."
                                    class="avatar-img rounded-circle" />
                                <?php endif; ?>
                            </div>
                            <span class="profile-username">
                                <span class="op-7">Hay,</span>
                                <span class="fw-bold"><?php echo $pendeta['nama_lengkap']; ?></span>
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-user" id="dropdownMenu">
                            <div class="dropdown-user-scroll scrollbar-outer">
                                <li>
                                    <div class="user-box">
                                        <div class="avatar-lg">
                                            <?php if (!empty($pendeta['fp'])): ?>
                                            <img src="../../assets/img/fp_pengguna/pendeta/<?php echo $pendeta['fp']; ?>"
                                                alt="image profile" class="avatar-img rounded" />
                                            <?php else: ?>
                                            <img src="../../assets/img/avatar/avatar.png" alt="..." alt="image profile"
                                                class="avatar-img rounded" />
                                            <?php endif; ?>
                                        </div>
                                        <div class="u-text">
                                            <span class="op-7">Hay,</span>
                                            <span class="fw-bold"><?php echo $pendeta['nama_lengkap']; ?></span>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="profile">My Profile</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="log_out">Logout</a>
                                </li>
                            </div>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- End Navbar -->
    </div>
    <script>
document.addEventListener("DOMContentLoaded", () => {
    const dropdownToggle = document.getElementById("dropdownProfile");
    const dropdownMenu = document.getElementById("dropdownMenu");

    // Toggle dropdown menu visibility
    dropdownToggle.addEventListener("click", (e) => {
        e.preventDefault();
        dropdownMenu.classList.toggle("show");
    });

    // Close the dropdown menu when clicking outside
    document.addEventListener("click", (e) => {
        if (!dropdownToggle.contains(e.target) && !dropdownMenu.contains(e.target)) {
            dropdownMenu.classList.remove("show");
        }
    });
});
    </script>
    <?php
            } else {
                // Jika tidak ada data pendeta
                echo "Tidak ada data pendeta.";
            }
        } else {
            // Jika query tidak berhasil dieksekusi
            echo "Gagal mengambil data pendeta: " . mysqli_error($koneksi);
        }
    } else {
        // Jika session id_pendeta tidak diset
        echo "Session id_pendeta tidak tersedia.";
    }

    // Tutup koneksi ke database
    mysqli_close($koneksi);
    ?>