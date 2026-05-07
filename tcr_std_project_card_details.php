<?php
session_start();

include("includes/header.php");
include("includes/functions.php");

if (!isset($_SESSION["user_email"]) || !isset($_SESSION["user_role"])) {
    header("Location: login.php");
    exit;
}

$teacher = $_SESSION["teacher"];

if ($user_role == 'teacher') {
    generateNavMenu('teacher');
} else {
    generateNavMenu('admin');
}
?>

<?php
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $delete = "DELETE FROM std_project_reg WHERE id='$id'";
    $result = mysqli_query($con, $delete);
    if ($result) {
?>
        <div class="alert alert-success">
            <strong>Project</strong> Data Deleted Successfully.
        </div>
<?php
        // echo "<meta http-equiv='refresh' content='2;>";
        // header("Location: your_page.php?deleted=true");
        // exit();
    } else {
        echo "Failed" . mysqli_error($con);
    }
}

?>
<?php
if (isset($_GET['project'])) {
    $show_id = $_GET['project'];
    $get_data = "SELECT * FROM std_project_reg WHERE id ='$show_id'";
    $result_show = mysqli_query($con, $get_data);
    $proje_id_show = mysqli_fetch_array($result_show);
    $projec_id  = $proje_id_show['id'];
    $status  = $proje_id_show['status'];
}
?>

<div class="main_page">
    <div class="content-area">
        <div class="container-fluid">


            <h2 class="text-capitalize"><?php echo $proje_id_show['status'] ?> Project - <?php echo $proje_id_show['proposal'] .  '<span class="fs-5">( ' . $proje_id_show['proj_topic'] . ' ) </span>'; ?>:</h2>

            <?php
            // $bring_data = "SELECT * FROM std_project_reg WHERE FIND_IN_SET('$user_email', tcr_user_email) AND status = 'pending' AND id = '$projec_id'";
            $bring_data = "SELECT * FROM std_project_reg WHERE FIND_IN_SET('$user_email', tcr_user_email) AND status IN ('pending','approved','complete', 'reject') AND id = '$projec_id'";

            $result = mysqli_query($con, $bring_data);

            if (mysqli_num_rows($result) > 0) {
            ?>
                <!-- Show Teacher -->
                <div class="student-list pt-5">
                    <div class="data_info mt-4">
                        <table class="table table-striped table-hove mt-4  ">
                            <thead>

                                <th scope="col">Supervisor Name (Initial)</th>
                                <th scope="col">Day/ Evening</th>
                                <th scope="col">Thesis/Project</th>
                                <th scope="col">Form Submission date</th>
                                <th scope="col">Project/Thesis Proposal</th>
                                <th scope="col">Project/Thesis Topic</th>
                                <th scope="col">Required Technology</th>
                                <th scope="col">Project Summary</th>
                                <th scope="col">Student Name</th>
                                <th scope="col">Edit / Delete</th>
                            </thead>
                            <tbody>
                                <?php
                                while ($project = mysqli_fetch_array($result)) :
                                ?>
                                    <tr>
                                        <td>
                                            <span class="d-block fs-5 mb-2"> <?php echo $teacher['tcr_name']; ?></span>
                                            <span class="d-block mb-1"> <?php echo $teacher['user_email']; ?></span>
                                            <span class="d-block mb-1"> <?php echo $teacher['phone']; ?></span>
                                            <span class="d-block mb-1"> <?php echo $teacher['department']; ?></span>
                                            <span class="d-block mb-1"> <?php echo $teacher['interest_field']; ?></span>
                                        </td>
                                        <td> <?php echo $project['program_type']; ?> </td>
                                        <td> <?php echo $project['project_type']; ?> </td>
                                        <td> <?php echo $project['date']; ?> </td>
                                        <td> <?php echo $project['proposal']; ?> </td>
                                        <td> <?php echo $project['proj_topic']; ?> </td>
                                        <td> <?php echo $project['proj_technology']; ?> </td>
                                        <td> <?php echo $project['project_summary']; ?> </td>
                                        <td>
                                            <strong>Live Link:</strong> <?php echo empty($project['project_live_link']) ? 'N/A' : '<a href="' . $project['project_live_link'] . '" target="_blank">' . $project['project_live_link'] . '</a>'; ?><br>
                                            <strong>GitHub:</strong> <?php echo empty($project['project_github_link']) ? 'N/A' : '<a href="' . $project['project_github_link'] . '" target="_blank">' . $project['project_github_link'] . '</a>'; ?>
                                        </td>

                                        <!-- Student Info -->

                                        <?php
                                        $std_ids = $project['std_id_multiple'];
                                        $get_std = "SELECT * FROM std_registration WHERE std_id IN ($std_ids)";
                                        if ($run_std = mysqli_query($con, $get_std)) {
                                            if (mysqli_num_rows($run_std) > 0) {
                                                echo "<td class='mb-3 '>";
                                                while ($student = mysqli_fetch_array($run_std)) {
                                                    echo "<div class='boder-bottom mb-2 pb-2 d-flex flex-column'>";
                                                    echo "<span class='mb-1'>{$student['std_id']}</span>";
                                                    echo "<span class='mb-1'>{$student['std_name']}</span>";
                                                    echo "<span class='mb-1'>{$student['user_email']}</span>";
                                                    echo "</div>";
                                                }
                                                echo "</td>";
                                            } else {
                                                echo "<div class='mb-1'>No records found</div>";
                                            }
                                        };

                                        ?>
                                        <td>
                                            <a class="btn btn-primary" href="tcr_std_project_card_edit.php?edit=<?php echo $project['id']; ?> "><i class="fa-regular fa-pen-to-square"></i></a>
                                            <a href="tcr_std_project_details.php?delete=<?php echo $project['id']; ?> " onclick="return confirm('Are you sure you want to delete <?php echo $project['proposal']; ?> Account?');" class="btn btn-danger"><i class="fa-solid fa-trash"></i></a>
                                        </td>
                                    </tr>
                                <?php
                                endwhile;
                                ?>


                            </tbody>
                        </table>
                    </div>
                <?php
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