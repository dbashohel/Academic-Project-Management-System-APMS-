<?php
session_start();
require_once('includes/functions.php');

if (isset($_POST['registration_submit'])) {
    $tcr_id = $_POST['tcr_id'];
    $user_email = $_POST['user_email'];
    $user_pass = $_POST['user_pass'];
    $tcr_name = $_POST['tcr_name'];
    $tcr_father = $_POST['tcr_father'];
    $tcr_mother = $_POST['tcr_mother'];
    $tcr_birth = $_POST['tcr_birth'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone'];
    $fphone = $_POST['fphone'];
    $user_nid = $_POST['user_nid'];
    $user_passport = $_POST['user_passport'];
    $department = $_POST['department'];
    $designation = $_POST['designation'];
    $job_type = $_POST['job_type'];
    $joining_date = $_POST['joining_date'];
    $status = $_POST['status'];
    $present_country = $_POST['present_country'];
    $permanent_country = $_POST['permanent_country'];
    $present_address = $_POST['present_address'];
    $permanent_address = $_POST['permanent_address'];
    $permanent_division = $_POST['permanent_division'];
    $permanent_district = $_POST['permanent_district'];
    $permanent_thana = $_POST['permanent_thana'];
    $religion = $_POST['religion'];
    $position = $_POST['position'];
    $experience = $_POST['experience'];
    $research_area = $_POST['research_area'];
    $interest_field = $_POST['interest_field'];
    $user_role = $_POST['user_role'];

    if (isset($_FILES["tcr_img"]) && $_FILES["tcr_img"]["error"] == 0) {
        $tcr_img = $_FILES["tcr_img"]["name"];
        $tempname = $_FILES["tcr_img"]["tmp_name"];
        $extension = pathinfo($tcr_img, PATHINFO_EXTENSION);
        $filename = uniqid() . "." . $extension;
        $folder = "./uploads/teachers/" . $filename;

        // Proceed with the file upload
        move_uploaded_file($tempname, $folder);
    } else {
        // Handle the case where no file is uploaded
        $filename = ''; // Set a default value if no file is uploaded
    }

    if (!tcr_email_exists($con, $user_email)) {
        if ($user_email && $user_pass) {
            if ($user_nid ||  $user_passport) {
                move_uploaded_file($tempname, $folder);
                $insert = mysqli_query($con, "INSERT INTO tcr_registration (tcr_id, user_email, user_pass,tcr_name,user_role,tcr_img, tcr_father, tcr_mother, tcr_birth, gender, phone,fphone, user_nid, user_passport, department,designation,job_type,joining_date,status,present_country,permanent_country, present_address,permanent_address,permanent_division,permanent_district,permanent_thana,religion,interest_field,experience,research_area,position, submition_date)
                VALUES ('$tcr_id','$user_email','$user_pass','$tcr_name','$user_role','$filename','$tcr_father','$tcr_mother','$tcr_birth','$gender','$phone','$fphone','$user_nid','$user_passport','$department','$designation','$job_type','$joining_date','$status','$present_country','$permanent_country','$present_address','$permanent_address','$permanent_division','$permanent_district','$permanent_thana','$religion','$interest_field','$experience','$research_area','$position', NOW())");

                $erroremail = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong> New Teacher Registered!</strong>. 
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
            } else {
                $erroremail = "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                    <strong>Teacher NID OR Passport cannot be empty!</strong>.
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
            }
        } else {
            $erroremail = "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                    <strong>Password and Email cannot be empty!</strong>.
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
        }
    } else {
        $erroremail = "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong>Email Address Already exists! try any other Email Address</strong>.
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

    <link href="css/select2.min.css" rel="stylesheet">
    <!-- style css-->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>

    <section class="registration start_page">
        <div class="container">
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
                                <div class="col-md-6 d-none">
                                    <label class="mb-1" for="tcr_id">Teacher ID :</label>
                                    <?php
                                    function generateRandomString($length = 4)
                                    {
                                        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                                        $charactersLength = strlen($characters);
                                        $randomString = '';
                                        for ($i = 0; $i < $length; $i++) {
                                            $randomString .= $characters[rand(0, $charactersLength - 1)];
                                        }
                                        return $randomString;
                                    }
                                    $teacher_id = "nub_" . generateRandomString();
                                    ?>
                                    <input type="text" id="tcr_id" name="tcr_id" value="<?php echo $teacher_id; ?>" class="form-control mb-3">
                                </div>
                                <div class="col-md-6">
                                    <label class="mb-1" for="user_email">Username <span class="text-danger">*</span> </label>
                                    <input type="email" id="user_email" name="user_email" class="form-control mb-3" placeholder="Email" required>
                                </div>
                                <div class="col-md-6 d-none">
                                    <label class="mb-1" for="user_pass">Password <span class="text-danger">*</span> </label>
                                    <input type="password" name="user_pass" id="user_pass" class="form-control mb-3  " value="123456" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="mb-1" for="tcr_name">Teacher's Name <span class="text-danger">*</span> </label>
                                    <input type="text" name="tcr_name" id="tcr_name" class="form-control mb-3" placeholder="Teacher's Name" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="mb-1" for="tcr_father">Father's Name <span class="text-danger">*</span> </label>
                                    <input type="text" name="tcr_father" id="tcr_father" class="form-control mb-3" placeholder="Father's Name" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="mb-1" for="tcr_mother">Mother's Name <span class="text-danger">*</span> </label>
                                    <input type="text" name="tcr_mother" id="tcr_mother" class="form-control mb-3" placeholder="Mother's Name" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="mb-1" for="tcr_birth">Date Of Birth <span class="text-danger">*</span> </label>
                                    <input type="date" name="tcr_birth" id="tcr_birth" class="form-control mb-3" required>
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
                                    <label class="mb-1" for="phone">Contact Number <span class="text-danger">*</span> </label>
                                    <input type="tel" name="phone" id="phone" class="form-control mb-3" placeholder="Contact Number" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="mb-1" for="fphone">Father's Contact Number <span class="text-danger">*</span> </label>
                                    <input type="tel" name="fphone" id="fphone" class="form-control mb-3" placeholder="Father's Contact Number" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="mb-1" for="user_nid">NID </label>
                                    <input type="number" name="user_nid" id="user_nid" class="form-control mb-3" placeholder="NID">
                                </div>
                                <div class="col-md-6">
                                    <label class="mb-1" for="user_passport">Passport No </label>
                                    <input type="number" name="user_passport" id="user_passport" class="form-control mb-3" placeholder="Passport No">
                                </div>
                                <div class="col-md-6">
                                    <label class="mb-1" for="department">Department <span class="text-danger">*</span> </label>
                                    <select name="department" class="form-control mb-3" id="department" required>
                                        <option value="0">Select Department</option>
                                        <option value="CSE">CSE</option>
                                        <option value="ECSE">ECSE</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="mb-1" for="designation">Designation</label>
                                    <input type="text" id="designation" name="designation" class="form-control mb-3" placeholder="designation">
                                </div>
                                <div class="col-md-6">
                                    <label class="mb-1" for="job_type">Job Type: </label>
                                    <select name="job_type" class="form-control mb-3" id="job_type">
                                        <option value="0">Select Job Type</option>
                                        <option value="permanent">Parmanent</option>
                                        <option value="part-time">Part Time</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="mb-1" for="joining_date">Joining Date </label>
                                    <input type="date" name="joining_date" id="joining_date" class="form-control mb-3" placeholder="joining date" required>
                                </div>
                                <div class="col-md-6 d-none">
                                    <label class="mb-1" for="status">Status : </label>
                                    <select name="status" class="form-control mb-3" id="status" required>
                                        <option value="pending">Pending</option>
                                        <option value="running">Running</option>
                                    </select>
                                </div>
                                <div class="col-md-6 d-none">
                                    <label class="mb-1">User Role <span class="text-danger">*</span> </label>
                                    <select name="user_role" class="form-control mb-3">
                                        <option value="teacher">teacher</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="mb-1" for="present_country">Present Country <span class="text-danger">*</span> </label>
                                    <input type="text" name="present_country" id="present_country" class="form-control mb-3" placeholder="Present Country" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="mb-1" for="permanent_country">Permanent Country <span class="text-danger">*</span> </label>
                                    <input type="text" name="permanent_country" id="permanent_country" class="form-control mb-3" placeholder="Permanent Country" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="mb-1" for="present_address">Present Address <span class="text-danger">*</span> </label>
                                    <input type="text" name="present_address" id="present_address" class="form-control mb-3" placeholder="Present Address" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="mb-1" for="permanent_address">Permanent Address <span class="text-danger">*</span> </label>
                                    <input type="text" name="permanent_address" id="permanent_address" class="form-control mb-3" placeholder="Permanent Address" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="mb-1" for="permanent_division">Permanent Division <span class="text-danger">*</span> </label>
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
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="academic">

                                        <h4 class="mt-4">Professional Information</h4>
                                        <div class="form-group mb-1">
                                            <label for="position">Position</label>
                                            <input type="text" class="form-control" id="position" name="position" required>
                                        </div>
                                        <div class="form-group mb-1">
                                            <label for="experience">Years of Experience</label>
                                            <input type="number" class="form-control" id="experience" name="experience" required>
                                        </div>
                                        <div class="form-group mb-1">
                                            <label for="research_area">Research Area</label>
                                            <input type="text" class="form-control" id="research_area" name="research_area">
                                        </div>
                                        <div class="form-group mb-1">
                                            <label for="interest_field">Interest Field</label>
                                            <input type="text" class="form-control" id="interest_field" name="interest_field">
                                        </div>

                                        <!-- Documents Upload -->
                                        <div class="form-group mb-3">
                                            <label class="mb-1" for="tcr_img">Image <span class="text-danger">*</span></label>
                                            <input type="file" class="form-control mb-3" name="tcr_img" id="tcr_img" required>
                                        </div>
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
                        <p class="mt-4"> Already have an account? please <a href="login2.php">Log in</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

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