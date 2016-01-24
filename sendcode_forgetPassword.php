<?php
/**
 * Created by PhpStorm.
 * User: Lasi
 * Date: 12/31/15
 * Time: 11:51 PM
 */
require_once 'core/init.php';
require 'SMS/sms.php';
require 'Files/accessFile.php';
$notification = new smsNotification();
$file = new accessFile();
$randomValue = rand(1000, 9999);
$_SESSION['rSend'] = $randomValue;
$detailArray = $file->read('Files/RouterPhone');
$messageArray = $file->read_newLine('Files/messages');
if(!isset($_POST['sending'])){
    $pNum = $_SESSION['phone'];
    $to = '94'.substr($pNum,1,9);
    $notification->send($detailArray[0], $to, $messageArray[2] . " " . $randomValue, $detailArray[1]);
}
$_SESSION['s3']=1;//to check verification sended or not
Redirect::to('forgetpassCheckPoint.php');

?>