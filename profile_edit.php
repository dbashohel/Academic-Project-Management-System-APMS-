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

if ($user_role == 'teacher') {
    generateNavMenu('teacher');
} else {
    generateNavMenu('admin');
}

if (isset($_GET['edit'])) {
    $edit_email = $_GET['edit'];
    $stmt = $con->prepare("SELECT * FROM tcr_registration WHERE user_email = ?");
    $stmt->bind_param("s", $edit_email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();
    if (!$row) {
        echo "<div class='alert alert-warning'>No user found with this email.</div>";
    }
}

if (isset($_POST['update_submit'])) {
    $tcr_name = $_POST['tcr_name'];
    $tcr_father = $_POST['tcr_father'];
    $tcr_mother = $_POST['tcr_mother'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone'];
    $fphone = $_POST['fphone'];
    $user_nid = $_POST['user_nid'];
    $user_passport = $_POST['user_passport'];
    $present_country = $_POST['present_country'];
    $permanent_country = $_POST['permanent_country'];
    $present_address = $_POST['present_address'];
    $permanent_address = $_POST['permanent_address'];
    $permanent_division = $_POST['permanent_division'];
    $permanent_district = $_POST['permanent_district'];
    $permanent_thana = $_POST['permanent_thana'];
    $religion = $_POST['religion'];

    $stmt = $con->prepare("UPDATE tcr_registration SET 
        tcr_name = ?, 
        tcr_father = ?, 
        tcr_mother = ?, 
        gender = ?, 
        phone = ?, 
        fphone = ?, 
        user_nid = ?, 
        user_passport = ?, 
        present_country = ?, 
        permanent_country = ?, 
        present_address = ?, 
        permanent_address = ?, 
        permanent_division = ?, 
        permanent_district = ?, 
        permanent_thana = ?, 
        religion = ?
        WHERE user_email = ?");
    $stmt->bind_param("sssssssssssssssss", 
        $tcr_name, 
        $tcr_father, 
        $tcr_mother, 
        $gender, 
        $phone, 
        $fphone, 
        $user_nid, 
        $user_passport, 
        $present_country, 
        $permanent_country, 
        $present_address, 
        $permanent_address, 
        $permanent_division, 
        $permanent_district, 
        $permanent_thana, 
        $religion,
        $user_email);

    if ($stmt->execute()) {
        $erroremail = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                        <strong>Profile Updated Successfully</strong>. 
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
        echo "<meta http-equiv='refresh' content='2;url=my_profile.php'>";
    } else {
        $erroremail = "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                        <strong>Something went wrong</strong>.
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>" . $con->error;
    }
    $stmt->close();
}
?>


<?php
if (isset($erroremail)) {
    echo $erroremail;
}
?>

<div class="main_page">
    <div class="content-area">
        <div class="container-fluid">
            <div class="my_profile pt-5">
                <div class="container">
                    <div class="row">
                        <h2 class="view_profile">Edit Profile</h2>
                        <div class="d-flex align-items-center justify-content-between my-3">
                            <h5>Username : <?php echo htmlspecialchars($user_email); ?></h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <form method="post" action="" class="d-flex flex-column gap-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="mb-1" for="tcr_name">Teacher's Name <span class="text-danger">*</span> </label>
                                        <input type="text" name="tcr_name" id="tcr_name" class="form-control mb-3" value="<?php echo $row['tcr_name']; ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="mb-1" for="tcr_father">Father's Name <span class="text-danger">*</span> </label>
                                        <input type="text" name="tcr_father" id="tcr_father" class="form-control mb-3" value="<?php echo $row['tcr_father']; ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="mb-1" for="tcr_mother">Mother's Name <span class="text-danger">*</span> </label>
                                        <input type="text" name="tcr_mother" id="tcr_mother" class="form-control mb-3" value="<?php echo $row['tcr_mother']; ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="mb-1" for="gender">Gender <span class="text-danger">*</span> </label>
                                        <select name="gender" class="form-control mb-3" id="gender" required>
                                            <option value="<?php echo $row['gender']; ?>"><?php echo $row['gender']; ?></option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                            <option value="others">Others</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="mb-1" for="phone">Contact Number <span class="text-danger">*</span> </label>
                                        <input type="tel" name="phone" id="phone" class="form-control mb-3" value="<?php echo $row['phone']; ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="mb-1" for="fphone">Father's Contact Number <span class="text-danger">*</span> </label>
                                        <input type="tel" name="fphone" id="fphone" class="form-control mb-3" value="<?php echo $row['fphone']; ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="mb-1" for="user_nid">NID </label>
                                        <input type="number" name="user_nid" id="user_nid" class="form-control mb-3" value="<?php echo $row['user_nid']; ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="mb-1" for="user_passport">Passport No </label>
                                        <input type="number" name="user_passport" id="user_passport" class="form-control mb-3" value="<?php echo $row['user_passport']; ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="mb-1" for="present_country">Present Country <span class="text-danger">*</span> </label>
                                        <input type="text" name="present_country" id="present_country" class="form-control mb-3" value="<?php echo $row['present_country']; ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="mb-1" for="permanent_country">Permanent Country <span class="text-danger">*</span> </label>
                                        <input type="text" name="permanent_country" id="permanent_country" class="form-control mb-3" value="<?php echo $row['permanent_country']; ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="mb-1" for="present_address">Present Address <span class="text-danger">*</span> </label>
                                        <input type="text" name="present_address" id="present_address" class="form-control mb-3" value="<?php echo $row['present_address']; ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="mb-1" for="permanent_address">Permanent Address <span class="text-danger">*</span> </label>
                                        <input type="text" name="permanent_address" id="permanent_address" class="form-control mb-3" value="<?php echo $row['permanent_address']; ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="mb-1" for="permanent_division">Permanent Division <span class="text-danger">*</span> </label>
                                        <input type="text" name="permanent_division" id="permanent_division" class="form-control mb-3" value="<?php echo $row['permanent_division']; ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="mb-1" for="permanent_district">Permanent District <span class="text-danger">*</span> </label>
                                        <input type="text" name="permanent_district" id="permanent_district" class="form-control mb-3" value="<?php echo $row['permanent_district']; ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="mb-1" for="permanent_thana">Permanent Thana <span class="text-danger">*</span> </label>
                                        <input type="text" name="permanent_thana" id="permanent_thana" class="form-control mb-3" value="<?php echo $row['permanent_thana']; ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="mb-1" for="religion">Religion <span class="text-danger">*</span> </label>
                                        <select name="religion" class="form-control mb-3" id="religion" required>
                                            <option value="<?php echo $row['religion']; ?>"><?php echo $row['religion']; ?></option>
                                            <option value="Islam">Islam</option>
                                            <option value="Hinduism">Hinduism</option>
                                            <option value="Christianity">Christianity</option>
                                            <option value="Buddhism">Buddhism</option>
                                            <option value="Other">Other</option>
                                            <option value="None">None</option>
                                        </select>
                                    </div>
                                </div>
                                <button type="submit" name="update_submit" class="btn btn-success">Update Profile</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include("includes/footer.php"); ?>