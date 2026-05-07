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
$tcr_name = $_SESSION["tcr_name"];

if ($user_role == 'teacher') {
    generateNavMenu('teacher');
} else {
    generateNavMenu('admin');
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
    $id_approved = mysqli_real_escape_string($con, $_POST['id_approved']);
    $status = mysqli_real_escape_string($con, $_POST['status']);

    $update_data = "UPDATE std_registration SET 
        id_approved = '$id_approved',
        status = '$status'
    WHERE std_id = '$std_id'";

    if (mysqli_query($con, $update_data)) {
        $erroremail = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                        <strong>Registration Updated Successfully</strong>. 
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
        echo "<meta http-equiv='refresh' content='2;url=tcr_std_reg_pending.php'>";
    } else {
        $erroremail = "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                        <strong>Something went wrong</strong>.
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>" . mysqli_error($con);
    }
}

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
                        <h2 class="view_profile">Edit</h2>
                        <div class="d-flex align-items-center justify-content-between my-3">
                            <h5>Student ID : <?php echo htmlspecialchars($std_id); ?></h5>
                            <a href="tcr_std_reg_pending.php" class="btn btn-primary">Back to Profile</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <form method="post" action="" class="d-flex flex-column gap-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="mb-1" for="id_approved">ID Approval Status <span class="text-danger">*</span></label>
                                        <select name="id_approved" class="form-control mb-3" id="id_approved" required>
                                            <option value="<?php echo htmlspecialchars($row['id_approved']); ?>"><?php echo htmlspecialchars($row['id_approved']); ?></option>
                                            <option value="approved">Approved</option>
                                            <option value="pending">Pending</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="mb-1" for="status">Status <span class="text-danger">*</span></label>
                                        <select name="status" class="form-control mb-3" id="status" required>
                                            <option value="<?php echo htmlspecialchars($row['status']); ?>"><?php echo htmlspecialchars($row['status']); ?></option>
                                            <option value="running">Running</option>
                                            <option value="pending">Pending</option>
                                        </select>
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
