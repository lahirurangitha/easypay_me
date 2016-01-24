<?php
/**
 * Created by PhpStorm.
 * User: lasithniro
 * Date: 1/10/16
 * Time: 12:59 AM
 */

include("qrcode.php");
$qr = new qrcode();

$transID = "easyID_002";
$studentName = "Lasith";
$paymentType = "Repeat exam fee";
$paymentStatus = "Completed";
$amount = '100.00';
$index = '13000829';

$str = "Transaction ID = $transID \n Student Index Number = $index \n Payment type = $paymentType \n Amount = $amount \n Payment Status = $paymentStatus \n ";
$qr->text($str);
echo "<p><img src='".$qr->get_link()."' border='0'/></p>";