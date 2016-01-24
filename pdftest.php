<?php
/**
 * Created by PhpStorm.
 * User: Anjana
 * Date: 11/14/2015
 * Time: 11:43 PM
 */

require_once 'core/init.php';
require_once 'fpdf/fpdf.php';
require 'Files/accessFile.php';
//require_once 'qr/qrcode.php';


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admission | Card</title>
</head>
</html>
<?php
$user = new User();
$fObject = new accessFile();
//$qr = new qrcode();
//$qr->link("http://www.easypaysl.com");
//$file = $qr->get_image();
//$qr->save_image($file,'images/QR1.png');



$inFile = $fObject->read('Files/admissionActivate');
$issuedDate = $inFile[0];

$indexNo=$user->data()->indexNumber;
//$sql3="SELECT name_full,reg_no,years,semester,cs_is from u_student WHERE  index_no=$indexNo ";
$details=DB::getInstance()->get2('u_student',array('index_no','=',$indexNo));
if(!$details->count()){
    echo 'No Records';
}else{
    foreach($details->results() as $stu){
        $name = $stu->name_full;
        $reg = $stu->reg_no;
        $years =$stu->years;
        $years -=1;
        $sem = $stu->semester;
        $deg=$stu->cs_is;
        $degree='';
        $semester='';
        $year_word='';
    }
}

//$resultz3=mysqli_query($conn,$sql3);
//$row3 = mysqli_fetch_assoc($resultz3);
//$name = $row3['name_full'];
//$reg = $row3['reg_no'];
//$years = $row3['years'];
//$years -=1;
//$sem = $row3['semester'];
//$deg=$row3['cs_is'];
//$degree='';
//$semester='';
//$year_word='';

if($deg==1){
    $degree ='Computer Science';
}
else if($deg==0){
    $degree='Information Systems';
}
if($sem==1){
    $semester='First Semester';
}
else if($sem==2){
    $semester='Second Semester';
}
switch($years){
    case 0:
        $year_word='First Year';
        break;
    case 1:
        $year_word='Second Year';
        break;
    case 2:
        $year_word='Third Year';
        break;
    case 3:
        $year_word='Fourth Year';
        break;
}


//include "header.php";
//Assuming that the subject code is passed through button pressing

$subs=DB::getInstance()->query2('SELECT sub_code,sub_name from results WHERE repeat_status=1 and index_no=?',array($indexNo));

if(!$subs->count()){
    echo 'No Records';
}else{
    $subjects = array();

    foreach($subs->results() as $stu) {
        $check=DB::getInstance()->query('SELECT subjectCode from repeat_exam WHERE indexNumber=? and subjectCode=? and paymentStatus=1 and adminStatus=1',array($indexNo,$stu->sub_code));
        if ($check->count()){
            //  $subject = $stu->sub_code;
            array_push($subjects, $stu);}
    }

    $examination = $year_word . " " . $semester . " " . $degree . " " . "Degree Programme";
    $image = "images/ucsc.png";
    $pdf = new FPDF();

    $pdf->AddPage();
    $pdf->Image($image, 90, 7.5, 23);

    $pdf->SetFont('Arial','B',15);
    $pdf->SetTextColor(255,192,203);

    $pdf->Text(150,10,"www.easypaysl.com");
    $pdf->SetFont('Arial','B',15);
    $pdf->SetTextColor(0,0,0);
//                    $pdf->SetFont("Arial", "B", "18");
//                    $pdf->Cell(0, 60, "UNIVERSITY OF COLOMBO, SRI LANKA", 0, 1, "C");

    $pdf->SetFont("Arial", "B", "15");
    $pdf->Cell(0, 60, "University of Colombo School of Computing", 0, 1, "C");
    $pdf->SetFont("Arial", "", "12");
    $pdf->Cell(0, -45, "Repeat Examination Admission Card", 0, 1, "C");
    $pdf->Line(20, 55, 190, 55);


    $pdf->SetY(60);
    $pdf->SetX(15);
    $pdf->SetFont("Arial", "B", 11);
    $pdf->Cell(50, 10, "   Examination", 1, 0);
    $pdf->SetFont("Arial", "", 11);
    $pdf->Cell(135, 10, $examination, 1, 1);

    $pdf->SetX(15);
    $pdf->SetFont("Arial", "B", 11);
    $pdf->Cell(50, 10, "   Name of the Candidate", 1, 0);
    $pdf->SetFont("Arial", "", 11);
    $pdf->Cell(135, 10, $name, 1, 1);

    $pdf->SetX(15);
    $pdf->SetFont("Arial", "B", 11);
    $pdf->Cell(50, 10, "   Index Number", 1, 0);
    $pdf->SetFont("Arial", "", 11);
    $pdf->Cell(135, 10, $indexNo, 1, 1);

    $pdf->SetX(15);
    $pdf->SetFont("Arial", "B", 11);
    $pdf->Cell(50, 10, "   Year of the Exam", 1, 0);
    $pdf->SetFont("Arial", "", 11);
    $pdf->Cell(135, 10, $year_word . " Repeat", 1, 1);

    $pdf->SetX(15);
    $pdf->SetFont("Arial", "B", 11);
    $pdf->Cell(50, 10, "   Semester", 1, 0);
    $pdf->SetFont("Arial", "", 11);
    $pdf->Cell(135, 10, $semester, 1, 1);

    $pdf->SetY(115);

    $pdf->SetFont("Arial", "BU", 11);
    $pdf->Cell(18, 14, "General Conditions", 0, 1);

    $pdf->SetFont("Arial", "", 10);
    $pdf->Cell(5, 8, "1. No candidates will be admitted to the Examination hall without this card and the student ID card.", 0, 1);
    $pdf->Cell(5, 8, "2. All specimen signatures must be clearly placed in ink.", 0, 1);
    $pdf->Cell(5, 4, "3. Candidates should adhere to the rules of the examinations given in the examination procedure(printed in the reverse side ", 0, 1);
    $pdf->Cell(5, 4, "    of the admission card). In case the supervisor has a reasonable doubt that a candidate has committed an examination ", 0, 1);
    $pdf->Cell(5, 4, "    offence, the candidate should furnish a written statement on the offence committed when requested by the supervisor. ", 0, 1);

    $pdf->SetY(160);

    $pdf->SetFont("Arial", "BU", 11);
    $pdf->Cell(18, 14, "Declaration by the Candidate", 0, 1);

    $pdf->SetFont("Arial", "", 10);

    $pdf->Cell(5, 4, "    I agreed to abide by the above conditions and to adhere to the rules of examination. I am also aware of the punishments  ", 0, 1);
    $pdf->Cell(5, 4, "    for examination offences. ", 0, 1);

    $pdf->SetY(190);
    $pdf->SetX(48);
    $pdf->Cell(32, 11, $issuedDate, 1, 0,"C");
    $pdf->Cell(34, 11, "", 1, 0);
    $pdf->Cell(47, 11, "", 1, 1);
    $pdf->SetX(48);
    $pdf->SetFont("Arial", "B", 10);
    $pdf->Cell(32, 11, "Date of issue", 1, 0,"C");
    $pdf->Cell(34, 11, "SAR/Examinations", 1, 0,"C");
    $pdf->Cell(47, 11, "Signature of the Candidate", 1, 1);


    $pdf->SetY(220);
    $pdf->SetFont("Arial", "B", 9);
    $pdf->Cell(16, 10, " Date", 1, 0);
    $pdf->Cell(21, 10, " Time", 1, 0);
    $pdf->Cell(80, 10, " Subject", 1, 0);
    //  $pdf->Cell(28, 10, " Place", 1, 0);
    $pdf->Cell(35, 10, " Candidate Signature", 1, 0);
    $pdf->Cell(35, 10, " Supervisor Signature", 1, 1);

    $pdf->SetFont("Arial", "B", 10);
//changed here
    foreach ($subjects as $each_sub) {
//                        $subcode=$stu->subcode;
        $sql2 = DB::getInstance()->query2('SELECT dates,times from exam_date_time WHERE sub_code=?',array($each_sub->sub_code));

        $sql2_res=$sql2->results();

        $date = $sql2_res[0]->dates;
        $time = $sql2_res[0]->times;
        $sub_name=$sql2_res[0]->sub_name;
        //                    $place = $sql2_res->place;


        $pdf->SetFont("Arial", "", 8);
        $pdf->Cell(16, 10, $date, 1, 0);
        $pdf->Cell(21, 10, $time, 1, 0);
        $pdf->Cell(80, 10, $each_sub->sub_code." ".$each_sub->sub_name, 1, 0);
        $pdf->SetFont("Arial", "", 11);
        //      $pdf->Cell(28, 10, $place, 1, 0);
        $pdf->Cell(35, 10, "", 1, 0);
        $pdf->Cell(35, 10, "", 1, 1);
        $sub_name='';
    }
    $pdf->SetFont("Arial", "B", 10);
    $pdf->Cell(1, 15, "    Warning: Students are not supposed to write anything other than their signature in this page or on the   ", 0, 1);
    $pdf->Cell(1, 0, "                     reverse side.  ", 0, 1);



    $pdf->Output();
    
    //add qr

    ob_end_clean();
}
?>







