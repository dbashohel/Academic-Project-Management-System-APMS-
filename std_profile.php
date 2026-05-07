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

if ($user_role == 'student') {
    generateNavMenu('student');
}


$query = "SELECT * FROM std_registration WHERE std_id = '$std_id'";
$result = mysqli_query($con, $query);

if (!$result) {
    die("Error: " . mysqli_error($con));
}
?>


<div class="main_page">
    <div class="content-area">
        <div class="container-fluid">
            <div class="my_profile pt-5">
                <div class="container">
                    <div class="row">
                        <h1 class="view_profile">View <?php echo $user_role; ?> Profile</h1>
                        <div class="d-flex align-items-center justify-content-between my-3">
                            <div class="user_info">
                                <p>Student ID : <?php echo $std_id; ?></p>
                            </div>
                            <div class="d-flex gap-3">
                                <a href="logout.php" class="btn btn-danger">Logout</a>
                                <a href="std_change_password.php" class="btn btn-warning">Change Password</a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <?php
                        if (mysqli_num_rows($result) == 1) {
                            while ($row = mysqli_fetch_assoc($result)) :
                        ?>
                                <table class="table my_profile student  mt-5">
                                    <tbody>
                                        <tr>
                                            <th>
                                                <div class="user_img">
                                                    <img src="./uploads/students/<?= $row['std_img']; ?>" alt="img">
                                                </div>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>Student's Name</th>
                                            <th>:</th>
                                            <td> <?php echo $row['std_name']; ?> </td>
                                            <th>Date of Birth</th>
                                            <th>:</th>
                                            <td> <?php echo $row['std_birth']; ?><span class="fs-7"> (yyyy-mm-dd)</span> </td>
                                        </tr>
                                        <tr>
                                            <th>Email Address</th>
                                            <th>:</th>
                                            <td> <?php echo $row['user_email']; ?> </td>
                                            <th>Phone Number</th>
                                            <th>:</th>
                                            <td> <?php echo $row['phone']; ?> </td>
                                        </tr>
                                        <?php if (!empty($row['add_user_email']) || !empty($row['add_user_phone']) || !empty($row['add_user_fphone'])) { ?>
                                            <tr>
                                                <?php if (!empty($row['add_user_email'])) { ?>
                                                    <th>Another Email Address</th>
                                                    <th>:</th>
                                                    <td><?php echo htmlspecialchars($row['add_user_email']); ?></td>
                                                <?php } ?>

                                                <?php if (!empty($row['add_user_phone'])) { ?>
                                                    <th>Another Phone Number</th>
                                                    <th>:</th>
                                                    <td><?php echo htmlspecialchars($row['add_user_phone']); ?></td>
                                                <?php } ?>
                                            </tr>
                                            <tr>
                                                <?php if (!empty($row['add_user_fphone'])) { ?>
                                                    <th>Another Father's Number</th>
                                                    <th>:</th>
                                                    <td><?php echo htmlspecialchars($row['add_user_fphone']); ?></td>
                                                <?php } ?>
                                            </tr>
                                        <?php } ?>

                                        <tr>
                                            <th>Gender</th>
                                            <th>:</th>
                                            <td> <?php echo $row['gender']; ?> </td>
                                            <th>NID Number</th>
                                            <th>:</th>
                                            <td> <?php echo $row['user_nid']; ?> </td>
                                        </tr>
                                        <tr>
                                            <th>Birth Certificate</th>
                                            <th>:</th>
                                            <td> <?php echo $row['user_birth_certi']; ?> </td>
                                            <th>Passport</th>
                                            <th>:</th>
                                            <td> <?php echo $row['user_passport']; ?> </td>
                                        </tr>
                                        <tr>
                                            <th>Father's Name</th>
                                            <th>:</th>
                                            <td> <?php echo $row['std_father']; ?> </td>
                                            <th>Mother's Name</th>
                                            <th>:</th>
                                            <td> <?php echo $row['std_mother']; ?> </td>
                                        </tr>
                                        <tr>
                                            <th>Program Type</th>
                                            <th>:</th>
                                            <td> <?php echo $row['program_type']; ?> </td>
                                            <th>Program</th>
                                            <th>:</th>
                                            <td> <?php echo $row['program']; ?> </td>
                                        </tr>
                                        <tr>
                                            <th>Credit</th>
                                            <th>:</th>
                                            <td> <?php echo $row['credit']; ?> </td>
                                            <th>Credit Transfer</th>
                                            <th>:</th>
                                            <td> <?php echo $row['credit_transfer']; ?> </td>
                                        </tr>
                                        <tr>
                                            <th>Admission Semester</th>
                                            <th>:</th>
                                            <td> <?php echo $row['admission_semester']; ?> </td>
                                            <th>Status</th>
                                            <th>:</th>
                                            <td> <?php echo $row['status']; ?> </td>
                                        </tr>
                                        <tr>
                                            <th>Admission Date</th>
                                            <th>:</th>
                                            <td> <?php echo $row['submition_date']; ?> </td>
                                            <th>Religion</th>
                                            <th>:</th>
                                            <td> <?php echo $row['religion']; ?> </td>
                                        </tr>
                                        <tr>
                                            <th>Present Country</th>
                                            <th>:</th>
                                            <td> <?php echo $row['present_country']; ?> </td>
                                            <th>Present Address</th>
                                            <th>:</th>
                                            <td> <?php echo $row['present_address']; ?> </td>
                                        </tr>
                                        <tr>
                                            <th>Permanent Country</th>
                                            <th>:</th>
                                            <td> <?php echo $row['permanent_country']; ?> </td>
                                            <th>Permanent Address</th>
                                            <th>:</th>
                                            <td> <?php echo $row['permanent_address']; ?> </td>
                                        </tr>
                                        <tr>
                                            <th>Permanent Division</th>
                                            <th>:</th>
                                            <td> <?php echo $row['permanent_division']; ?> </td>
                                            <th>Permanent District</th>
                                            <th>:</th>
                                            <td> <?php echo $row['permanent_district']; ?> </td>
                                        </tr>
                                        <tr>
                                            <th>Permanent Thana</th>
                                            <th>:</th>
                                            <td> <?php echo $row['permanent_thana']; ?> </td>

                                        </tr>
                                        <tr>
                                            <th>Education Level </th>
                                            <th>:</th>
                                            <td> <?php echo $row['education_level_ssc']; ?> </td>
                                            <th>Passing Year</th>
                                            <th>:</th>
                                            <td> <?php echo $row['passing_year']; ?> </td>
                                        </tr>
                                        <tr>
                                            <th>Grading</th>
                                            <th>:</th>
                                            <td> <?php echo $row['ssc_grading']; ?> </td>
                                            <th>Grade Point</th>
                                            <th>:</th>
                                            <td> <?php echo $row['ssc_grade_point']; ?> </td>
                                        </tr>
                                        <tr>
                                            <th>Education Level</th>
                                            <th>:</th>
                                            <td> <?php echo $row['education_level_hsc']; ?> </td>
                                            <th>Passing Year</th>
                                            <th>:</th>
                                            <td> <?php echo $row['hsc_passing_year']; ?> </td>
                                        </tr>
                                        <tr>
                                            <th>Grading</th>
                                            <th>:</th>
                                            <td> <?php echo $row['hsc_grading']; ?> </td>
                                            <th>Grade Point</th>
                                            <th>:</th>
                                            <td> <?php echo $row['hsc_grade_point']; ?> </td>
                                        </tr>
                                        <tr>
                                            <th>Education Level</th>
                                            <th>:</th>
                                            <td> <?php echo $row['education_level_bac']; ?> </td>
                                            <th>Passing Year </th>
                                            <th>:</th>
                                            <td> <?php echo $row['ba_passing_year']; ?> </td>
                                        </tr>
                                        <tr>
                                            <th>Grading</th>
                                            <th>:</th>
                                            <td> <?php echo $row['ba_grading']; ?> </td>
                                            <th>Grade point</th>
                                            <th>:</th>
                                            <td> <?php echo $row['ba_grade_point']; ?> </td>
                                        </tr>

                                    </tbody>
                                </table>
                                <a class="btn btn-primary" href="std_profile_edit.php?edit=<?php echo $row['std_id']; ?> ">Edit</a>
                        <?php
                            endwhile;
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <?php include("includes/footer.php"); ?>