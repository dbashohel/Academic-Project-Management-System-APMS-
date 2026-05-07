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
?>


<!--content area start-->
<div class="main_page">
    <div class="content-area">
        <div class="container-fluid">
            <h2 class=" mb-5 mt-4 text-capitalize">Welcome to USA <?php echo $user_role ?> Portal</h2>
            <div class="row g-4">
                <?php if ($user_role == 'admin') { ?>
                    <div class="col-sm-6  col-lg-4 col-xxl-3">
                        <div class="cus_box">
                            <a href="registration_cat.php" class="d-flex flex-column text-center gap-2">
                                <div class="card_top d-flex justify-content-between gap-3 align-items-center">
                                    <div class="text_area ">
                                        <h5>Registration Form</h5>
                                        <span>Teachers & Students</span>
                                    </div>
                                    <i class="fa-brands fa-wpforms"></i>
                                </div>
                                <h6 class="cus_title">Registration Form</h6>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-6  col-lg-4 col-xxl-3">
                        <div class="cus_box">
                            <a href="tcr_a_table.php" class="d-flex flex-column text-center gap-2">
                                <div class="card_top d-flex justify-content-between gap-3 align-items-center">
                                    <div class="text_area ">
                                        <h5>Teacher's Info</h5>
                                        <span>Teacher</span>
                                    </div>
                                    <i class="fa-solid fa-users"></i>
                                </div>
                                <h6 class="cus_title">Teachers Info</h6>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-6  col-lg-4 col-xxl-3">
                        <div class="cus_box">
                            <a href="tcr_std_table.php" class="d-flex flex-column text-center gap-2">
                                <div class="card_top d-flex justify-content-between gap-3 align-items-center">
                                    <div class="text_area ">
                                        <h5>Students Info </h5>
                                        <span>Students</span>
                                    </div>
                                    <i class="fa-solid fa-users"></i>
                                </div>
                                <h6 class="cus_title">Students Info</h6>
                            </a>
                        </div>
                    </div>

                    <div class="col-sm-6  col-lg-4 col-xxl-3">
                        <div class="cus_box">
                            <a href="tcr_std_project_complete.php" class="d-flex flex-column text-center gap-2">
                                <div class="card_top d-flex justify-content-between gap-3 align-items-center">
                                    <div class="text_area ">
                                        <h5>Project & Thesis </h5>
                                        <span>Students</span>
                                    </div>
                                    <i class="fa fa-book"></i>
                                </div>
                                <h6 class="cus_title">Project & Thesis Info</h6>
                            </a>
                        </div>
                    </div>

                <?php } ?>

                <?php if ($user_role == 'student') { ?>
                    <div class="col-sm-6  col-lg-4 col-xxl-3">
                        <div class="cus_box">
                            <a href="registration-type.php" class="d-flex flex-column text-center gap-2">
                                <div class="card_top d-flex justify-content-between gap-3 align-items-center">
                                    <div class="text_area ">
                                        <h5>Subject Registration</h5>
                                        <span>Registration</span>
                                    </div>
                                    <i class="fa fa-book"></i>
                                </div>
                                <h6 class="cus_title">Subject Registration Info</h6>
                            </a>
                        </div>
                    </div>

                    <div class="col-md-6  col-lg-4 col-xxl-3">
                        <div class="cus_box">
                            <a href="resultInfo_admin.php" class="d-flex flex-column text-center gap-2">
                                <div class="card_top d-flex justify-content-between gap-3 align-items-center">
                                    <div class="text_area ">
                                        <h5>Result Information</h5>
                                        <span>Result</span>
                                    </div>
                                    <i class="fa fa-pencil"></i>
                                </div>
                                <h6 class="cus_title">Result Info</h6>
                            </a>
                        </div>
                    </div>
                <?php } ?>

                <?php if ($user_role == 'teacher') { ?>
                    <div class="col-sm-6  col-lg-4 col-xxl-3">
                        <div class="cus_box">
                            <a href="std_project_reg.php" class="d-flex flex-column text-center gap-2">
                                <div class="card_top d-flex justify-content-between gap-3 align-items-center">
                                    <div class="text_area ">
                                        <h5>Registration Form</h5>
                                        <span>Student</span>
                                    </div>
                                    <i class="fa-brands fa-wpforms"></i>
                                </div>
                                <h6 class="cus_title">Project Registration</h6>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-6  col-lg-4 col-xxl-3">
                        <div class="cus_box">
                            <a href="tcr_std_info.php" class="d-flex flex-column text-center gap-2">
                                <div class="card_top d-flex justify-content-between gap-3 align-items-center">
                                    <div class="text_area ">
                                        <h5>Students Group</h5>
                                        <span>Complete & Reject</span>
                                    </div>
                                    <i class="fa-solid fa-users"></i>
                                </div>
                                <h6 class="cus_title">Project & Thesis </h6>
                            </a>
                        </div>
                    </div>

                    <div class="col-sm-6  col-lg-4 col-xxl-3">
                        <div class="cus_box">
                            <a href="tcr_std_project.php" class="d-flex flex-column text-center gap-2">
                                <div class="card_top d-flex justify-content-between gap-3 align-items-center">
                                    <div class="text_area ">
                                        <h5>Project & Thesis </h5>
                                        <span>Student</span>
                                    </div>
                                    <i class="fa fa-book"></i>
                                </div>
                                <h6 class="cus_title">Project Info</h6>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-6  col-lg-4 col-xxl-3">
                        <div class="cus_box">
                            <a href="tcr_project_for_available_edit.php" class="d-flex flex-column text-center gap-2">
                                <div class="card_top d-flex justify-content-between gap-3 align-items-center">
                                    <div class="text_area ">
                                        <h5>Project For Available? </h5>
                                        <span>Teacher</span>
                                    </div>
                                    <i class="fa-solid fa-person-chalkboard"></i>
                                </div>
                                <h6 class="cus_title">Project For Available?</h6>
                            </a>
                        </div>
                    </div>
                    <!-- <div class="col-sm-6  col-lg-4 col-xxl-3">
                        <div class="cus_box">
                            <a href="registration-type.php" class="d-flex flex-column text-center gap-2">
                                <div class="card_top d-flex justify-content-between gap-3 align-items-center">
                                    <div class="text_area ">
                                        <h5>Subject Registration</h5>
                                        <span>Registration</span>
                                    </div>
                                    <i class="fa fa-book"></i>
                                </div>
                                <h6 class="cus_title">Subject Registration Info</h6>
                            </a>
                        </div>
                    </div> -->

                    <!-- <div class="col-md-6  col-lg-4 col-xxl-3">
                        <div class="cus_box">
                            <a href="resultInfo_admin.php" class="d-flex flex-column text-center gap-2">
                                <div class="card_top d-flex justify-content-between gap-3 align-items-center">
                                    <div class="text_area ">
                                        <h5>Result Information</h5>
                                        <span>Result</span>
                                    </div>
                                    <i class="fa fa-pencil"></i>
                                </div>
                                <h6 class="cus_title">Result Info</h6>
                            </a>
                        </div>
                    </div> -->


                    <!-- <div class="col-md-6  col-lg-4 col-xxl-3">
                        <div class="cus_box">
                            <a href="teacher_credit_reg.php" class="d-flex flex-column text-center gap-2">
                            <div class="card_top d-flex justify-content-between gap-3 align-items-center">
                                    <div class="text_area ">
                                        <h5>Result Information</h5>
                                        <span>Result</span>
                                    </div>
                                    <i class="fa-solid fa-person-chalkboard"></i>
                                </div>    
                                <h6 class="cus_title">Credit Wise Teachers Info</h6>
                            </a>
                        </div>
                    </div> -->
                <?php } ?>

            </div>
        </div>
    </div>
</div>
<!--content area end-->
<?php include("includes/footer.php"); ?>