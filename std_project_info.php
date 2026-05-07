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
$student_id = $student['id'];

if ($user_role == 'student') {
    generateNavMenu('student');
}

$tab = 'stream';
if (isset($_GET["tab"]) && in_array($_GET["tab"], ['stream', 'overview', 'result', 'team'])) {
    $tab = $_GET["tab"];
}

?>


<?php
// $erroremail = "";
// if (isset($_POST['upload_content'])) {
//     $overview_content = $_POST['overview_content'];
//     $project_id = $_POST['project_id'];
//     $user_id = $_POST['user_id'];

//     if ($project_id && $user_id) {
//         $uploaded_files = [];

//         // Check if files are uploaded and handle errors
//         if (isset($_FILES['overview_file']['name']) && count($_FILES['overview_file']['name']) > 0) {
//             foreach ($_FILES['overview_file']['name'] as $key => $overview_file) {
//                 $overview_tempname = $_FILES['overview_file']['tmp_name'][$key];
//                 $overview_extension = pathinfo($overview_file, PATHINFO_EXTENSION);
//                 $filename = uniqid() . "." . $overview_extension;
//                 $overview_folder = "./uploads/projects/" . $filename;

//                 if (move_uploaded_file($overview_tempname, $overview_folder)) {
//                     $uploaded_files[] = $filename;
//                 }
//             }
//         }

//         // Convert uploaded files to JSON format
//         $uploaded_files_json = json_encode($uploaded_files);

//         // Execute the insert query
//         $addinsert = mysqli_query($con, "INSERT INTO porject_overview (project_id, student_id, overview_content, file, date)
//                 VALUES ('$project_id', '$user_id', '$overview_content', '$uploaded_files_json', NOW())");

//         if ($addinsert) {
//             $erroremail = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
//                         <strong>Successfully Added!</strong> 
//                         <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
//                     </div>";
//         } else {
//             $erroremail = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
//                         <strong>Database Error: " . mysqli_error($con) . "</strong> 
//                         <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
//                     </div>";
//         }
//     } else {
//         $erroremail = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
//                     <strong>Failed! Project ID or User ID is missing.</strong> 
//                     <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
//                 </div>";
//     }
// }
?>

<?php
$erroremail = "";
if (isset($_POST['upload_content'])) {
    $overview_content = $_POST['overview_content'];
    $project_id = $_POST['project_id'];
    $user_id = $_POST['user_id'];

    if ($project_id && $user_id) {
        $uploaded_files = [];
        $max_file_size = 15 * 1024 * 1024; // 15MB in bytes
        $allowed_extensions = ['pdf', 'docx', 'pptx', 'jpg', 'jpeg', 'png', 'webp', 'gif']; // Allowed file types
        $file_error = false;

        // Check if files are uploaded and handle errors
        if (isset($_FILES['overview_file']['name']) && count($_FILES['overview_file']['name']) > 0) {
            foreach ($_FILES['overview_file']['name'] as $key => $overview_file) {
                $overview_tempname = $_FILES['overview_file']['tmp_name'][$key];
                $overview_extension = strtolower(pathinfo($overview_file, PATHINFO_EXTENSION)); // Convert extension to lowercase
                $file_size = $_FILES['overview_file']['size'][$key];

                // Check if the file extension is allowed
                if (!in_array($overview_extension, $allowed_extensions)) {
                    $erroremail = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                    <strong>Invalid file type!</strong> Allowed types: pdf, docx, pptx, jpg, jpeg, png, webp, gif. File: $overview_file
                                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                  </div>";
                    $file_error = true;
                    break; // Stop processing further files if one is invalid
                }

                // Check if file size exceeds the limit
                if ($file_size > $max_file_size) {
                    $erroremail = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                    <strong>File size exceeds 15MB!</strong> File: $overview_file
                                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                  </div>";
                    $file_error = true;
                    break; // Stop processing further files if one exceeds the size limit
                }

                $filename = uniqid() . "." . $overview_extension;
                $overview_folder = "./uploads/projects/" . $filename;

                if (move_uploaded_file($overview_tempname, $overview_folder)) {
                    $uploaded_files[] = $filename;
                }
            }
        }

        if (!$file_error) {
            // Convert uploaded files to JSON format
            $uploaded_files_json = json_encode($uploaded_files);

            // Execute the insert query
            $addinsert = mysqli_query($con, "INSERT INTO porject_overview (project_id, student_id, overview_content, file, date)
                    VALUES ('$project_id', '$user_id', '$overview_content', '$uploaded_files_json', NOW())");

            if ($addinsert) {
                $erroremail = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                            <strong>Successfully Added!</strong> 
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>";
            } else {
                $erroremail = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                            <strong>Database Error: " . mysqli_error($con) . "</strong> 
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>";
            }
        }
    } else {
        $erroremail = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    <strong>Failed! Project ID or User ID is missing.</strong> 
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
    }
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



if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $delete = "DELETE FROM porject_overview WHERE id ='$id'";
    $result = mysqli_query($con, $delete);
    if ($result) {
        $erroremail = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Successfully Delete!</strong> 
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>";
        echo "<meta http-equiv='refresh' content='2;url=std_project_info.php'>";


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
?>
        <div class="alert alert-success">
            <strong>Comment</strong> Data Deleted Successfully.
        </div>
<?php
    } else {
        echo "Failed" . mysqli_error($con);
    }
}

?>



<style>
    .main_page.std_pro_info .table tr td {
        padding: 16px 12px;
    }
</style>
<?php


if (isset($_POST['grade_submit_btn'])) {
    $grade = json_encode($_POST['grade']);
    $grade_point = json_encode($_POST['grade_point']);
    $remarks = json_encode($_POST['remarks']);

    $project_update_qry = "UPDATE std_project_reg SET grade = '$grade', grade_point = '$grade_point', remarks = '$remarks' WHERE id='$proj_id'";
    $update_result = mysqli_query($con, $project_update_qry);
}
?>

<div class="main_page std_pro_info">
    <div class="content-area ">
        <div class="container-fluid">
            <!-- Show Teacher -->
            <!-- <div class="student-list pt-5"> -->
            <?php
            $project_query = "SELECT * FROM std_project_reg WHERE FIND_IN_SET('$std_id', std_id_multiple)  AND status = 'approved'";
            $project_result = mysqli_query($con, $project_query);


            if (mysqli_num_rows($project_result) > 0) { ?>

                <div class="row details_bar mb-10 mb-lg-12 mb-xxl-15">
                    <div class="d-flex flex-wrap gap-4 row-gap-8 justify-content-center justify-content-md-between align-items-center">
                        <div class="d-flex gap-3 flex-wrap border-bottom w-100">
                            <button class="cmn-btn tab_button <?= $tab == 'stream' ? 'active' : '' ?>"
                                data-tab="project_stream">Stream</button>
                            <button class="cmn-btn tab_button <?= $tab == 'overview' ? 'active' : '' ?>"
                                data-tab="project_file">Porject Overview</button>
                            <button class="cmn-btn tab_button <?= $tab == 'team' ? 'active' : '' ?>"
                                data-tab="project_team">Team</button>
                        </div>
                    </div>
                </div>

                <?php while ($project = mysqli_fetch_assoc($project_result)) :
                    $user_email = $project['tcr_user_email'];
                    $project_id = $project['id'];


                    $query = "SELECT * FROM tcr_registration  WHERE user_email = '$user_email'";
                    $teacher_find = mysqli_query($con, $query);
                    $teacher = mysqli_fetch_assoc($teacher_find);

                    // if (mysqli_num_rows($teacher_find) > 0) {
                    // }

                ?>
                    <div class="row g-6 mt-5">
                        <div class="tab_content project_stream <?= $tab == 'stream' ? 'active' : '' ?>">
                            <div class="row">
                                <div class="col-12">
                                    <div class="stream_area">
                                        <div class="mb-4 d-flex justify-content-between align-items-center">
                                            <h2>Announcement:</h2>
                                        </div>
                                        <?php echo $erroremail; ?>
                                        <div class="stream_file d-flex flex-column gap-3">
                                            <?php
                                            $files_query = "SELECT * FROM project_stream ORDER BY stream_id DESC";
                                            $files_result = mysqli_query($con, $files_query);
                                            if (mysqli_num_rows($files_result) > 0) {
                                                while ($stream_file = mysqli_fetch_assoc($files_result)) {
                                                    $file_type = strtoupper(pathinfo($stream_file['file'], PATHINFO_EXTENSION));

                                                    $file_names_json = $stream_file['file']; // Assuming JSON-encoded file names
                                                    $file_names = json_decode($file_names_json, true); // Decode JSON to array

                                                    $file_extensions = []; // Array to hold extensions

                                                    if (is_array($file_names)) {
                                                        foreach ($file_names as $file_name) {
                                                            $file_extensions[] = pathinfo($file_name, PATHINFO_EXTENSION); // Extract file extension
                                                        }
                                                    }
                                                    $extensions_display = implode(', ', $file_extensions);

                                            ?>
                                                    <div class="stream_card" data-stream-id="<?php echo $stream_file['stream_id']; ?>">
                                                        <!-- Your HTML content -->
                                                        <div class="stream_card pointer d-flex align-items-center justify-content-between w-100 border p-4 rounded-3 ">
                                                            <div class="d-flex gap-3  align-items-center">
                                                                <div class='d-flex p1_bg nw0_color gap-2 align-items-center justify-content-center rounded-circle fs-5 box_12 '>
                                                                    <i class='fas <?= getFileIcon($file_type); ?>'></i>
                                                                </div>
                                                                <div class="d-flex gap-2 flex-column">
                                                                    <h6 class=""><?= $teacher['tcr_name'] . ' Teacher - Create a New Announcement: ' . $extensions_display; ?></h6>
                                                                    <p class="fs-7 mb-0"><?= $stream_file['date']; ?></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <script>
                                                        $(".stream_card").on("click", function() {
                                                            var streamId = $(this).data("stream-id");
                                                            window.location.href = 'tcr_std_project_stream_details.php?announce=' + streamId;
                                                        });

                                                        $(".stream_card .threedot").on("click", function(event) {
                                                            event.stopPropagation();
                                                        });
                                                    </script>

                                            <?php }
                                            }
                                            ?>
                                            <script>
                                                function confirmDelete(id) {
                                                    if (confirm('Are you sure you want to delete this data?')) {
                                                        window.location.href = 'tcr_std_project_card_details.php?delete=' + id;
                                                    }
                                                }
                                            </script>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab_content project_file <?= $tab == 'overview' ? 'active' : '' ?>">
                            <div class="row">
                                <div class="col-12">
                                    <div class="overview_area">
                                        <div class="mb-4 d-flex justify-content-between align-items-center">
                                            <h2>Project Overview:</h2>
                                            <button type="button" class="btn btn-primary rounded-3" data-bs-toggle="modal" data-bs-target="#addFileModal">
                                                Project Overview
                                            </button>
                                        </div>
                                        <?php echo $erroremail; ?>
                                        <div class="overview_file d-flex flex-column gap-3">
                                            <?php
                                            $files_query = "SELECT * FROM porject_overview ORDER BY id DESC";
                                            $files_result = mysqli_query($con, $files_query);
                                            if (mysqli_num_rows($files_result) > 0) {
                                                while ($overview_file = mysqli_fetch_assoc($files_result)) {
                                                    $file_type = strtoupper(pathinfo($overview_file['file'], PATHINFO_EXTENSION));

                                                    
                                                    $file_names_json = $overview_file['file']; // Assuming JSON-encoded file names
                                                    $file_names = json_decode($file_names_json, true); // Decode JSON to array

                                                    $file_extensions = []; // Array to hold extensions

                                                    if (is_array($file_names)) {
                                                        foreach ($file_names as $file_name) {
                                                            $file_extensions[] = pathinfo($file_name, PATHINFO_EXTENSION); // Extract file extension
                                                        }
                                                    }
                                                    $extensions_display = implode(', ', $file_extensions);
                                            ?>
                                                    <div class="overview_card" data-overview-id="<?php echo $overview_file['id']; ?>">
                                                        <!-- Your HTML content -->
                                                        <div class="pointer d-flex align-items-center justify-content-between w-100 border p-4 rounded-3 ">
                                                            <div class="d-flex gap-3  align-items-center">
                                                                <div class='d-flex p1_bg nw0_color gap-2 align-items-center justify-content-center rounded-circle fs-5 box_12 '>
                                                                    <i class='fas <?= getFileIcon($file_type); ?>'></i>
                                                                </div>
                                                                <div class="d-flex gap-2 flex-column">
                                                                    <?php
                                                                    $std_id = $overview_file['student_id'];
                                                                    $get_std = "SELECT * FROM std_registration WHERE id = $std_id";
                                                                    if ($run_std = mysqli_query($con, $get_std)) {
                                                                        if (mysqli_num_rows($run_std) > 0) {
                                                                            $student = mysqli_fetch_array($run_std); ?>
                                                                            <h6 class=""><?= $student['std_name'] . ' - Create a New Post: ' . $extensions_display; ?></h6>
                                                                    <?php }
                                                                    } ?>
                                                                    <!-- <h6 class="">Student Create a New Post:</h6> -->
                                                                    <p class="fs-7 mb-0"><?= $overview_file['date']; ?></p>
                                                                </div>
                                                            </div>
                                                            <div class="threedot position-relative d-center">
                                                                <span class="action_setting shadow2 rounded-2 box_10 d-center"><i class="fa-solid fa-ellipsis-vertical "></i></span>
                                                                <div class="action_drop rounded-3 ">
                                                                    <div class=" d-center flex-column gap-2">


                                                                        <a href="tcr_std_project_overview_edit.php?overview=<?= $overview_file['id'] ?>">
                                                                            <i class="fa-regular fa-pen-to-square"></i>
                                                                        </a>
                                                                        <a href="std_project_info.php?&delete=<?= $overview_file['id']; ?>" onclick="return confirm('Are you sure you want to delete this data?');">
                                                                            <i class="fa-solid fa-trash"></i>
                                                                        </a>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <script>
                                                        $(".overview_card").on("click", function() {
                                                            var overviewId = $(this).data("overview-id");
                                                            window.location.href = 'tcr_std_project_overview_details.php?overview=' + overviewId;
                                                        });

                                                        $(".overview_card .threedot").on("click", function(event) {
                                                            event.stopPropagation();
                                                        });
                                                    </script>
                                            <?php }
                                            } else {
                                                echo "
                                                <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                                                    <strong>No files found for this project.</strong> 
                                                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                                </div>";
                                            }
                                            ?>
                                            <script>
                                                function confirmDelete(id) {
                                                    if (confirm('Are you sure you want to delete this data?')) {
                                                        window.location.href = 'tcr_std_project_card_details.php?delete=' + id;
                                                    }
                                                }
                                            </script>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab_content project_team <?= $tab == 'team' ? 'active' : '' ?>">
                            <div class="row">
                                <div class="col-lg-10">
                                    <div class="shadow1 border-color rounded-3 p-3 p-lg-5">
                                        <div class="supervisor">
                                            <h4 class="fs-one fw-semibold mb-4 text-decoration-underline ">Supervisor</h4>
                                            <?php
                                            $get_std = "SELECT * FROM tcr_registration WHERE user_email = '$user_email' ";
                                            if ($run_std = mysqli_query($con, $get_std)) {
                                                if (mysqli_num_rows($run_std) > 0) {
                                                    while ($teacher = mysqli_fetch_array($run_std)) { ?>
                                                        <div class='divider  d-flex gap-4 flex-wrap align-items-center pb-5 mb-5'>
                                                            <div class="user_img box_12">
                                                                <img src="./uploads/teachers/<?= $teacher['tcr_img']; ?>" class=" rounded-circle" alt="img">
                                                            </div>
                                                            <div class='d-flex flex-column'>
                                                                <?php
                                                                echo "<span class='mb-1'>{$teacher['tcr_name']}</span>";
                                                                echo "<span class='mb-1'>{$teacher['phone']}</span>";
                                                                echo "<span class='mb-1'>{$teacher['user_email']}</span>";
                                                                // echo "<span class='mb-1'>{$teacher['interest_field']}</span>";
                                                                // echo "<span class='mb-1'>{$teacher['designation']}</span>";
                                                                ?>
                                                            </div>
                                                            <!-- <a class="btn btn-primary ms-auto rounded-3" href="std_more_infor.php?show=<?php echo $student['id'] ?>"><i class="fa-solid fa-eye"></i></a> -->
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
                                                            <!-- <a class="btn btn-primary ms-auto rounded-3" href="std_more_infor.php?show=<?php echo $student['std_id'] ?>"><i class="fa-solid fa-eye"></i></a> -->
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


<!-- HTML Form -->
<div class="modal fade" id="addFileModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Project Overview:</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form method="POST" class="mt-3" enctype="multipart/form-data">
                <div class="modal-body">
                    <?php echo $erroremail; ?> <!-- Display success/error messages here -->

                    <div class="mb-3">
                        <label class="form-label" for="overview_file">File Upload</label>
                        <input type="file" class="form-control" id="overview_file" name="overview_file[]" multiple required>
                    </div>
                    <small class="text-muted">Allowed file types: PDF, DOCX, PPTX, JPG, JPEG, PNG, GIF. Maximum size: 15MB per file.</small>
                    <div class="mb-3">
                        <label class="form-label" for="overview_content">Post</label>
                        <textarea name="overview_content" class="form-control" id="overview_content" rows="5"></textarea>
                    </div>
                    <div class="mb-3 d-none">
                        <label class="form-label">Student</label>
                        <input type="text" class="form-control" name="user_id" value="<?php echo htmlspecialchars($student_id); ?>" readonly>
                    </div>
                    <div class="mb-3 d-none">
                        <label class="form-label">Project ID</label>
                        <input type="text" class="form-control" name="project_id" value="<?php echo  $project_id; ?>" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="upload_content" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>


<?php include("includes/footer.php"); ?>