<?php
/**
 * Created by PhpStorm.
 * User: lasithniro
 * Date: 1/9/16
 * Time: 6:23 PM
 */

require_once 'core/init.php';
$user = new User();
$notification = new Notification();
//check for login
if(!$user->isLoggedIn()){Redirect::to('index.php');}
?><!DOCTYPE html>
<html lang="en">

<head>
    <title>My | Notification</title>
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
    include "studentSidebar.php";
    ?>
    <br>
    <div class="col-md-9 col-sm-12 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3><strong>Remove My Notifications</strong></h3>
            </div>

    <?php
    /* nID | uID | Topic | Description */
    $uID = $user->data()->id;
    $Tdata= DB::getInstance()->query('SELECT * FROM repeatexam_notification WHERE uID = ?',array($uID));
    $data = $Tdata->results();
    if($Tdata->count()>0){
        ?>
            <table class="table table-striped table-bordered table-hover ">
                <thead>
                <tr>
                    <th>#</th>
                    <!--        <th>Username</th>-->
                    <th>Topic</th>
                    <th>Description</th>
                    <th>Settings</th>
                </tr>
                </thead>
                <tbody>
                <?php
        $count = 0;
        foreach($data as $d){
            $count++;
            $notficationID = $d->nID;
            $userID = $d->uID;
            $U = $notification->getUsername($userID);
//        print_r($U);
            foreach((array)$U as $u){$username=$u->username;}
            $topic = $d->topic;
            $decrp = $d->description;

            echo"<tr>";
            echo "<td width=5% align=center bgcolor=#E6E6E6>".$count."</td>";
//        echo "<td width=6% align=center bgcolor=#E6E6E6>".$username."</td>";
            echo "<td width=10% align=center bgcolor=#E6E6E6>".$topic."</td>";
            echo "<td width=20% align=center bgcolor=#E6E6E6 >".$decrp."</td>";
            echo "<td width=5% align=center bgcolor=#E6E6E6 data-color='red'><a onclick='return confirm(\"Are you sure?\")' href=notif_repeatexam_disAllowUser.php?nid=$notficationID&uid=$userID>Clear</a>
                  </td>";
            echo "</tr>";
        }
    }else{
        echo "<div class='alert alert-info'>No notifications</div>";
    }


?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
include "footer.php";
?>

</body>
</html>