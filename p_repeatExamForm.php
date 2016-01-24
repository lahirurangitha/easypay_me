<?php

require_once 'core/init.php';
require 'Files/accessFile.php';
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
    ?>
    <br>
    <div class="jumbotron col-sm-6 col-sm-offset-1">
        <h3><strong>Repeat Exam Form</strong></h3>
        <?php
        //payfor other person check
        if(isset($_SESSION['p4o']) && $_SESSION['p4o']==1){
            echo "<div class='text text-info'><strong>You are paying for ".$_SESSION['payeeName'].". </strong><button class='btn btn-default btn-xs'><a href='payForOtherRemove.php' title='Click here to remove other person.'>I have changed my mind</a></button></div> ";
        }?>
<?php

$user = new User();
$tra = new Transaction();
$fileObject = new accessFile();
$dataArray = $fileObject->read('Files/data_repeatExam');

if(!$user->isLoggedIn()) {
    Redirect::to('index.php');
}

$prefix = 'easyID_';
$lastID = (integer)$tra->lastID();
$newID = $lastID + 1;
$transactionID = $tra->encodeEasyID($prefix, $newID);
//echo $transactionID . '<br />';
$_SESSION['tId'] = $transactionID;

$date1 = strtotime($dataArray[1]);
$date2 = time();
$dayLimit = $date1-$date2;
$dayLimit = floor($dayLimit/(60*60*24));

if($dayLimit<0){
    echo "<div class='alert alert-danger'>payment is closed!</div>";
}else{
    if(isset($_SESSION['p4o']) && $_SESSION['p4o']==1){
        $uID = $_SESSION['payeeID'];
        $uRegID = $_SESSION['o_indexNumber'];
        $username = $_SESSION['payeeName'];
    }else{
        $uID = $user->data()->id;
        $uRegID = $user->data()->indexNumber;
        $username = $user->data()->username;
    }


if(!$uRegID){
    echo "<div class='alert alert-danger'>You have not submitted your registration number.</div>";
} else {
    echo "<div class='text text-info gap'><strong>* Your registration number is $uRegID. </strong></div>";
}
    //get data from repeat exam file
    $payInfo = fopen("Files/data_repeatExam", "r") or die("Unable to open file!");
    while(!feof($payInfo)) {
        $line = fgets($payInfo);
        $det = explode(' ',trim($line));
    }
    fclose($payInfo);
    //get data from repeat exam file-end
    echo "<div class='text text-info gap'><strong>* You have to pay Rs.$det[0] per paper. </strong></div>";
$de_transactionID = $tra->decodeEasyID($transactionID);
$_SESSION['deID'] = $de_transactionID;

if(Input::exists()) {
    if (Token::check(Input::get('token'))) {
            $semester = Input::get('examSem');
            $index = Input::get('indexNo');
            $init_name = Input::get('initName');
            $full_name = Input::get('fullName');
            $mobilePhone = Input::get('mobileNo');
            $fixedPhone = Input::get('fixedNo');
//
            $subject = Input::get('subject');
//
//            $subCode = Input::get('subjectCode');
//            $subName = Input::get('subjectName');
            $assignmentComplete = Input::get('assignmentCom');
            $gradeFirst = Input::get('l1Grade');
            $gradeSecond = Input::get('l2Grade');
            $gradeThird = Input::get('l3Grade');
        ///// validate////

//        $validate = new Validate();
//        $validation = $validate->check($_POST, array(
//            'indexNo' => array(
//                'required' => true,
//                'min' => 4,
//                'max' => 4,
//            )
//        ));
//        if($validation->passed()){
//            echo "here";
//        }else{
//            $str = "";
//            foreach ($validation->errors() as $error) {
//                $str .= $error;
//                $str .= '\n';
//            }
//            echo '<script type="text/javascript">alert("' . $str . '")</script>';
//        }

        ///////end validate////////

////////////////////// creating a associative array for each subject//////////////////
        $numForms = count($subject);
        for($i = 0;$i<$numForms;$i++){
            $j = $i+1;
            $sub = explode(' ',trim($subject[$i]),2);
            ${"subject$j"} = array(
//                'subjectCode'=>$subCode[$i],
                'subjectCode'=>$sub[0],
                'subjectName'=>$sub[1],
                'assignmentCom'=>$assignmentComplete[$i],
                'gradeFirst'=>$gradeFirst[$i],
                'gradeSecond'=>$gradeSecond[$i],
                'gradeThird'=>$gradeThird[$i]
            );
        }

//        ////printing subject array///
//        for($i=0;$i<$numForms;$i++){
//            $j=$i+1;
//            print_r(${"subject$j"});
//            echo "<br>";
//        }

        /////////////////////// creating transaction array and insert data////////////////
        for ($i = 0; $i < $numForms; $i++) {
            $j = $i + 1;
            $tra->createRepeatExam(array(
                'transactionID' => $de_transactionID,
                'Year' => $user->data()->year,
                'Semester' => $semester,
                'subjectCode' => ${"subject$j"}['subjectCode'],
                'indexNumber' => $index,
                'nameWithInitials' => $init_name,
                'fullName' => $full_name,
                'fixedPhone' => $fixedPhone,
                'subjectName' => ${"subject$j"}['subjectName'],
                'AssignmentComplete' => ${"subject$j"}['assignmentCom'],
                'gradeFirst' => ${"subject$j"}['gradeFirst'],
                'gradeSecond' => ${"subject$j"}['gradeSecond'],
                'gradeThird' => ${"subject$j"}['gradeThird'],
                'paymentStatus' => 0,
                'adminStatus' => 0,
                'username'=>$username
            ));
        }
        $_SESSION['num'] = $numForms;
        Redirect::to('p_repeatExam.php');
    } else {
        echo "error";
//        $str = "";
//        foreach ($validation->errors() as $error) {
//            $str .= $error;
//            $str .= '\n';
//        }
//        echo '<script type="text/javascript">alert("' . $str . '")</script>';
    }
}
?>


<form action="" method="post" class="form-horizontal">
    <div id="f1">
        <div class="redColor">
            <h5><strong>* Please fill the form below accurately to continue.</strong></h5>
        </div>
        <div class="col-sm-6">
            <?php
            if((integer)date('m') < 6){
                ?>
                <div class="">
                    <label>Semester</label>
                    <select class="form-control" name="examSem" required="true">
                        <option id="FYS1" value="<?php echo escape("FYS1"); ?>">First year - Semester I</option>
                        <option id="SYS1" value="<?php echo escape("SYS1"); ?>">Second year - Semester I</option>
                        <option id="TYS1" value="<?php echo escape("TYS1"); ?>">Third year - Semester I</option>
                    </select>
                </div>
            <?php
            }else{
                ?>
                <div class="">
                    <label>Semester</label>
                    <select class="form-control" name="examSem" required="true" >
                        <option id="FYS2" value="<?php echo escape("FYS2"); ?>">First year - Semester II</option>
                        <option id="SYS2" value="<?php echo escape("SYS2"); ?>">Second year - Semester II</option>
                        <option id="TYS2" value="<?php echo escape("TYS2"); ?>">Third year - Semester II</option>
                    </select>
                </div>
            <?php
            }
            ?>
            </div>
            <div class="col-sm-6">
                <label for="indexNo">Index number</label>
                <input class="form-control" type="text" name="indexNo" required="true" value="<?php echo Input::get('indexNo'); ?>">

            </div>
            <div class="col-sm-6">
                <label>Name with initials</label>
                <input class="form-control" type="text" name="initName" required="true" value="<?php echo Input::get('initName'); ?>">

            </div>
            <div class="col-sm-6">
                <label>Name in full</label>
                <input class="form-control" type="text" name="fullName" required="true" value="<?php echo Input::get('fullName'); ?>">
            </div>
<!--        -->
        <div class="col-sm-12">
            <h4><strong>Contacts</strong></h4>
        </div>
        <div class="col-sm-6">
            <label>Mobile number</label>
            <input class="form-control" type="tel" name="mobileNo" required="true" value="<?php echo escape($user->data()->phone); ?>">
        </div>
        <div class="col-sm-6">
            <label>Fixed number</label>
            <input class="form-control" type="text" name="fixedNo" required="true" value="<?php echo Input::get('fixedNo'); ?>">
        </div>
        <!--    Subject code + Subject name + Assignment complete + Grades obtained (prev)-->

        <div id="subjectDet">
            <div class="col-sm-7">
                <h4><strong>Subject Details</strong></h4>
<!--           diynamic select     -->
                <label>Subject</label>
                <select class="form-control" name="subject[]">
                    <?php
                    $myfile = fopen("Files/courseList", "r") or die("Unable to open file!");
                    while(!feof($myfile)) {
                        $line = fgets($myfile);
                        echo "<option value=\"$line\">$line</option>";
                    }
                    fclose($myfile);
                    ?>
                </select>
<!--            end dinamic select subject    -->
<!--                <label>Subject code</label>-->
<!--                <input class="form-control" type="text" name="subjectCode[]" required="true" value="--><?php //echo Input::get('subjectCode'); ?><!--">-->
<!---->
<!--                    <label>Subject name</label>-->
<!--                    <input class="form-control" type="text" name="subjectName[]" required="true" value="--><?php //echo Input::get('subjectName'); ?><!--">-->

                    <div>
                        <label>Assignment Completed?</label>
                        <select class="form-control" name="assignmentCom[]" required="true">
                            <option value="<?php echo "Completed"; ?>">Yes</option>
                            <option value="<?php echo "Not Completed"; ?>" >No</option>
                        </select>
                    </div>
                </div>

            <div class="col-sm-5">
                <h4><strong>Grades Obtained</strong></h4>
                <div>
                    <label for="firstShy">First attempt</label>
                    <select class="form-control" name="l1Grade[]" value="<?php echo Input::get('l1Grade'); ?>">
                        <option>-</option>
                        <option>C+</option>
                        <option>C</option>
                        <option>C-</option>
                        <option>D+</option>
                        <option>D</option>
                        <option>D-</option>
                        <option>ab</option>
                    </select>
        <!--                        <div>-->
        <!--                            <input class="form-control" type="text" name="l1Grade[]" required="true" value="--><?php //echo Input::get('l1Grade'); ?><!--">-->
        <!--                        </div>-->
                </div>
                <div>
                    <label for="secondShy">Second attempt</label>
                    <select class="form-control" name="l2Grade[]" value="<?php echo Input::get('l2Grade'); ?>">
                        <option>-</option>
                        <option>C+</option>
                        <option>C</option>
                        <option>C-</option>
                        <option>D+</option>
                        <option>D</option>
                        <option>D-</option>
                        <option>ab</option>
                    </select>
        <!--                        <div>-->
        <!--                            <input class="form-control" type="text" name="l2Grade[]" required="true" value="--><?php //echo Input::get('l2Grade'); ?><!--">-->
        <!--                        </div>-->
                </div>
                <div>
                    <label for="thirdShy">Third attempt</label>
                    <select class="form-control" name="l3Grade[]" value="<?php echo Input::get('l3Grade'); ?>">
                        <option>-</option>
                        <option>C+</option>
                        <option>C</option>
                        <option>C-</option>
                        <option>D+</option>
                        <option>D</option>
                        <option>D-</option>
                        <option>ab</option>
                    </select>
        <!--                        <div>-->
        <!--                            <input class="form-control" type="text" name="l3Grade[]" required="true" value="--><?php //echo Input::get('l3Grade'); ?><!--">-->
        <!--                        </div>-->
                </div>
            </div>
        </div>
<!--        end of sub det-->
<!--            <br>-->
        <div id="container" class="">

        </div>
        <div class="">
            <div class="col-sm-12">
                <br>
                <input class="btn btn-default btn-xs col-sm-2" id="add" name="add" type="button" value="Add" onclick="createCopy();" title="Add another subject.">
                <input class="btn btn-default btn-xs col-sm-2" id="remove" name="remove" type="button" value="Remove" onclick="removeCopy();" title="Remove a subject.">
                <span class="redColor col-sm-offset-1">* To add or remove a subject</span>
            </div>
            <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
            <div class="col-sm-12">
                <input class="btn btn-default col-sm-2"type="submit" value="Next">
            </div>

        </div>
    </div>
</form>
<?php
}
?>
        <button class="btn btn-primary btn-xs col-sm-2" style="float: right" onclick="window.location.href='payforme.php'"><< Back</button>
</div>
</div>

<?php
include "footer.php";
?>


</body>
</html>