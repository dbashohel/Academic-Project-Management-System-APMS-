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
    generateNavMenu('teacher');
} else {
    generateNavMenu('admin');
}
?>

<?php
if (isset($_GET['show'])) {
    $std_id = $_GET['show'];
    $select_data = "SELECT * FROM std_registration WHERE std_id='$std_id'";
    $result = mysqli_query($con, $select_data);
    $row = mysqli_fetch_array($result);

    $std_id = $row['std_id'];
    $row['std_name'];
}
?>



<div class="main_page">
    <div class="content-area">
        <div class="container-fluid">
            <div class="my_profile pt-5">
                <div class="container">
                    <div class="row">
                        <h2 class="view_profile">Additional Information About "<?php echo $row['std_name']; ?>"</h2>
                        <div class="d-flex align-items-center justify-content-between my-3">
                            <h5>Student ID : <?php echo $row['std_id']; ?></h5>
                        </div>
                    </div>
                    <div class="row">
                        <table class="table my_profile student  mt-5">
                            <tbody>
                                <tr>
                                    <th>Student's Name</th>
                                    <th>:</th>
                                    <td> <?php echo $row['std_name']; ?> </td>
                                    <th>Religion</th>
                                    <th>:</th>
                                    <td> <?php echo $row['religion']; ?></td>
                                </tr>
                                <tr>
                                    <th>Father's Name</th>
                                    <th>:</th>
                                    <td> <?php echo $row['std_father']; ?></td>
                                    <th>Mother's Name</th>
                                    <th>:</th>
                                    <td> <?php echo $row['std_mother']; ?></td>
                                </tr>
                                <tr>
                                    <th>Student Phone</th>
                                    <th>:</th>
                                    <td> <?php echo $row['phone']; ?></td>
                                    <th>Father's Phone</th>
                                    <th>:</th>
                                    <td> <?php echo $row['fphone']; ?></td>
                                </tr>
                                <?php if (!empty($row['add_user_email']) || !empty($row['add_user_phone']) || !empty($row['user_nid']) || !empty($row['user_birth_certi']) || !empty($row['user_passport'])) { ?>
                                    <tr>
                                        <?php if (!empty($row['add_user_email'])) { ?>
                                            <th>Additional Email Address</th>
                                            <th>:</th>
                                            <td><?php echo htmlspecialchars($row['add_user_email']); ?></td>
                                        <?php } ?>

                                        <?php if (!empty($row['add_user_phone'])) { ?>
                                            <th>Additional Phone Number</th>
                                            <th>:</th>
                                            <td><?php echo htmlspecialchars($row['add_user_phone']); ?></td>
                                        <?php } ?>
                                    </tr>
                                    <tr>
                                        <?php if (!empty($row['add_user_fphone'])) { ?>
                                            <th>Additional Father's Number</th>
                                            <th>:</th>
                                            <td><?php echo htmlspecialchars($row['add_user_fphone']); ?></td>
                                        <?php } ?>
                                        <?php if (!empty($row['user_birth_certi'])) { ?>
                                            <th>Birth Certificate</th>
                                            <th>:</th>
                                            <td><?php echo htmlspecialchars($row['user_birth_certi']); ?></td>
                                        <?php } ?>
                                    </tr>
                                    <tr>
                                        <?php if (!empty($row['user_nid'])) { ?>
                                            <th>NID No.</th>
                                            <th>:</th>
                                            <td><?php echo htmlspecialchars($row['user_nid']); ?></td>
                                        <?php } ?>
                                        <?php if (!empty($row['user_passport'])) { ?>
                                            <th>Passport No.</th>
                                            <th>:</th>
                                            <td><?php echo htmlspecialchars($row['user_passport']); ?></td>
                                        <?php } ?>
                                    </tr>
                                <?php } ?>



                            </tbody>
                        </table>
                    </div>
                    <div class="row mt-4">
                        <h3 class="view_profile">Address</h3>

                        <table class="table my_profile student  mt-4">

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

                        </table>
                    </div>
                    <div class="row mt-4">
                        <h3 class="view_profile">Academic Details</h3>

                        <table class="table my_profile student  mt-4">
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
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include("includes/footer.php"); ?>