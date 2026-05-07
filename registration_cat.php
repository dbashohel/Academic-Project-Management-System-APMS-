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
?>
<!--content area start-->
<div class="main_page">
    <div class="content-area">
        <div class="container-fluid">
            <h3 class="box-card mb-4 mt-4">Welcome to USA Teacher Portal</h3>
            <div class="row">
                <div class="col-sm-6  col-lg-4 col-xxl-3">
                    <div class="cus_box">
                        <a href="teacher_registration.php" class="d-flex flex-column text-center gap-2">
                            <div class="card_top d-flex justify-content-between gap-3 align-items-center">
                                <div class="text_area ">
                                    <h5> Registration Form</h5>
                                    <span>Teacher</span>
                                </div>
                                <i class="fa-solid fa-person-chalkboard"></i>
                            </div>
                            <h6 class="cus_title">Teacher Registration</h6>
                        </a>
                    </div>
                </div>
                <div class="col-sm-6  col-lg-4 col-xxl-3">
                    <div class="cus_box">
                        <a href="student_registration.php" class="d-flex flex-column text-center gap-2">
                            <div class="card_top d-flex justify-content-between gap-3 align-items-center">
                                <div class="text_area ">
                                    <h5> Registration Form</h5>
                                    <span>Student</span>
                                </div>
                                <i class="fa-solid fa-graduation-cap"></i>
                            </div>
                            <h6 class="cus_title">Student Registration</h6>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--content area end-->
<?php include("includes/footer.php"); ?>