<?php
/**
 * Created by PhpStorm.
 * User: lahiru
 * Date: 1/10/2016
 * Time: 12:06 PM
 */
require_once 'core/init.php';
$rID=$_SESSION['rID'];
if(Input::exists()) {
    if (Token::check(Input::get('token'))) {
        $semester = Input::get('examSem');
        $index = Input::get('indexNo');
        $init_name = Input::get('initName');
        $full_name = Input::get('fullName');
        $mobilePhone = Input::get('mobileNo');
        $fixedPhone = Input::get('fixedNo');
        $subject = Input::get('subject');
        $assignmentCom = Input::get('assignmentCom');
        $gradeFirst = Input::get('l1Grade');
        $gradeSecond = Input::get('l2Grade');
        $gradeThird = Input::get('l3Grade');
        $username = Input::get('username');
        $sub = explode(' ',trim($subject),2);
        $subjectCode =$sub[0];
        $subjectName =$sub[1];

            $arr = array(
                'Semester' => $semester,
                'subjectCode' => $subjectCode,
                'indexNumber' => $index,
                'nameWithInitials' => $init_name,
                'fullName' => $full_name,
                'fixedPhone' => $fixedPhone,
                'subjectName' => $subjectName,
                'AssignmentComplete' => $assignmentCom,
                'gradeFirst' => $gradeFirst,
                'gradeSecond' => $gradeSecond,
                'gradeThird' => $gradeThird,
                'adminStatus' => 0
            );


        $update = DB::getInstance()->update('repeat_exam',$rID,$arr);
        if($update){
            echo "<script>alert('Update successful.');window.location.href='admin_repeatExamApplicationTable.php'</script>";
        }else{
            echo "<script>alert('Update failed.');window.location.href='admin_repeatExamApplicationTable.php'</script>";
        }
//        echo "<script>alert('Update successful.');window.location.href='admin_repeatExamApplicationTable.php'</script>";
    } else {
        echo "error";

    }
}