<?php
session_start();
include("includes/header.php");
include("includes/functions.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}
generateNavMenu('user');

$user_id = $_SESSION["user_id"];
$name = $_SESSION["name"];
?>

<style>
    .total-info {
        border-top: 2px solid gray !important;
    }
</style>

<div class="main_page">
    <div class="content-area">
        <div class="container-fluid">
            <!-- subject_reg -->
            <div class="subject_reg">
                <div class="container">
                    <h2 class="my-3">Student name : <?php echo $name ?></h2>
                    <h2 class="my-3">Student ID : <?php echo $user_id ?></h2>

                    <?php
                    // Initialize variables to store total credit, total TGP, and total gradepoint
                    $totalCredit = 0;
                    $totalTGP = 0;
                    $totalGradepoint = 0;
                    $totalSubjects = 0;
                    // Loop through all semesters
                    for ($semesterNumber = 1; $semesterNumber <= 12; $semesterNumber++) {
                        $semesterName = $semesterNumber . (($semesterNumber == 1) ? 'st' : (($semesterNumber == 2) ? 'nd' : (($semesterNumber == 3) ? 'rd' : 'th')));                       
                        $bring_data = "SELECT * FROM studentresult WHERE semester = '$semesterName' AND std_id = '$user_id' ";                    
                        $result = mysqli_query($con, $bring_data);
                        $totalSemesterCredit = 0;
                        $totalSemesterTgp = 0;
                        $totalSemesterGradepoint=0;
                    ?>

                        <div class="row">
                            <h5><?php echo $semesterName; ?> Semester</h5>
                            <table class="table subject-reg table-striped table-hove mt-5">
                                <?php

                                if (mysqli_num_rows($result) > 0) {
                                ?>
                                    <thead>
                                        <tr>
                                            <th class="font-medium">Subject Code</th>
                                            <th class="font-medium">Subject Title</th>
                                            <th class="font-medium">Credit Hour</th>
                                            <th class="font-medium">Letter Grade</th>
                                            <th class="font-medium">Grade Point</th>
                                            <th class="font-medium">TGP</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        while ($row = mysqli_fetch_array($result)) :
                                            $credit = floatval($row['credit']);
                                            $totalCredit += $credit;
                                            $totalSemesterCredit += $credit;
                                            $gradepoint = floatval($row['gradepoint']);
                                            $totalGradepoint += $gradepoint;
                                            $totalSemesterGradepoint += $gradepoint;
                                            $tgp = $credit * $gradepoint;
                                            $totalTGP += $tgp;
                                            $totalSemesterTgp += $tgp;
                                            $totalSubjects++;
                                        ?>
                                            <tr>
                                                <td> <?php echo $row['courseCode']; ?> </td>
                                                <td> <?php echo $row['courseTitle']; ?> </td>
                                                <td> <?php echo $credit; ?> </td>
                                                <td> <?php echo $row['lettergrade']; ?> </td>
                                                <td> <?php echo $gradepoint; ?> </td>
                                                <td> <?php echo $tgp; ?> </td>
                                            </tr>

                                    <?php
                                        endwhile;
                                        ?>
                                        <tr style="border-top: 2px solid gray;">
                                        <td></td>
                                        <td></td>
                                        <td><?php echo $totalSemesterCredit; ?></td>
                                        <td></td>
                                        <td><?php echo number_format($totalSemesterTgp/$totalSemesterCredit,2); ?></td>
                                        <td><?php echo $totalSemesterTgp; ?></td>
                                    </tr>
                                    <?php
                                    } else {
                                        echo '<tr><td colspan="6">Result Not Published yet for this semester.</td></tr>';
                                    }
                                    ?>
                                   
                                    </tbody>
                            </table>
                        </div>
                    <?php
                        // Increment the total credit for all semesters
                        $cgpa=0;
                        if($totalGradepoint>0){
                            $cgpa = number_format($totalGradepoint / $totalSubjects, 2);
                        }
                        $lettergrade='';
                        switch (true) {
                            case $cgpa >= 4.00:
                                $letterGrade = 'A+';
                                break;
                            case $cgpa >= 3.75:
                                $letterGrade = 'A';
                                break;
                            case $cgpa >= 3.50:
                                $letterGrade = 'A-';
                                break;
                            case $cgpa >= 3.25:
                                $letterGrade = 'B+';
                                break;
                            case $cgpa >= 3.00:
                                $letterGrade = 'B';
                                break;
                            case $cgpa >= 2.75:
                                $letterGrade = 'B-';
                                break;
                            case $cgpa >= 2.50:
                                $letterGrade = 'C+';
                                break;
                            case $cgpa >= 2.25:
                                $letterGrade = 'C';
                                break;
                            case $cgpa >= 2.00:
                                $letterGrade = 'D';
                                break;
                            default:
                                $letterGrade = 'F';
                                $gradePoint = 0.00;
                                break;
                        }
                    } // end for loop
                    ?>

                    <!-- Display total credit, total TGP, and total gradepoint after the loop -->
                    <div class="row mt-5">
                        <h5>Total Result Summary</h5>
                        <table class="table subject-reg table-striped table-hove mt-3">
                            <thead>
                                <tr>
                                    <th class="font-medium">Total Credit</th>
                                    <th class="font-medium">Letter Grade</th>
                                    <th class="font-medium">CGPA</th>
                                    <th class="font-medium">Total TGP</th>
                                </tr>
                            </thead>
                            <tbody>
                            <tr style="border-top: 2px solid gray;">
                                    <td><?php echo $totalCredit; ?></td>
                                    <td><?php echo $letterGrade; ?></td>
                                    <td><?php echo number_format($totalTGP/$totalCredit,2); ?></td>
                                    <td><?php echo $totalTGP; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include("includes/footer.php"); ?>
