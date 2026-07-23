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

                    <section class="gereja-hero">
                        <div class="gereja-hero-overlay">
                            <h1 class="hero-title">GMIT Imanuel Naikliu</h1>
                            <p class="hero-subtitle">Klasis Amfoang Utara · Kabupaten Kupang, NTT</p>
                        </div>
                    </section>

                    <!-- ===================== GALERI GEREJA ===================== -->
                    <section class="gereja-gallery mt-5 mb-5">
                        <h2 class="text-center fw-bold mb-4">Galeri GMIT Imanuel Naikliu</h2>

                        <div class="gallery-grid">
                            <!-- Ganti src dengan gambar Anda -->
                            <div class="gallery-item">
                                <img src="../../assets/img/gereja/gereja.jpg" alt="Foto Gereja 1"
                                    onclick="openLightbox(this.src)">
                            </div>

                            <div class="gallery-item">
                                <img src="../../assets/img/gereja/jemaat.jpg" alt="Foto Gereja 2"
                                    onclick="openLightbox(this.src)">
                            </div>

                            <div class="gallery-item">
                                <img src="../../assets/img/gereja/struktur.jpg" alt="Foto Gereja 3"
                                    onclick="openLightbox(this.src)">
                            </div>

                            <div class="gallery-item">
                                <img src="../../assets/img/gereja/tangga.jpg" alt="Foto Gereja 4"
                                    onclick="openLightbox(this.src)">
                            </div>
                        </div>
                    </section>
                    <!-- ===================== END GALERI ===================== -->
                    <style>
                        /* Section Title */
                        .gereja-gallery h2 {
                            color: var(--title-color, #2c3e50);
                            font-family: 'Cinzel', serif;
                        }

                        /* Grid Layout */
                        .gallery-grid {
                            display: grid;
                            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
                            gap: 20px;
                        }

                        /* Gallery Items */
                        .gallery-item {
                            width: 100%;
                            height: 230px;
                            overflow: hidden;
                            border-radius: 12px;
                            position: relative;
                            cursor: pointer;
                            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
                            transition: 0.3s ease;
                        }

                        .gallery-item img {
                            width: 100%;
                            height: 100%;
                            object-fit: cover;
                            transition: transform .4s ease;
                        }

                        .gallery-item:hover img {
                            transform: scale(1.15);
                        }

                        /* Lightbox Overlay */
                        #lightbox {
                            display: none;
                            position: fixed;
                            z-index: 2000;
                            padding-top: 50px;
                            left: 0;
                            top: 0;
                            width: 100%;
                            height: 100%;
                            background-color: rgba(0, 0, 0, 0.85);
                        }

                        #lightbox img {
                            display: block;
                            margin: auto;
                            max-width: 85%;
                            max-height: 85%;
                            border-radius: 10px;
                        }
                    </style>
                    <script>
                        function openLightbox(src) {
                            const lightbox = document.getElementById("lightbox");
                            const img = document.getElementById("lightbox-img");

                            img.src = src;
                            lightbox.style.display = "block";
                        }

                        function closeLightbox() {
                            document.getElementById("lightbox").style.display = "none";
                        }
                    </script>

                    <!-- LIGHTBOX ELEMENT -->
                    <div id="lightbox" onclick="closeLightbox()">
                        <img id="lightbox-img" src="">
                    </div>


                </div>
            </div>
            <!-- bagian pop up edit dan tambah -->

            <?php include 'fitur/js.php'; ?>
</body>

</html>