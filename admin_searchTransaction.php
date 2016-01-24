<?php
/**
 * Created by PhpStorm.
 * User: lahiru
 * Date: 11/28/2015
 * Time: 8:33 PM
 */

require_once 'core/init.php';

if(isset($_POST['searchVal']) && $_POST['searchVal']!= null) {
    $date = $_POST['searchVal'];
    $_SESSION['date1']=$date;//search date
//        echo"<label>Transactions on $date</label><br>";
        $DayTra = DB::getInstance()->query('SELECT * From transaction t,users u WHERE t.date = ? and t.payerID = u.id ORDER BY transactionID DESC', array($date));
        //foreach($MonthTra->results() as $res){
        //    print_r($res);
        //    echo"<br>";
        //}
        if (!$DayTra->count()){
            echo "<div class='alert alert-info'><strong>No transactions found on $date</strong></div><br>";
        }else{
        ?>

            <div class="panel panel-default">
            <div class="panel-heading">
                <?php
                echo"<label>Transactions on $date</label><br>";
                ?>
                <input type="button" value="Download PDF"
                       onclick="window.open('transactionDatePDF.php')">
            </div>
            <div class="panel-body">
            <div class="pre-scrollable" style="max-height: 400px">
            <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>No</th>
            <th>Date</th>
            <th>Time</th>
            <th>Transaction ID</th>
<!--            <th>PayerID</th>-->
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
        foreach ($DayTra->results() as $t) {
//                                       print_r($t);
//                                        echo'<br>';
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
            $counter += 1;
            echo "<tr>";
            echo "<td>" . $counter . "</td>";
            echo "<td>" . $t->date . "</td>";
            echo "<td>" . $t->time . "</td>";
            echo "<td>" . $t->transactionID . "</td>";
//            echo "<td>" . $t->payerID . "</td>";

            echo "<td>" . $t->username . "</td>";
            $PayeeName = DB::getInstance()->get('users',array('id','=',$t->payeeID))->results()[0]->username;
            echo "<td>".$PayeeName."</td>";
            echo "<td>" . $paymentType . "</td>";
            echo "<td>" . $t->statusDescription . "</td>";
            echo "<td>" . $t->amount . "</td>";
            echo "</tr>";
        }
        }
        ?>
        </tbody>
    </table>
    </div>
    </div>
    </div>

<?php
}
    ?>