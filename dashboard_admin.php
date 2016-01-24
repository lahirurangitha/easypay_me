<?php
/**
 * Created by PhpStorm.
 * User: lasith-niro
 * Date: 17/10/15
 * Time: 07:53
 */

require_once 'core/init.php';
$user  = new User();
if(!$user->isLoggedIn()){Redirect::to('index.php');}
if(!$user->hasPermission('admin')){Redirect::to('index.php');}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin | Dashboard</title>
    <?php include 'headerScript.php'?>

</head>
<body>
<div id="wrapper">
    <?php
    include "header.php";
    ?>
</div>
<div class="backgroundImg container-fluid">
<?php
include "adminSidebar.php";
?>
    <div class="container col-sm-9">
        <div class="row">
            <div class="col-sm-6">
                <h2><strong>Admin Dashboard</strong></h2>
                <h5>Welcome <?php echo $_SESSION['fname']." ".$_SESSION['lname']?></h5>
            </div>
        </div>

        <hr />
        <div id="rAppPanel" class="container col-sm-12">
<!--            <div class="d_icon">-->
<!--                <a href="coord_RejectedRepeatApplications.php">-->
<!--                --><?php
//                $appCount = DB::getInstance()->get('repeat_exam',array('adminStatus','=',0));
//                $count = $appCount->count();
//                ?>
<!--                <div class="col-lg-offset-5"><span class="label label-danger ">--><?php //echo $count;?><!--</span></div>-->
<!---->
<!--                    <img src="images/notification.png" height="100px">-->
<!---->
<!--                    <div>-->
<!--                        <label>Rejected Repeat Exam Applications</label>-->
<!--                    </div>-->
<!--                </a>-->
<!--            </div>-->
			<div class="d_icon">
                <a href="admin_repeatExamApplicationTable.php">
                    <img src="images/editApplications.png" height="120px">

                    <div>
                        <label>Edit Repeat Applications</label>
                    </div>
                </a>
            </div>
            
            
            <div class="d_icon">
                <a href="admin_enableDisableUser.php">
                    <img src="images/accountsManager.png" height="120px">

                    <div>
                        <label>Accounts Manager</label>
                    </div>
                </a>
            </div>
			<div class="d_icon">
                <a href="notif_main_forum.php">
                    <img src="images/notificationForum.png" height="120px">

                    <div>
                        <label>Notifications Manager</label>
                    </div>
                </a>
            </div>
            <!--      chart      -->
            <div class="d_icon">
                <a href="line_html.php">
                    <img src="images/chart.png" height="120px">

                    <div>
                        <label>Payment Statistics</label>
                    </div>
                </a>
            </div>
			<div class="d_icon">
                <a href="email_notify.php">
                    <img src="images/email.png" height="120px">

                    <div>
                        <label>Email Inquiries</label>
                    </div>
                </a>
            </div>
            <!-- chart end-->

        </div>
        <div id="nPanel" class="container col-sm-4">

        </div>

    </div>
</div>
<?php
include "footer.php";
?>

</body>
</html>