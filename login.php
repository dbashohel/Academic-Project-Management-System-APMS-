<?php
session_start();
require_once('includes/functions.php');

// Check if user is already logged in
if (isset($_SESSION["user_email"])) {
    // Redirect to dashboard or any other page
    if ($_SESSION["user_role"] == 'teacher') {
        header("Location: index.php");
        exit();
    } elseif ($_SESSION["user_role"] == 'admin') {
        header("Location: index.php");
        exit();
    } else {
        // If user is logged in but role is not recognized, log them out and redirect to login
        session_unset();
        session_destroy();
        header("Location: login.php");
        exit();
    }
} elseif (isset($_SESSION["std_id"])) {
    // Redirect to dashboard or any other page
    if ($_SESSION["user_role"] == 'student') {
        header("Location: std_dashboard.php");
        exit();
    } else {
        // If user is logged in but role is not recognized, log them out and redirect to login
        session_unset();
        session_destroy();
        header("Location: login.php");
        exit();
    }
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- fontawesome CSS -->
    <link href="css/fontawesome.min.css" rel="stylesheet">
    <!-- style css-->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <style>
        .start_page {
            height: 100vh;
            align-items: center;
            min-height: 100%;

            /* max-width: 250px; */
        }

        .start_page .start_page_box .area {
            align-items: center;
            height: 100%;
        }

        .rounded-4 {
            border-radius: 24px !important;
        }
    </style>

    <section class="login start_page ">
        <div class="container h-100">
            <div class="row justify-content-center align-items-center h-100">
                <div class="start_page_box p-3 p-md-5 rounded-4 shadow-lg border my-5">
                    <div class="nub_logo text-end mb-4 mb-md-5 ">
                        <img src="img/nub_logo.png" class="" alt="USA">
                    </div>
                    <h1 class="mb-4 white">Hello USA,</h1>
                    <h3 class="mb-5 white pb-lg-3">Please Login to Your Account!</h3>
                    <div class="row area g-4">
                        <div class="col-sm-6 col-lg-4">
                            <div class="card box-card py-5 rounded-4 shadow-lg border">
                                <a href="login2.php" class="d-flex flex-column text-center gap-4">
                                    <i class="fa-solid fa-person-chalkboard"></i>
                                    <h4 class="white">Super Admin</h4>
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-4">
                            <div class="card box-card py-5 rounded-4 shadow-lg border">
                                <a href="login2.php" class="d-flex flex-column text-center gap-4">
                                    <i class="fa-solid fa-person-chalkboard"></i>
                                    <h4 class="white">Teacher's</h4>
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-4">
                            <div class="card box-card py-5 rounded-4 shadow-lg border">
                                <a href="login_std.php" class="d-flex flex-column text-center gap-4">
                                    <i class="fa-solid fa-users"></i>
                                    <h4 class="white">Student's</h4>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include("includes/footer.php"); ?>

</body>

</html>


<!-- iJ7rfpgEDp@4Z3v -->