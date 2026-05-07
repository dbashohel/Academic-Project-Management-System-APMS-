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
    $id = $_GET['edit'];
    $select_data = "SELECT * FROM std_project_reg WHERE id = '$id'";
    $result = mysqli_query($con, $select_data);

    if ($result) {
        $row = mysqli_fetch_array($result);
        if (!$row) {
            die("Error: Could not fetch data for student : $id");
        }
    } else {
        die("Error: Could not execute query: " . mysqli_error($con));
    }
}

if (isset($_POST['update_submit'])) {
    $status = mysqli_real_escape_string($con, $_POST['status']);
    $project_live_link = isset($_POST['project_live_link']) ? mysqli_real_escape_string($con, $_POST['project_live_link']) : null;
    $project_github_link = isset($_POST['project_github_link']) ? mysqli_real_escape_string($con, $_POST['project_github_link']) : null;
    if ($status == 'complete' && $row['is_submitted'] == '0') {
        $erroremail = "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
            <strong>Please Submit Result Fist </strong>.
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
    } elseif ($row['status'] == 'complete' && $status == 'reject') {
        $erroremail = "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
        <strong>You can not Perform this action </strong>.
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
    } else {
        $update_data = "UPDATE std_project_reg SET status = '$status', project_live_link = '$project_live_link', project_github_link = '$project_github_link' WHERE id = '$id'";
        if (mysqli_query($con, $update_data)) {
            $erroremail = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                            <strong>Project Approved Successfully</strong>. 
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>";
            echo "<meta http-equiv='refresh' content='2;url=tcr_std_project_card.php?status=" . urlencode($status) . "'>";
        } else {
            $erroremail = "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                            <strong>Something went wrong</strong>.
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>" . mysqli_error($con);
        }
    }
}

// if (isset($erroremail)) {
//     echo $erroremail;
// }
?>


<div class="main_page">
    <div class="content-area">
        <div class="container-fluid">
            <div class="my_profile pt-5">
                <div class="container">
                    <div class="row">
                        <h2 class="view_profile">Edit</h2>
                        <div class="d-flex align-items-center justify-content-between my-3">
                            <h5>Submit ID : <?php echo htmlspecialchars($id); ?></h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <form method="post" action="" class="d-flex flex-column gap-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="mb-2" for="status">ID Approval Status <span class="text-danger">*</span></label>
                                            <select name="status" class="form-control mb-3" id="status" required>
                                                <option <?= $row['status'] == 'approved' ? 'selected' : '' ?> value="approved">Approved</option>
                                                <option <?= $row['status'] == 'pending' ? 'selected' : '' ?> value="pending">Pending</option>
                                                <option <?= $row['status'] == 'reject' ? 'selected' : '' ?> value="reject">Reject</option>
                                                <option <?= $row['status'] == 'complete' ? 'selected' : '' ?> value="complete">Complete</option>
                                            </select>
                                        </div>
                                        <div class="form-group mt-3">
                                            <label class="mb-2" for="project_live_link">Project Live Link (optional)</label>
                                            <input type="url" name="project_live_link" class="form-control mb-2" id="project_live_link" value="<?= isset($row['project_live_link']) ? htmlspecialchars($row['project_live_link']) : '' ?>" placeholder="https://your-live-link.com">
                                        </div>
                                        <div class="form-group mt-2">
                                            <label class="mb-2" for="project_github_link">Project GitHub Link (optional)</label>
                                            <input type="url" name="project_github_link" class="form-control mb-2" id="project_github_link" value="<?= isset($row['project_github_link']) ? htmlspecialchars($row['project_github_link']) : '' ?>" placeholder="https://github.com/your-repo">
                                        </div>
                                        <button type="submit" name="update_submit" class="btn btn-success mt-4 fit-content">Update Profile</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row">

                        <?php

                        if (isset($_POST['update_std_submit'])) {
                            // $status = mysqli_real_escape_string($con, $_POST['status']);
                            $std_id_multiple = $_POST['std_id_multiple'];

                            $std_id_multiple_proj = implode(",", $std_id_multiple);

                            $std_update_data = "UPDATE std_project_reg SET std_id_multiple = '$std_id_multiple_proj' WHERE id = '$id'";

                            if (mysqli_query($con, $std_update_data)) {
                                $erroremail = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                                    <strong>Add Student Successfully</strong>. 
                                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                </div>";
                                echo "<meta http-equiv='refresh' content='2;url=tcr_std_project_card.php?status=approved'>";
                            } else {
                                $erroremail = "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                                    <strong>Something went wrong</strong>.
                                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                </div>";
                            }
                        }

                        if (isset($erroremail)) {
                            echo $erroremail;
                        } 
                        ?>
                        <div class="col-12">
                            <form method="post" action="" class="d-flex flex-column gap-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="heading mb-2" for="std_id_multiple">Add Student Id</label>
                                            <select class="js-example-basic-multiple select_placeholder form-control" name="std_id_multiple[]" id="std_id_multiple" multiple="multiple">
                                                <?php
                                                $get_std = "SELECT * FROM std_registration WHERE id_approved = 'approved'";
                                                if ($run_std = mysqli_query($con, $get_std)) {
                                                    if (mysqli_num_rows($run_std) > 0) {
                                                        while ($row = mysqli_fetch_array($run_std)) {
                                                            $std_id  = $row['std_id'];
                                                            echo "<option value='$std_id'>$std_id</option>";
                                                        }
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <button type="submit" name="update_std_submit" class="btn btn-success mt-4 fit-content">Add Student</button>
                                    </div>
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