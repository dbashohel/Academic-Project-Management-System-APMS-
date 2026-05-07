<?php
session_start();

include("includes/header.php");
include("includes/functions.php");

if (!isset($_SESSION["user_email"]) || !isset($_SESSION["user_role"])) {
    header("Location: login.php");
    exit;
}

$teacher = $_SESSION["teacher"];
$user_email = $_SESSION["user_email"];
$user_role = $_SESSION["user_role"];
$tcr_name = $_SESSION["tcr_name"];

if ($user_role == 'teacher') {
    generateNavMenu('teacher');
} else {
    generateNavMenu('admin');
}

// Fetch teacher details from the database
$query = "SELECT * FROM tcr_registration WHERE user_email = '$user_email'";
$result = mysqli_query($con, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $teacher = mysqli_fetch_assoc($result);
    $id = $teacher['id']; // Get the ID for the current user
} else {
    echo "Failed to fetch teacher details.";
    exit;
}

// Handle form submission
if (isset($_POST['update_submit'])) {
    $area_of_interest = mysqli_real_escape_string($con, $_POST['area_of_interest']);
    $update_data = "UPDATE tcr_registration SET area_of_interest = '$area_of_interest' WHERE id = '$id'";

    if (mysqli_query($con, $update_data)) {
        $erroremail = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                            <strong>Submit Successfully</strong>. 
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>";
        echo "<meta http-equiv='refresh' content='1;url=tcr_project_for_available_edit.php'>";
    } else {
        $erroremail = "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                            <strong>Something went wrong</strong>.
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>" . mysqli_error($con);
    }
}

// Display messages
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
                        <h2 class="view_profile">Project & Thesis For Available?</h2>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <form method="post" action="" class="d-flex flex-column gap-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="mb-2" for="area_of_interest">Project & Thesis For Available? <span class="text-danger">*</span></label>
                                            <select name="area_of_interest" class="form-control mb-3" id="area_of_interest" required>
                                                <option <?= $teacher['area_of_interest'] == 'available' ? 'selected' : '' ?> value="available">available</option>
                                                <option <?= $teacher['area_of_interest'] == 'unavailable' ? 'selected' : '' ?> value="unavailable">unavailable</option>
                                            </select>
                                        </div>
                                        <button type="submit" name="update_submit" class="btn btn-success mt-4 fit-content">Submit</button>
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