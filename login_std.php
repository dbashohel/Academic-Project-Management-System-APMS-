<?php
session_start();
require_once('includes/functions.php');

// Check if user is already logged in
if (isset($_SESSION["std_id"])) {
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
} elseif (isset($_SESSION["user_email"])) {
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
}

// Check if the remember me checkbox is checked
if (isset($_POST["login_submit"]) && isset($_POST["remember_me"])) {
    // Set a cookie to remember the user's email for 30 days
    setcookie("remember_std_id", $_POST["std_id"], time() + (30 * 24 * 60 * 60), "/");
}

if (isset($_POST["std_id"]) && isset($_POST["std_pass"])) {
    $std_id = $_POST["std_id"];
    $std_pass = $_POST["std_pass"];

    // Validate the user's credentials
    $query = "SELECT * FROM std_registration WHERE std_id = '$std_id' AND std_pass = '$std_pass'";
    $find = mysqli_query($con, $query);
    

    if (mysqli_num_rows($find) == 1) {
        $row = mysqli_fetch_assoc($find);

        $id_approved = $row["id_approved"];
        $std_id = $row["std_id"];
        $user_role = $row["user_role"];
        $std_name = $row["std_name"];
        $_SESSION["std_id"] = $std_id;
        $_SESSION["std_name"] = $std_name;
        $_SESSION["student"] = $row;

        if ($id_approved != 'approved') {
            $erroremail = "<div class='alert alert-warning alert-dismissible'>
            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
            <strong>Your ID is not verified!</strong> Please contact the administrator.
          </div>";
        } elseif ($user_role == 'student') {
            $_SESSION["user_role"] = $user_role;
            header("Location: std_dashboard.php");
            exit();
        }
    } else {
        $erroremail = "<div class='alert alert-warning alert-dismissible'>
        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
        <strong>Username and Password not Valid!</strong> You must enter a valid Username and Password to use the user profile.
      </div>" . mysqli_error($con);
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

    <section class="login">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
                    <div class="start_page_box p-4 p-lg-5 rounded-4 shadow-lg border my-5">
                        <div class="nub_logo text-end mb-5">
                            <a href="index.php">
                                <img src="img/nub_logo.png" class="" alt="USA">
                            </a>
                        </div>
                        <h1 class="mb-4">Hello USA,</h1>
                        <h3 class="mb-4">Please Login to Your Account!</h3>
                        <form method="POST">
                            <label class="mb-1" for="std_id">Student ID :</label>
                            <input type="string" name="std_id" id="std_id" class="form-control mb-3" placeholder="Student ID" required>

                            <label class="mb-1" for="std_pass">Student Password :</label>
                            <input type="password" id="std_pass" name="std_pass" class="form-control mb-3" placeholder="Student Password" required>
                            <div class="d-flex flex-wrap justify-content-between row-gap-3 column-gap-5">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember_me" name="remember_me">
                                    <label class="form-check-label" for="remember_me">
                                        Remember me
                                    </label>
                                </div>
                                <div class="form-cool">
                                    <p><a href="std_forget_password.php">Forgotten password?</a></p>
                                </div>
                            </div>

                            <div class="d-flex  gap-3 mt-4">
                                <button type="submit" name="login_submit" class="btn btn-success px-4 py-2 rounded-3">Login</button>
                                <a href="student_new_registration.php" class="btn btn-outline-success px-4 py-2 rounded-3" role="button">Sign Up</a>
                            </div>
                        </form>

                        <?php
                        if (isset($erroremail)) {
                            echo $erroremail;
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include("includes/footer.php"); ?>



    <!-- iJ7rfpgEDp@4Z3v -->