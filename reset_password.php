<?php
session_start();
require_once('includes/functions.php');

// Validate if token is provided in the URL
if (isset($_GET["token"])) {
    $token = $_GET["token"];

    // Check if the token exists in the database
    $query = "SELECT * FROM tcr_registration WHERE reset_token = '$token'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) == 1) {
        // Display a password reset form
        // Process password reset form submission
    } else {
        // Token not found or expired, handle error
        $error_message = "Invalid or expired token. Please request a new password reset link.";
    }
} else {
    // Token not provided in URL, handle error
    $error_message = "Token not provided. Please request a password reset link.";
}
?>

<?php
if (isset($_POST["reset_submit"])) {
    $new_password = $_POST["new_password"];
    $confirm_password = $_POST["confirm_password"];

    // Validate password strength and match
    if ($new_password != $confirm_password) {
        $error_message = "Passwords do not match. Please try again.";
    } else {
        // Hash the new password (use password_hash() for secure hashing)
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Update the user's password in the database
        $update_query = "UPDATE tcr_registration SET user_pass = '$hashed_password', reset_token = NULL WHERE reset_token = '$token'";
        $update_result = mysqli_query($con, $update_query);

        if ($update_result) {
            // Password reset successful, redirect to login page or display success message
            header("Location: login.php");
            exit();
        } else {
            $error_message = "Failed to reset password. Please try again later.";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
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
                <div class="col-md-6 col-xl-5">
                <?php
                if (isset($error_message)) {
                    echo $error_message;
                }
                ?>
                    <div class="p-4 rounded-4 shadow-lg border my-5">
                        <h2 class="text-center mb-4">Forgot Password</h2>
                        <form method="POST">
                            <div class="form-group d-flex flex-column gap-2">
                                <label class="mb-1" for="user_email">Enter your email:</label>
                                <input type="email" name="user_email" id="user_email" class="form-control mb-3" placeholder="Your Email" required>
                                <div class="d-flex justify-content-end gap-3">
                                    <button type="submit" name="forgot_submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include("includes/footer.php"); ?>

</body>

</html>