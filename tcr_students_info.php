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
            <div class="student-list pt-4">
                <?php
                if (isset($_GET['delete'])) {
                    $std_id = $_GET['delete'];
                    $delete = "DELETE FROM std_registration WHERE std_id='$std_id'";
                    $result = mysqli_query($con, $delete);
                    if ($result) {
                ?>
                       <div class='alert alert-success alert-dismissible fade show' role='alert'>
                            <strong>Student <?php echo $std_id; ?> </strong> Data Deleted Successfully..
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>
                <?php
                        //    echo "<meta http-equiv='refresh' content='4;url=tcr_students_info.php'>";
                    } else {
                        echo "Failed" . mysqli_error($con);
                    }
                }

                ?>


                <h2>All Student:</h2>
                <div class="data_info mt-5">
                    <table class="table table-striped table-hove">
                        <thead>
                            <tr>
                                <th scope="col">Registration Date</th>
                                <th scope="col">Program Type</th>
                                <th scope="col">Program</th>
                                <th scope="col">Admission Semester</th>
                                <th scope="col">Image</th>
                                <th scope="col">Student's ID</th>
                                <th scope="col">Student's Name</th>
                                <th scope="col">Email Address</th>
                                <th scope="col">Additional Email</th>
                                <th scope="col">Date of Birth</th>
                                <th scope="col">Gender</th>
                                <th scope="col">Credit</th>
                                <th scope="col">Status</th>
                                <th scope="col">Credit Transfer</th>
                                <th scope="col">View / Edit / Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $bring_data = "SELECT * FROM std_registration WHERE id_approved = 'approved' ";

                            $result = mysqli_query($con, $bring_data);

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_array($result)) :
                            ?>
                                    <tr>
                                        <td> <?php echo $row['submition_date']; ?> </td>
                                        <td> <?php echo $row['program_type']; ?> </td>
                                        <td> <?php echo $row['program']; ?> </td>
                                        <td> <?php echo $row['admission_semester']; ?> </td>
                                        <td>
                                            <div class="user_img">
                                                <img src="./uploads/students/<?= $row['std_img']; ?>" alt="img">
                                            </div>
                                        </td>
                                        <td> <?php echo $row['std_id']; ?> </td>
                                        <td> <?php echo $row['std_name']; ?> </td>
                                        <td> <?php echo $row['user_email']; ?> </td>
                                        <td> <?php echo $row['add_user_email']; ?> </td>
                                        <td> <?php echo $row['std_birth']; ?> </td>
                                        <td> <?php echo $row['gender']; ?> </td>
                                        <td> <?php echo $row['credit']; ?> </td>
                                        <td> <?php echo $row['status']; ?> </td>
                                        <td> <?php echo $row['credit_transfer']; ?> </td>
                                        <td>
                                            <a class="btn btn-primary" href="std_more_infor.php?show=<?php echo $row['std_id'] ?>"><i class="fa-solid fa-eye"></i></a>
                                            <a class="btn btn-primary" href="tcr_std_reg_pending_edit.php?edit=<?php echo $row['std_id']; ?> "><i class="fa-regular fa-pen-to-square"></i></a>
                                            <a href="?delete=<?php echo $row['std_id']; ?> " onclick="return confirm('Are you sure you want to delete <?php echo $row['user_email']; ?> Account?');" class="btn btn-danger"><i class="fa-solid fa-trash"></i></a>
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