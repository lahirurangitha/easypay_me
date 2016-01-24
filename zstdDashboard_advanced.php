<?php
require_once 'core/init.php';
require 'Files/accessFile.php';
if(!$_SESSION['isLoggedIn']) {
    Redirect::to('index.php');
}
if($_SESSION['admin']){
    Redirect::to('dashboard_admin.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>User Dashboard</title>
    <?php include 'headerScript.php'?>
</head>

<body>
<!--nav-->
<div id="navbars">
    <nav class="navbar navbar-default" style="margin: 0px;">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="homePage.php"><img id="img" src="images/logo.png" width="150px" ></a>
            </div>
            <div class="collapse navbar-collapse"  id="navbar-1" >
                <!--          inline form  -->
                <?php
                if(!isset($_SESSION['isLoggedIn'])|| $_SESSION['isLoggedIn']==false){
                    ?>
                    <div style="float: right">
                        <form action="homePage.php" method="POST" class="form-inline">
                            <div class="form-group">
                                <input class="form-control" required id="username" type="text" name="username" autocomplete="off" placeholder="Username"/>
                            </div>
                            <div class="form-group">
                                <input class="form-control" required id="password" type="password" name="password" autocomplete="off" placeholder="Enter password" size="25" maxlength="20"/>
                            </div>
                            <input class="btn btn-primary" type="submit" value="Sign in" name="inlinesubmit"/>
                            <div class="">
                                <input type="checkbox"  name="remember"/> Remember me
                                <a href="forgetpass.php" title="To recover your password, click here" >Forgot password?</a>
                            </div>
                        </form>
                    </div>
                <?php
                }
                ?>
                <!--           /inline form -->
                <ul class="nav navbar-nav">
                    <?php
                    if(!isset($_SESSION['isLoggedIn'])|| $_SESSION['isLoggedIn']==false){
                        ?>
                        <li>
                            <a href="login.php">LOGIN</a>
                        </li>
                        <li>
                            <a href="register.php">REGISTER</a>
                        </li>
                        <li>
                            <a href="about.php">ABOUT</a>
                        </li>
                        <li>
                            <a href="contact.php">CONTACT</a>
                        </li>
                    <?php
                    }else{
                    ?>
                    <li>
                        <a href="dashboard_student.php">DASHBOARD</a>
                    </li>
                    <li>
                        <a href="about.php">ABOUT</a>
                    </li>
                    <li>
                        <a href="contact.php">CONTACT</a>
                    </li>
                </ul>
            <!--                button logout-->
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span>  LOGOUT</a></li>
                </ul>
<!--                -->
                <?php
                $user = new user();
                $user_id = $user->data()->id;
                $userNotificationDet = DB::getInstance();
                $userNotificationDet->query('SELECT * FROM notification n, user_notification un WHERE un.uID = ? and n.nID = un.nID ORDER BY n.nID DESC',array($user_id));
                $count = $userNotificationDet->count();
                ?>
                <ul class="nav navbar-nav navbar-right" title="Notifications">
                    <div class="col-sm-2">
                    <li>
                    <a id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="/page.html">
                        <?php
                        if($count>0){
                            ?>
                            <i class="label label-danger col-sm-offset-5"><?php echo $count;?></i>
                        <?php
                        }else{
                            ?>
                            <i class="label label-info col-sm-offset-5"><?php echo $count;?></i>
                        <?php
                        }
                        ?>
<!--                        <span class="glyphicon glyphicon-bell"> NOTIFICATIONS</span>-->
                        <span class="glyphicon glyphicon-bell">


                        </span>
                    </a>
                    <ul class="dropdown-menu notifications navbar-default pre-scrollable" role="menu" aria-labelledby="dLabel" style="max-height: 300px;">
                        <div class="col-sm-12 ">
                            <?php
                            $resultSet = $userNotificationDet->results();
                            if($count>0){
                                foreach($resultSet as $n ){
                                    echo "<div class=''><p><strong>$n->topic</strong></p><p>$n->detail</p></div>";
                                }
                            }else{
                                echo "<div class=''><p>No Notifications</p></div>";
                            }

                            ?>
                        </div>
                    </ul>
                    </li>
                    </div>
                </ul>


            <?php
            }
            ?>
            </div>
        </div>
    </nav>
</div>
<!--nav-->
<div class="backgroundImg container-fluid">
    <?php
    include "studentSidebar.php";
    $fileObject = new accessFile();
    $dataArray = $fileObject->read('Files/admissionActivate');
    $user = new User();
    $startDate = $dataArray[0];
    $endDate   = $dataArray[1];
    date_default_timezone_set("Asia/Colombo");
    $curDate=date("Y-m-d");
    ?>
    <!-- /. NAV SIDE  -->
    <div class="container col-sm-9 " id="page-wrapper" >
        <div class="row">
            <div class="col-sm-12">
                <div class="col-sm-8">
                    <h2>Student Dashboard</h2>
                    <h5>Welcome <?php echo $_SESSION['fname']." ".$_SESSION['lname']?></h5>
                </div>
                <br>
                <!--Start: give this to lahiru-->
                <?php
                if($startDate<$curDate and $curDate<$endDate){
                    ?>
                    <div class="col-sm-4 alert alert-success alert-dismissible" style="float: right">
                        <label class="label label-default">Click to Download Admission card</label>
                        <input class="btn btn-primary btn-xs" type="button" value="Download" onclick="window.open('pdftest.php')">
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                    </div>
                <?php
                }
                ?>
                <!--            end-->
            </div>
        </div>
        <hr />

        <div class="col-sm-9">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Transaction History Table</h4>
                </div>
                <div class="panel-body">
                    <div class="table-responsive pre-scrollable" style="max-height:200px;">
                        <table class="table table-striped table-bordered table-hover">
                            <?php
                            $user_id = $_SESSION['userid'];   // get usr id
                            $transaction = DB::getInstance()->get('transaction',array('payerID','=',$user_id));
                            if(!$transaction->count()){
                                echo 'No transactions';
                            }else{
                            ?>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Transaction ID</th>
                                <!--                            <th>PayerID</th>-->
                                <th>Payment type</th>
                                <th>Status</th>
                                <th>Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $counter = 0;
                            foreach($transaction->results() as $t){
//                                       print_r($t);
//                                       echo'<br>';
                                $counter+=1;
                                echo"<tr>";
                                echo "<td>".$counter."</td>";
                                echo "<td>".$t->date."</td>";
                                echo "<td>".$t->time."</td>";
                                echo "<td>".$t->transactionID."</td>";
//                                echo "<td>".$t->payerID."</td>";
                                echo "<td>".$t->paymentType."</td>";
                                echo "<td>".$t->statusDescription."</td>";
                                echo "<td>".$t->amount."</td>";
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
        <!--    nadeesh-->
        <div id="nPanel" class="container col-sm-3">
            <div id="paymentNotification" class="panel panel-default">
                <div class="box-header with-border">
                    <div class="box-title">
                        <h4 class="col-sm-offset-1"> Notifications</h4>
                        <div class="box-tools pull-right ">
                            <button class="btn btn-info" data-widget="collapse" data-toggle="collapse" data-target="#nBox" title="Collapse"  style="margin-top:-65px;margin-left:-35px;"><i class="fa fa-plus"></i></button>
                        </div>
                    </div>
                    <div id="nBox" class="container col-sm-12 box-body alert-info pre-scrollable" style="max-height:250px;">

                        <?php
                        //                    $conn = mysqli_connect("localhost","root","","easypay_db");
                        //                    mysqli_select_db($conn,"easypay_db");
                        //                    $sql = "SELECT * FROM notification";
                        //                    $result = mysqli_query($conn,$sql);
                        //                    $data = mysqli_fetch_assoc($result);
                        //
                        //                    while($row = mysqli_fetch_assoc($result)){
                        //                        echo "<p>"."<b>".$row['topic']."</b>"."</p>";
                        //                        echo "<p>".$row['detail']."</p>";
                        //                    }
                        //                    mysqli_close($conn);

                        $user = new user();
                        $user_id = $user->data()->id;
                        //                    echo $user_id;
                        $userNotificationDet = DB::getInstance();
                        $userNotificationDet->query('SELECT * FROM notification n, user_notification un WHERE un.uID = ? and n.nID = un.nID',array($user_id));
                        //                    print_r($userNotificationDet->results());
                        $resultSet = $userNotificationDet->results();
                        foreach($resultSet as $n ){
                            echo "<a href='#'><strong>$n->topic</strong> <br> $n->detail</a><br>";
                        }


                        //                    $conn = mysqli_connect("localhost","root","","easypay_db");
                        //                    mysqli_select_db($conn,"easypay_db");
                        //
                        //                    $user_id = $_SESSION["userid"]; // store the user id into session
                        //
                        //                    $sql1 = "SELECT * FROM user_notification";
                        //                    $result1 = mysqli_query($conn,$sql1);
                        //
                        //                    while($row1 = mysqli_fetch_assoc($result1)){
                        //                        if($row1['uID']==$user_id) {
                        //
                        //                            $sql2 = "SELECT * FROM notification";
                        //                            $result2 = mysqli_query($conn,$sql2);
                        //
                        //                            while($row2 = mysqli_fetch_assoc($result2)) {
                        //                                if ($row2['nID'] == $row1['nID']) {
                        //                                    switch($row2['nID']) {
                        //                                        case 2:
                        //                                            ?>
                        <!--                                            <a href="p_repeatExamForm.php">-->
                        <!--                                            --><?php
                        //                                            echo "<p>"."<b>".$row2['topic']."</b>"."</p>";
                        //                                            echo "<p>".$row2['detail']."</p>";
                        //                                            ?>
                        <!--                                            </a>-->
                        <!--                                            --><?php
                        //                                            break;
                        //                                        case 3:
                        //                                            ?>
                        <!--                                            <a href="p_UCSCregistration.php">-->
                        <!--                                                --><?php
                        //                                            echo "<p>"."<b>".$row2['topic']."</b>"."</p>";
                        //                                            echo "<p>".$row2['detail']."</p>";
                        //                                                ?>
                        <!--                                            </a>-->
                        <!--                                            --><?php
                        //                                            break;
                        //                                        case 4:
                        //                                            ?>
                        <!--                                            <a href="p_newAcaYear.php">-->
                        <!--                                                --><?php
                        //                                            echo "<p>"."<b>".$row2['topic']."</b>"."</p>";
                        //                                            echo "<p>".$row2['detail']."</p>";
                        //                                                ?>
                        <!--                                            </a>-->
                        <!--                                            --><?php
                        //                                            break;
                        //                                        default: echo "system error"; break;
                        //                                    }
                        //                                }
                        //                            }
                        //                        }
                        //                    }
                        //
                        //                    mysqli_close($conn);

                        ?>

                    </div>

                </div>
            </div>
        </div>
        <!--    /nadeesh-->
    </div>
</div>
<?php
include "footer.php";
?>



</body>
</html>