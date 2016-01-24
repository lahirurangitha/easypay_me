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
<div id="wrapper">
    <?php
    include "header.php";
    ?>
</div>
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
                <h2><strong>Student Dashboard</strong></h2>
                <h5>Welcome <?php echo $_SESSION['fname']." ".$_SESSION['lname']?></h5>
            </div>
            <br>
            <!--Start: give this to lahiru-->
            <?php
            if($startDate<$curDate and $curDate<$endDate){
//
            $usr = $user->data()->username;
            $check=DB::getInstance()->query('SELECT * from repeat_exam WHERE paymentStatus=1 and adminStatus=1 and username=?',array($usr));
            if ($check->count()>0){
                ?>
                <div class="col-sm-3" style="float: right">
                    <span class="redColor"><strong>* Admission is available</strong></span>
                    <input class="btn btn-primary btn-xs" type="button" value="Download" onclick="window.open('pdftest.php')">
                    <!--                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>-->
                </div>
            <?php
            }
                
            }
//
            ?>

            <!--            end-->
        </div>
    </div>
    <hr />

    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3><strong>Transaction History Table</strong></h3>
            </div>
            <div class="panel-body">
                <div class="table-responsive pre-scrollable" style="max-height:200px;">
                    <table class="table table-striped table-bordered table-hover">
                        <?php
                        $user_id = $_SESSION['userid'];   // get usr id
                        //$transaction = DB::getInstance()->get('transaction',array('payerID','=',$user_id));
						$transaction = DB::getInstance()->query('SELECT * FROM transaction WHERE payerID = ? ORDER BY transactionID DESC',array($user_id));
                        if(!$transaction->count()){
                            echo '<div class="text text-info"><strong>No transactions</strong></div>';
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
                                //payment type check
                                $p1 = DB::getInstance()->get('ucsc_registration',array('transactionID','=',$t->transactionID))->count();
                                $p2 = DB::getInstance()->get('new_academic_year',array('transactionID','=',$t->transactionID))->count();
                                $p3 = DB::getInstance()->get('repeat_exam',array('transactionID','=',$t->transactionID))->count();
                                if($p1>0){
                                    $paymentType = 'UCSC Registration';
                                }elseif($p2>0){
                                    $paymentType = 'New Academic Year';
                                }elseif($p3>0){
                                    $paymentType = 'Repeat Exam';
                                }else{
                                    $paymentType = 'Other';
                                }
                                //
                                $counter+=1;
                                echo"<tr>";
                                echo "<td>".$counter."</td>";
                                echo "<td>".$t->date."</td>";
                                echo "<td>".$t->time."</td>";
                                echo "<td>".$t->transactionID."</td>";
//                                echo "<td>".$t->payerID."</td>";
                                echo "<td>".$paymentType."</td>";
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
<!--    <div id="nPanel" class="container col-sm-3">-->
<!--        <div id="paymentNotification" class="panel panel-default">-->
<!--            <div class="box-header with-border">-->
<!--                <div class="box-title">-->
<!--                    <h4 class="col-sm-offset-1"> Notifications</h4>-->
<!--                    <div class="box-tools pull-right ">-->
<!--                        <button class="btn btn-info" data-widget="collapse" data-toggle="collapse" data-target="#nBox" title="Collapse"  style="margin-top:-65px;margin-left:-35px;"><i class="fa fa-plus"></i></button>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div id="nBox" class="container col-sm-12 box-body alert-info pre-scrollable" style="max-height:250px;">-->
<!---->
<!--                    --><?php
//
//                    $user = new user();
//                    $user_id = $user->data()->id;
//                    $userNotificationDet = DB::getInstance();
//                    $userNotificationDet->query('SELECT * FROM notification n, user_notification un WHERE un.uID = ? and n.nID = un.nID',array($user_id));
//                    $resultSet = $userNotificationDet->results();
//                    foreach($resultSet as $n ){
//                        echo "<a href='#'><strong>$n->topic</strong> <br> $n->detail</a><br>";
//                    }
//
//                    ?>
<!---->
<!--                </div>-->
<!---->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--    /nadeesh-->
</div>
</div>
<?php
include "footer.php";
?>



</body>
</html>