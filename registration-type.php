<?php
session_start();

include("includes/header.php"); ?>
<?php include("includes/functions.php"); 
if (!isset($_SESSION["user_email"])) {
        header("Location: login.php");
        exit;
    }
    generateNavMenu('admin');
?>


    <!--content area start-->
    <div class="main_page">
        <div class="content-area">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6  col-lg-4 col-xxl-3">
                        <div class="card box-card">
                            <a href="subject_insert.php" class="d-flex flex-column text-center gap-2">
                                <i class="fa fa-book"></i>   
                                <span>Add to Subject & Others</span>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6  col-lg-4 col-xxl-3">
                        <div class="card box-card">
                            <a href="subject_ragistration.php" class="d-flex flex-column text-center gap-2">
                                <i class="fa fa-book"></i>   
                                <span>Subject Registration</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!--content area end-->
<?php include("includes/footer.php"); ?>
        