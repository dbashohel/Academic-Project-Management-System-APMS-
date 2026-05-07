<?php
require_once '../vendor/autoload.php';
include("../includes/functions.php");

use Dompdf\Dompdf;

$dompdf = new Dompdf();

$supervisor_name = "Mr. Xyz df";

if (isset($_GET['project_id'])) {
    $project_id = $_GET['project_id'];
    $project_qry = "SELECT * FROM std_project_reg WHERE id = '$project_id'";
    $project_result = mysqli_query($con, $project_qry);
    $project = mysqli_fetch_assoc($project_result);
    // Validate and sanitize project data
    $project_type = isset($project['project_type']) ? htmlspecialchars($project['project_type']) : '';
    $program_type = isset($project['program_type']) ? htmlspecialchars($project['program_type']) : '';
    $semester = isset($project['semester']) ? htmlspecialchars($project['semester']) : '';
    $date = isset($project['date']) ? htmlspecialchars(date('Y', strtotime($project['date']))) : date('Y');

    $std_ids = mysqli_real_escape_string($con, $project['std_id_multiple']);
    $students_qry = "SELECT std_id, std_name FROM std_registration WHERE std_id IN ($std_ids)";
    $students_result = mysqli_query($con, $students_qry);

    $supervisor_email = $project['tcr_user_email'];
    $supervisor_qry = "SELECT tcr_name, department, designation FROM tcr_registration WHERE user_email= '$supervisor_email '";
    $supervisor_result = mysqli_query($con, $supervisor_qry);
    $supervisor = mysqli_fetch_assoc($supervisor_result);
}

$grades = json_decode($project['grade'], true) ?? [];
$grade_points = json_decode($project['grade_point'], true) ?? [];
$remarks = json_decode($project['remarks'], true) ?? [];

$result_html = "";
$count = 1;

while ($result = mysqli_fetch_assoc($students_result)) {
    $result_html .= '<tr>
                <td>' . $count++ . '</td>
                <td>' . $result['std_id'] . '</td>
                <td>' . $result['std_name'] . '</td>
                <td>' . (isset($grade_points[$result['std_id']]) ? $grade_points[$result['std_id']] : '') . '</td>
                <td>' . (isset($grades[$result['std_id']]) ? $grades[$result['std_id']] : '') . '</td>
                <td>' . (isset($remarks[$result['std_id']]) ? $remarks[$result['std_id']] : '') . '</td>
            </tr>';
}

$html = '
<!DOCTYPE html>
<html>
<head>
<style>
    body {
        font-family: serif;
        line-height: 1.6;
        margin: 40px;
    }
    
    .header {
        text-align: center;
        margin-bottom: 20px;
    }
    
    .university-name {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 15px;
    }
    
    .sheet-title {
        display: inline-block;
        border: 1px solid black;
        border-radius: 8px;
        padding: 5px 15px 10px;
        font-size: 18px;
        margin-bottom: 20px;
        font-weidth: 500;
    }
    
    .tick-section {
        margin-bottom: 13px;
    }
    .tick-section .text-decoration-underline{
       text-decoration: underline
    }
    .tick-section ul{
       margin-top: 8px;
    }
    
    .info-section {
        margin-bottom: 40px;
    }
    
    .info-row {
        margin-bottom: 8px;
    }
    .info-row.capitalize{
        text-transform: capitalize;
    }
    .info-row .capitalize{
        text-transform: capitalize;
    }

    .info-row label {
        font-weight: bold;
    }
    
    table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
        
    }
    
    th, td {
        border: 1px solid black;
        padding: 4px 8px 8px;
        text-align: left;
    }
    th:nth-child(1), td:nth-child(1) ,
    th:nth-child(4), td:nth-child(4) ,
    th:nth-child(5), td:nth-child(5){
        text-align: center;
    }
    
    .signature-section {
        margin-top: 100px;
    }
    
    .signature-line {
        border-top: 1px solid black;
        width: 200px;
        margin-bottom: 5px;
    }
    
    .supervisor-info {
        margin-bottom: 5px;
    }
    
    .department-head {
        text-align: center;
        margin-top: 80px;
    }
    
    .department-head-line {
        border-top: 1px solid black;
        width: 200px;
        margin: 5px auto;
    }
</style>
</head>
<body>
    <div class="header">
        <div class="university-name">UNIVERSITY OF SOUTH ASIA</div>
        <div class="sheet-title">Supplementary Marks Sheet</div>
    </div>
    
    <div class="tick-section">
       <span class="text-decoration-underline"> Please Put Tick:</span>
        <ul><li> Project & Thesis</li></ul>
    </div>
    
    <div class="info-section">
        <div class="info-row">
            <label>Department:</label> Computer Science and Engineering (<span class="capitalize">' . $program_type . '</span>)
        </div>
        <div class="info-row">
            <label>Program:</label> B. Sc in Computer Science and Engineering
        </div>
        <div class="info-row capitalize">
            <label>Semester:</label> ' . $semester . '
            <span style="float: right;"><label>Year:</label> ' . $date . '</span>
        </div>
        <div class="info-row">
            <label>Course Code:</label> CSE 4000
            <span style="float: right;"><label>Course Title:</label> Project & Thesis</span>
        </div>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>SI No</th>
                <th>Student\'s ID</th>
                <th>Name of the Student</th>
                <th>Total (100%)</th>
                <th>Grade</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>' . $result_html . '</tbody>
    </table>
    
    <div class="signature-section">
        <div class="signature-line"></div>
        <div class="supervisor-info">Signature of the Supervisor</div>
        <div class="supervisor-info">Full Name of the Supervisor:</div>
        <div class="supervisor-info">' . $supervisor['tcr_name'] . ', ' . $supervisor['designation'] . ', ' . $supervisor['department'] . '</div>
        <div class="supervisor-info">Date of Submission:</div>
    </div>
    
    <div class="department-head">
        <div class="department-head-line"></div>
        Head, Department of CSE
    </div>
</body>
</html>
';

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

$dompdf->stream($project['semester'] . '-' . $project['proposal'], array("Attachment" => false));
