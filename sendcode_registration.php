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

if(!isset($_POST['sending3'])){
    $pNumber = $_SESSION['phoneNo'];
    $to ='94'.substr($pNumber,1,9);
    $from = $detailArray[0];
    $pass = $detailArray[1];
    $message = $messageArray[0];
    $var = $notification->send($from,$to,$message ." ". $randomValue ,$pass);
}
$_SESSION['s1']=1;//to check verification sended or not
Redirect::to('registerConfirm.php');

?>