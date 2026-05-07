<?php
$user_role = isset($_SESSION['user_role']) ? $_SESSION['user_role'] : 'student'; // Default to 'guest' if not set
?>
 
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/favicon.ico">

    <title>Versity Project Dashboard</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- fontawesome CSS -->
    <link href="css/fontawesome.min.css" rel="stylesheet">
    <link href="css/select2.min.css" rel="stylesheet">

    <!-- Tag Manager CSS -->
    <link href="css/tagmanager.css" rel="stylesheet">

    <!-- style css-->
    <link href="css/style.css" rel="stylesheet">

    <script src="js/jquery-3.6.3.min.js"></script>

    <!-- <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script> -->
    <script>
        // tinymce.init({
        //     selector: 'textarea'
        // });
    </script>

</head>

<body>


    <!--wrapper start-->
    <div id="wrapper">

        <div class="content-wrapper">