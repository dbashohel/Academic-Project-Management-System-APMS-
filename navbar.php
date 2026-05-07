<?php if (!empty($user_role)) : ?>

    <!-- Top Navigation Start -->
    <div class="top-navigation">
        <nav class="navbar navbar-default py-3">
            <div class="container-fluid no-padding pe-3 pe-md-4">
                <div class="d-flex gap-2 align-items-center">
                    <div id="aside-toggler" class="bars pull-left  box_10 rounded-circle d-center">
                        <i class="fa fa-bars"></i>
                    </div>
                    <button onclick="history.back()" id="go-back" class="back_btn box_10 rounded-circle "><i class="fa-solid fa-arrow-left"></i></button>
                </div>
                <ul class="parent-ul pull-right d-flex gap-1 gap-md-3 align-items-center">
                    <li class="parent-li">

                        <?php

                        $user_role = isset($_SESSION["user_role"]) ? $_SESSION["user_role"] : null;
                        $user_image = 'user.png'; // Default image
                        if ($user_role == 'student') {
                            $std_id = $_SESSION["std_id"];
                            $query = "SELECT * FROM std_registration WHERE std_id = '$std_id'";
                            $result = mysqli_query($con, $query);

                            if ($result && mysqli_num_rows($result) > 0) {
                                $userData = mysqli_fetch_assoc($result);
                                $user_image = !empty($userData['std_img']) ? $userData['std_img'] : $user_image;
                            }
                        } elseif (($user_role == 'teacher') || ($user_role == 'admin')) {
                            $user_email = $_SESSION["user_email"];
                            $query = "SELECT * FROM tcr_registration WHERE user_email = '$user_email'";
                            $result = mysqli_query($con, $query);

                            if ($result && mysqli_num_rows($result) > 0) {
                                $userData = mysqli_fetch_assoc($result);
                                $user_image = !empty($userData['tcr_img']) ? $userData['tcr_img'] : $user_image;
                            }
                        }
                        $profileLink = ($user_role == 'student') ? 'std_profile.php' : 'my_profile.php';
                        ?>
                        <a href="<?php echo $profileLink; ?>" class="user_thumb ">
                            <img src="./uploads/students/<?php echo $user_image; ?>" alt="img" class="box_10 shadow2">
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
    <!-- Top Navigation Close -->
<?php endif ?>
<?php

function generateNavMenu($user_role, $page = '')
{
    $status = isset($_GET['status']) ? $_GET['status'] : "";
    echo '<aside>';
    echo '    <div class="fixed-sidebar" id="according">';

    if ($user_role == 'student') {
        echo '        <a href="std_dashboard.php" class="logo"><img src="img/nub_logo.png" alt=""></a>';
        echo '        <ul class="nav student mt-4">';
        echo '            <li><a href="std_dashboard.php">Dashboard</a></li>';
        echo '            <li><a href="std_project_reg.php"> Project Registration </a></li>';
        echo '            <li><a href="std_project_info.php"> My Project </a></li>';
        echo '            <li><a href="std_profile.php"> My Profile </a></li>';
        echo '        </ul>';
    } elseif ($user_role == 'teacher') {
        echo '        <a href="index.php" class="logo"><img src="img/nub_logo.png" alt=""></a>';
        echo '        <ul class="nav admin mt-4">';
        echo '            <li><a class="' . ($page == 'index' ? 'active' : '') . '" href="index.php">Dashboard</a></li>';

        echo '            <li><a class="' . ($status == 'pending' ? 'active' : '') . '" href="tcr_std_project_card.php?status=pending">Project Pending </a></li>';
        echo '            <li><a class="' . ($status == 'approved' ? 'active' : '') . '" href="tcr_std_project_card.php?status=approved">Project Approved</a></li>';
        echo '            <li><a class="' . ($status == 'complete' ? 'active' : '') . '" href="tcr_std_project_card.php?status=complete">Complete Group</a></li>';
        echo '            <li><a class="' . ($status == 'reject' ? 'active' : '') . '" href="tcr_std_project_card.php?status=reject">Reject Group</a></li>';
        echo '            <li><a class="' . ($page == 'profile' ? 'active' : '') . '" href="my_profile.php">My Profile </a></li>';

        echo '        </ul>';
    } elseif ($user_role == 'admin') {
        echo '        <a href="index.php" class="logo"><img src="img/nub_logo.png" alt=""></a>';
        echo '        <ul class="nav Teacher mt-4">';
        echo '            <li><a href="index.php">Dashboard</a></li>';
        echo '            <li><a href="tcr_reg_pending.php"> Teachers Pending</a></li>';
        echo '            <li><a href="teacher_info.php"> Teachers Info</a></li>';
        echo '            <li><a href="tcr_students_info.php"> Students Info</a></li>';
        echo '            <li><a href="tcr_std_reg_pending.php"> Student Pending</a></li>';
        echo '            <li><a href="tcr_std_project_complete.php">Project & Thesis Complete Group</a></li>';
        // echo '            <li><a href="subject_insert.php"> Subject Insert</a></li>';
        echo '            <li><a href="my_profile.php"> My Profile </a></li>';
        echo '        </ul>';
    }
    echo '        <ul class="nav mt-5">';
    echo '            <li class="parent-li">';
    echo '                <a href="logout.php" class="parent-a"> <i class="fa fa-sign-out"></i> Log Out </a>';
    echo '            </li>';
    echo '        </ul>';

    echo '    </div>';
    echo '</aside>';
}


?>