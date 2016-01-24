<?php
/**
 * Created by PhpStorm.
 * User: lasithniro
 * Date: 1/2/16
 * Time: 6:09 PM
 */

require_once 'core/init.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Notification | Page</title>
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
$user = new User();
$notification = new Notification();
if(!$user->isLoggedIn()){Redirect::to('index.php');}
//check for admin
if (!$user->hasPermission('admin')) {Redirect::to('index.php');}
$notifyID = $_GET['id'];
//echo $notifyID;
    ?>
    <div class="col-sm-9">
        <br>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3><strong>Remove Assigned Users From Notification</strong></h3>
<!--                <button class="btn btn-primary btn-xs col-sm-1" style="float: right" onclick="window.location.href='notif_main_forum.php'"><< Back</button>-->
            </div>
            <div class="panel-body">
                <div class="pre-scrollable" style="max-height: 400px">
                <table class="table table-striped table-bordered table-hover ">

                    <?php
                    /*count|username|batch|topic|send data|setting*/
                    $data = $notification->outNotifications($notifyID);
                    //    print_r($data);
                    if($data){
                        ?>
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Username</th>
                        <th>Batch</th>
                        <th>Topic</th>
                        <th>Send date</th>
                        <th>Settings</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                        $counter = 0;
                        foreach((array)$data as $d){
                            $notid = $d->nID;
                            $userid = $d->uID;
                            $usernameObject = $notification->getUsername($userid);
                            foreach((array)$usernameObject as $u){$username=$u->username;}
                            $userbatchObject = $notification->getUserBatch($userid);
                            foreach((array)$userbatchObject as $u){$userbatch=$u->year;}
                            $topicObject = $notification->getTopic($notid);
                            foreach((array)$topicObject as $t){$topic=$t->topic;}
                            $date = $d->send_date;
                            $counter++;
                            echo"<tr>";
                            echo "<td width=6% align=center bgcolor=#E6E6E6>".$counter."</td>";
                            echo "<td width=10% align=center bgcolor=#E6E6E6>".$username."</td>";
                            echo "<td width=20% align=center bgcolor=#E6E6E6>".$userbatch."</td>";
                            echo "<td width=20% align=center bgcolor=#E6E6E6>".$topic."</td>";
                            echo "<td width=20% align=center bgcolor=#E6E6E6>".$date."</td>";

                            echo "<td width=5% align=center bgcolor=#E6E6E6 data-color='red'><a onclick='return confirm(\"Are you sure?\")' href=notif_disAllowUser.php?nid=$notid&uid=$userid>Remove</a>
                  </td>";

                            echo "</tr>";
                        }
                    }else {
                        echo("<div class='alert alert-info'>No users assigned to this notification.</div>");
                    }
                    ?>
                    </tbody>




                </table>
                </div>
            </div>

        </div>
    </div>
    </div>
<?php
include "footer.php";
?>

</body>
</html>
