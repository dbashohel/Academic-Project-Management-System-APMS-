<?php
session_start();

include("includes/header.php");
include("includes/functions.php");

if (!isset($_SESSION["user_email"]) || !isset($_SESSION["user_role"])) {
    header("Location: login.php");
    exit;
}

$user_email = $_SESSION["user_email"];
$user_role = $_SESSION["user_role"];
$tcr_name = $_SESSION["tcr_name"];

if ($user_role == 'teacher') {
    generateNavMenu('teacher', 'profile');
} else {
    generateNavMenu('admin', 'profile');
}



$query = "SELECT * FROM tcr_registration WHERE user_email = '$user_email'";
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
                                <p>Username : <?php echo $user_email; ?></p>
                            </div>
                            <div class="d-flex gap-3">
                                <a href="logout.php" class="btn btn-danger">Logout</a>
                                <a href="change_password.php" class="btn btn-warning">Change Password</a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <?php
                        if (mysqli_num_rows($result) == 1) {
                            while ($row = mysqli_fetch_assoc($result)) :
                        ?>
                                <table class="table my_profile  mt-5">
                                    <tbody>
                                        <tr>
                                            <th>Teacher's ID</th>
                                            <th>:</th>
                                            <td> <?php echo $row['tcr_id']; ?> </td>
                                            <th>Status</th>
                                            <th>:</th>
                                            <td> <?php echo $row['status']; ?> </td>
                                        </tr>
                                        <tr>
                                            <th>Teacher's Name</th>
                                            <th>:</th>
                                            <td> <?php echo $row['tcr_name']; ?> </td>
                                            <th>Father's Name</th>
                                            <th>:</th>
                                            <td> <?php echo $row['tcr_father']; ?> </td>
                                        </tr>
                                        <tr>
                                            <th>Mother's Name</th>
                                            <th>:</th>
                                            <td> <?php echo $row['tcr_father']; ?> </td>
                                            <th>Date Of Birth</th>
                                            <th>:</th>
                                            <td> <?php echo $row['tcr_birth']; ?> </td>
                                        </tr>
                                        <tr>
                                            <th>Gender</th>
                                            <th>:</th>
                                            <td> <?php echo $row['gender']; ?> </td>
                                            <th>Contact Number</th>
                                            <th>:</th>
                                            <td> <?php echo $row['phone']; ?> </td>
                                        </tr>
                                        <tr>
                                            <th>Father's Contact Number</th>
                                            <th>:</th>
                                            <td> <?php echo $row['fphone']; ?> </td>
                                            <th>NID</th>
                                            <th>:</th>
                                            <td> <?php echo $row['user_nid']; ?> </td>
                                        </tr>
                                        <tr>
                                            <th>Passport No</th>
                                            <th>:</th>
                                            <td> <?php echo $row['user_passport']; ?> </td>
                                            <th>Campus</th>
                                            <th>:</th>
                                            <td> <?php echo $row['campus']; ?> </td>
                                        </tr>
                                        <tr>
                                            <th>Department</th>
                                            <th>:</th>
                                            <td> <?php echo $row['department']; ?> </td>
                                            <th>Designation</th>
                                            <th>:</th>
                                            <td> <?php echo $row['designation']; ?> </td>
                                        </tr>
                                        <tr>
                                            <th>Job Type</th>
                                            <th>:</th>
                                            <td> <?php echo $row['job_type']; ?> </td>
                                            <th>Joining Date</th>
                                            <th>:</th>
                                            <td> <?php echo $row['joining_date']; ?> </td>

                                        </tr>
                                        <tr>
                                            <th>Present Country</th>
                                            <th>:</th>
                                            <td> <?php echo $row['present_country']; ?> </td>
                                            <th>Permanent Country</th>
                                            <th>:</th>
                                            <td> <?php echo $row['permanent_country']; ?> </td>
                                        </tr>
                                        <tr>
                                            <th>Present Address</th>
                                            <th>:</th>
                                            <td> <?php echo $row['present_address']; ?> </td>
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
                                            <th>SSC</th>
                                            <th>:</th>
                                            <td> <?php echo $row['education_level_ssc']; ?> </td>
                                            <th>Passing Year</th>
                                            <th>:</th>
                                            <td> <?php echo $row['passing_year']; ?> </td>
                                        </tr>
                                        <tr>
                                            <th>SSC Grading</th>
                                            <th>:</th>
                                            <td> <?php echo $row['ssc_grading']; ?> </td>
                                            <th>SSC Grade Point</th>
                                            <th>:</th>
                                            <td> <?php echo $row['ssc_grade_point']; ?> </td>
                                        </tr>
                                        <tr>
                                            <th>HSC</th>
                                            <th>:</th>
                                            <td> <?php echo $row['education_level_hsc']; ?> </td>
                                            <th>Passing Year</th>
                                            <th>:</th>
                                            <td> <?php echo $row['hsc_passing_year']; ?> </td>
                                        </tr>
                                        <tr>
                                            <th>HSC Grading</th>
                                            <th>:</th>
                                            <td> <?php echo $row['hsc_grading']; ?> </td>
                                            <th>HSC Grade Point</th>
                                            <th>:</th>
                                            <td> <?php echo $row['hsc_grade_point']; ?> </td>
                                        </tr>
                                        <tr>
                                            <th>Bachelor</th>
                                            <th>:</th>
                                            <td> <?php echo $row['education_level_bac']; ?> </td>
                                            <th>Passing Year</th>
                                            <th>:</th>
                                            <td> <?php echo $row['ba_passing_year']; ?> </td>
                                        </tr>
                                        <tr>
                                            <th>Grading</th>
                                            <th>:</th>
                                            <td> <?php echo $row['ba_grading']; ?> </td>
                                            <th>Grade Point</th>
                                            <th>:</th>
                                            <td> <?php echo $row['ba_grade_point']; ?> </td>
                                        </tr>



                                    </tbody>
                                </table>
                                <a class="btn btn-primary mt-4" href="profile_edit.php?edit=<?php echo $row['user_email']; ?> ">Edit</a>
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