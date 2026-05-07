<?php
session_start();

include("includes/header.php");
include("includes/functions.php");

if (!isset($_SESSION["user_email"]) || !isset($_SESSION["user_role"])) {
    header("Location: login.php");
    exit;
}

$user_email = $_SESSION["user_email"];
$user_role = $_SESSION["user_role"];

if ($user_role == 'admin') {
    generateNavMenu('admin');
} else {
    generateNavMenu('teacher');
}




$query = "SELECT * FROM tcr_registration WHERE user_email = '$user_email'";
$result = mysqli_query($con, $query);

if (!$result) {
    die("Error: " . mysqli_error($con));
}

if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    $tcr_name = $row["tcr_name"];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $oldPassword = $_POST["old_password"];
    $newPassword = $_POST["new_password"];
    $confirmPassword = $_POST["confirm_password"];

    // Check if the old password matches the user's current password
    $currentPassword = $row["user_pass"];
    if ($oldPassword !== $currentPassword) {
        $error = "Old password is incorrect.";
    } elseif ($newPassword !== $confirmPassword) {
        $error = "New password and confirm password do not match.";
    } else {
        // Update the password in the database
        $updateQuery = "UPDATE tcr_registration SET user_pass = '$newPassword' WHERE user_email = '$user_email'";
        if (mysqli_query($con, $updateQuery)) {
            $success = "Password changed successfully.";
            echo "<meta http-equiv='refresh' content='2;url=my_profile.php'>";
        } else {
            $error = "Error changing password: " . mysqli_error($con);
        }
    }
}

?>


<div class="main_page">
    <div class="content-area">
        <div class="container-fluid">
            <div class="my_profile pt-5">
                <div class="container">
                    <div class="row">
                        <div class="d-flex align-items-center justify-content-between my-3">
                            <h1>Change Password</h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <?php if (isset($error)) { ?>
                                <div class="alert alert-danger"><?= $error ?></div>
                            <?php } elseif (isset($success)) { ?>
                                <div class="alert alert-success"><?= $success ?></div>
                            <?php } ?>
                            <form method="post" class="d-flex flex-column gap-3">
                                <div class="form-group d-flex flex-column gap-2">
                                    <label for="old_password">Old Password</label>
                                    <input type="password" name="old_password" class="form-control" required>
                                </div>
                                <div class="form-group d-flex flex-column gap-2">
                                    <label for="new_password">New Password</label>
                                    <input type="password" name="new_password" class="form-control" required>
                                </div>
                                <div class="form-group d-flex flex-column gap-2 mb-4">
                                    <label for="confirm_password">Confirm Password</label>
                                    <input type="password" name="confirm_password" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Change Password</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<?php include("includes/footer.php"); ?>