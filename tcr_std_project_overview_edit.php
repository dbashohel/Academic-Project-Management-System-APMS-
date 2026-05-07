<?php
session_start();

include("includes/header.php");
include("includes/functions.php");

if (!isset($_SESSION["std_id"]) || !isset($_SESSION["user_role"])) {
    header("Location: login.php");
    exit;
}

$student = $_SESSION["student"];
$std_id = $_SESSION["std_id"];
$user_role = $_SESSION["user_role"];
$student_id = $student['id'];

if ($user_role == 'student') {
    generateNavMenu('student');
}



if (isset($_GET['overview'])) {
    $id = $_GET['overview'];
    $select_data = "SELECT * FROM porject_overview WHERE id = '$id'";
    $result = mysqli_query($con, $select_data);

    if ($result) {
        $row = mysqli_fetch_array($result);
        if (!$row) {
            die("Error: Could not fetch data ");
        }
    } else {
        die("Error: Could not execute query: " . mysqli_error($con));
    }
}

if (isset($_POST['update_submit'])) {
    $overview_content = mysqli_real_escape_string($con, $_POST['overview_content']);

    $update_data = "UPDATE porject_overview SET overview_content = '$overview_content' WHERE id  = '$id'";

    if (mysqli_query($con, $update_data)) {

        $erroremail = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                        <strong>Update Successfully</strong>. 
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
        echo "<meta http-equiv='refresh' content='2;url=std_project_info.php'>";
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
                            <h5>Submit ID : <?php echo htmlspecialchars($id); ?></h5>
                            <a href="tcr_std_project_pending.php" class="btn btn-primary">Back to Profile</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <form method="post" class="d-flex flex-column gap-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="overview_content">Text / URL Link</label>
                                            <input type="text" class="form-control" id="overview_content" name="overview_content"
                                                value="<?php echo isset($row) ? htmlspecialchars($row['overview_content']) : $row['overview_content'] ?>" required>
                                        </div>
                                        <button type="submit" name="update_submit" class="btn btn-success mt-4 fit-content">Update Profile</button>
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