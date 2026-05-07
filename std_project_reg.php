<?php
session_start();

include("includes/header.php");
include("includes/functions.php");


// Assign session variables only if they are set, else assign a default value
$std_id = isset($_SESSION["std_id"]) ? $_SESSION["std_id"] : null;
$user_role = isset($_SESSION["user_role"]) ? $_SESSION["user_role"] : null;
$teacher = isset($_SESSION["teacher"]) ? $_SESSION["teacher"] : null;
$user_email = isset($_SESSION["user_email"]) ? $_SESSION["user_email"] : null;

// Generate the navigation menu based on user role
if ($user_role == 'student') {
    generateNavMenu('student');
} elseif ($user_role == 'teacher') {
    generateNavMenu('teacher');
} else {
    generateNavMenu('admin');
}



$query = "SELECT * FROM std_registration WHERE std_id = '$std_id'";
$result = mysqli_query($con, $query);

if (!$result) {
    die("Error: " . mysqli_error($con));
}

?>


<?php

if (isset($_POST['std_project_reg_submit'])) {
    $status = $_POST['status'];
    $semester = $_POST['semester'];
    $std_id_multiple = $_POST['std_id_multiple'];
    $tcr_name = $_POST['tcr_name'];
    $program_type = $_POST['program_type'];
    $project_type = $_POST['project_type'];
    $proposal = $_POST['proposal'];
    $proj_topic = $_POST['proj_topic'];
    $proj_technology = $_POST['proj_technology'];
    $project_summary = $_POST['project_summary'];
    $area_of_interest = $_POST['area_of_interest'];
    $project_live_link = isset($_POST['project_live_link']) ? $_POST['project_live_link'] : null;
    $project_github_link = isset($_POST['project_github_link']) ? $_POST['project_github_link'] : null;

    $std_id_multiple_proj = implode(",", $std_id_multiple);

    if (
        empty($semester) || empty($std_id_multiple) || empty($tcr_name) || empty($program_type) || empty($project_type) || empty($proposal) ||
        empty($proj_topic) || empty($proj_technology) || empty($project_summary)
    ) {
        echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong>All fields are required!</strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
              </div>";
    } elseif ($area_of_interest !== 'available') {
        echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
            <strong>Teacher Unavailable for Thesis & Project.</strong>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
    } else {
        $insert = mysqli_query($con, "INSERT INTO std_project_reg (status, semester, std_id_multiple, tcr_user_email, program_type, project_type, proposal, proj_topic, proj_technology, project_summary, project_live_link, project_github_link, date) VALUES ('$status', '$semester', '$std_id_multiple_proj', '$tcr_name', '$program_type', '$project_type', '$proposal', '$proj_topic', '$proj_technology','$project_summary', '$project_live_link', '$project_github_link', NOW())");
        if ($insert == 1) {
            $message = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong> Project/Thesis are Registered!</strong>.
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
        } else {
            $erroremail = "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong>Something went wrong</strong>.
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>" . mysqli_error($con);
        }
    }
}


?>





<!-- Show students -->
<section class="main_page registration">
    <div class="content-area">
        <div class="container">
            <?php
            if (isset($erroremail)) {
                echo $erroremail;
            }
            if (isset($message)) {
                echo $message;
            }
            if (isset($lettergrade)) {
                echo $lettergrade;
            }
            ?>

            <div class="row justify-content-center">
                <div class="col-xl-11 mt-4 mb-5">
                    <h3>Project / Thesis Proposal Form</h3>
                </div>
                <div class="col-xl-11">
                    <div class="p-4 rounded-4 shadow-lg border mb-5">
                        <div class="col-12">
                            <form method="POST" class="mt-0">
                                <div class="row g-4">
                                    <div class="col-12 d-none">
                                        <label for="status">ID Approved : </label>
                                        <select name="status" class="form-control" id="status">
                                            <option value="pending">Pending</option>
                                            <option value="approved">Approved</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="heading mb-2" for="semester"> Semester <span class="text-danger">*</span></label>
                                            <select name="semester" class="form-control" id="semester" required>
                                                <option value="0">Select Semester</option>
                                                <option value="spring">Spring</option>
                                                <option value="summer">Summer</option>
                                                <option value="fall">Fall</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="heading mb-2" for="program_type">Day / Evening ? <span class="text-danger">*</span></label>
                                            <select name="program_type" class="form-control" id="program_type" required>
                                                <option value="0">Select Program Type</option>
                                                <option value="day">Day</option>
                                                <option value="evening">Evening</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="heading mb-2" for="project_type">Project/Thesis<span class="text-danger">*</span></label>
                                            <select name="project_type" class="form-control" id="project_type" required>
                                                <option value="0">Select Program Type</option>
                                                <option value="project">Project</option>
                                                <option value="thesis">Thesis</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="heading mb-2" for="std_id_multiple">Select Student Id<span class="text-danger">*</span></label>
                                            <select class="js-example-basic-multiple select_placeholder form-control" name="std_id_multiple[]" id="std_id_multiple" multiple="multiple" required>
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
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="heading mb-2" for="proposal">Project/Thesis Title <span class="fs-7">(proposal)</span> <span class="text-danger">*</span></label>
                                            <input type="text" id="proposal" name="proposal" class="form-control" placeholder="Your answer" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="heading mb-2" for="proj_topic">Project/Thesis Topic <span class="text-danger">*</span></label>
                                            <input type="text" id="proj_topic" name="proj_topic" class="form-control" placeholder="Your answer" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="heading mb-2" for="proj_technology">Required Technology <span class="text-danger">*</span></label>
                                            <input type="text" id="proj_technology" name="proj_technology" class="form-control" placeholder="Your answer" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="heading mb-2" for="project_summary">Project Summary </label>
                                            <input type="text" id="project_summary" name="project_summary" class="form-control" placeholder="Your answer" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="heading mb-2">Supervisor Name : </label>
                                            <select name="tcr_name" class="form-control" id="tcr_name" onchange="updateFields()" required>
                                                <option value="0">Select Teacher's Name</option>

                                                <?php
                                                $get_teacher = "SELECT * FROM tcr_registration";
                                                if ($run_teacher = mysqli_query($con, $get_teacher)) {
                                                    if (mysqli_num_rows($run_teacher) > 0) {
                                                        while ($row = mysqli_fetch_array($run_teacher)) {
                                                            // $id = $row['id'];
                                                            $tcr_name = $row['tcr_name'];
                                                            $teacher_email = $row['user_email'];
                                                            $department = $row['department'];
                                                            $phone = $row['phone'];
                                                            $interest_field = $row['interest_field'];
                                                            $area_of_interest = $row['area_of_interest'];

                                                            echo "<option value='$teacher_email' data-email='$teacher_email' data-department='$department' data-phone='$phone' data-interestfield='$interest_field' data-areainterest='$area_of_interest'>$tcr_name</option>";
                                                        }
                                                    }
                                                }

                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="heading mb-2" for="teacher_email">Teacher's Email : </label>
                                            <input type="text" name="teacher_email" class="form-control" id="teacher_email" readonly>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="heading mb-2" for="tcr_phone">Teacher's Phone : </label>
                                            <input type="text" name="tcr_phone" class="form-control" id="tcr_phone" readonly>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="heading mb-2" for="department">Teacher's Department : </label>
                                            <input type="text" name="department" class="form-control" id="department" readonly>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="heading mb-2" for="interest_field">Teacher's Field of Interest : </label>
                                            <input type="text" name="interest_field" class="form-control" id="interest_field" readonly>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="heading mb-2" for="area_of_interest">Teacher's Areas of Interest : </label>
                                            <input type="text" name="area_of_interest" class="form-control" id="area_of_interest" readonly>
                                        </div>
                                    </div>

                                    <script>
                                        function updateFields() {
                                            // Get the selected option
                                            var selectedOption = document.getElementById("tcr_name").selectedOptions[0];

                                            // Get the data attributes from the selected option
                                            var email = selectedOption.getAttribute("data-email");
                                            var department = selectedOption.getAttribute("data-department");
                                            var tcr_phone = selectedOption.getAttribute("data-phone");
                                            var interest_field = selectedOption.getAttribute("data-interestfield");
                                            var area_of_interest = selectedOption.getAttribute("data-areainterest");

                                            // Set the values of the input fields
                                            document.getElementById("teacher_email").value = email;
                                            document.getElementById("department").value = department;
                                            document.getElementById("tcr_phone").value = tcr_phone;
                                            document.getElementById("interest_field").value = interest_field;
                                            document.getElementById("area_of_interest").value = area_of_interest;
                                        }
                                    </script>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="heading mb-2" for="project_live_link">Project Live Link (optional)</label>
                                            <input type="url" id="project_live_link" name="project_live_link" class="form-control" placeholder="https://your-live-link.com">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="heading mb-2" for="project_github_link">Project GitHub Link (optional)</label>
                                            <input type="url" id="project_github_link" name="project_github_link" class="form-control" placeholder="https://github.com/your-repo">
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="form-group">
                                            <div class="d-flex  gap-3">
                                                <button type="reset" class="btn btn-danger">Reset</button>
                                                <button type="submit" name="std_project_reg_submit" class="btn btn-success">Submit</button>
                                            </div>
                                        </div>
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
    </div>
    </div>

    <?php include("includes/footer.php"); ?>