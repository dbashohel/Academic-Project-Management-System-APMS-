<?php

require_once('connection.php');

function tcr_email_exists($con, $user_email2)
{
    $query = mysqli_query($con, "SELECT * FROM tcr_registration WHERE user_email = '$user_email2'");
    if (mysqli_num_rows($query) == 1) {
        return true;
    } else {
        return false;
    }
}
// function tcr_nid_exists($con, $user_nid)
// {
//     $query = mysqli_query($con, "SELECT * FROM tcr_registration WHERE user_nid = '$user_nid'");
//     if (mysqli_num_rows($query) == 1) {
//         return true;
//     } else {
//         return false;
//     }
// }
function std_id_exists($con, $std_id)
{
    $query = mysqli_query($con, "SELECT * FROM std_registration WHERE std_id = '$std_id'");
    if (mysqli_num_rows($query) == 1) {
        return true;
    } else {
        return false;
    }
}
function std_email_exists($con, $user_email)
{
    $query = mysqli_query($con, "SELECT * FROM std_registration WHERE user_email = '$user_email'");
    if (mysqli_num_rows($query) == 1) {
        return true;
    } else {
        return false;
    }
}
function std_Pro_email_exists($con, $std_email)
{
    $query = mysqli_query($con, "SELECT * FROM std_project_reg WHERE std_email = '$std_email'");
    if (mysqli_num_rows($query) == 1) {
        return true;
    } else {
        return false;
    }
}

// function std_id_exists($con, $std_id)
// {
//     $stmt = $con->prepare("SELECT 1 FROM std_registration WHERE std_id = ?");
//     $stmt->bind_param("s", $std_id);
//     $stmt->execute();
//     $stmt->store_result();
//     return $stmt->num_rows > 0;
// }

// function std_email_exists($con, $user_email)
// {
//     $stmt = $con->prepare("SELECT 1 FROM std_registration WHERE user_email = ?");
//     $stmt->bind_param("s", $user_email);
//     $stmt->execute();
//     $stmt->store_result();
//     return $stmt->num_rows > 0;
// }



// function std_email_exists($con, $user_email)
// {
//     $stmt = $con->prepare("SELECT * FROM std_registration WHERE user_email = ?");
//     $stmt->bind_param("s", $user_email);
//     $stmt->execute();
//     $result = $stmt->get_result();
//     return $result->num_rows === 1;
// }

// function std_id_exists($con, $std_id)
// {
//     $query = mysqli_query($con, "SELECT * FROM std_registration WHERE std_id = '$std_id'");
//     if (mysqli_num_rows($query) >= 1) { // Changed condition to check if there are any rows with the given student ID
//         return true;
//     } else {
//         return false;
//     }
// }

// function subReg_exists(){

// 	global $con;
// 	global $std_id;
// 	global $sub_id;

// 	$query = mysqli_query($con, "SELECT * FROM subjectregistration WHERE std_id = '$std_id' AND sub_id = '$sub_id'");
// 	if(mysqli_num_rows($query) == 1){
// 		return true;
// 	}
// }

function courseCode_exists()
{

    global $con;
    global $courseCode;

    $query = mysqli_query($con, "SELECT * FROM allsubject WHERE courseCode = '$courseCode'");
    if (mysqli_num_rows($query) == 1) {
        return true;
    }
}




function getFileIcon($fileType)
{
    $icons = [
        'PDF' => 'fa-file-pdf',
        'DOC' => 'fa-file-word',
        'DOCX' => 'fa-file-word',
        'XLS' => 'fa-file-excel',
        'XLSX' => 'fa-file-excel',
        'JPG' => 'fa-file-image',
        'JPEG' => 'fa-file-image',
        'PNG' => 'fa-file-image',
        'TXT' => 'fa-file-text',
        'ZIP' => 'fa-file-archive',
        'RAR' => 'fa-file-archive',
        'PPT' => 'fa-file-powerpoint',
        'PPTX' => 'fa-file-powerpoint'
    ];
    return isset($icons[$fileType]) ? $icons[$fileType] : 'fa-file';
}
  

// function user_logged_in(){
// 	if(isset($_SESSION['user_id'])){
// 		return true;
// 	}
// }

 
// function call 
// generateNavMenu('admin'); // or generateNavMenu('user');

require_once('navbar.php');
