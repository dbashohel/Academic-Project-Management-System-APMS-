<?php
session_start();

include("includes/header.php");
include("includes/functions.php");

$student = isset($_SESSION["student"]) ? $_SESSION["student"] : null;
$user_role = isset($_SESSION["user_role"]) ? $_SESSION["user_role"] : null;
$teacher = isset($_SESSION["teacher"]) ? $_SESSION["teacher"] : null;
$user_email = isset($_SESSION["user_email"]) ? $_SESSION["user_email"] : null;
$user_role = $user_role;
$teachername = $teacher['tcr_name'];
$userid = ($user_role == 'student') ? $student['id'] : $teacher['id'];
$userrole = ($user_role == 'student') ? $student['user_role'] : $teacher['user_role'];

// Generate the navigation menu based on user role
if ($user_role == 'student') {
    generateNavMenu('student');
} elseif ($user_role == 'teacher') {
    generateNavMenu('teacher');
} else {
    generateNavMenu('admin');
}

?>

<?php
// Announcement add
// $addmessage = '';
// if (isset($_POST['upload_files'])) {
//     $project_stream_id = $_POST['project_stream_id'];
//     $user_role = $_POST['user_role'];

//     // Loop through each uploaded file
//     foreach ($_FILES['announce_file']['name'] as $key => $announce_file) {
//         $announce_tempname = $_FILES['announce_file']['tmp_name'][$key];
//         $announce_extension = pathinfo($announce_file, PATHINFO_EXTENSION);
//         $filename = uniqid() . "." . $announce_extension;
//         $announce_folder = "./uploads/projects/" . $filename;


//         // Uploading file and inserting record
//         if ($project_stream_id) {
//             if (move_uploaded_file($announce_tempname, $announce_folder)) {
//                 $addinsert = mysqli_query($con, "INSERT INTO stream_files (project_stream_id,user_role, file)
//                     VALUES ('$project_stream_id','$user_role','$filename')");
//             }
//         }
//     }

//     $addmessage = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
//                     <strong>Files uploaded successfully!</strong> 
//                     <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
//                 </div>";
// }
?>

<?php
// Announcement add
$addmessage = '';
if (isset($_POST['upload_files'])) {
    $project_stream_id = $_POST['project_stream_id'];
    $user_role = $_POST['user_role'];

    $max_file_size = 15 * 1024 * 1024; // 15MB in bytes
    $allowed_extensions = ['pdf', 'docx', 'pptx', 'jpg', 'jpeg', 'png', 'webp', 'gif']; // Allowed file types
    $file_error = false;

    // Loop through each uploaded file
    foreach ($_FILES['announce_file']['name'] as $key => $announce_file) {
        $announce_tempname = $_FILES['announce_file']['tmp_name'][$key];
        $announce_extension = strtolower(pathinfo($announce_file, PATHINFO_EXTENSION)); // Get file extension in lowercase
        $file_size = $_FILES['announce_file']['size'][$key];

        // Validate file type
        if (!in_array($announce_extension, $allowed_extensions)) {
            $addmessage = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                            <strong>Invalid file type!</strong> Allowed types: pdf, docx, pptx, jpg, jpeg, png, webp, gif. File: $announce_file
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                          </div>";
            $file_error = true;
            break;
        }

        // Validate file size
        if ($file_size > $max_file_size) {
            $addmessage = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                            <strong>File size exceeds 15MB!</strong> File: $announce_file
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                          </div>";
            $file_error = true;
            break;
        }

        // If no errors, upload the file and insert record
        $filename = uniqid() . "." . $announce_extension;
        $announce_folder = "./uploads/projects/" . $filename;

        if (!$file_error && $project_stream_id) {
            if (move_uploaded_file($announce_tempname, $announce_folder)) {
                $addinsert = mysqli_query($con, "INSERT INTO stream_files (project_stream_id, user_role, file)
                    VALUES ('$project_stream_id', '$user_role', '$filename')");
            }
        }
    }

    // Display success message if no errors occurred
    if (!$file_error) {
        $addmessage = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                        <strong>Files uploaded successfully!</strong> 
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
    }
}
?>


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
    } else {
        $erroremail = "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
        <strong>Something went wrong</strong>.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>" . mysqli_error($con);
    }
}
?>

<?php
if (isset($_GET['announce'])) {
    $announce_id = $_GET['announce'];
    $select_announce = "SELECT * FROM project_stream WHERE stream_id = '$announce_id'";
    $result_announce = mysqli_query($con, $select_announce);
    $project_announce = mysqli_fetch_assoc($result_announce);
}
?>

<?php
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $delete = "DELETE FROM stream_files WHERE id='$id'";
    $result = mysqli_query($con, $delete);
    if ($result) {

        $addmessage = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
            <strong>Project</strong> Data Deleted Successfully.
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>" . mysqli_error($con);
        echo "<meta http-equiv='refresh' content='0;url=tcr_std_project_stream_details.php?announce=$announce_id'>";
?>
<?php
    } else {
        echo "Failed" . mysqli_error($con);
    }
}

?>

<?php
if (isset($_GET['comment'])) {
    $id = $_GET['comment'];
    $comment = "DELETE FROM comments WHERE cmnts_id ='$id'";
    $result = mysqli_query($con, $comment);
    if ($result) {
        $addmessage = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Project</strong> Data Deleted Successfully.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>" . mysqli_error($con);
        echo "<meta http-equiv='refresh' content='0;url=tcr_std_project_stream_details.php?announce=$announce_id'>";
    } else {
        echo "Failed" . mysqli_error($con);
    }
}

?>



<?php
// Fetch files related to the announcement
$stream_query = "SELECT * FROM project_stream WHERE stream_id  = '$announce_id'";
$stream__result = mysqli_query($con, $stream_query);
$stream_file_available = mysqli_num_rows($stream__result) > 0;
// $file_project_stream = mysqli_fetch_assoc($stream__result);
?>

<?php
// Fetch files related to the announcement
$files_query = "SELECT * FROM stream_files WHERE project_stream_id = '$announce_id'";
$files_result = mysqli_query($con, $files_query);
$file_available = mysqli_num_rows($files_result) > 0;
$file_stream = mysqli_fetch_assoc($files_result)
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
                <h2>Announcement:</h2>
            </div>
            <?php echo $addmessage; ?>

            <div class="student-list pt-5">
                <div class="row g-6">
                    <div class="col-12">
                        <div class="stream_area">
                            <div class="stream_file d-flex flex-column gap-3 pb-4">
                                <div class="stream_card d-flex align-items-center justify-content-between w-100">
                                    <div class="d-flex gap-3 align-items-start w-100">
                                        <div class="icon-box d-flex align-items-center justify-content-center rounded-circle fs-5 box_12">
                                            <?php
                                            if ($file = $stream__result->fetch_assoc()) {
                                                $file_type = strtoupper(pathinfo($file['file'], PATHINFO_EXTENSION)); ?>
                                                <div class='d-flex p1_bg nw0_color gap-2 align-items-center justify-content-center rounded-circle fs-5 box_12 '>
                                                    <i class='fas <?= getFileIcon($file_type); ?>'></i>
                                                </div>
                                            <?php } else { ?>
                                                <div class='d-flex p1_bg nw0_color gap-2 align-items-center justify-content-center rounded-circle fs-5 box_12 '>
                                                    <i class='fa-solid fa-file'></i>
                                                </div>
                                            <?php  }
                                            ?>
                                        </div>
                                        <div class="works w-100">
                                            <div class="d-flex flex-wrap gap-3 align-items-center justify-content-between">
                                                <div class="d-flex gap-2 flex-column">
                                                    <h4><?= $teachername . ' - Create a New Announcement:' ?></h4>
                                                    <p class="fs-7 mb-0"><?= htmlspecialchars($project_announce['date']);
                                                                            ?></p>
                                                </div>
                                                <?php if ($user_role == 'teacher' || $user_role == 'admin') { ?>
                                                    <div class="add">
                                                        <button type="button" class="btn btn-primary rounded-3" data-bs-toggle="modal" data-bs-target="#addFileModal">
                                                            Add File
                                                        </button>
                                                    </div>
                                                <?php } ?>
                                            </div>

                                            <div class="files_area border-top mt-4 pt-4">
                                                <?php if ($stream_file_available): ?>
                                                    <div class="d-flex flex-wrap gap-3">
                                                        <?php
                                                        mysqli_data_seek($stream__result, 0);
                                                        while ($sfile = mysqli_fetch_assoc($stream__result)):
                                                            $file_array = json_decode($sfile['file'], true);

                                                            if (!empty($file_array)) {
                                                                foreach ($file_array as $file): ?>
                                                                    <div class="announce_file shadow1 rounded-2 overflow-hidden">
                                                                        <a href="./uploads/projects/<?= htmlspecialchars($file); ?>" class="announce_main_img h-100" target="_blank">
                                                                            <div class="file_show">
                                                                                <embed width="100%" height="100%" class="overflow-hidden" src="./uploads/projects/<?= htmlspecialchars($file); ?>">
                                                                            </div>
                                                                        </a>
                                                                        <!-- Delete icon for each file -->
                                                                        <!-- <a href="tcr_std_project_stream_details.php?announce=<? //= $announce_id 
                                                                                                                                    ?>&delete=<? //= $file 
                                                                                                                                                ?>"
                                                                            onclick="return confirm('Are you sure you want to delete this file?');"
                                                                            class="announce_file_delete">
                                                                            <i class="fa-solid fa-trash-can"></i>
                                                                        </a> -->
                                                                    </div>
                                                        <?php endforeach;
                                                            }
                                                        endwhile; ?>
                                                    </div>
                                                <?php endif; ?>

                                                <?php if ($file_available): ?>
                                                    <div class="d-flex flex-wrap gap-3 mt-3">
                                                        <?php
                                                        mysqli_data_seek($files_result, 0);
                                                        while ($file = mysqli_fetch_assoc($files_result)): ?>
                                                            <div class="announce_file shadow1 rounded-2 overflow-hidden">
                                                                <a href="./uploads/projects/<?= htmlspecialchars($file['file']); ?>" class="announce_main_img h-100" target="_blank">
                                                                    <div class="file_show">
                                                                        <embed width="100%" height="100%" class="overflow-hidden" src="./uploads/projects/<?= htmlspecialchars($file['file']); ?>">
                                                                        <?php if (!empty($file['file_title'])): ?>
                                                                            <h5 class="p-2 text-center"><?= htmlspecialchars($file['file_title']); ?></h5>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                </a>
                                                                <?php if ($user_role == 'teacher' || $user_role == 'admin') { ?>
                                                                    <a href="tcr_std_project_stream_details.php?announce=<?= $announce_id ?>&delete=<?= $file['id']; ?>"
                                                                        onclick="return confirm('Are you sure you want to delete this data?');"
                                                                        class="announce_file_delete">
                                                                        <i class="fa-solid fa-trash-can"></i>
                                                                    </a>
                                                                <?php } ?>
                                                            </div>
                                                        <?php endwhile; ?>
                                                    </div>
                                                <?php endif; ?>

                                            </div>

                                            <p class="fs-7 mb-0 border-top mt-4 pt-4"><?= htmlspecialchars($project_announce['stream_content']); ?></p> <!-- Display stream content -->


                                            <div class="comments_area border-top mt-4 pt-4">
                                                <h5 class="mb-4 text-decoration-underline">Add comments:</h5>
                                                <div class="comments_group d-flex flex-column gap-4">
                                                    <?php
                                                    $comments_query = "SELECT * FROM comments WHERE stream_id = '$announce_id'";
                                                    $comments_result = mysqli_query($con, $comments_query);

                                                    while ($stream_comments = mysqli_fetch_assoc($comments_result)) {
                                                        $formatted_time = date('h:i A', strtotime($stream_comments['date']));
                                                        $formatted_date = date('F j, Y', strtotime($stream_comments['date']));
                                                        $user_id = $stream_comments['user_id'];
                                                        $user_role = $stream_comments['user_role'];
                                                        $get_id = $user_role === 'student' ?
                                                            "SELECT * FROM std_registration WHERE id = '$user_id'" :
                                                            "SELECT * FROM tcr_registration WHERE id = '$user_id'";
                                                        $run_id = mysqli_query($con, $get_id);

                                                        if ($run_id && mysqli_num_rows($run_id) > 0) {
                                                            while ($user_table_id = mysqli_fetch_assoc($run_id)) {
                                                                $name = $user_role === 'student' ? $user_table_id['std_name'] : $user_table_id['tcr_name'];
                                                                $image = $user_role === 'student' ? $user_table_id['std_img'] : $user_table_id['tcr_img'];
                                                    ?>
                                                                <div class="comments_part d-flex gap-1 align-items-center justify-content-between w-100">
                                                                    <div class="comment-item d-flex gap-4 pt-4 pe-5">
                                                                        <div class="user_img box_12">
                                                                            <img src="./uploads/students/<?= htmlspecialchars($image); ?>" class="rounded-circle" alt="User image">
                                                                        </div>
                                                                        <div class="d-flex flex-column gap-3">
                                                                            <div class="d-flex gap-2">
                                                                                <h6 class="comm_user"><?= htmlspecialchars($name); ?></h6>
                                                                                <span class="fs-eight mb-0"><?= $formatted_time; ?> on <?= $formatted_date; ?></span>
                                                                            </div>
                                                                            <p class="mb-0"><?= htmlspecialchars($stream_comments['comments']); ?></p>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                    if (($stream_comments['user_id'] == $userid) && ($stream_comments['user_role'] == $userrole)) {
                                                                    ?>
                                                                        <div class="threedot position-relative d-center">
                                                                            <span class="action_setting shadow2 rounded-2 box_10 d-center"><i class="fa-solid fa-ellipsis-vertical "></i></span>
                                                                            <div class="action_drop rounded-3 ">
                                                                                <div class=" d-center flex-column gap-2">
                                                                                    <a href="tcr_std_project_comments_edit.php?announce=<?= $announce_id ?>&comment=<?= $stream_comments['cmnts_id']; ?>">
                                                                                        <i class="fa-regular fa-pen-to-square"></i>
                                                                                    </a>
                                                                                    <a href="tcr_std_project_stream_details.php?announce=<?= $announce_id ?>&comment=<?= $stream_comments['cmnts_id']; ?>" onclick="return confirm('Are you sure you want to delete this data?');">
                                                                                        <i class="fa-solid fa-trash"></i>
                                                                                    </a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    <?php }
                                                                    ?>


                                                                </div>
                                                    <?php
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                </div>

                                                <div class="message_box">
                                                    <?php if (isset($message)) echo $message; ?>
                                                    <?php if (isset($erroremail)) echo $erroremail; ?>
                                                </div>

                                                <form method="POST" class="form-inline d-flex gap-0 align-items-center border border-color rounded-3 mt-4">
                                                    <div class="form-group d-flex rounded-3 gap-2 p-2 w-100">
                                                        <input type="text" class="form-control border-none w-100" name="comments" placeholder="Your comments" required />
                                                        <input type="hidden" name="stream_id" value="<?= htmlspecialchars($announce_id); ?>" />
                                                        <input type="hidden" name="user_id" value="<?= htmlspecialchars($userid); ?>" />
                                                        <input type="hidden" name="user_role" value="<?= htmlspecialchars($userrole); ?>" />
                                                        <button type="submit" class="btn btn-default p1_bg nw0_color" name="comments_submit">Add</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addFileModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Announcement:</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form method="POST" class="mt-3" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label" for="announce_file">File Upload</label>
                        <input type="file" class="form-control" id="announce_file" name="announce_file[]" multiple required>
                    </div>
                    <small class="text-muted">Allowed file types: PDF, DOCX, PPTX, JPG, JPEG, PNG, GIF. Maximum size: 15MB per file.</small>
                    <div class="mb-3 d-none">
                        <label class="form-label">Project Stream ID</label>
                        <input type="text" class="form-control" name="project_stream_id" value="<?php echo $announce_id; ?>" readonly>
                    </div>
                    <div class="mb-3 d-none">
                        <label class="form-label">user_role</label>
                        <input type="text" class="form-control" name="user_role" value="<?php echo $teacher['user_role']; ?>" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="upload_files" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>


<?php include("includes/footer.php"); ?>