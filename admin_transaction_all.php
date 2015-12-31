<?php
/**
 * Created by PhpStorm.
 * User: lahiru
 * Date: 10/16/2015
 * Time: 7:53 PM
 */

require_once 'core/init.php';
if(!$_SESSION['isLoggedIn']) {
    Redirect::to('index.php');
}

if($_SESSION['student']){
    Redirect::to('dashboard_student.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Transaction | Page</title>
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

    <div id="page-wrapper" class="container col-lg-9" >
        <div id="page-inner">
            <br>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="list-inline">
                            <h4>Transaction History</h4>
                            <div class="col-lg-offset-8">
                                <label>Search</label>
                                <input type="date" name="search" onchange="autoSuggest('byDate','admin_searchTransaction.php')">
                            </div>

                        </div>

                    </div>

                    <div class="panel-body">
                        <br>
<!--                        <div class="col-lg-12">-->
<!--                            <div class="col-lg-4" style="float: right">-->
<!--                                <label>Search</label>-->
<!--                                <input type="date" name="search" onchange="autoSuggest('byDate','admin_searchTransaction.php')">-->
<!--                            </div>-->
<!--                        </div>-->



<!-- search results-->
                    <div id="byDate">

                    </div>

<!-- search results end-->

                    <!--                all transactions-->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h5><strong>All Transactions</strong></h5>
                        </div>
                        <div class="panel-body">
                    <div class="pre-scrollable">
                        <div class="">
                            <table class="table table-striped table-bordered table-hover">
                                <?php
                                $Alltransactions = DB::getInstance()->get('transaction',array(1,'=',1));
                                //foreach($Alltransactions->results() as $res){
                                //    print_r($res);
                                //    echo"<br>";
                                //}
                                if(!$Alltransactions->count()){
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
                                foreach($Alltransactions->results() as $t){
                                    //                                   print_r($t);
                                    //                                   echo'<br>';
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
                    <!--                All transactions end-->


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