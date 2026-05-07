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
$tab = 'stream';
if (isset($_GET["tab"]) && in_array($_GET["tab"], ['stream', 'overview', 'result', 'team'])) {
    $tab = $_GET["tab"];
}

// stream_content
$erroremail = "";
if (isset($_POST['upload_content'])) {
    $stream_content = $_POST['stream_content'];
    $project_id = $_POST['project_id'];
    $user_id = $_POST['user_id'];

    if ($project_id && $user_id) {
        $uploaded_files = [];
        $max_file_size = 15 * 1024 * 1024; // 15MB in bytes
        $allowed_extensions = ['pdf', 'docx', 'pptx', 'jpg', 'jpeg', 'png', 'WebP', 'gif']; // Allowed file types
        $file_error = false;

        foreach ($_FILES['announce_file']['name'] as $key => $announce_file) {
            $announce_tempname = $_FILES['announce_file']['tmp_name'][$key];
            $announce_extension = strtolower(pathinfo($announce_file, PATHINFO_EXTENSION)); // Get file extension
            $file_size = $_FILES['announce_file']['size'][$key];

            // Check file type
            if (!in_array($announce_extension, $allowed_extensions)) {
                $erroremail = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                <strong>Invalid file type!</strong> Allowed types: pdf, docx, pptx, jpg, jpeg, png, WebP, gif. File: $announce_file
                                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                              </div>";
                $file_error = true;
                break; // Stop processing further files if one is invalid
            }

            // Check file size
            if ($file_size > $max_file_size) {
                $erroremail = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                <strong>File size exceeds 15MB!</strong> File: $announce_file
                                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                              </div>";
                $file_error = true;
                break; // Stop processing further files if one exceeds the size limit
            }

            $filename = uniqid() . "." . $announce_extension;
            $announce_folder = "./uploads/projects/" . $filename;

            if (move_uploaded_file($announce_tempname, $announce_folder)) {
                $uploaded_files[] = $filename;
            }
        }

        if (!$file_error) {
            $uploaded_files_json = json_encode($uploaded_files);

            $addinsert = mysqli_query($con, "INSERT INTO project_stream (project_id, tcr_reg_id, stream_content, file, date)
                    VALUES ('$project_id', '$user_id', '$stream_content', '$uploaded_files_json', NOW())");

            if ($addinsert) {
                $erroremail = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                            <strong>Successfully Added!</strong> 
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>";
            } else {
                $erroremail = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                            <strong>Failed to save to database!</strong> 
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
    $delete = "DELETE FROM project_stream WHERE stream_id ='$id'";
    $result = mysqli_query($con, $delete);
    if ($result) {
        $erroremail = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Successfully Delete!</strong> 
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>";
        echo "<meta http-equiv='refresh' content='2;url=tcr_std_project_details.php?project=" . $proj_id . "'>";


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

    $project_update_qry = "UPDATE std_project_reg SET grade = '$grade', is_submitted = '1', grade_point = '$grade_point', remarks = '$remarks' WHERE id='$proj_id'";
    $update_result = mysqli_query($con, $project_update_qry);
}
?>

<div class="main_page std_pro_info">
    <div class="content-area ">
        <div class="container-fluid">
            <!-- Show Teacher -->
            <!-- <div class="student-list pt-5"> -->
            <?php
            $project_query = "SELECT * FROM std_project_reg WHERE FIND_IN_SET('$user_email', tcr_user_email) AND id = '$proj_id' AND status = 'approved'";
            $project_result = mysqli_query($con, $project_query);

            if (mysqli_num_rows($project_result) > 0) {
            ?>

                <div class="row details_bar mb-10 mb-lg-12 mb-xxl-15">
                    <div class="d-flex flex-wrap gap-4 row-gap-8 justify-content-center justify-content-md-between align-items-center">
                        <div class="d-flex gap-3 flex-wrap border-bottom w-100">
                            <button class="cmn-btn tab_button <?= ($tab == 'stream' ? 'active' : '') ?>"
                                data-tab="project_stream">Stream</button>
                            <button class="cmn-btn tab_button <?= $tab == 'overview' ? 'active' : '' ?>"
                                data-tab="project_file">Porject Overview</button>
                            <button class="cmn-btn tab_button <?= $tab == 'result' ? 'active' : '' ?>"
                                data-tab="project_profile">Result Sheet</button>
                            <button class="cmn-btn tab_button <?= $tab == 'team' ? 'active' : '' ?>"
                                data-tab="project_team">Team</button>
                        </div>
                    </div>
                </div>

                <?php while ($project = mysqli_fetch_assoc($project_result)) : ?>
                    <div class="row g-6 mt-5">
                        <div class="tab_content project_stream  <?= ($tab == 'stream' ? 'active' : '') ?>">
                            <div class="row">
                                <div class="col-12">
                                    <div class="stream_area">
                                        <div class="mb-4 d-flex justify-content-between align-items-center">
                                            <h2>Announcement:</h2>
                                            <button type="button" class="btn btn-primary rounded-3" data-bs-toggle="modal" data-bs-target="#addFileModal">
                                                Announcement
                                            </button>
                                        </div>
                                        <?php echo $erroremail; ?>
                                        <div class="stream_file d-flex flex-column gap-3">
                                            <?php
                                            $files_query = "SELECT * FROM project_stream WHERE project_id = '$proj_ids' ORDER BY stream_id DESC";
                                            $files_result = mysqli_query($con, $files_query);
                                            if (mysqli_num_rows($files_result) > 0) {
                                                while ($stream_file = mysqli_fetch_assoc($files_result)) {
                                                    $fileType = strtoupper(pathinfo($stream_file['file'], PATHINFO_EXTENSION));

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
                                                                    <i class='fas <?= getFileIcon($fileType); ?>'></i>
                                                                </div>
                                                                <div class="d-flex gap-2 flex-column">
                                                                    <h6 class=""><?= $teacher['tcr_name'] . ' - Create a New Announcement: ' . $extensions_display; ?></h6>
                                                                    <p class="fs-7 mb-0"><?= $stream_file['date']; ?></p>
                                                                </div>
                                                            </div>
                                                            <div class="threedot position-relative d-center">
                                                                <span class="action_setting shadow2 rounded-2 box_10 d-center"><i class="fa-solid fa-ellipsis-vertical "></i></span>
                                                                <div class="action_drop rounded-3 ">
                                                                    <div class=" d-center flex-column gap-2">
                                                                        <!-- <a download href="./uploads/projects/<? //= $stream_file['stream_file'] 
                                                                                                                    ?>"><i class="fa-solid fa-download"></i></a> -->

                                                                        <a href="tcr_std_project_announce_edit.php?announce=<?= $stream_file['stream_id'] ?>">
                                                                            <i class="fa-regular fa-pen-to-square"></i>
                                                                        </a>
                                                                        <a href="tcr_std_project_details.php?project=<?= $proj_id ?>&delete=<?= $stream_file['stream_id']; ?>" onclick="return confirm('Are you sure you want to delete this data?');">
                                                                            <i class="fa-solid fa-trash"></i>
                                                                        </a>

                                                                    </div>
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

                        <div class="tab_content project_file <?= $tab == 'overview' ? 'active' : '' ?>">
                            <div class="row">
                                <div class="col-12">
                                    <div class="overview_area">
                                        <div class="mb-4 d-flex justify-content-between align-items-center">
                                            <h2>Project Overview:</h2>
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
                                                                    <p class="fs-7 mb-0"><?= $overview_file['date']; ?></p>
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
                        <!-- project_profile -->
                        <?php
                        // Define grade and grade point mappings
                        $grade_points = [
                            "A+" => 4.0,
                            "A" => 3.75,
                            "A-" => 3.5,
                            "B+" => 3.25,
                            "B" => 3.0,
                            "B-" => 2.75,
                            "C+" => 2.5,
                            "C" => 2.25,
                            "D" => 2.0,
                            "F" => 0.0,
                        ];

                        function displayStudentList($students, $grade_points, $project)
                        {
                            if (!$students) {
                                echo "<tr><td colspan='5' class='text-center'>Error fetching student records</td></tr>";
                                return;
                            }

                            $count = 1;


                            $project_grade = json_decode($project['grade'], true);
                            $project_grade_point = json_decode($project['grade_point'], true);
                            $project_remarks = json_decode($project['remarks'], true);

                            if (mysqli_num_rows($students) > 0) {
                                while ($student = mysqli_fetch_array($students)) {
                                    $student_id = htmlspecialchars($student['std_id']);
                                    $student_name = htmlspecialchars($student['std_name']);
                        ?>
                                    <tr class='mb-3'>
                                        <td><?php echo $count; ?></td>
                                        <td><?php echo $student_id; ?></td>
                                        <td><?php echo $student_name; ?></td>
                                        <td>
                                            <input type="hidden" name="student_id[]" value="<?= $student_id ?>">
                                            <select name="grade[<?= $student_id ?>]"
                                                class="form-select grade-select"
                                                data-student-id="<?php echo $student_id; ?>"
                                                required>
                                                <option value="">Select Grade</option>
                                                <?php foreach ($grade_points as $grade => $point): ?>
                                                    <option <?= ((isset($project_grade[$student_id]) ? $project_grade[$student_id] : '') == $grade ? 'selected' : '') ?> value="<?php echo htmlspecialchars($grade); ?>">
                                                        <?= htmlspecialchars($grade); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" name="grade_point[<?= $student_id ?>]" class="form-control grade-point" id="grade_point_<?php echo $student_id; ?>"
                                                value="<?= (isset($project_grade_point[$student_id]) ? $project_grade_point[$student_id] : '') ?>" readonly>
                                        </td>
                                        <td><input type="text" class="form-control" name="remarks[<?= $student_id ?>]" value="<?= (isset($project_remarks[$student_id]) ? $project_remarks[$student_id] : '') ?>"></td>
                                    </tr>
                        <?php
                                    $count++;
                                }
                            } else {
                                echo "<tr><td colspan='5' class='text-center'>No records found</td></tr>";
                            }
                        }

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

                                        <form id="gradeForm" method="POST">
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Sl.No.</th>
                                                        <th>Student ID</th>
                                                        <th>Student Name</th>
                                                        <th>Grade</th>
                                                        <th>Grade Point</th>
                                                        <th>Remark</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if (isset($project['std_id_multiple']) && !empty($project['std_id_multiple'])) {
                                                        $std_ids = mysqli_real_escape_string($con, $project['std_id_multiple']);
                                                        $get_std = "SELECT * FROM std_registration WHERE std_id IN ($std_ids)";
                                                        $run_std = mysqli_query($con, $get_std);
                                                        displayStudentList($run_std, $grade_points, $project);
                                                    } else {
                                                        echo "<tr><td colspan='5' class='text-center'>No students assigned to this project</td></tr>";
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                            <div class="d-flex  gap-3">
                                                <input name="grade_submit_btn" class="btn btn-success" type="submit" value="Submit">
                                                <a href="pdf/project_result.php?project_id=<?= $proj_id ?>" target="_blank" class="btn btn-success"><i class="fa-solid fa-eye"></i></a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                const gradePoints = <?php echo json_encode($grade_points); ?>;

                                function updateGradePoint(select) {
                                    const selectedGrade = select.value;
                                    const studentId = select.getAttribute("data-student-id");
                                    const gradePointInput = document.getElementById("grade_point_" + studentId);

                                    if (gradePointInput) {
                                        gradePointInput.value = selectedGrade ? gradePoints[selectedGrade] : "";
                                    }
                                }

                                $('.grade-select').on('change', function(e) {
                                    const grade_points = {
                                        "A+": 4.0,
                                        "A": 3.75,
                                        "A-": 3.5,
                                        "B+": 3.25,
                                        "B": 3.0,
                                        "B-": 2.75,
                                        "C+": 2.5,
                                        "C": 2.25,
                                        "D": 2.0,
                                        "F": 0.0,
                                    };
                                    const grade = $(this).val();
                                    const student_id = $(this).attr("data-student-id");

                                    $('#grade_point_' + student_id).val(grade_points[grade]);
                                });

                            });
                        </script>
                        <div class="tab_content project_team  <?= $tab == 'team' ? 'active' : '' ?>">
                            <div class="row">
                                <div class="col-lg-10">
                                    <div class="shadow1 border-color rounded-3 p-3 p-lg-5">
                                        <div class="supervisor">
                                            <h4 class="fs-one fw-semibold mb-4 text-decoration-underline ">Supervisor</h4>
                                            <?php
                                            $get_std = "SELECT * FROM tcr_registration WHERE user_email = '$user_email' ";
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
                                                                // echo "<span class='mb-1'>{$student['interest_field']}</span>";
                                                                // echo "<span class='mb-1'>{$student['designation']}</span>";
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
                    <div class="mb-3">
                        <label class="form-label" for="stream_content">Post</label>
                        <textarea name="stream_content" class="form-control" id="stream_content" rows="5"></textarea>
                    </div>
                    <div class="mb-3 d-none">
                        <label class="form-label">Teacher</label>
                        <input type="text" class="form-control" name="user_id" value="<?php echo htmlspecialchars($teacher['id']); ?>" readonly>
                    </div>
                    <div class="mb-3 d-none">
                        <label class="form-label">Project ID</label>
                        <input type="text" class="form-control" name="project_id" value="<?php echo $proj_ids; ?>" readonly>
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