function togglePasswordVisibility(inputId) {
  var passwordInput = document.getElementById(inputId);
  var passwordIcon = document.querySelector(".toggle-password");

  if (passwordInput.type === "password") {
    passwordInput.type = "text";
    passwordIcon.classList.remove("fa-eye-slash");
    passwordIcon.classList.add("fa-eye");
  } else {
    passwordInput.type = "password";
    passwordIcon.classList.remove("fa-eye");
    passwordIcon.classList.add("fa-eye-slash");
  }
}

document.getElementById("login").addEventListener("submit", function (event) {
  event.preventDefault();

  var formData = new FormData(this);

  var xhr = new XMLHttpRequest();
  xhr.open("POST", "../keamanan/proses_login", true);
  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        var response = xhr.responseText;
        var responseArray = response.split(":");
        if (responseArray[0].trim() === "success") {
          Swal.fire({
            icon: "success",
            title: "Login berhasil!",
            text: "Selamat datang " + responseArray[1],
            timer: 2000,
            timerProgressBar: true,
            didOpen: () => {
              Swal.showLoading();
            },
          }).then((result) => {
            switch (responseArray[2].trim()) {
              case "admin":
                window.location.href = "../pengguna/admin/";
                break;
              case "pendeta":
                window.location.href = "../pengguna/pendeta/";
                break;
              case "jemaat":
                window.location.href = "../pengguna/jemaat/";
                break;
              default:
                window.location.href = "login";
                break;
            }
          });

          if (rememberMe) {
            var username = formData.get("username");
            var password = formData.get("password");
            document.cookie =
              "username=" + encodeURIComponent(username) + "; path=/";
            document.cookie =
              "password=" + encodeURIComponent(password) + "; path=/";
          }
        } else if (responseArray[0].trim() === "error_password") {
          Swal.fire("Error", "Password yang dimasukkan salah", "info");
        } else if (responseArray[0].trim() === "error_username") {
          Swal.fire("Error", "Username tidak ditemukan", "info");
        } else if (responseArray[0].trim() === "username_tidak_ada") {
          Swal.fire("Info", "Username belum diisi", "info");
        } else if (responseArray[0].trim() === "password_tidak_ada") {
          Swal.fire("Info", "Password belum diisi", "info");
        } else if (responseArray[0].trim() === "tidak_ada_data") {
          Swal.fire("Info", "Username dan Password belum diisi", "info");
        } else {
          Swal.fire("Error", "Terjadi kesalahan saat proses login", "error");
        }
      } else {
        Swal.fire("Error", "Gagal", "error");
      }
    }
  };
  xhr.onerror = function () {
    Swal.fire("Error", "Gagal melakukan request", "error");
  };
  xhr.send(formData);
});

window.onload = function () {
  // Melakukan AJAX request untuk memeriksa akses di check_serial.php
  var xhr = new XMLHttpRequest();
  xhr.open("GET", "../keamanan/akses_halaman.php", true); // Ganti dengan path yang sesuai jika perlu
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
        window.location.href = "403";
      }
    } else {
      // Jika request gagal
      window.location.href = "403";
    }
  };
  xhr.send(); // Kirim request ke check_serial.php
};
