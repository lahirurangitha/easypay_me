<?php
require_once 'core/init.php';
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
?>
<!-- /. NAV SIDE  -->
<div class="container col-sm-9 " id="page-wrapper" >
    <div class="row">
        <div class="col-sm-12">
            <h2>Student Dashboard</h2>
            <h5>Welcome <?php echo $_SESSION['fname']." ".$_SESSION['lname']?></h5>
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
                            <th>PayerID</th>
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
                                echo "<td>".$t->payerID."</td>";
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
                    $conn = mysqli_connect("localhost","root","","easypay_db");
                    mysqli_select_db($conn,"easypay_db");

                    $user_id = $_SESSION["userid"]; // store the user id into session

                    $sql1 = "SELECT * FROM user_notification";
                    $result1 = mysqli_query($conn,$sql1);

                    while($row1 = mysqli_fetch_assoc($result1)){
                        if($row1['uID']==$user_id) {

                            $sql2 = "SELECT * FROM notification";
                            $result2 = mysqli_query($conn,$sql2);

                            while($row2 = mysqli_fetch_assoc($result2)) {
                                if ($row2['nID'] == $row1['nID']) {
                                    switch($row2['nID']) {
                                        case 2:
                                            ?>
                                            <a href="p_repeatExamForm.php">
                                            <?php
                                            echo "<p>"."<b>".$row2['topic']."</b>"."</p>";
                                            echo "<p>".$row2['detail']."</p>";
                                            ?>
                                            </a>
                                            <?php
                                            break;
                                        case 3:
                                            ?>
                                            <a href="p_UCSCregistration.php">
                                                <?php
                                            echo "<p>"."<b>".$row2['topic']."</b>"."</p>";
                                            echo "<p>".$row2['detail']."</p>";
                                                ?>
                                            </a>
                                            <?php
                                            break;
                                        case 4:
                                            ?>
                                            <a href="p_newAcaYear.php">
                                                <?php
                                            echo "<p>"."<b>".$row2['topic']."</b>"."</p>";
                                            echo "<p>".$row2['detail']."</p>";
                                                ?>
                                            </a>
                                            <?php
                                            break;
                                        default: echo "system error"; break;
                                    }
                                }
                            }
                        }
                    }

                    mysqli_close($conn);

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