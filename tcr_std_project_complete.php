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

// $status = isset($_GET['status']) ? $_GET['status'] : "";
// if (!in_array($status, ['approved'])) {
//     header("Location: 404.php");
//     exit;
// }
?>


<div class="main_page">
    <div class="content-area">
        <div class="container-fluid">


            <div class="row mb-5 pb-4">
                <div class="d-flex justify-content-between align-items-center w-100  mb-3">
                    <h2>Project Tracking:</h2>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <!-- <label class="heading mb-2" for="std_id_multiple">Project Search</label> -->
                        <select class="js-example-basic-multiple  form-control" name="std_id_multiple[]" id="std_id_multiple" multiple="multiple">
                            <?php
                            $get_search = "SELECT * FROM std_project_reg WHERE (status = 'complete' OR is_submitted = '1')";
                            if ($run_search = mysqli_query($con, $get_search)) {
                                if (mysqli_num_rows($run_search) > 0) {
                                    while ($search_project = mysqli_fetch_array($run_search)) {
                                        $id  = $search_project['id'];
                                        $proposal  = $search_project['proposal'];
                                        echo "<option value='$proposal'>$proposal</option>";
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center w-100 ">
                <h2>Student Projects:</h2>
            </div>
            <div class="row pt-5">

                <!-- Show admin/Teacher Panel-->
                <?php
                $bring_data = "SELECT * FROM std_project_reg WHERE (status = 'complete' OR is_submitted = '1')";

                $result = mysqli_query($con, $bring_data);
                if (mysqli_num_rows($result) > 0) {
                    while ($project_row = mysqli_fetch_array($result)) : ?>

                        <div class="col-sm-6 col-xxl-4">
                            <div class="cus_box">
                                <a href="tcr_super_std_project_details.php?project=<?php echo $project_row['id'] ?>" class="d-flex flex-column text-center gap-2">

                                    <div class="card_top d-flex justify-content-between gap-3 align-items-center">
                                        <div class="text_area">
                                            <h4 class="text-capitalize"><?php echo $project_row['proposal'] . '<span class="fs-6 d-block mt-2">(' . $project_row['proj_topic'] . ') - (' .  $project_row['semester'] . '-' .  date('Y', strtotime($project_row['date'])) . ')</span>' ?> </h4>

                                            <?php
                                            $teacher_email = $project_row['tcr_user_email'];
                                            $get_std = "SELECT * FROM tcr_registration WHERE user_email = '$teacher_email' ";
                                            if ($run_std = mysqli_query($con, $get_std)) {
                                                if (mysqli_num_rows($run_std) > 0) {
                                                    while ($teacher = mysqli_fetch_array($run_std)) { ?>
                                                        <div class='d-flex gap-3 flex-wrap align-items-center mt-3'>
                                                            <div class="user_img box_12">
                                                                <img src="./uploads/teachers/<?= $teacher['tcr_img']; ?>" class=" rounded-circle" alt="img">
                                                            </div>
                                                            <div class='d-flex flex-column'>
                                                                <?php
                                                                echo "<span class='mb-1'>{$teacher['tcr_name']}</span>";
                                                                ?>
                                                            </div>
                                                        </div>
                                            <?php
                                                    }
                                                } else {
                                                    echo "<div class='mb-1 mt-4'>No records found</div>";
                                                }
                                            }
                                            ?>
                                        </div>
                                        <i class="fa-regular fa-address-card"></i>
                                    </div>
                                </a>
                                <div class="cus_title d-flex justify-content-between gap-3 align-items-center">
                                    <h6 class="text-capitalize"><?php echo $project_row['project_type'] . ' (' . $project_row['program_type'] . ')'; ?></h6>
                                    <span class="fs-7"><?= $project_row['status'] == 'complete' ? 'Completed' : 'Result Submitted' ?></span>
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
</div>

<?php include("includes/footer.php"); ?>