<?php
/**
 * Created by PhpStorm.
 * User: lahiru
 * Date: 11/28/2015
 * Time: 8:33 PM
 */

require_once 'core/init.php';

if(isset($_POST['searchVal'])) {
    $date = $_POST['searchVal'];
//        echo"<label>Transactions on $date</label><br>";
        $DayTra = DB::getInstance()->get('transaction', array('date', '=', $date));
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
            </div>
            <div class="panel-body">
            <div class="pre-scrollable">
            <table class="table table-striped table-bordered table-hover">
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
        foreach ($DayTra->results() as $t) {
//                                       print_r($t);
//                                        echo'<br>';
            $counter += 1;
            echo "<tr>";
            echo "<td>" . $counter . "</td>";
            echo "<td>" . $t->date . "</td>";
            echo "<td>" . $t->time . "</td>";
            echo "<td>" . $t->transactionID . "</td>";
            echo "<td>" . $t->payerID . "</td>";
            echo "<td>" . $t->paymentType . "</td>";
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