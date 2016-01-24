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
                            <h3><strong>Transaction History</strong></h3>
                            <div class="col-lg-offset-8">
                                <label>Search by date</label>
                                <input type="date" name="search" onchange="autoSuggest('byDate','admin_searchTransaction.php')">
                            </div>
                            <div class="col-lg-offset-8">
                                <label>Search by username</label>
                                <input type="text" name="search2" onkeyup="autoSuggest2('byName','admin_searchTransactionByName.php')">
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
                        <!-- search results-->
                    <div id="byName">

                    </div>
<!-- search results end-->

                    <!--                all transactions-->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h5><strong>All Transactions</strong></h5>
                            <input type="button" value="Download PDF"
                                   onclick="window.open('transactionPDF.php')">
                        </div>
                        <div class="panel-body">
                    <div class="pre-scrollable" style="max-height: 400px">
                        <div class="">
                            <table class="table table-striped table-bordered table-hover">
                                <?php
//                                $Alltransactions = DB::getInstance()->get('transaction',array(1,'=',1));
                                $Alltransactions = DB::getInstance()->query('SELECT * From transaction t,users u WHERE t.payerID = u.id ORDER BY transactionID DESC',array());

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
                                    <th>No</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Transaction ID</th>
<!--                                    <th>PayerID</th>-->
                                    <th>Payed By</th>
                                    <th>Pay For</th>
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
//                                    echo "<td>".$t->payerID."</td>";
                                    echo "<td>".$t->username."</td>";
                                    $PayeeName = DB::getInstance()->get('users',array('id','=',$t->payeeID))->results()[0]->username;
                                    echo "<td>".$PayeeName."</td>";
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