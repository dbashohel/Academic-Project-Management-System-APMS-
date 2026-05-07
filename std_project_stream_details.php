<?php
session_start();

include("includes/header.php");
include("includes/functions.php");

if (!isset($_SESSION["std_id"]) || !isset($_SESSION["user_role"])) {
    header("Location: login.php");
    exit;
}


$student = $_SESSION["student"];
$std_id = $_SESSION["std_id"];
$user_role = $_SESSION["user_role"];

if ($user_role == 'student') {
    generateNavMenu('student');
}


// $query = "SELECT * FROM std_registration WHERE std_id = '$std_id'";
// $result = mysqli_query($con, $query);

// if (!$result) {
//     die("Error: " . mysqli_error($con));
// }
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
if (isset($_GET['comments'])) {
    $comments_id = $_GET['comments'];
    $get_data = "SELECT * FROM project_stream WHERE stream_id ='$comments_id'";
    $result = mysqli_query($con, $get_data);
    $stream_id_show = mysqli_fetch_array($result);
    $stream_id  = $stream_id_show['stream_id'];
    // $proj_ids  = $stream_id_show['project_id'];
}
?>

<style>
    .main_page.std_pro_info .table tr td {
        padding: 16px 12px;
    }

    .form-inline {
        width: 70%;
    }
</style>

<div class="main_page std_pro_info">
    <div class="content-area">
        <div class="container-fluid">
            <div class="row">
                <h2> Announcement:</h2>
            </div>
            <!-- Show Teacher -->
            <!-- <div class="student-list pt-5"> -->
            <?php
            $project_query = "SELECT * FROM std_project_reg WHERE FIND_IN_SET('$std_id', std_id_multiple) AND status = 'approved'";
            $project_result = mysqli_query($con, $project_query);

            if (mysqli_num_rows($project_result) > 0) :
                while ($project = mysqli_fetch_assoc($project_result)) : ?>
                    <div class="row g-6 mt-5">
                        <div class="col-12">
                            <div class="stream_area">
                                

                                <div class="stream_file d-flex flex-column gap-3 pb-4">
                                    <?php
                                    $files_query = "SELECT * FROM project_stream WHERE stream_id = '$stream_id'";
                                    $files_result = mysqli_query($con, $files_query);

                                    while ($stream_file = mysqli_fetch_assoc($files_result)) {
                                        $file_type = strtoupper(pathinfo($stream_file['stream_file'], PATHINFO_EXTENSION)); ?>

                                        <div class="stream_card d-flex align-items-center justify-content-between  w-100 ">
                                            <div class="d-flex gap-3  align-items-start w-100">
                                                <div class='d-flex p1_bg nw0_color gap-2 align-items-center justify-content-center rounded-circle fs-5 box_12 '>
                                                    <i class='fas <?= getFileIcon($file_type); ?>'></i>
                                                </div>
                                                <div class="works w-100">
                                                    <div class="d-flex gap-2 flex-column">
                                                        <h2 class=""><?= $stream_file['stream_content']; ?></h2>
                                                        <p class="fs-7 mb-0"><?= $stream_file['date']; ?></p>
                                                    </div>
                                                    <div class="comments_area border-top mt-4 pt-4">
                                                        <h5 class="mb-4 text-decoration-underline "> Add comments: </h5>
                                                        <div class="comments_part d-flex flex-column gap-4">
                                                            <?php
                                                            $comments_query = "SELECT * FROM comments WHERE stream_id = '$stream_id'";
                                                            $comments_result = mysqli_query($con, $comments_query);

                                                            while ($stream_comments = mysqli_fetch_assoc($comments_result)) {
                                                                $formatted_time = date('h:i A', strtotime($stream_comments['date']));
                                                                $formatted_date = date('F j, Y', strtotime($stream_comments['date']));
                                                                $user_id = $stream_comments['user_id'];
                                                                $user_role = $stream_comments['user_role'];

                                                                // Determine table based on user role
                                                                if ($user_role == 'student') {
                                                                    $get_id = "SELECT * FROM std_registration WHERE id = '$user_id'";
                                                                } else {
                                                                    $get_id = "SELECT * FROM tcr_registration WHERE id = '$user_id'";
                                                                }

                                                                // Execute the query to get user details
                                                                if ($run_id = mysqli_query($con, $get_id)) {
                                                                    if (mysqli_num_rows($run_id) > 0) {
                                                                        while ($user_table_id = mysqli_fetch_array($run_id)) {
                                                                            $name = ($user_role == 'student') ? $user_table_id['std_name'] : $user_table_id['tcr_name'];
                                                                            $image = ($user_role == 'student') ? $user_table_id['std_img'] : $user_table_id['tcr_img'];
                                                            ?>
                                                                            <div class='border_first_child_none pt-4 d-flex gap-4 flex-wrap'>
                                                                                <div class="user_img box_12">
                                                                                    <img src="./uploads/students/<?= htmlspecialchars($image); ?>" class=" rounded-circle" alt="img">
                                                                                </div>
                                                                                <div class="d-flex flex-column gap-3">
                                                                                    <div class="d-flex gap-2 ">
                                                                                        <h6 class="comm_user"><?= htmlspecialchars($name); ?></h6>
                                                                                        <span class="fs-eight mb-0"><?= $formatted_time; ?> on <?= $formatted_date; ?></span>
                                                                                    </div>
                                                                                    <p class="mb-0"><?= $stream_comments['comments']; ?></p>
                                                                                </div>
                                                                            </div>
                                                                <?php
                                                                        }
                                                                    }
                                                                }
                                                                ?>


                                                            <?php } ?>
                                                        </div>
                                                        <?php

                                                        if (isset($_POST['comments_submit'])) {
                                                            $comments = $_POST['comments'];
                                                            $stream_id = $_POST['stream_id'];
                                                            $user_id = $_POST['user_id'];
                                                            $user_role = $_POST['user_role'];

                                                            // Sanitize inputs to prevent SQL injection
                                                            $comments = mysqli_real_escape_string($con, $comments);
                                                            $stream_id = mysqli_real_escape_string($con, $stream_id);
                                                            $user_id = mysqli_real_escape_string($con, $user_id);

                                                            $insert = mysqli_query($con, "INSERT INTO comments (comments, stream_id, user_id, user_role, date) VALUES ('$comments', '$stream_id', '$user_id','$user_role', NOW())");

                                                            if ($insert) {
                                                                $message = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                                                                <strong> Comment Successfully Submitted</strong>.
                                                                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                                            </div>";
                                                            echo "<meta http-equiv='refresh' content='1;url=std_project_stream_details.php?comments=" . $stream_file['stream_id'] . "'>";

                                                            } else {
                                                                $erroremail = "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                                                                <strong>Something went wrong</strong>.
                                                                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                                            </div>" . mysqli_error($con);
                                                            }
                                                        }
                                                        ?>

                                                        <div class="message_box">
                                                            <?php
                                                            if (isset($message)) {
                                                                echo $message;
                                                            } elseif (isset($erroremail)) {
                                                                echo $erroremail;
                                                            }
                                                            ?>
                                                        </div>
                                                        <form method="POST" class="form-inline comment_form d-flex gap-0 align-items-center border border-color rounded-3 mt-4" role="form">
                                                            <div class="form-group d-flex rounded-3 gap-2 p-2 w-100">
                                                                <input type="text" class="form-control border-none w-100" name="comments" placeholder="Your comments" required />
                                                                <input type="hidden" class="form-control border-none w-100" name="stream_id" value="<?= htmlspecialchars($stream_file['stream_id']) ?>" readonly />
                                                                <input type="hidden" class="form-control border-none w-100" name="user_id" value="<?= htmlspecialchars($student['id']); ?>" readonly />
                                                                <input type="hidden" class="form-control border-none w-100" name="user_role" value="<?= htmlspecialchars($student['user_role']); ?>" readonly />
                                                                <button type="submit" class="btn btn-default p1_bg nw0_color" name="comments_submit">Add</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>




                                    <?php } ?>
                                </div>

                            </div>
                        </div>
                    </div>

            <?php
                endwhile;
            endif;
            ?>
        </div>
    </div>
</div>


<?php include("includes/footer.php"); ?>