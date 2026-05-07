<?php
session_start();

include("includes/header.php"); ?>
<?php include("includes/functions.php"); 
if (!isset($_SESSION["user_id"])) {
        header("Location: login.php");
        exit;
    }
    generateNavMenu('user');
?>

<?php
$user_role = $_SESSION["user_role"];
$user_id = $_SESSION["user_id"];

$result = mysqli_query($con, "select * from registration WHERE std_id = '$user_id'");

if (!$result) {
    die("Error: " . mysqli_error($con));
}

?>


<!--content area start-->
<div class="main_page">
    <div class="content-area">
        <div class="container-fluid">
            <div class="user_profile pt-5">
                <div class="container pt-5">
                    <?php
                    while ($row = mysqli_fetch_assoc($result)) :
                    ?>
                        <h2 class="mb-4">Hi <?php echo $row['name']; ?> Welcome to USA Portal</h2>
                    <?php
                    endwhile;
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6  col-lg-4 col-xxl-3">
                    <div class="card box-card">
                        <a href="subjectRegistrationStd.php" class="d-flex flex-column text-center gap-2">
                            <i class="fa fa-book"></i>
                            <span>Registration</span>
                        </a>
                    </div>
                </div>
                <div class="col-md-6  col-lg-4 col-xxl-3">
                    <div class="card box-card">
                        <a href="resultInfo_user.php" class="d-flex flex-column text-center gap-2">
                            <i class="fa fa-pencil"></i>
                            <span>Result Information</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--content area end-->
<?php include("includes/footer.php"); ?>