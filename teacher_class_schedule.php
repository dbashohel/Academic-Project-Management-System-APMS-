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




$query = "SELECT * FROM teacher_credit_reg WHERE user_email = '$user_email'";
$result = mysqli_query($con, $query);

if (!$result) {
    die("Error: " . mysqli_error($con));
}

?>



<?php

if (isset($_POST['credit_reg_submit'])) {
    $tcr_name = $_POST['tcr_name'];
    $teacher_username = $_POST['teacher_username'];
    $program_type = $_POST['program_type'];
    $program = $_POST['program'];
    $session = $_POST['session'];
    $running_year = $_POST['running_year'];
    $semesterName = $_POST['semesterName'];
    $section = $_POST['section'];

    if ($user_role == 'admin') {
        $status = $_POST['status'];
    } else {
        $status = 'pending';
    }

    $checkbox1 = $_POST['course_code'];
    $chk = implode(",", $checkbox1);


    if ($semesterName == NULL) {
        echo "field empty";
    } else {

        $insert = mysqli_query($con, "INSERT INTO teacher_credit_reg (tcr_name, teacher_username, program_type, program, session, running_year, semesterName, section, status, course_code) VALUES ('$tcr_name', '$teacher_username', '$program_type', '$program', '$session', '$running_year', '$semesterName', '$section', '$status','$chk')");
    }


    $message = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
            <strong> Semester are registered!</strong>.
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>
        <meta http-equiv='refresh' content='2;url=teacher_credit_reg.php'>";
}



?>


<!-- Show students -->
<section class="main_page registration">
    <div class="content-area">
        <div class="container">
            <div class="row justify-content-center">
                <h3 class="text-center mb-4">Teacher Class Schedule</h3>
                <div class="d-flex align-items-center justify-content-between my-3 ">
                    <span></span>
                    <a href="teacher_profile.php" class="btn btn-primary">Back to Users</a>
                </div>
            </div>
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
                <div class="col-12">
                    <div class="p-4 rounded-4 shadow-lg border mb-5">


                        <!-- Semester Add -->
                        <div class="col-12">
                            <form method="POST" class="mt-0">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="mb-2">Teacher's username : </label>
                                            <select name="teacher_username" class="form-control" id="teacher_username" required onchange="updateRunningName()">
                                                <option value="0">Select Teacher's Name</option>
                                                <?php
                                                $get_teacher = "SELECT * FROM tcr_registration";
                                                if ($run_teacher = mysqli_query($con, $get_teacher)) {
                                                    if (mysqli_num_rows($run_teacher) > 0) {
                                                        while ($row = mysqli_fetch_array($run_teacher)) {
                                                            $teacher_username = $row['user_email'];
                                                            $tcr_name = $row['tcr_name'];
                                                            echo "<option value='$teacher_username' data-name='$tcr_name'>$teacher_username</option>";
                                                        }
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="mb-2" for="teachers_name">Teacher Name : </label>
                                            <input type="text" name="teachers_name" class="form-control" id="teachers_name" readonly>
                                        </div>
                                    </div>

                                    <script>
                                        function updateRunningName() {
                                            var teacherSelect = document.getElementById('teacher_username');
                                            var selectedOption = teacherSelect.options[teacherSelect.selectedIndex];
                                            var teacherName = selectedOption.getAttribute('data-name');

                                            document.getElementById('teachers_name').value = teacherName;
                                        }
                                    </script>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="mb-2" for="program_type">Program Type : </label>
                                            <select name="program_type" class="form-control" id="program_type" required>
                                                <option value="0">Select Program Type</option>
                                                <option value="bachelor">Bachelor</option>
                                                <option value="Masters">Masters</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="mb-2" for="program">Program : </label>
                                            <select name="program" class="form-control" id="program" required>
                                                <option value="0">Select Program</option>
                                                <option value="BANG">BANG</option>
                                                <option value="BPharm">BPharm</option>
                                                <option value="BBA">BBA</option>
                                                <option value="BTX">BTX</option>
                                                <option value="EBTX">EBTX</option>
                                                <option value="CE">CE</option>
                                                <option value="ECE">ECE</option>
                                                <option value="EECE">EECE</option>
                                                <option value="CSE">CSE</option>
                                                <option value="ECSE">ECSE</option>
                                                <option value="EEE">EEE</option>
                                                <option value="EEEE">EEEE</option>
                                                <option value="ELL">ELL</option>
                                                <option value="LLB">LLB</option>
                                                <option value="ME">ME</option>
                                                <option value="others">Others</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="mb-2" for="session">Admission Semester : </label>
                                            <select name="session" class="form-control" id="session" required>
                                                <option value="0">Select Semester</option>
                                                <option value="spring">Spring</option>
                                                <option value="summer">Summer</option>
                                                <option value="fall">Fall</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="mb-2">Running Year : </label>
                                            <input type="text" name="running_year" class="form-control" value="<?php echo date('Y'); ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="mb-2" for="semesterName">Semester :</label>
                                            <select name="semesterName" class="form-control">
                                                <option value="1st">1st</option>
                                                <option value="2nd">2nd</option>
                                                <option value="3rd">3rd</option>
                                                <option value="4th">4th</option>
                                                <option value="5th">5th</option>
                                                <option value="6th">6th</option>
                                                <option value="7th">7th</option>
                                                <option value="8th">8th</option>
                                                <option value="9th">9th</option>
                                                <option value="10th">10th</option>
                                                <option value="11th">11h</option>
                                                <option value="12th">12h</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="mb-2" for="section">Section :</label>
                                            <select name="section" class="form-control mb-3">
                                                <option value="A">A</option>
                                                <option value="B">B</option>
                                                <option value="C">C</option>
                                                <option value="D">D</option>
                                                <option value="E">E</option>
                                                <option value="F">F</option>
                                            </select>
                                        </div>
                                    </div>
                                    <?php
                                    if ($user_role == 'admin') { ?>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="mb-2">Status :</label>
                                                <select name="status" class="form-control mb-3">
                                                    <option value="approve">Approve</option>
                                                    <option value="pending">Pending</option>
                                                </select>
                                            </div>
                                        </div>
                                    <?php   }  ?>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="mb-2" for="section">Subject Code :</label>
                                            <select class="js-example-basic-multiple" name="course_code[]" multiple="multiple" required>
                                                <?php
                                                $get_sub_code = "SELECT * FROM allsubject";
                                                if ($run_sub_code = mysqli_query($con, $get_sub_code)) {
                                                    if (mysqli_num_rows($run_sub_code) > 0) {

                                                        while ($row = mysqli_fetch_array($run_sub_code)) {

                                                            $courseCode = $row['courseCode'];
                                                            $courseTitle = $row['courseTitle'];
                                                            echo "<option value='$courseCode'>$courseCode ==> $courseTitle</option>";
                                                        }
                                                    }
                                                } ?>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <div class="d-flex  gap-3">
                                                <button type="reset" class="btn btn-danger">Reset</button>
                                                <button type="submit" name="credit_reg_submit" class="btn btn-success">Submit</button>
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