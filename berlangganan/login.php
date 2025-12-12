<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="slide navbar style.css">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap?v=<?= time(); ?>" rel="stylesheet">
    <title>Login</title>
    <link href="../css/login_register.css?<?= time(); ?>" rel="stylesheet" />
    <link rel="shortcut icon" href="../assets/img/gereja/logo.png?<?= time(); ?>" type=""
        style="background-color: aliceblue;" />
    <!-- Link untuk Font Awesome -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css?v=<?= time(); ?>">
</head>

<body>
    <div class="wrapper fadeInDown">
        <div id="formContent">
            <!-- Tabs Titles -->
            <a href="login">
                <h2 class="active">Login</h2>
            </a>
            <!-- Icon -->
            <div class="fadeIn first">
                <img src="../assets/img/gereja/logo.png" id="icon" alt="User Icon" />
            </div>

            <!-- Login Form -->
            <form id="login">
                <div class="input-wrapper">
                    <input type="text" id="username" name="username" placeholder="Username" />
                    <i class="fas fa-user input-icon"></i>
                </div>

                <div class="input-wrapper">
                    <input type="password" id="password" name="password" placeholder="Password" />
                    <i class="fas fa-lock input-icon"></i>
                    <i class="fas fa-eye toggle-password" onclick="togglePasswordVisibility('password')"></i>
                </div>

                <input type="submit" class="fadeIn fourth" value="Log In" style="cursor: pointer" />
            </form>

            <!-- Remind Passowrd -->
            <!-- <div id="formFooter">
                <a class="underlineHover" href="#">Forgot Password?</a>
            </div> -->
        </div>
    </div>

    </style>
    <!-- End footer -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
    <script src="../assets/js/sweetalert2.all.min.js"></script>
    <script src="../assets/js/login.js?<?= time(); ?>"></script>
</body>

</html>