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
            <h3 class=" mb-5 mt-4">Welcome to USA Teacher Portal</h3>
            <div class="row">
                <div class="col-sm-6  col-lg-4 col-xxl-3">
                    <div class="cus_box">
                        <a href="tcr_std_project_card.php?status=reject" class="d-flex flex-column text-center gap-2">
                            <div class="card_top d-flex justify-content-between gap-3 align-items-center">
                                <div class="text_area ">
                                    <h5>Reject Group</h5>
                                    <span>Project</span>
                                </div>
                                <i class="fa-regular fa-address-card"></i>
                            </div>
                            <h6 class="cus_title">Student Pending</h6>
                        </a>
                    </div>
                </div>
                <div class="col-sm-6  col-lg-4 col-xxl-3">
                    <div class="cus_box">
                        <a href="tcr_std_project_card.php?status=complete" class="d-flex flex-column text-center gap-2">
                            <div class="card_top d-flex justify-content-between gap-3 align-items-center">
                                <div class="text_area ">
                                    <h5>Complete Group</h5>
                                    <span>Project</span>
                                </div>
                                <i class="fa-solid fa-diagram-project"></i>
                            </div>
                            <h6 class="cus_title">Student Information</h6>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--content area end-->
<?php include("includes/footer.php"); ?>