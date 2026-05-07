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

if (isset($_POST['subject_submit'])) {
    $courseCode = $_POST['courseCode'];
    $courseTitle = $_POST['courseTitle'];
    $credit = $_POST['credit'];

    if (!courseCode_exists()) {
        if ($courseCode == NULL) {
            echo "field empty";
        } else {
            $insert =  mysqli_query($con, "INSERT INTO allsubject (courseCode, courseTitle, credit) 
                VALUES ('$courseCode', '$courseTitle','$credit')");
        }

        $erroremail = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                <strong> Subject code are registered!</strong>. Please add another subject</a>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
            <meta http-equiv='refresh' content='2;url=subject_insert.php'>";
    } else {
        $erroremail = "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong>This subject Code already exists! try any other subject Code</strong>.
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
    }
}




?>
<!-- Show students -->
<div class="main_page">
    <div class="content-area">
        <div class="container-fluid">
            <div class="student-list">
                <div class="container">
                    <div class="subject-list">
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <?php
                                    if (isset($erroremail)) {
                                        echo $erroremail;
                                    }
                                    ?>
                                    <h2 class=" my-3">Subejct Add</h2>
                                    <form method="POST">
                                        <label class="mb-1" for="courseCode">Course Code :</label>
                                        <input type="text" name="courseCode" id="courseCode" class="form-control mb-3" placeholder="Course Code*" required>
                                        <label class="mb-1" for="courseTitle">Course Title :</label>
                                        <input type="text" name="courseTitle" id="courseTitle" class="form-control mb-3" placeholder="Course Title*" required>
                                        <label class="mb-1" for="credit">Credit hour :</label>
                                        <input type="text" name="credit" id="credit" class="form-control mb-3" placeholder="Credit hour*" required>

                                        <div class="d-flex justify-content-end gap-3">
                                            <button type="reset" class="btn btn-danger">Reset</button>
                                            <button type="submit" name="subject_submit" class="btn btn-success">submit</button>
                                        </div>
                                    </form>

                                </div>




                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>

<!-- 
    <script>
        function highlightRow(checkbox) {
            const row = checkbox.closest("tr");
            if (checkbox.checked) {
                row.classList.add("selected-row");
            } else {
                row.classList.remove("selected-row");
            }
        }
    </script> -->