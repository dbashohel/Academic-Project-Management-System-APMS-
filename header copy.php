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

    <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: 'textarea'
        });
    </script>

</head>

<body>


    <!--wrapper start-->
    <div id="wrapper">

        <div class="content-wrapper">
            <!--top navigation start-->
            <div class="top-navigation">
                <nav class="navbar navbar-default">
                    <div class="container-fluid no-padding pe-3 pe-md-4">

                        <div id="aside-toggler" class="bars pull-left">
                            <i class="fa fa-bars"></i>
                        </div>

                        <ul class="parent-ul pull-right d-flex gap-1 gap-md-3 align-items-center">
                            <li class="parent-li">
                                <a href="#" class="parent-a"> <i class="fa-solid fa-bell"></i> </a>
                            </li>
                            <li class="parent-li">
                                <?php if ($user_role == 'student') { ?>
                                    <a href="std_profile.php" class="user_thumb">
                                        <img src="img/user.png" alt="img">
                                    </a>
                                <?php } else { ?>
                                    <a href="my_profile.php" class="user_thumb">
                                        <img src="img/user.png" alt="img">
                                    </a>
                                <?php } ?>
                            </li> 
                        </ul>
                    </div>
                </nav>
            </div>
            <!--top navigation close-->

            <style>
                table thead tr th {
                    font-weight: 600;
                }
            </style>