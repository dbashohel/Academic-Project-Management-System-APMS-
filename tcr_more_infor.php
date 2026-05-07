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
    $tcr_id = $_GET['show'];
    $select_data = "SELECT * FROM tcr_registration WHERE id='$tcr_id'";
    $result = mysqli_query($con, $select_data);
    $row = mysqli_fetch_array($result);

    $tcr_id = $row['tcr_id'];
    $row['tcr_name'];
}
?>



<div class="main_page">
    <div class="content-area">
        <div class="container-fluid">
            <div class="my_profile pt-5">
                <div class="container">
                    <div class="row">
                        <h2 class="view_profile">Additional Information About "<?php echo $row['tcr_name']; ?>"</h2>
                        <div class="d-flex align-items-center justify-content-between my-3">
                            <h5>Teacher ID : <?php echo $row['tcr_id']; ?></h5>
                        </div>
                    </div>
                    <div class="row">
                        <table class="table my_profile student  mt-5">
                            <tbody>
                                <tr>
                                    <th>Teacher's Name</th>
                                    <th>:</th>
                                    <td> <?php echo $row['tcr_name']; ?> </td>
                                    <th>Religion</th>
                                    <th>:</th>
                                    <td> <?php echo $row['religion']; ?></td>
                                </tr>
                                <tr>
                                    <th>Father's Name</th>
                                    <th>:</th>
                                    <td> <?php echo $row['tcr_father']; ?></td>
                                    <th>Mother's Name</th>
                                    <th>:</th>
                                    <td> <?php echo $row['tcr_mother']; ?></td>
                                </tr>
                                <tr>
                                    <th>Teacher Phone</th>
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
                        <h3 class="view_profile">Professional Information</h3>

                        <table class="table my_profile student  mt-4">
                            <tr>
                                <th>Position </th>
                                <th>:</th>
                                <td> <?php echo $row['position']; ?> </td>
                                <th>Years of Experience</th>
                                <th>:</th>
                                <td> <?php echo $row['experience']; ?> </td>
                            </tr>
                            <tr>
                                <th>Research Area</th>
                                <th>:</th>
                                <td> <?php echo $row['research_area']; ?> </td>
                                <th>Interest Field</th>
                                <th>:</th>
                                <td> <?php echo $row['interest_field']; ?> </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include("includes/footer.php"); ?>