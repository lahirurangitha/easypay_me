<?php
/**
 * Created by PhpStorm.
 * User: Anjana
 * Date: 11/14/2015
 * Time: 2:21 PM
 */
require_once 'core/init.php';
require 'Files/accessFile.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Due | Payments</title>
    <?php include 'headerScript.php'?>
</head>
<?php
$fileObject = new accessFile();
$dataArray = $fileObject->read('Files/data_newAcaYear');
$amount    = $dataArray[0];
$endDate   = $dataArray[1];

$fileObject2 = new accessFile();
$dataArray2 = $fileObject2->read('Files/data_UCSCregistration');
$amount2    = $dataArray2[0];
$endDate2   = $dataArray2[1];

$fileObject3 = new accessFile();
$dataArray3 = $fileObject3->read('Files/data_repeatExam');
$amount3   = $dataArray3[0];
$endDate3   = $dataArray3[1];
date_default_timezone_set("Asia/Colombo");
$curDate=date("Y-m-d");
?>
<body>
<?php
include "header.php";
?>
<div class="backgroundImg container-fluid">
    <?php
    include "studentSidebar.php";
    ?>
            <br>
    <div class="container col-sm-9">
            <div class="panel panel-default ">
                <div class="panel-heading">
                    <h3><strong>Due Payments</strong></h3>
                </div>
                <div class="panel-body pre-scrollable" style="min-height: 450px">

    <?php
// start here
    $user = new User();
    $indexNo=$user->data()->indexNumber;
    $userID=$user->data()->id;


    $sql=DB::getInstance()->query2('SELECT sub_code,sub_name,aca_year,aca_sem from results WHERE index_no=? and repeat_status=1',array($indexNo));



    if (!$sql->count()){
        echo "<div class='alert alert-info'>You don't have Due Payments for Repeat Examinations </div>";
    }
// end here
    else{ ?>
                    <div class="table-responsive">
                        <h3><strong>Repeat Exam Payments-Due</strong></h3>
                        <?php if($curDate>$endDate3){
                        echo"You don't have Due Payments for Repeat Examinations!";}else{?>
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Subject Code</th>
                                <th>Subject Name</th>
                                <th>Academic Year</th>
                                <th>Semester</th>

                            </tr>
                            </thead>
                            <tbody>

                            <?php
                            //this is for check whether specific payment has already been made by the student
//start: edited here
                            $count = 0;
                            foreach ($sql->results() as $res) {
                                $sql2 = DB::getInstance()->query('SELECT * FROM repeat_exam WHERE indexNumber=? and subjectCode=? and paymentStatus=1 and (adminStatus=0 or adminStatus=1)', array($indexNo, $res->sub_code));
                                if (!$sql2->count()) {
                                    $count += 1;
                                    $subject = $res->sub_code;
                                    echo "<tr>";
                                    echo "<td>" . $count . "</td>";
                                    echo "<td>" . $res->sub_code . "</td>";
                                    echo "<td>" . $res->sub_name . "</td>";
                                    echo "<td>" . $res->aca_year . "</td>";
                                    echo "<td>" . $res->aca_sem . "</td>";
                                    //  echo "<td>" . "<form action='me_repeat.php' method='POST'><button type='submit' value='{$subject}' name='subject'>Pay</button></form>";
                                    ?><?php "</td>";
                                    echo "<td>" . "<a href='me_repeat.php?var=$subject'><button class=\"btn btn-default col-sm-12\">Pay</button></a>";
//end here

                                }
                            }
                           // $payee=$user->data()->id;
                            //$checkExist=DB::getInstance()->query('SELECT new_academic_year.acaYear FROM new_academic_year WHERE paymentStatus=1 INNER JOIN transaction ON new_academic_year.transactionID=transaction.transactionID AND transaction.payeeID=$payee ');

                            ?>
                            </tbody>

                        </table> <?php } ?>
                        <h3><strong>Annual Registration Fee</strong></h3>
                        <?php
                        if($curDate>$endDate){
                            echo "This payment has not been activated yet!";
                        }
                        else{
                            if(($user->data()->year)==4){
                                echo "You don't have to make this Payment";
                            }
                        else{

                           // $newAca=DB::getInstance()->query(SELECT )

                        ?>
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Closing Date</th>
                                <th>New Academic Year</th>
                                <th>Amount</th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            echo "<td>" . $endDate . "</td>";
                            echo "<td>" . (($user->data()->year)+1) . "</td>";
                            echo "<td>" . "Rs. ".$amount . "</td>";
                            echo "<td>" . "<a href='p_newAcaYear.php'><button class=\"btn btn-default col-sm-12\">Pay</button></a>";
                            ?>
                            </tbody>
                            <?php
                            }
                        }?>
                            </table>

                    </div>

                </div>
            </div>
        </div>
        <?php


        }
?>
</div>
        </div>
<?php
include "footer.php";
?>



</body>
</html>





