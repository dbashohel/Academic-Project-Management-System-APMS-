<?php
session_start();

include("includes/header.php"); ?>
<?php include("includes/functions.php");
if (!isset($_SESSION["user_email"])) {
    header("Location: login.php");
    exit;
}
generateNavMenu('admin');
?>

<?php
    if (isset($_GET['delete'])) {
        $sub_reg_id = $_GET['delete'];
        $delete = "DELETE FROM subjectregistration WHERE sub_reg_id='$sub_reg_id'";
        $result = mysqli_query($con, $delete);
        if ($result) {
    ?>
            <div class="alert alert-success">
                <strong>Success!</strong> Data Deleted Successfully.
            </div>
    <?php
            echo "<meta http-equiv='refresh' content='1;url=subjectRagistration.php'>";
        } else {
            echo "Failed" . mysqli_error($con);
        }
    }
?>

<!--content area start-->
<div class="main_page">
    <div class="content-area">
        <div class="container-fluid">
            <div class="user_profile pt-5">
                <h2 class="d-flex justify-content-center">Subject List for Registration by Students</h2>
                <div class="container pt-5">
                    <table class="table table-striped table-hove">
                        <thead>
                            <tr>
                                <th scope="col">Sl.No</th>
                                <!-- <th scope="col">Stu. ID</th> -->
                                <th scope="col">Name</th>
                                <th scope="col">Semester</th>
                                <th scope="col">Sub. Codes</th>
                                <th scope="col">Submit Date</th>
                                <th scope="col">Status</th>
                                <th scope="col" class="text-center">Edit or Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            include("includes/connection.php");

                            $bring_data = "SELECT * FROM subjectregistration";

                            $result = mysqli_query($con, $bring_data);

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_array($result)) :
                            ?>
                                    <tr>
                                        <td> <?php echo $row['sub_reg_id']; ?> </td>
                                        <td> <?php echo $row['name']; ?> </td>
                                        <td> <?php echo $row['semester']; ?> </td>
                                        <td> <?php echo $row['sub_id']; ?> </td>
                                        <td> <?php echo $row['date']; ?> </td>
                                        <td> <?php echo $row['status']; ?> </td>
                                        <td class="text-center">
                                            <a class="btn btn-primary" href="subjectRagistrationEdit.php?edit=<?php echo $row['sub_reg_id']; ?> ">Edit</a>
                                            <a href="subjectRagistration.php?delete=<?php echo $row['sub_reg_id']; ?> " onclick="return confirm('Are you sure?');" class="btn btn-danger">Delete</a>
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