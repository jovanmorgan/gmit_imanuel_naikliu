<?php
include 'koneksi.php';

function checkpenggunahType($username)
{
    global $koneksi;
    $query_admin = "SELECT * FROM admin WHERE username = '$username'";
    $query_majelis = "SELECT * FROM majelis WHERE username = '$username'";
    $query_jemaat = "SELECT * FROM jemaat WHERE username = '$username'";
    $query_pendeta = "SELECT * FROM pendeta WHERE username = '$username'";

    $result_admin = mysqli_query($koneksi, $query_admin);
    $result_majelis = mysqli_query($koneksi, $query_majelis);
    $result_jemaat = mysqli_query($koneksi, $query_jemaat);
    $result_pendeta = mysqli_query($koneksi, $query_pendeta);

    if (mysqli_num_rows($result_admin) > 0) {
        return "admin";
    } elseif (mysqli_num_rows($result_majelis) > 0) {
        return "majelis";
    } elseif (mysqli_num_rows($result_jemaat) > 0) {
        return "jemaat";
    } elseif (mysqli_num_rows($result_pendeta) > 0) {
        return "pendeta";
    } else {
        return "not_found";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Lakukan validasi data
    if (empty($username) && empty($password)) {
        echo "tidak_ada_data";
        exit();
    }
    if (empty($username)) {
        echo "username_tidak_ada";
        exit();
    }

    if (empty($password)) {
        echo "password_tidak_ada";
        exit();
    }


    $penggunahType = checkpenggunahType($username);
    if ($penggunahType !== "not_found") {
        $query_penggunah = "SELECT * FROM $penggunahType WHERE username = '$username'";
        $result_penggunah = mysqli_query($koneksi, $query_penggunah);

        if (mysqli_num_rows($result_penggunah) > 0) {
            $row = mysqli_fetch_assoc($result_penggunah);
            $hashed_password = $row['password'];

            if ($password === $hashed_password) {

                // Process login for other penggunah types
                session_start();
                $_SESSION['username'] = $username;

                switch ($penggunahType) {
                    case "admin":
                        $_SESSION['id_admin'] = $row['id_admin'];
                        break;
                    case "majelis":
                        $_SESSION['id_majelis'] = $row['id_majelis'];
                        $id_majelis = $row['id_majelis'];
                        break;
                    case "jemaat":
                        $_SESSION['id_jemaat'] = $row['id_jemaat'];
                        $id_jemaat = $row['id_jemaat'];
                        break;
                    case "pendeta":
                        $_SESSION['id_pendeta'] = $row['id_pendeta'];
                        break;
                    default:
                        break;
                }

                // Success response
                switch ($penggunahType) {
                    case "admin":
                        echo "success:" . $username . ":" . $penggunahType . ":" . "../pengguna/admin/";
                        break;
                    case "majelis":
                        echo "success:" . $username . ":" . $penggunahType . ":" . "../pengguna/majelis/";
                        break;
                    case "jemaat":
                        echo "success:" . $username . ":" . $penggunahType . ":" . "../pengguna/jemaat/";
                        break;
                    case "pendeta":
                        echo "success:" . $username . ":" . $penggunahType . ":" . "../pengguna/pendeta/";
                        break;
                    default:
                        echo "success:" . $username . ":" . $penggunahType . ":" . "../berlangganan/login";
                        break;
                }
            } else {
                echo "error_password";
            }
        } else {
            echo "error_username";
        }
    } else {
        echo "error_username";
    }
}