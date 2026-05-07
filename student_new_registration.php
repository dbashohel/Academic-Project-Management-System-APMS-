<?php
session_start();
require_once('includes/functions.php');

// Check if form is submitted
if (isset($_POST['registration_submit'])) {
    $std_id = $_POST['std_id'];
    $std_pass = $_POST['std_pass'];
    $id_approved = $_POST['id_approved'];
    $std_name = $_POST['std_name'];
    $std_father = $_POST['std_father'];
    $std_mother = $_POST['std_mother'];
    $std_birth = $_POST['std_birth'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone'];
    $fphone = $_POST['fphone'];
    $user_email = $_POST['user_email'];
    $user_nid = $_POST['user_nid'];
    $user_birth_certi = $_POST['user_birth_certi'];
    $user_passport = $_POST['user_passport'];
    $program_type = $_POST['program_type'];
    $program = $_POST['program'];
    $admission_semester = $_POST['admission_semester'];
    $credit = $_POST['credit'];
    $status = $_POST['status'];
    $credit_transfer = $_POST['credit_transfer'];
    $present_country = $_POST['present_country'];
    $permanent_country = $_POST['permanent_country'];
    $present_address = $_POST['present_address'];
    $permanent_address = $_POST['permanent_address'];
    $permanent_division = $_POST['permanent_division'];
    $permanent_district = $_POST['permanent_district'];
    $permanent_thana = $_POST['permanent_thana'];
    $religion = $_POST['religion'];
    $education_level_ss = $_POST['education_level_ss'];
    $education_level_ssc = $_POST['education_level_ssc'];
    $passing_year = $_POST['passing_year'];
    $ssc_grading = $_POST['ssc_grading'];
    $ssc_grade_point = $_POST['ssc_grade_point'];
    $education_level_hs = $_POST['education_level_hs'];
    $education_level_hsc = $_POST['education_level_hsc'];
    $hsc_passing_year = $_POST['hsc_passing_year'];
    $hsc_grading = $_POST['hsc_grading'];
    $hsc_grade_point = $_POST['hsc_grade_point'];
    $education_level_ba = $_POST['education_level_ba'];
    $education_level_bac = $_POST['education_level_bac'];
    $ba_passing_year = $_POST['ba_passing_year'];
    $ba_grading = $_POST['ba_grading'];
    $ba_grade_point = $_POST['ba_grade_point'];
    $user_role = $_POST['user_role'];
    // $date = date("d-m-Y");

    $std_img = $_FILES["std_img"]["name"];
    $tempname = $_FILES["std_img"]["tmp_name"];
    $extension = pathinfo($std_img, PATHINFO_EXTENSION);
    $filename = uniqid() . "." . $extension;
    $folder = "./uploads/students/" . $filename;

    //uploading images to its folder

    if (!std_id_exists($con, $std_id)) {
        if (!std_email_exists($con, $user_email)) {
            if ($std_id && $std_pass && $user_email) {
                if ($user_nid || $user_birth_certi || $user_passport) {
                    move_uploaded_file($tempname, $folder);
                    $insert = mysqli_query($con, "INSERT INTO std_registration (std_name, std_id, std_pass, id_approved, user_role, std_img, std_father, std_mother, std_birth, gender, phone,fphone, user_email, user_nid, user_birth_certi, user_passport,program_type,program,admission_semester,credit,status, credit_transfer,present_country,permanent_country,present_address,permanent_address,permanent_division,permanent_district,permanent_thana,religion,education_level_ss,education_level_ssc,passing_year,ssc_grading,ssc_grade_point,education_level_hs,education_level_hsc,hsc_passing_year,hsc_grading,hsc_grade_point,education_level_ba,education_level_bac,ba_passing_year,ba_grading,ba_grade_point, submition_date)
                VALUES ('$std_name', '$std_id', '$std_pass', '$id_approved','$user_role','$filename', '$std_father', '$std_mother', '$std_birth', '$gender', '$phone','$fphone', '$user_email', '$user_nid', '$user_birth_certi', '$user_passport', '$program_type', '$program', '$admission_semester', '$credit', '$status', '$credit_transfer', '$present_country', '$permanent_country', '$present_address', '$permanent_address', '$permanent_division', '$permanent_district', '$permanent_thana', '$religion','$education_level_ss','$education_level_ssc','$passing_year','$ssc_grading','$ssc_grade_point','$education_level_hs','$education_level_hsc','$hsc_passing_year','$hsc_grading','$hsc_grade_point','$education_level_ba','$education_level_bac','$ba_passing_year','$ba_grading','$ba_grade_point', NOW())");

                    $erroremail = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong> New Student Registered!</strong>. 
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
                } else {
                    $erroremail = "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                    <strong>Student NID, Passport or Birth Certificate cannot be empty!</strong>.
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
                }
            } else {
                $erroremail = "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                    <strong>Student ID or Password and Email cannot be empty!</strong>.
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
            }
        } else {
            $erroremail = "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong>Email Address Already exists! try any other Email Address</strong>.
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
        }
    } else {
        $erroremail = "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
            <strong>ID Already exists! try any other ID</strong>.
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
    <title>Login</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- fontawesome CSS -->
    <link href="css/fontawesome.min.css" rel="stylesheet">
    <!-- style css-->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>

    <div class="main_page start_page">
        <div class="content-area m-0">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-lg-11 col-xl-9">
                        <div class="start_page_box p-4 rounded-4 shadow-lg border my-5">

                            <div class="nub_logo text-end mb-3">
                                <a href="index.php">
                                    <img src="img/nub_logo.png" class="" alt="NUB">
                                </a>
                            </div>
                            <?php
                            if (isset($erroremail)) {
                                echo $erroremail;
                            }
                            ?>
                            <h1 class="mb-4">Hello USA,</h1>
                            <h3 class="mb-4">Please Register to Your Account!</h3>
                            <form method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="mb-1" for="std_id">Student ID<span class="text-danger">*</span> </label>
                                        <input type="text" id="std_id" name="std_id" class="form-control mb-3" placeholder="Student ID">
                                    </div>
                                    <div class="col-md-6 d-none">
                                        <label class="mb-1" for="std_pass">Password </label>
                                        <input type="password" name="std_pass" id="std_pass" class="form-control mb-3  " value="123456">
                                    </div>

                                    <div class="col-md-6 d-none">
                                        <label class="mb-1" for="user_role">User Role </label>
                                        <select name="user_role" class="form-control mb-3" id="user_role" required>
                                            <option value="student">Student</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 d-none">
                                        <label class="mb-1" for="id_approved">ID Approved : </label>
                                        <select name="id_approved" class="form-control mb-3" id="id_approved" required>
                                            <option value="pending">Pending</option>
                                            <option value="approved">Approved</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="mb-1" for="std_name">Full Name <span class="text-danger">*</span></label>
                                        <input type="text" name="std_name" id="std_name" class="form-control mb-3" placeholder="Full Name" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="mb-1" for="std_img">Image <span class="text-danger">*</span></label>
                                        <input type="file" class="form-control mb-3" name="std_img" id="std_img" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="mb-1" for="user_email">Email Address <span class="text-danger">*</span></label>
                                        <input type="email" id="user_email" name="user_email" class="form-control mb-3" placeholder="Email" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="mb-1" for="std_birth">Date Of Birth <span class="text-danger">*</span> </label>
                                        <input type="date" name="std_birth" id="std_birth" class="form-control mb-3" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="mb-1" for="gender">Gender <span class="text-danger">*</span> </label>
                                        <select name="gender" class="form-control mb-3" id="gender" required>
                                            <option value="0">Select Gender</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                            <option value="others">Others</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="mb-1" for="std_father">Father's Name <span class="text-danger">*</span> </label>
                                        <input type="text" name="std_father" id="std_father" class="form-control mb-3" placeholder="Father's Name" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="mb-1" for="std_mother">Mother's Name <span class="text-danger">*</span> </label>
                                        <input type="text" name="std_mother" id="std_mother" class="form-control mb-3" placeholder="Mother's Name" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="mb-1" for="phone">Contact Number <span class="text-danger">*</span></label>
                                        <input type="tel" name="phone" id="phone" class="form-control mb-3" placeholder="Contact Number" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="mb-1" for="fphone">Father's Number <span class="text-danger">*</span></label>
                                        <input type="tel" name="fphone" id="fphone" class="form-control mb-3" placeholder="Father's Contact Number" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="mb-1" for="user_nid">NID</label>
                                        <input type="number" name="user_nid" id="user_nid" class="form-control mb-3" placeholder="Student's NID">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="mb-1" for="user_birth_certi">Birth Certificate Number :</label>
                                        <input type="number" name="user_birth_certi" id="user_birth_certi" class="form-control mb-3" placeholder="Birth Certificate Number">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="mb-1" for="user_passport">Passport No :</label>
                                        <input type="number" name="user_passport" id="user_passport" class="form-control mb-3" placeholder="Passport No">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="mb-1" for="religion">Religion <span class="text-danger">*</span> </label>
                                        <select name="religion" class="form-control mb-3" id="religion" required>
                                            <option value="Islam">Islam</option>
                                            <option value="Hinduism">Hinduism</option>
                                            <option value="Christianity">Christianity</option>
                                            <option value="Buddhism">Buddhism</option>
                                            <option value="Other">Other</option>
                                            <option value="None">None</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="mb-1" for="program_type">Program Type <span class="text-danger">*</span></label>
                                        <select name="program_type" class="form-control mb-3" id="program_type" required>
                                            <option value="0">Select Program Type</option>
                                            <option value="bachelor">Bachelor</option>
                                            <option value="Masters">Masters</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="mb-1" for="program">Program <span class="text-danger">*</span> </label>
                                        <select name="program" class="form-control mb-3" id="program" required>
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
                                    <div class="col-md-6">
                                        <label class="mb-1" for="admission_semester">Admission Semester <span class="text-danger">*</span> </label>
                                        <select name="admission_semester" class="form-control mb-3" id="admission_semester" required>
                                            <option value="0">Select Admission Semester</option>
                                            <option value="spring">Spring</option>
                                            <option value="summer">Summer</option>
                                            <option value="fall">Fall</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="mb-1" for="credit">Required Credit <span class="text-danger">*</span> </label>
                                        <select name="credit" class="form-control mb-3" id="credit" required>
                                            <option value="0">Select Credit</option>
                                            <option value="129">129</option>
                                            <option value="152">152</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 d-none">
                                        <label class="mb-1" for="status">Academic Status : </label>
                                        <select name="status" class="form-control mb-3" id="status" required>
                                            <option value="running">Running</option>
                                            <option value="pending">Pending</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="mb-1" for="credit_transfer">Is Credit Transferred : </label>
                                        <select name="credit_transfer" class="form-control mb-3" id="credit_transfer" required>
                                            <option value="no">No</option>
                                            <option value="yes">Yes</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="mb-1" for="present_country">Present Country <span class="text-danger">*</span></label>
                                        <input type="text" name="present_country" id="present_country" class="form-control mb-3" placeholder="Present Country" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="mb-1" for="permanent_country">Permanent Country <span class="text-danger">*</span></label>
                                        <input type="text" name="permanent_country" id="permanent_country" class="form-control mb-3" placeholder="Permanent Country" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="mb-1" for="present_address">Present Address <span class="text-danger">*</span></label>
                                        <input type="text" name="present_address" id="present_address" class="form-control mb-3" placeholder="Present Address" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="mb-1" for="permanent_address">Permanent Address <span class="text-danger">*</span></label>
                                        <input type="text" name="permanent_address" id="permanent_address" class="form-control mb-3" placeholder="Permanent Address" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="mb-1" for="permanent_division">Permanent Division <span class="text-danger">*</span></label>
                                        <input type="text" name="permanent_division" id="permanent_division" class="form-control mb-3" placeholder="Permanent Division" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="mb-1" for="permanent_district">Permanent District <span class="text-danger">*</span> </label>
                                        <input type="text" name="permanent_district" id="permanent_district" class="form-control mb-3" placeholder="Permanent District" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="mb-1" for="permanent_thana">Permanent Thana <span class="text-danger">*</span> </label>
                                        <input type="text" name="permanent_thana" id="permanent_thana" class="form-control mb-3" placeholder="Permanent Thana" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <h4>Academic Details <span class="text-danger">*</span></h4>
                                    </div>
                                    <div class="col-12">
                                        <div class="academic">
                                            <table>
                                                <tr>
                                                    <th class="pb-2">Education Level</th>
                                                    <th class="pb-2">Exam</th>
                                                    <th class="pb-2">Passing Year</th>
                                                    <th class="pb-2">Result System</th>
                                                    <th class="pb-2">Grade Point</th>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        <select name="education_level_ss" class="form-control mb-1" id="education_level_ss" required>
                                                            <option value="SSC">SSC</option>
                                                        </select>
                                                    </th>
                                                    <th>
                                                        <select name="education_level_ssc" class="form-control mb-1" id="education_level_ssc" required>
                                                            <option value="SSC">SSC</option>
                                                            <option value="Dakhil">Dakhil</option>
                                                            <option value="O-Level">O-Level</option>
                                                            <option value="Others">Others</option>
                                                        </select>
                                                    </th>
                                                    <th>
                                                        <input type="text" id="passing_year" name="passing_year" class="form-control mb-1" placeholder="Passing Year" required>
                                                    </th>

                                                    <th>
                                                        <select name="ssc_grading" class="form-control mb-1" id="ssc_grading" required>
                                                            <option value="grading">Grading</option>
                                                            <option value="class">Class</option>
                                                        </select>
                                                    </th>
                                                    <th>
                                                        <input type="text" name="ssc_grade_point" id="ssc_grade_point" class="form-control mb-1" placeholder="Grade Point" required>
                                                        <select name="ssc_grade_point" class="form-control mb-1 d-none" id="ssc_grade_point_select" required>
                                                            <option value="First Class">First Class</option>
                                                            <option value="Second Class">Second Class</option>
                                                            <option value="Third Class">Third Class</option>
                                                        </select>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        <select name="education_level_hs" class="form-control mb-1" id="education_level_hs" required>
                                                            <option value="HSC">HSC</option>
                                                        </select>
                                                    </th>
                                                    <th>
                                                        <select name="education_level_hsc" class="form-control mb-1" id="education_level_hsc" required>
                                                            <option value="HSC">HSC</option>
                                                            <option value="Alim">Alim</option>
                                                            <option value="A-Level">A-Level</option>
                                                            <option value="Diploma">Diploma</option>
                                                            <option value="Others">Others</option>
                                                        </select>
                                                    </th>
                                                    <th>
                                                        <input type="text" id="hsc_passing_year" name="hsc_passing_year" class="form-control mb-1" placeholder="Passing Year" required>
                                                    </th>

                                                    <th>
                                                        <select name="hsc_grading" class="form-control mb-1" id="hsc_grading" required>
                                                            <option value="grading">Grading</option>
                                                            <option value="class">Class</option>
                                                        </select>
                                                    </th>
                                                    <th>
                                                        <input type="text" name="hsc_grade_point" id="hsc_grade_point" class="form-control mb-1" placeholder="Grade Point" required>
                                                        <select name="hsc_grade_point" class="form-control mb-1 d-none" id="hsc_grade_point_select" required>
                                                            <option value="First Class">First Class</option>
                                                            <option value="Second Class">Second Class</option>
                                                            <option value="Third Class">Third Class</option>
                                                        </select>
                                                    </th>
                                                </tr>
                                                <tr class="d-none">
                                                    <th>
                                                        <select name="education_level_ba" class="form-control mb-1" id="education_level_ba">
                                                            <option value="Bachelor">Bachelor</option>
                                                        </select>
                                                    </th>
                                                    <th>
                                                        <select name="education_level_bac" class="form-control mb-1" id="education_level_bac">
                                                            <option value="0">Select</option>
                                                            <option value="Bachelor">Bachelor</option>
                                                            <option value="Others">Others</option>
                                                        </select>
                                                    </th>
                                                    <th>
                                                        <input type="text" id="ba_passing_year" name="ba_passing_year" class="form-control mb-1" placeholder="Passing Year">
                                                    </th>
                                                    <th>
                                                        <select name="ba_grading" class="form-control mb-1" id="ba_grading" required>
                                                            <option value="0">Select</option>
                                                            <option value="grading">Grading</option>
                                                            <option value="class">Class</option>
                                                        </select>
                                                    </th>
                                                    <th>
                                                        <input type="text" name="ba_grade_point" id="ba_grade_point_input" class="form-control mb-1" placeholder="Grade Point">
                                                        <select name="ba_grade_point" class="form-control mb-1 d-none" id="ba_grade_point_select" required>
                                                            <option value="First Class">First Class</option>
                                                            <option value="Second Class">Second Class</option>
                                                            <option value="Third Class">Third Class</option>
                                                        </select>
                                                    </th>


                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="d-flex  gap-3 mt-4">
                                            <button type="submit" name="registration_submit" class="btn btn-success px-4 py-2 rounded-3">Submit</button>
                                            <button type="reset" class="btn btn-outline-success px-4 py-2 rounded-3">Reset</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <p class="mt-4"> Already have an account? please <a href="login_std.php">Log in</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function toggleGradePoint(gradingId, inputId, selectId) {
            document.getElementById(gradingId).addEventListener('change', function() {
                var gradeInput = document.getElementById(inputId);
                var gradeSelect = document.getElementById(selectId);

                if (this.value === 'class') {
                    gradeInput.classList.add('d-none');
                    gradeSelect.classList.remove('d-none');
                } else {
                    gradeInput.classList.remove('d-none');
                    gradeSelect.classList.add('d-none');
                }
            });
        }

        toggleGradePoint('ssc_grading', 'ssc_grade_point', 'ssc_grade_point_select');
        toggleGradePoint('hsc_grading', 'hsc_grade_point', 'hsc_grade_point_select');
        toggleGradePoint('ba_grading', 'ba_grade_point_input', 'ba_grade_point_select');
    </script>


    <?php include("includes/footer.php"); ?>