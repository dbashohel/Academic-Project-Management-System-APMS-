<?php
session_start();

include("includes/header.php");
include("includes/functions.php");

if (!isset($_SESSION["std_id"]) || !isset($_SESSION["user_role"])) {
    header("Location: login.php");
    exit;
}


$std_id = $_SESSION["std_id"];
$user_role = $_SESSION["user_role"];
$std_name = $_SESSION["std_name"];

if ($user_role == 'student') {
    generateNavMenu('student');
}
?>



<?php

$result = mysqli_query($con, "select * from std_registration WHERE std_id = '$std_id'");

if (!$result) {
    die("Error: " . mysqli_error($con));
}

?>


<!--content area start-->
<div class="main_page">
    <div class="content-area">
        <div class="container-fluid">
            <div class="user_profile pt-4">
                <div class="pt-4">
                    <h2 class="mb-5">Welcome to USA <?php echo $user_role ?> Portal</h2>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6  col-lg-4 col-xxl-3">
                    <div class="cus_box">
                        <a href="std_project_reg.php" class="d-flex flex-column text-center gap-2">
                            <div class="card_top d-flex justify-content-between gap-3 align-items-center">
                                <div class="text_area ">
                                    <h5>Project Registration</h5>
                                    <span>Project</span>
                                </div>
                                <i class="fa-regular fa-address-card"></i>
                            </div>
                            <h6 class="cus_title">Project Registration</h6>
                        </a>
                    </div>
                </div>
                <div class="col-sm-6  col-lg-4 col-xxl-3">
                    <div class="cus_box">
                        <a href="std_project_info.php" class="d-flex flex-column text-center gap-2">
                            <div class="card_top d-flex justify-content-between gap-3 align-items-center">
                                <div class="text_area ">
                                    <h5>My Project </h5>
                                    <span>Project</span>
                                </div>
                                <i class="fa-solid fa-diagram-project"></i>
                            </div>
                            <h6 class="cus_title">Project</h6>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--content area end-->
<?php include("includes/footer.php"); ?>