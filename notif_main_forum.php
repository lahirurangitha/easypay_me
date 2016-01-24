<?php
require_once 'core/init.php';
require 'Files/accessFile.php';
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
?>
    <br>
    <div class="col-sm-9">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3><strong>Notification Forum</strong></h3>
                <a class="col-sm-offset-9" href="notif_add_topic.php"><strong>Create New Notification >></strong></a>
            </div>
            <div class="panel-body">

<?php


$user = new User();
if(!$user->isLoggedIn()){
    Redirect::to('index.php');
}
//check for admin
if ($user->hasPermission('admin')) {
?>
            <div class="pre-scrollable" style="min-height: 100px">
<table class="table table-striped table-bordered table-hover">
    <?php
    //$user_id = $_SESSION['userid'];   // get usr id
    $notification = DB::getInstance()->query('SELECT * FROM notification ORDER BY nID DESC ',array());
    if(!$notification->count()){
        echo "<br><div class='alert alert-info alert-dismissible'>No notifications found.<button type = 'button' class = 'close' data-dismiss = 'alert' aria-hidden = 'true'>&times;</button></div>";
    }else{
    ?>
    <thead>
    <tr>
        <th>Notification ID</th>
        <th>Topic</th>
        <th>Description</th>
        <th>Date and time</th>
        <th>Settings</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $counter = 0;
    foreach($notification->results() as $t){
//                                    print_r($t);
//                                    echo'<br>';

        $id = $t->nID;
        $counter+=1;
        echo"<tr>";
        echo "<td width=6% align=center bgcolor=#E6E6E6>".$t->nID."</td>";
        echo "<td width=10% align=center bgcolor=#E6E6E6>".$t->topic."</td>";
        echo "<td width=20% align=center bgcolor=#E6E6E6>".$t->detail."</td>";
        echo "<td width=5% align=center bgcolor=#E6E6E6>".$t->datetime."</td>";
        $_SESSION['dID'] = $t->nID;
        echo "<td width=5% align=center bgcolor=#E6E6E6 data-color='red'><a href=notif_delete.php?id=$id>Clear</a><br>
<a href='notif_assign_users.php?id=$id'>Assign users</a><br><a href='notif_remove_user.php?id=$id'>Remove users</a>
        </td>";

        echo "</tr>";
    }
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
} else {
    Redirect::to('index.php');
}

include "footer.php";
?>

</body>
</html>
