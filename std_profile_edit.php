<?php
session_start();

include("includes/header.php");
include("includes/functions.php");

if (!isset($_SESSION["std_id"]) || !isset($_SESSION["user_role"])) {
    header("Location: login.php");
    exit;
}

$std_id = $_SESSION["std_id"];
$user_role = $_SESSION["user_role"];

if ($user_role == 'student') {
    generateNavMenu('student');
}

if (isset($_GET['edit'])) {
    $std_id = $_GET['edit'];
    $select_data = "SELECT * FROM std_registration WHERE std_id = '$std_id'";
    $result = mysqli_query($con, $select_data);

    if ($result) {
        $row = mysqli_fetch_array($result);
        if (!$row) {
            die("Error: Could not fetch data for student ID: $std_id");
        }
    } else {
        die("Error: Could not execute query: " . mysqli_error($con));
    }
}

if (isset($_POST['update_submit'])) {
    $std_name = mysqli_real_escape_string($con, $_POST['std_name']);
    $std_father = mysqli_real_escape_string($con, $_POST['std_father']);
    $std_mother = mysqli_real_escape_string($con, $_POST['std_mother']);
    $add_user_email = mysqli_real_escape_string($con, $_POST['add_user_email']);
    $add_user_phone = mysqli_real_escape_string($con, $_POST['add_user_phone']);
    $add_user_fphone = mysqli_real_escape_string($con, $_POST['add_user_fphone']);
    $present_address = mysqli_real_escape_string($con, $_POST['present_address']);

    $update_data = "UPDATE std_registration SET 
        std_name = '$std_name',
        std_father = '$std_father',
        std_mother = '$std_mother',
        add_user_email = '$add_user_email',
        add_user_phone = '$add_user_phone',
        add_user_fphone = '$add_user_fphone',
        present_address = '$present_address'
    WHERE std_id = '$std_id'";

    if (mysqli_query($con, $update_data)) {
        $erroremail = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                        <strong>Profile Update Successfully</strong>. 
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
        echo "<meta http-equiv='refresh' content='2;url=std_profile.php'>";
    } else {
        $erroremail = "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                        <strong>Something went wrong</strong>.
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>" . mysqli_error($con);
    }
}
?>

<?php
if (isset($erroremail)) {
    echo $erroremail;
}
?>

<div class="main_page">
    <div class="content-area">
        <div class="container-fluid">
            <div class="my_profile pt-5">
                <div class="container">
                    <div class="row">
                        <h2 class="view_profile">Edit Profile</h2>
                        <div class="d-flex align-items-center justify-content-between my-3">
                            <h5>Student ID : <?php echo htmlspecialchars($std_id); ?></h5>
                            <a href="std_profile.php" class="btn btn-primary">Back to Profile</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <form method="post" action="" class="d-flex flex-column gap-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="mb-1" for="std_name">Full Name <span class="text-danger">*</span></label>
                                        <input type="text" name="std_name" id="std_name" class="form-control mb-3" value="<?php echo htmlspecialchars($row['std_name']); ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="mb-1" for="add_user_email">Add Another Email Address</label>
                                        <input type="email" id="add_user_email" name="add_user_email" class="form-control mb-3" value="<?php echo htmlspecialchars($row['add_user_email']); ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="mb-1" for="add_user_phone">Add Another Phone Number</label>
                                        <input type="tel" name="add_user_phone" id="add_user_phone" class="form-control mb-3" value="<?php echo htmlspecialchars($row['add_user_phone']); ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="mb-1" for="add_user_fphone">Add Another Father's Number</label>
                                        <input type="tel" name="add_user_fphone" id="add_user_fphone" class="form-control mb-3" value="<?php echo htmlspecialchars($row['add_user_fphone']); ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="mb-1" for="std_father">Father's Name <span class="text-danger">*</span> </label>
                                        <input type="text" name="std_father" id="std_father" class="form-control mb-3" value="<?php echo htmlspecialchars($row['std_father']); ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="mb-1" for="std_mother">Mother's Name <span class="text-danger">*</span> </label>
                                        <input type="text" name="std_mother" id="std_mother" class="form-control mb-3" value="<?php echo htmlspecialchars($row['std_mother']); ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="mb-1" for="present_address">Present Address <span class="text-danger">*</span> </label>
                                        <input type="text" name="present_address" id="present_address" class="form-control mb-3" value="<?php echo htmlspecialchars($row['present_address']); ?>" required>
                                    </div>
                                    <button type="submit" name="update_submit" class="btn btn-success mt-4">Update Profile</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>