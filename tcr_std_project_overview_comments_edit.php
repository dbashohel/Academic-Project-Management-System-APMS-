<?php
session_start();

include("includes/header.php");
include("includes/functions.php");


$student = isset($_SESSION["student"]) ? $_SESSION["student"] : null;
$user_role = isset($_SESSION["user_role"]) ? $_SESSION["user_role"] : null;
$teacher = isset($_SESSION["teacher"]) ? $_SESSION["teacher"] : null;
$user_email = isset($_SESSION["user_email"]) ? $_SESSION["user_email"] : null;
$user_role = $user_role;

$userid = ($user_role == 'student') ? $student['id'] : $teacher['id'];
$userrole = ($user_role == 'student') ? $student['user_role'] : $teacher['user_role'];

if ($user_role == 'student') {
    generateNavMenu('student');
} elseif ($user_role == 'teacher') {
    generateNavMenu('teacher');
} else {
    generateNavMenu('admin');
}




if (isset($_GET['comment'])) {
    $comments_id = $_GET['comment'];
    $comment_data = "SELECT * FROM comments_overview WHERE id = '$comments_id'";
    $comment_result = mysqli_query($con, $comment_data);

    if ($comment_result) {
        $comment_row = mysqli_fetch_array($comment_result);
        if (!$comment_row) {
            die("Error: Could not fetch data ");
        }
    } else {
        die("Error: Could not execute query: " . mysqli_error($con));
    }
}

if (isset($_POST['update_submit'])) {
    $comments = mysqli_real_escape_string($con, $_POST['comments']);

    $update_data = "UPDATE comments_overview SET comments = '$comments' WHERE id = '$comments_id'";

    if (mysqli_query($con, $update_data)) {

        $erroremail = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                        <strong>Update Successfully</strong>. 
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
        echo "<meta http-equiv='refresh' content='2; url=tcr_std_project_overview_details.php?overview=" . $comment_row['overview_id'] . "'>";

    } else {
        $erroremail = "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                        <strong>Something went wrong</strong>.
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>" . mysqli_error($con);
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
                            <h2 class="view_profile">Edit</h2>
                            
                            <a href="tcr_std_project_pending.php" class="btn btn-primary">Back to Profile</a>
                        </div>
                    </div>
                    <?php if (isset($erroremail)) {
                        echo $erroremail;
                    } ?>
                    <div class="row">
                        <div class="col-12">
                            <form method="post" class="d-flex flex-column gap-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            
                                            <label class="form-label" for="comments">Text / URL Link</label>
                                            <textarea class="form-control fs-7" id="comments" name="comments" rows="6" required><?php echo isset($comment_row['comments']) ? htmlspecialchars($comment_row['comments']) : ''; ?></textarea>
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