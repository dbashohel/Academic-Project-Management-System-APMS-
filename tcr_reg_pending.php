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
                            <strong>Teacher</strong> Data Deleted Successfully.
                        </div>
                <?php
                        // echo "<meta http-equiv='refresh' content='2;>";
                        // header("Location: your_page.php?deleted=true");
                        // exit();
                    } else {
                        echo "Failed" . mysqli_error($con);
                    }
                }

                ?>


                <h2>Pending teacher Registration:</h2>
                <?php
                $bring_data = "SELECT * FROM tcr_registration WHERE status = 'pending' ";

                $result = mysqli_query($con, $bring_data);
                if (mysqli_num_rows($result) > 0) {
                ?>
                    <div class="data_info mt-4">
                        <table class="table table-striped table-hove mt-4  ">
                            <thead>
                                <tr>
                                    <th scope="col">Registration Date</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">teacher's ID</th>
                                    <th scope="col">phone</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Father Name</th>
                                    <th scope="col">Date of Birth</th>
                                    <th scope="col">Gender</th>
                                    <th scope="col">Department</th>
                                    <th scope="col">Designation</th>
                                    <th scope="col">User Role</th>
                                    <th scope="col">View / Edit / Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($row = mysqli_fetch_array($result)) :
                                ?>
                                    <tr>
                                        <td> <?php echo $row['submition_date']; ?> </td>
                                        <td> <?php echo $row['user_email']; ?> </td>
                                        <td> <?php echo $row['tcr_name']; ?> </td>
                                        <td> <?php echo $row['tcr_id']; ?> </td>
                                        <td> <?php echo $row['phone']; ?> </td>
                                        <td>
                                            <div class="user_img">
                                                <img src="./uploads/teachers/<?= $row['tcr_img']; ?>" alt="img">
                                            </div>
                                        </td>
                                        <td> <?php echo $row['tcr_father']; ?> </td>
                                        <td> <?php echo $row['tcr_birth']; ?> </td>
                                        <td> <?php echo $row['gender']; ?> </td>
                                        <td> <?php echo $row['department']; ?> </td>
                                        <td> <?php echo $row['designation']; ?> </td>
                                        <td> <?php echo $row['user_role']; ?> </td>
                                        <td>
                                            <a class="btn btn-primary" href="tcr_more_infor.php?show=<?php echo $row['id'] ?>"><i class="fa-solid fa-eye"></i></a>
                                            <a class="btn btn-primary" href="tcr_reg_pending_edit.php?edit=<?php echo $row['id']; ?> "><i class="fa-regular fa-pen-to-square"></i></a>
                                            <a href="tcr_reg_pending.php?delete=<?php echo $row['id']; ?> " onclick="return confirm('Are you sure you want to delete <?php echo $row['id']; ?> Account?');" class="btn btn-danger"><i class="fa-solid fa-trash"></i></a>
                                        </td>
                                    </tr>
                                <?php
                                endwhile;
                                ?>
                            </tbody>
                        </table>
                    </div>
                <?php
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
</div>



<?php include("includes/footer.php"); ?>