<?php
/**
 * Created by PhpStorm.
 * User: lasithniro
 * Date: 1/9/16
 * Time: 7:08 PM
 */
require_once 'core/init.php';
$user = new User();
$notification = new Notification();
if(!$user->isLoggedIn()){ Redirect::to('index.php');}
$notificationID = $_GET['nid'];
$userid = $_GET['uid'];
//$sql = "DELETE FROM `repeatexam_notification` WHERE `nID` = 1 AND `uID` = 3";
DB::getInstance()->query('DELETE FROM repeatexam_notification WHERE nID = ? AND uID = ?',array($notificationID, $userid));
Redirect::to('notif_repeat_exam_remove.php');