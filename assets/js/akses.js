window.onload = function () {
  // Melakukan AJAX request untuk memeriksa akses di check_serial.php
  var xhr = new XMLHttpRequest();
  xhr.open("GET", "../../keamanan/akses_halaman.php", true); // Ganti dengan path yang sesuai jika perlu
  xhr.onload = function () {
    if (xhr.status === 200) {
      var response = xhr.responseText.trim(); // Menghapus spasi yang tidak perlu

      if (response === "akses_diperbolehkan") {
        // Jika akses diperbolehkan, lanjutkan dengan memuat halaman
        console.log(response);
      } else if (response === "akses_ditolak") {
        //    arahkan ke halaman 403
        window.location.href = "403";
      } else {
        // Jika respons tidak terduga
        Swal.fire({
          title: "Kesalahan",
          text: "Terjadi masalah dalam memeriksa akses.",
          icon: "error",
          confirmButtonText: "Tutup",
        });
      }
    } else {
      // Jika request gagal
      Swal.fire({
        title: "Kesalahan",
        text: "Gagal memverifikasi akses.",
        icon: "error",
        confirmButtonText: "Tutup",
      });
    }
  };
  xhr.send(); // Kirim request ke check_serial.php
};
