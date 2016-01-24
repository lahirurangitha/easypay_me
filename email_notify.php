<?php
require_once 'core/init.php';
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title>Email | Page</title>
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
                <h3><strong>Email Inquiries</strong></h3>
                <!-- <a class="col-lg-offset-9" href="sendEmail.php"><strong>Send Email</strong></a> -->
            </div>

<?php


$user = new User();
if(!$user->isLoggedIn()){
    Redirect::to('index.php');
}
//check for admin
if ($user->hasPermission('admin')) {
?>
<table class="table table-striped table-bordered table-hover " width="90%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
    <?php
    //$user_id = $_SESSION['userid'];   // get usr id
    $notification = DB::getInstance()->query('SELECT * FROM mycontacts ORDER BY ContactID DESC ',array());
    if(!$notification->count()){
        echo '<div class="alert alert-info">No notifications</div>';
    }else{
    ?>
    <thead>
    <tr>
        <th>#</th>
        <th>Name</th>
        <th>email</th>
        <th>Message</th>
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
$CEmail=$t->ContactEmail;
        $counter+=1;
        echo"<tr>";
        echo "<td width=6% align=center bgcolor=#E6E6E6>".$counter."</td>";
        echo "<td width=6% align=center bgcolor=#E6E6E6>".$t->ContactName."</td>";
        echo "<td width=10% align=center bgcolor=#E6E6E6>".$t->ContactEmail."</td>";
        echo "<td width=20% align=center bgcolor=#E6E6E6>".$t->contactMessage."</td>";
        echo "<td width=5% align=center bgcolor=#E6E6E6>".$t->ContactDateCreated."</td>";
		echo "<td width=5% align=center bgcolor=#E6E6E6 data-color='red'><a onclick='return confirm(\"Are you sure?\")' href=contact_delete.php?cID=$t->ContactID>Clear</a><br>
<a href='sendEmail2.php?varname=$CEmail' >Send Email</a>
        </td>";

        echo "</tr>";
    }
    }
    ?>
    </tbody>




</table>
        </div>
    </div>
<!--    <div id="assignUser" class="modal fade" role="dialog">-->
<!--        <div class="modal-dialog">-->
<!--            <!-- Modal content-->
<!--            <div class="modal-content">-->
<!--                <div class="modal-header">-->
<!--                    <button type="button" class="close" data-dismiss="modal">&times;</button>-->
<!--                    <h4 class="modal-title">Select Users</h4>-->
<!--                </div>-->
<!--                <div class="modal-body">-->
<!--                    <p>Some text in the modal.</p>-->
<!--                </div>-->
<!--                <div class="modal-footer">-->
<!--                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
<!--                </div>-->
<!--            </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
</div>
<?php
} else {
    Redirect::to('index.php');
}

include "footer.php";
?>

</body>
</html>
