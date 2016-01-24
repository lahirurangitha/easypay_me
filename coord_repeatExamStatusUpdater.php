<?php
/**
 * Created by PhpStorm.
 * User: lahiru
 * Date: 11/14/2015
 * Time: 9:21 PM
 */
require_once 'core/init.php';
require_once 'PHPMailer/PHPMailerAutoload.php';
require_once 'PHPMailer/class.phpmailer.php';
require_once 'PHPMailer/class.smtp.php';
$id = $_GET['id'];
$subCode=$_GET['subCode'];
$subName=$_GET['subName'];
$username=$_GET['username'];
$subjectTitle="Regarding to repeat Application";
$acceptMSG= "Dear Student,Your Repeat Examination Application on"." ". $subCode." ". $subName. " " . "has been Accepted.";
$ignoreMSG= "Dear Student,Your Repeat Examination Application on"." ". $subCode." ". $subName. " " . "has been Rejected. Please meet your course coordinator.";
$acceptEmail= "Dear Student,<br>Your Repeat Examination Application on<strong>"." ". $subCode." ". $subName. " " . "</strong>has been <strong>Accepted</strong>.";
$ignoreEmail= "Dear Student,<br>Your Repeat Examination Application on<strong>"." ". $subCode." ". $subName. " " . "</strong>has been <strong>Rejected</strong>. Please meet your course coordinator.";


$catchMail=DB::getInstance()->get('users',array('username','=',$username));
$res=$catchMail->results()[0];
$uID = $res->id;
$mail= $res->email;
$id = $_GET['id'];
if(isset($_GET['accept'])){
    if($_GET['accept']==true){
        $tdb1 = DB::getInstance()->update('repeat_exam',$id,array('adminStatus' => 1));
        $tdb2 = DB::getInstance()->insert('repeatExam_notification',array('uID' => $uID,'topic' => 'Application Accepted','description' => $acceptMSG));
//        $mailObject ->sendMail($mail,$subject,$acceptMSG);
        //mail
        /* CONFIGURATION */
        $crendentials = array(
            'email'     => 'easypayucsc2@gmail.com',    //Your GMail adress
            'password'  => 'easypayucsc@123'               //Your GMail password
        );

        /* SPECIFIC TO GMAIL SMTP */
        $smtp = array(

            'host' => 'smtp.gmail.com',
            'port' => 587,
            'username' => $crendentials['email'],
            'password' => $crendentials['password'],
            'secure' => 'tls' //SSL or TLS

        );

        /* TO, SUBJECT, CONTENT */
        $to         = $mail; //The 'To' field
        $subject    = $subjectTitle;



        $mailer = new PHPMailer();

//SMTP Configuration
        $mailer->isSMTP();
        $mailer->SMTPAuth   = true; //We need to authenticate
        $mailer->Host       = $smtp['host'];
        $mailer->Port       = $smtp['port'];
        $mailer->Username   = $smtp['username'];
        $mailer->Password   = $smtp['password'];
        $mailer->SMTPSecure = $smtp['secure'];

//Now, send mail :
//From - To :
        $mailer->From       = $crendentials['email'];
        $mailer->FromName   = 'Easy Pay'; //Optional
        $mailer->addAddress($to);  // Add a recipient

//Subject - Body :
        $mailer->Subject        = $subject;
        $mailer->Body           = $acceptEmail;
        $mailer->isHTML(true); //Mail body contains HTML tags

//Check if mail is sent :
        if(!$mailer->send()) {
            echo 'Error sending mail : ' . $mailer->ErrorInfo;
        } else {
            echo 'Message sent !';
        }

        //
        Redirect::to('coord_repeatExamApplication.php');
    }
}
if(isset($_GET['reject'])){
    if($_GET['reject']==true){
        $tdb1 = DB::getInstance()->update('repeat_exam',$id,array('adminStatus' => 2));
        $tdb2 = DB::getInstance()->insert('repeatExam_notification',array('uID' => $uID,'topic' => 'Application Rejected','description' => $ignoreMSG));
//        $mailObject ->sendMail($mail,$subject,$ignoreMSG);
        //mail
        /* CONFIGURATION */
        $crendentials = array(
            'email'     => 'easypayucsc2@gmail.com',    //Your GMail adress
            'password'  => 'easypayucsc@123'               //Your GMail password
        );

        /* SPECIFIC TO GMAIL SMTP */
        $smtp = array(

            'host' => 'smtp.gmail.com',
            'port' => 587,
            'username' => $crendentials['email'],
            'password' => $crendentials['password'],
            'secure' => 'tls' //SSL or TLS

        );

        /* TO, SUBJECT, CONTENT */
        $to         = $mail; //The 'To' field
        $subject    = $subjectTitle;



        $mailer = new PHPMailer();

//SMTP Configuration
        $mailer->isSMTP();
        $mailer->SMTPAuth   = true; //We need to authenticate
        $mailer->Host       = $smtp['host'];
        $mailer->Port       = $smtp['port'];
        $mailer->Username   = $smtp['username'];
        $mailer->Password   = $smtp['password'];
        $mailer->SMTPSecure = $smtp['secure'];

//Now, send mail :
//From - To :
        $mailer->From       = $crendentials['email'];
        $mailer->FromName   = 'Easy Pay'; //Optional
        $mailer->addAddress($to);  // Add a recipient

//Subject - Body :
        $mailer->Subject        = $subject;
        $mailer->Body           = $ignoreEmail;
        $mailer->isHTML(true); //Mail body contains HTML tags

//Check if mail is sent :
        if(!$mailer->send()) {
            echo 'Error sending mail : ' . $mailer->ErrorInfo;
        } else {
            echo 'Message sent !';
        }
        //
        Redirect::to('coord_repeatExamApplication.php');
    }
}