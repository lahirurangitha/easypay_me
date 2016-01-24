<?php
/**
 * Created by PhpStorm.
 * User: lahiru
 * Date: 1/10/2016
 * Time: 10:48 AM
 */
require_once 'core/init.php';
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title>Repeat Exam Application | page</title>
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
    <div class="container col-sm-9">
        <br>
<?php
if(isset($_GET['username'])&& isset($_GET['subjectCode'])){
    $username =$_GET['username'];
    $subjectCode = $_GET['subjectCode'];
    $_SESSION['rID']=$_GET['rID'];
    $tdb = DB::getInstance()->query('SELECT * FROM repeat_exam WHERE paymentStatus = 1 AND adminStatus=2 AND username = ? AND subjectCode = ?',array($username,$subjectCode));
//    print_r($tdb->results());
    if($tdb->count()>0){
        foreach($tdb->results() as $res){
            ?>
<!--        form-->
        <div class="jumbotron col-sm-12">
            <h3><strong>Update Repeat Application Form</strong></h3>
            <form action="admin_repeatExamApplicationStatusUpdater.php" method="post" class="form-horizontal">
                <div id="f1">
                    <div class="redColor">
                        <h5><strong>* Please update the form below accurately to continue.</strong></h5>
                    </div>
                    <div class="col-sm-6">
                            <div class="">
                                <label>Semester</label>
                                <select class="form-control" name="examSem" required="true">
                                    <option id="FYS1" value="<?php echo escape("FYS1"); ?>">First year - Semester I</option>
                                    <option id="SYS1" value="<?php echo escape("SYS1"); ?>">Second year - Semester I</option>
                                    <option id="TYS1" value="<?php echo escape("TYS1"); ?>">Third year - Semester I</option>
                                    <option id="FYS2" value="<?php echo escape("FYS2"); ?>">First year - Semester II</option>
                                    <option id="SYS2" value="<?php echo escape("SYS2"); ?>">Second year - Semester II</option>
                                    <option id="TYS2" value="<?php echo escape("TYS2"); ?>">Third year - Semester II</option>
                                </select>
                            </div>

                    </div>
                    <div class="col-sm-6">
                        <label for="indexNo">Index number</label>
                        <input class="form-control" type="text" name="indexNo" value="<?php echo $res->indexNumber ?>">

                    </div>
                    <div class="col-sm-6">
                        <label>Name with initials</label>
                        <input class="form-control" type="text" name="initName" required="true" value="<?php echo $res->nameWithInitials ?>">
                    </div>
                    <div class="col-sm-6">
                        <label>Name in full</label>
                        <input class="form-control" type="text" name="fullName" required="true" value="<?php echo $res->fullName ?>">
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
                        <input class="form-control" type="text" name="fixedNo" required="true" value="<?php echo $res->fixedPhone?>">
                    </div>
                    <!--    Subject code + Subject name + Assignment complete + Grades obtained (prev)-->

                    <div id="subjectDet">
                        <div class="col-sm-7">
                            <h4><strong>Subject Details</strong></h4>
                            <!--           diynamic select     -->
                            <label>Subject</label>
                            <select class="form-control" name="subject">
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
                                <select class="form-control" name="assignmentCom" required="true">
                                    <option value="<?php echo "Completed"; ?>">Yes</option>
                                    <option value="<?php echo "Not Completed"; ?>" >No</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-5">
                            <h4><strong>Grades Obtained</strong></h4>
                            <div>
                                <label for="firstShy">First attempt</label>
                                <select class="form-control" name="l1Grade" value="<?php echo Input::get('l1Grade'); ?>">
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
                                <select class="form-control" name="l2Grade" value="<?php echo Input::get('l2Grade'); ?>">
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
                                <select class="form-control" name="l3Grade" value="<?php echo Input::get('l3Grade'); ?>">
                                    <option>-</option>
                                    <option>C+</option>
                                    <option>C</option>
                                    <option>C-</option>
                                    <option>D+</option>
                                    <option>D</option>
                                    <option>D-</option>
                                    <option>ab</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                        <div class="col-sm-12">
                            <input class="btn btn-default col-sm-2"type="submit" name="updateForm" value="Next">
                        </div>
                    </div>
                </div>
            </form>
            </div>
<!--        /form-->
        <?php
        }
    }
}
?>
        </div>
</div>
</body>
</html>