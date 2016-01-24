<?php
/**
 * Created by PhpStorm.
 * User: lasithniro
 * Date: 1/1/16
 * Time: 2:32 PM
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

if(!isset($_POST['sending2'])){
    $phNumber = $_SESSION['new_number'];
    $to ='94'.substr($phNumber,1,9);
    $notification->send($detailArray[0], $to, $messageArray[1] . " " . $randomValue, $detailArray[1]);
}
$_SESSION['s2']=1;//to check verification sended or not
Redirect::to('confirmPNum.php');

?>