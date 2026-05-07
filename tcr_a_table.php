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
            <div class="d-flex justify-content-between align-items-center w-100 mb-5 mt-4">
                <h3 class=" ">Teacher Project Pending</h3>
                <a href="index.php">Back to Home</a>
            </div>
            <div class="row">
                <div class="col-sm-6  col-lg-4 col-xxl-3">
                    <div class="cus_box">
                        <a href="tcr_reg_pending.php?status=pending" class="d-flex flex-column text-center gap-2">
                            <div class="card_top d-flex justify-content-between gap-3 align-items-center">
                                <div class="text_area ">
                                    <h5>Teacher Pending</h5>
                                    <span>Registration</span>
                                </div>
                                <i class="fa-regular fa-address-card"></i>
                            </div>
                            <h6 class="cus_title">Teacher Pending</h6>
                        </a>
                    </div>
                </div>
                <div class="col-sm-6  col-lg-4 col-xxl-3">
                    <div class="cus_box">
                        <a href="teacher_info.php?status=approved" class="d-flex flex-column text-center gap-2">
                            <div class="card_top d-flex justify-content-between gap-3 align-items-center">
                                <div class="text_area ">
                                    <h5>Registered Teacher</h5>
                                    <span>Teacher</span>
                                </div>
                                <i class="fa-solid fa-diagram-project"></i>
                            </div>
                            <h6 class="cus_title">Registered Teacher</h6>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--content area end-->
<?php include("includes/footer.php"); ?>