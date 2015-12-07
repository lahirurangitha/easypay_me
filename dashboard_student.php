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
<nav class="navbar-default navbar-side col-lg-3" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav" id="main-menu">
            <li class="text-center">
                <img src="images/User.png" class="user-image " height="150px"/>
            </li>
            <li>
                <a class="active-menu"  href="dashboard_student.php"><i class="fa fa-dashboard fa-3x"></i> Dashboard</a>
            </li>
            <li>
                <a href="paymentHome.php"><i class="fa fa-dollar fa-3x"></i> Make a Payment</a>
            </li>
            <li>
                <a href="update.php"><i class="fa fa-book fa-3x"></i> Update Details</a>
            </li>
            <li>
                <a href="changepassword.php"><i class="fa fa-lock fa-3x"></i> Change Password</a>
            </li>
            <li>
                <a href="changephonenumber.php"><i class="fa fa-phone fa-3x"></i> Change Phone Number</a>
            </li>
            <li>
                <a href="duepayments.php"><i class="fa fa-phone fa-3x"></i> Due Payments</a>
            </li>
        </ul>

    </div>

</nav>
<!-- /. NAV SIDE  -->
<div class="container col-lg-9 " id="page-wrapper" >
    <div class="row">
        <div class="col-md-12">
            <h2>Student Dashboard</h2>
            <h5>Welcome <?php echo $_SESSION['fname']." ".$_SESSION['lname']?></h5>
        </div>
    </div>
    <hr />

    <div class="col-md-9 col-sm-12 col-xs-12">
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
    <div id="nPanel" class="container col-lg-3">
        <div id="paymentNotification" class="panel panel-default">
            <div class="box-header with-border">
                <div class="box-title">
                    <h4 class="col-lg-offset-1"> Notifications</h4>
                    <div class="box-tools pull-right ">
                        <button class="btn btn-info" data-widget="collapse" data-toggle="collapse" data-target="#nBox" title="Collapse"  style="margin-top:-65px;margin-left:-35px;"><i class="fa fa-plus"></i></button>
                    </div>
                </div>
                <div id="nBox" class="container col-lg-12 box-body alert-info pre-scrollable" style="max-height:250px;">

                    <?php
                    $conn = mysqli_connect("localhost","root","","easypay_db");
                    mysqli_select_db($conn,"easypay_db");
                    $sql = "SELECT * FROM notification";
                    $result = mysqli_query($conn,$sql);
                    $data = mysqli_fetch_assoc($result);

                    while($row = mysqli_fetch_assoc($result)){
                        echo "<p>"."<b>".$row['topic']."</b>"."</p>";
                        echo "<p>".$row['detail']."</p>";
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