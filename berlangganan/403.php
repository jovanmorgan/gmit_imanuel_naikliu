<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 Forbidden</title>
    <!-- Menyertakan Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Menyertakan font-awesome untuk ikon -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <style>
    /* CSS untuk background dan layout */
    body {
        background-color: #f8f9fa;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0;
    }

    .container {
        text-align: center;
        padding: 40px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        animation: fadeIn 1s ease-in-out;
    }

    h1 {
        font-size: 100px;
        font-weight: bold;
        color: #e74c3c;
    }

    h2 {
        color: #333;
        margin-bottom: 30px;
    }

    .btn-custom {
        background-color: #3498db;
        color: white;
        border-radius: 5px;
        padding: 10px 20px;
        font-size: 16px;
        transition: background-color 0.3s;
    }

    .btn-custom:hover {
        background-color: #2980b9;
    }

    .fa-lock {
        font-size: 80px;
        color: #e74c3c;
        margin-bottom: 20px;
    }

    @keyframes fadeIn {
        0% {
            opacity: 0;
            transform: translateY(-50px);
        }

        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }
    </style>
</head>

<body>

    <div class="container">
        <i class="fas fa-lock"></i>
        <h1>403</h1>
        <h2>Halaman Tidak Diijinkan</h2>
        <p>Anda tidak memiliki izin untuk mengakses halaman ini.</p>
        <a href="login" class="btn btn-custom">Kembali</a>
    </div>

    <!-- Menyertakan Bootstrap JS dan Popper -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

</body>

</html>