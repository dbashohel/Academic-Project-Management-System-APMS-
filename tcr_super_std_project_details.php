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
// $tcr_reg_id = $_SESSION["id"];

if ($user_role == 'teacher') {
    generateNavMenu('teacher');
} else {
    generateNavMenu('admin');
}

// tab active
$tab = 'result';
if (isset($_GET["tab"]) && in_array($_GET["tab"], ['result', 'team'])) {
    $tab = $_GET["tab"];
}
?>




<?php

if (isset($_GET['project'])) {
    $proj_id = $_GET['project'];
    $get_data = "SELECT * FROM std_project_reg WHERE id='$proj_id'";
    $result = mysqli_query($con, $get_data);
    $proj_id_show = mysqli_fetch_array($result);

    $proj_ids = $proj_id_show['id'];
}
?>


<style>
    .main_page.std_pro_info .table tr td {
        padding: 16px 12px;
    }
</style>

<div class="main_page std_pro_info">
    <div class="content-area ">
        <div class="container-fluid">
            <!-- Show Teacher -->
            <!-- <div class="student-list pt-5"> -->
            <?php
            $project_query = "SELECT * FROM std_project_reg WHERE id = $proj_id";
            $project_result = mysqli_query($con, $project_query);

            if (mysqli_num_rows($project_result) > 0) {
            ?>

                <div class="row details_bar mb-10 mb-lg-12 mb-xxl-15">
                    <div class="d-flex flex-wrap gap-4 row-gap-8 justify-content-center justify-content-md-between align-items-center">
                        <div class="d-flex gap-3 flex-wrap border-bottom w-100">
                            <button class="cmn-btn tab_button <?= ($tab == 'result' ? 'active' : '') ?>"
                                data-tab="project_profile">Result Sheet</button>
                            <button class="cmn-btn tab_button <?= $tab == 'team' ? 'active' : '' ?>"
                                data-tab="project_team">Team</button>
                        </div>
                    </div>
                </div>

                <?php while ($project = mysqli_fetch_assoc($project_result)) : ?>
                    <div class="row g-6 mt-5">


                        <!-- project_profile -->
                        <?php



                        // Validate and sanitize project data
                        $project_type = isset($project['project_type']) ? htmlspecialchars($project['project_type']) : '';
                        $program_type = isset($project['program_type']) ? htmlspecialchars($project['program_type']) : '';
                        $semester = isset($project['semester']) ? htmlspecialchars($project['semester']) : '';
                        $date = isset($project['date']) ? htmlspecialchars(date('Y', strtotime($project['date']))) : date('Y');
                        ?>

                        <div class="tab_content project_profile <?= $tab == 'result' ? 'active' : '' ?>">
                            <div class="row justify-content-center">
                                <div class="col-12">
                                    <div class="border border-color rounded-3 p-3 p-lg-5">
                                        <h1 class="mb-5 mx-auto supplementary">Supplementary Mark Sheet</h1>
                                        <h4 class="text-decoration-underline mb-3">Please Put Ticket</h4>
                                        <p class="mb-3 fs-4 text-capitalize">
                                            <strong class="d-flex align-items-center gap-3">
                                                <i class="fa-solid fa-check"></i> <?php echo $project_type; ?>
                                            </strong>
                                        </p>
                                        <p class="mb-3 fs-4">
                                            <strong>Department:</strong> Science and Engineering (<span class="text-capitalize"><?php echo $program_type; ?></span> )
                                        </p>
                                        <p class="mb-3 fs-4">
                                            <strong>Program:</strong> B.Sc in Science and Engineering
                                        </p>
                                        <p class="mb-3 fs-4 d-flex flex-wrap justify-content-between text-capitalize">
                                            <span><strong>Semester: </strong> <?php echo $semester; ?></span>
                                            <span><strong>Year: </strong><?php echo $date; ?></span>
                                        </p>
                                        <p class="mb-5 fs-4 d-flex flex-wrap justify-content-between">
                                            <span><strong>Course Code: </strong> CSE 4000</span>
                                            <span class="ms-auto"><strong>Course Title: </strong>Project & Thesis</span>
                                        </p>

                                        <div class="d-flex  gap-3">
                                            <a href="pdf/project_result.php?project_id=<?= $proj_id ?>" target="_blank" class="btn btn-success fs-1 px-4 py-1 rounded-3"><i class="fa-regular fa-file-pdf"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab_content project_team  <?= $tab == 'team' ? 'active' : '' ?>">
                            <div class="row">
                                <div class="col-lg-10">
                                    <div class="shadow1 border-color rounded-3 p-3 p-lg-5">
                                        <div class="supervisor">
                                            <h4 class="fs-one fw-semibold mb-4 text-decoration-underline ">Supervisor</h4>
                                            <?php
                                            $teacher_email = $project['tcr_user_email'];
                                            $get_std = "SELECT * FROM tcr_registration WHERE user_email = '$teacher_email' ";
                                            if ($run_std = mysqli_query($con, $get_std)) {
                                                if (mysqli_num_rows($run_std) > 0) {
                                                    while ($student = mysqli_fetch_array($run_std)) { ?>
                                                        <div class='divider  d-flex gap-4 flex-wrap align-items-center pb-5 mb-5'>
                                                            <div class="user_img box_12">
                                                                <img src="./uploads/students/<?= $student['tcr_img']; ?>" class=" rounded-circle" alt="img">
                                                            </div>
                                                            <div class='d-flex flex-column'>
                                                                <?php
                                                                echo "<span class='mb-1'>{$student['tcr_name']}</span>";
                                                                echo "<span class='mb-1'>{$student['phone']}</span>";
                                                                echo "<span class='mb-1'>{$student['user_email']}</span>";
                                                                ?>
                                                            </div>
                                                            <a class="btn btn-primary ms-auto rounded-3" href="tcr_more_infor.php?show=<?php echo $student['id'] ?>"><i class="fa-solid fa-eye"></i></a>
                                                        </div>
                                            <?php
                                                    }
                                                } else {
                                                    echo "<div class='mb-1 mt-4'>No records found</div>";
                                                }
                                            };

                                            ?>
                                        </div>
                                        <div class="student">
                                            <h4 class="fs-one fw-semibold mb-4 text-decoration-underline">Team Member</h4>
                                            <?php
                                            $std_ids = $project['std_id_multiple'];
                                            $get_std = "SELECT * FROM std_registration WHERE std_id IN ($std_ids)";
                                            if ($run_std = mysqli_query($con, $get_std)) {
                                                if (mysqli_num_rows($run_std) > 0) {
                                                    while ($student = mysqli_fetch_array($run_std)) { ?>
                                                        <div class='boder-bottom d-flex gap-4 flex-wrap align-items-center'>
                                                            <div class="user_img box_12">
                                                                <img src="./uploads/students/<?= $student['std_img']; ?>" class=" rounded-circle" alt="img">
                                                            </div>
                                                            <div class='d-flex flex-column'>
                                                                <?php
                                                                echo "<span class='mb-1'>{$student['std_id']}</span>";
                                                                echo "<span class='mb-1'>{$student['std_name']}</span>";
                                                                echo "<span class='mb-1'>{$student['user_email']}</span>";
                                                                ?>
                                                            </div>
                                                            <a class="btn btn-primary ms-auto rounded-3" href="std_more_infor.php?show=<?php echo $student['std_id'] ?>"><i class="fa-solid fa-eye"></i></a>
                                                        </div>
                                            <?php
                                                    }
                                                } else {
                                                    echo "<div class='mb-1'>No records found</div>";
                                                }
                                            };

                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php
                endwhile;
            } else {
                // Display a message when there is no data
                echo "<div class='alert alert-warning alert-dismissible mt-5 text-center'>
                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                <strong class='d-block mb-2'>Data Empty!</strong> 
              </div>";
            }
            ?>
        </div>
    </div>
</div>




<?php include("includes/footer.php"); ?>