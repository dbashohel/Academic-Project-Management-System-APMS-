<?php
session_start();
require_once('includes/functions.php');

if (isset($_POST["forgot_submit"])) {
    $user_email = $_POST["user_email"];

    // Validate if the email exists in your database
    $query = "SELECT * FROM std_registration WHERE user_email = '$user_email'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) == 1) {
        // Generate a unique token for password reset (you can use a library like random_bytes or hash functions)
        $token = bin2hex(random_bytes(32)); // Example of generating a random token

        // Store the token in the database for the user
        $update_query = "UPDATE std_registration SET reset_token = '$token' WHERE user_email = '$user_email'";
        $update_result = mysqli_query($con, $update_query);

        if ($update_result) {
            // Send an email with the reset link containing the token
            $reset_link = "http://yourwebsite.com/reset_password.php?token=$token";
            $to = $user_email;
            $subject = "Password Reset Request";
            $message = "Dear User,\n\nPlease click the following link to reset your password:\n$reset_link\n\nIf you did not request this reset, please ignore this email.";
            $headers = "From: your-email@example.com";

            // Send the email (you might want to handle errors and use a library like PHPMailer for robust email sending)
            $mail_sent = mail($to, $subject, $message, $headers);

            if ($mail_sent) {
                // Display a success message or redirect to a confirmation page
                $success_message = "Password reset link has been sent to your email.";
            } else {
                $error_message = "Failed to send reset link. Please try again later.";
            }
        } else {
            $error_message = "Failed to update reset token. Please try again later.";
        }
    } else {
        $error_message = "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                        <strong>Email address not found. Please enter a valid email.</strong>.
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
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