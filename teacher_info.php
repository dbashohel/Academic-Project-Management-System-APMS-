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

<div class="main_page">
    <div class="content-area">
        <div class="container-fluid">
            <!-- Show Teacher -->
            <div class="student-list pt-5">
                <?php
                if (isset($_GET['delete'])) {
                    $id = $_GET['delete'];
                    $delete = "DELETE FROM tcr_registration WHERE id='$id'";
                    $result = mysqli_query($con, $delete);
                    if ($result) {
                ?>
                        <div class="alert alert-success">
                            <strong>Success!</strong> Data Deleted Successfully.
                        </div>
                <?php
                        echo "<meta http-equiv='refresh' content='2;url=teacher_info.php'>";
                    } else {
                        echo "Failed" . mysqli_error($con);
                    }
                }
                ?>
                <h2>Teachers Info:</h2>
                <div class="data_info">
                    <table class="table table-striped table-hove mt-4">
                        <thead>
                            <tr>
                                <th scope="col">Teacher's Name</th>
                                <th scope="col">Email Address</th>
                                <th scope="col">Phone Number</th>
                                <th scope="col">Image</th>
                                <th scope="col">NID Number</th>
                                <th scope="col">Father's Name</th>
                                <th scope="col">Address</th>
                                <th scope="col">Department</th>
                                <th scope="col">Designation</th>
                                <th scope="col">Job Type</th>
                                <th scope="col">Joining Date</th>
                                <th scope="col">User Role</th>
                                <th scope="col">Registration Date</th>
                                <th scope="col">Edit / Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $bring_data = "SELECT * FROM tcr_registration WHERE status = 'approved'";

                            $result = mysqli_query($con, $bring_data);

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_array($result)) :
                            ?>
                                    <tr>
                                        <td> <?php echo $row['tcr_name']; ?> </td>
                                        <td> <?php echo $row['user_email']; ?> </td>
                                        <td> <?php echo $row['phone']; ?> </td>
                                        <td>
                                            <div class="user_img">
                                                <img src="./uploads/teachers/<?= $row['tcr_img']; ?>" alt="img">
                                            </div>
                                        </td>
                                        <td> <?php echo $row['user_nid']; ?> </td>
                                        <td> <?php echo $row['tcr_father']; ?> </td>
                                        <td> <?php echo $row['permanent_address']; ?> </td>
                                        <td> <?php echo $row['department']; ?> </td>
                                        <td> <?php echo $row['designation']; ?> </td>
                                        <td> <?php echo $row['job_type']; ?> </td>
                                        <td> <?php echo $row['joining_date']; ?> </td>
                                        <td> <?php echo $row['user_role']; ?> </td>
                                        <td> <?php echo $row['submition_date']; ?> </td>
                                        <td>
                                            <a class="btn btn-primary ms-auto rounded-3" href="tcr_more_infor.php?show=<?php echo $row['id']; ?>"><i class="fa-solid fa-eye"></i></a>
                                            <a class="btn btn-primary rounded-3" href="profile_edit.php?edit=<?php echo $row['user_email']; ?> "><i class="fa-regular fa-pen-to-square"></i></a>
                                            <a href="teacher_info.php?delete=<?php echo $row['id']; ?> " onclick="return confirm('Are you sure you want to delete <?php echo $row['id']; ?> Account?');" class="btn btn-danger rounded-3"><i class="fa-solid fa-trash"></i></a>
                                        </td>
                                    </tr>

                            <?php
                                endwhile;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include("includes/footer.php"); ?>