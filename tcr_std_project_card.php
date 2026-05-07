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

$status = isset($_GET['status']) ? $_GET['status'] : "";
if (!in_array($status, ['complete', 'pending', 'reject', 'approved'])) {
    header("Location: 404.php");
    exit;
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
                <h2>Student Project <?php echo ucfirst($status) ?>:</h2>
            </div>
            <div class="row pt-5">

                <!-- Show admin/Teacher Panel-->
                <?php
                $bring_data = "SELECT * FROM std_project_reg WHERE FIND_IN_SET('$user_email', tcr_user_email) AND status = '$status'";

                $result = mysqli_query($con, $bring_data);

                if (mysqli_num_rows($result) > 0) {
                    while ($project_row = mysqli_fetch_array($result)) : ?>
                        <div class="col-sm-6 col-xxl-4">
                            <div class="cus_box position-relative shadow-sm d-flex flex-column justify-content-between" style="padding-top: 18px; border-radius:18px; background:#fff; box-shadow:0 4px 24px 0 rgba(44,62,80,.07); border:1px solid #f0f0f0; min-height:270px; transition:box-shadow .2s; height:100%;">
                                <?php if ($status == 'approved') { ?>
                                    <a href="tcr_std_project_details.php?project=<?php echo $project_row['id'] ?>" class="d-flex flex-column gap-2" style="text-decoration:none;">
                                    <?php  } else { ?>
                                        <a href="tcr_std_project_card_details.php?project=<?php echo $project_row['id'] ?>" class="d-flex flex-column gap-2" style="text-decoration:none;">
                                        <?php } ?>
                                        <div class="card_top position-relative p-3 pb-2" style="background:transparent; min-height:120px;">
                                            <i class="fa-regular fa-address-card position-absolute" style="top:18px; right:18px; font-size:1.7em; color:#222;"></i>
                                            <div class="text_area w-100">
                                                <h4 class="mb-1 d-flex align-items-center gap-2" style="font-weight:600; font-size:1.18rem; color:#222;">
                                                    <i class="fa-solid fa-lightbulb text-warning" style="font-size:1.1em;"></i>
                                                    <span><?php echo $project_row['proposal']; ?></span>
                                                    <span class="fs-6 text-secondary" style="font-weight:400;">(<?php echo $project_row['proj_topic']; ?>)</span>
                                                </h4>
                                                <span class="mb-2 d-block text-muted d-flex align-items-center gap-2" style="font-size:0.97rem; font-weight:400;">
                                                    <i class="fa-regular fa-calendar" style="font-size:1.1em;"></i> <?php echo $project_row['date']; ?>
                                                </span>
                                                <div class="mt-2 text-start px-1">
                                                    <div class="d-flex align-items-center flex-wrap" style="gap:7px;">
                                                        <span class="d-flex align-items-center" style="gap:7px;">
                                                            <i class="fa-solid fa-globe text-success" style="font-size:1.1em;"></i>
                                                            <span style="font-weight:500;">Live Link:</span>
                                                            <?php if (empty($project_row['project_live_link'])) {
                                                                echo '<span class="text-muted ms-1">N/A</span>';
                                                            } else {
                                                                $liveLink = $project_row['project_live_link'];
                                                                $liveLinkDisplay = strlen($liveLink) > 30 ? substr($liveLink, 0, 30) . '...' : $liveLink;
                                                                echo '<a href="' . $liveLink . '" target="_blank" class="ms-1 text-decoration-underline" style="color:#2d6cdf;">' . $liveLinkDisplay . '</a>';
                                                            } ?>
                                                        </span>
                                                        <span class="d-flex align-items-center" style="gap:7px;">
                                                            <i class="fa-brands fa-github text-dark" style="font-size:1.1em;"></i>
                                                            <span style="font-weight:500;">GitHub:</span>
                                                            <?php if (empty($project_row['project_github_link'])) {
                                                                echo '<span class="text-muted ms-1">N/A</span>';
                                                            } else {
                                                                $githubLink = $project_row['project_github_link'];
                                                                $githubLinkDisplay = strlen($githubLink) > 30 ? substr($githubLink, 0, 30) . '...' : $githubLink;
                                                                echo '<a href="' . $githubLink . '" target="_blank" class="ms-1 text-decoration-underline" style="color:#2d6cdf;">' . $githubLinkDisplay . '</a>';
                                                            } ?>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </a>
                                        <!-- Remove old cus_title and move edit icon to bottom bar -->
                                        <div class="w-100 mt-auto" style="background:#e7e6fa; border-radius:0 0 18px 18px; padding:10px 0 8px 0; text-align:center; margin-top:-2px;">
                                            <span style="font-weight:500; color:#6c63ff; font-size:1rem; letter-spacing:0.5px; display:inline-flex; align-items:center; gap:18px;">
                                                <span style="display:inline-flex; align-items:center; gap:7px;">
                                                    <i class="fa-solid fa-diagram-project" style="font-size:1.1em;"></i>
                                                    <?php echo $project_row['project_type'] . ' (' . $project_row['program_type'] . ')'; ?>
                                                </span>
                                                <a href="tcr_std_project_card_edit.php?edit=<?php echo $project_row['id']; ?> " style="color:#2d6cdf; font-size:1.15em;" title="Edit"><i class="fa-regular fa-pen-to-square"></i></a>
                                            </span>
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