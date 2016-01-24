<?php

require_once 'core/init.php';
require 'Files/accessFile.php';
require_once 'dbcon.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Payment | Page</title>
    <?php include 'headerScript.php'?>

</head>
<body>

<?php
include "header.php";
?>
<div class="backgroundImg container-fluid">
<?php

include "studentSidebar.php";
//This for catching the subject code for each button press on due payments
$user = new User();
$tmp_sub= $_GET['var'];
$indexNo=$user->data()->indexNumber;
//echo $tmp_sub;

//This is for catching required data fields from education department dadatabase
$user = new User();

$sql=DB::getInstance()->query2('SELECT sub_name from subjects WHERE sub_code=?',array($tmp_sub));
if (!$sql->count()) {
    echo "Subject name doesn't exist";
    $sub_name="";
}else{
    $res=$sql->results()[0];
    $sub_name=$res->sub_name;
}
// for getting the  name with initials
$sql2=DB::getInstance()->query2('SELECT name_initial,name_full from u_student WHERE index_no=?',array($user->data()->indexNumber));
if (!$sql->count()) {
    echo "Full name doesn't exist";
}else{
    $res2=$sql2->results()[0];
    $name_ini=$res2->name_initial;
	$full_name= $res2->name_full;
}


?>

    <br>
    <div class="jumbotron col-sm-6 col-sm-offset-1">
        <div>
            <h3><strong>Repeat Exam Form</strong></h3>
        </div>
        <?php


        $tra = new Transaction();
        $fileObject = new accessFile();
        $dataArray = $fileObject->read('Files/data_repeatExam');

        if(!$user->isLoggedIn()) {
            Redirect::to('index.php');
        }

        $prefix = 'easypayID_';
        $lastID = (integer)$tra->lastID();
        $newID = $lastID + 1;
        $transactionID = $tra->encodeEasyID($prefix, $newID);
        //echo $transactionID . '<br />';
        $_SESSION['tId'] = $transactionID;

        $date1 = strtotime($dataArray[1]);
        $date2 = time();
        $dayLimit = $date1-$date2;
        $dayLimit = floor($dayLimit/(60*60*24));

        $filledData=DB::getInstance()->query2('SELECT aca_year,aca_sem,assignments,result1,result2,result3 FROM results WHERE index_no=? AND sub_code=?',array($indexNo,$tmp_sub));

        $semDisplay='';
        $semDB='';
        $fillResult=$filledData->results()[0];
        $acaYear=$fillResult->aca_year;
        $acaSem=$fillResult->aca_sem;
        $assignment=$fillResult->assignments;
        $result1=$fillResult->result1;
        $result2=$fillResult->result2;
        $result3=$fillResult->result3;
        //$full_name=$user->data()->fname." ".$user->data()->lname;

        if($acaYear==1){
            if($acaSem==1){
                $semDisplay='First Year - Semester I';
                $semDB='FYS1';
            }
            elseif($acaSem==2){
                $semDisplay='First Year - Semester II';
                $semDB='FYS2';
            }
        }
        elseif($acaYear==2){
            if($acaSem==1){
                $semDisplay='Second Year - Semester I';
                $semDB='SYS1';
            }
            elseif($acaSem==2){
                $semDisplay='Second Year - Semester II';
                $semDB='SYS2';
            }
        }
        elseif($acaYear==3) {
            if ($acaSem == 1) {
                $semDisplay = 'Third Year - Semester I';
                $semDB = 'TYS1';
            }
        }




        $assignmentComplete='';
        if($assignment==1){
            $assignmentComplete='Completed';
        }
        elseif($assignment==0){
            $assignmentComplete='Not Completed';
        }

        if($dayLimit<0){
            echo "payment is closed!";
        }else {
        $uID = $user->data()->id;
        $uRegID = $user->data()->indexNumber;
        $username= $user->data()->username; //

        if(!$uRegID){
            echo "<div class='text text-danger'><strong>You have not submitted your registration number.</strong></div>";
        } else {
            echo "<div class='text text-info gap'><strong>*Your registration number is $uRegID</strong> </div>";
        }
        //get data from repeat exam file
        $payInfo = fopen("Files/data_repeatExam", "r") or die("Unable to open file!");
        while(!feof($payInfo)) {
            $line = fgets($payInfo);
            $det = explode(' ',trim($line));
        }
        fclose($payInfo);
        //get data from repeat exam file-end
        echo "<div class='text text-info gap'><strong>*You have to pay Rs.$det[0] per paper.</strong> </div>";
        $de_transactionID = $tra->decodeEasyID($transactionID);
        $_SESSION['deID'] = $de_transactionID;

        if(Input::exists()) {
            if (Token::check(Input::get('token'))) {
//
                    $tra->createRepeatExam(array(
                        'transactionID' => $de_transactionID,
                        'Year' => $acaYear,
                        'Semester' => $semDB,
                        'subjectCode' => $tmp_sub,
                        'username'=>$username,
                        'indexNumber' => $indexNo,
                        'nameWithInitials' => $name_ini,
                        'fullName' => $full_name,
                        'fixedPhone' => "-",
                        'subjectName' => $sub_name,
                        'AssignmentComplete' => $assignmentComplete,
                        'gradeFirst' => $result1,
                        'gradeSecond' => $result2,
                        'gradeThird' =>$result3,
                        'paymentStatus' => 0,
                        'adminStatus' => 0
                        )
                    );
                }
                $_SESSION['num'] = 1;
                Redirect::to('p_repeatExam.php');
            }
        }


        ?>


        <form action="" method="post" class="form-horizontal">
            <div id="f1">
                <div class="redColor gap">
                    <h5><strong>* You cannot change automatically filled data.</strong></h5>
                </div>


                <div class="col-sm-6">
                    <label>Semester</label>
                    <input class="form-control" type="text" name="examSem" required="true" value="<?php echo $semDisplay; ?>" disabled>
                </div>
                <div class="col-sm-6">
                    <label>Index number</label>
                    <input class="form-control" type="text" name="indexNo" required="true" value="<?php echo escape($user->data()->indexNumber); ?>"disabled>

                </div>
                <div class="col-sm-6">
                    <label>Name with initials</label>
                    <input class="form-control" type="text" name="initName" required="true" value="<?php echo $name_ini; ?>"disabled>

                </div>
                <div class="col-sm-6">
                    <label>Name in full</label>
                    <input class="form-control" type="text" name="fullName" required="true" value="<?php echo $full_name; ?>"disabled>
                </div>
                <div class="col-sm-12">
                    <h4><strong>Contacts</strong></h4>
                </div>
                <div class="col-sm-6">
                    <label>Mobile number</label>
                    <input class="form-control" type="tel" name="mobileNo" required="true" value="<?php echo escape($user->data()->phone); ?>"disabled>

<!--                    <label>Fixed number</label>-->
<!--                    <input class="form-control" type="text" name="fixedNo" required="true" value="--><?php //echo Input::get('fixedNo'); ?><!--">-->
                </div>
                <!--    Subject code + Subject name + Assignment complete + Grades obtained (prev)-->

                <div id="subjectDet" class="gap">
                    <div class="col-sm-7">
                        <h4><strong>Subject Details</strong></h4>
                    <div>
                        <label>Subject code</label>
                        <input class="form-control" type="text" name="subjectCode[]" required="true" value="<?php echo $tmp_sub; ?>"disabled>

                        <label>Subject name</label>
                        <?php if($sub_name){?>
                        <input class="form-control" type="text" name="subjectName[]" required="true" value="<?php echo $sub_name; ?>"disabled>
                        <?php }else{?>
                        <input class="form-control" type="text" name="subjectName[]" required="true" value=""disabled>
                        <?php } ?>

                        <div>
                            <label>Assignment Completed?</label>
                            <input class="form-control" type="text" name="assignmentCom[]" required="true" value="<?php echo $assignmentComplete; ?>"disabled>

                        </div>
                        </div>
                        </div>
                        <div class="col-sm-5">
                            <h4><strong>Grades Obtained</strong></h4>
                            <div>
                                <label for="firstShy">First attempt</label>
                                <input class="form-control" type="text" name="l1Grade[]" required="true" value="<?php echo $result1; ?>"disabled>
                            </div>
                            <div>
                                <label for="secondShy">Second attempt</label>
                                <input class="form-control" type="text" name="l2Grade[]" required="true" value="<?php echo $result2; ?>"disabled>

                            </div>
                            <div>
                                <label for="thirdShy">Third attempt</label>
                                <input class="form-control" type="text" name="l3Grade[]" required="true" value="<?php echo $result3; ?>"disabled>

                            </div>

                        </div>
                    </div>


                <div id="container">

                </div>
                <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
				
                <div class="col-sm-12">
					<br>
					<input class="btn btn-primary col-sm-2"type="submit" value="Next">
                </div>
            </div>

        </form>
        <button class="btn btn-danger btn-xs col-sm-2" style="float: right" onclick="window.location.href='duepayments.php'"><< Back</button>
    </div>
</div>


<?php

include "footer.php";
?>

</body>
</html>