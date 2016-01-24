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
if(!$user->hasPermission('coord')){Redirect::to('index.php');}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Coordinator | Dashboard</title>
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
include "coordinatorSidebar.php";
?>
    <div class="container col-lg-9">
        <div class="row">
            <div class="col-lg-6">
                <h2><strong>Coordinator Dashboard</strong></h2>
                <h5>Welcome <?php echo $_SESSION['fname']." ".$_SESSION['lname']?></h5>
            </div>
        </div>

        <hr />
        <div id="rAppPanel" class="container col-sm-8">
            <div class="d_icon">
                <a href="coord_repeatExamApplication.php">
                <?php
                $appCount = DB::getInstance()->query('SELECT * FROM repeat_exam WHERE adminStatus = 0 AND paymentStatus = 1',array());
                $count = $appCount->count();
                ?>
                <div class="col-lg-offset-5"><span class="label label-danger "><?php echo $count;?></span></div>

                    <img src="images/notification.png" height="100px">

                    <div>
                        <label>Repeat Exam Applications</label>
                    </div>
                </a>
            </div>

        </div>
        <div id="nPanel" class="container col-lg-4">

        </div>

    </div>
</div>
<?php
include "footer.php";
?>

</body>
</html>