<?php
/**
 * Created by PhpStorm.
 * User: lasithniro
 * Date: 1/3/16
 * Time: 8:40 AM
 */
require_once 'core/init.php';
$user = new User();
$notification = new Notification();
if(!$user->isLoggedIn()){ Redirect::to('index.php');}
if (!$user->hasPermission('admin')) {Redirect::to('index.php');}
$notificationID = $_GET['nid'];
$userid = $_GET['uid'];
$notification->disAllowUser($userid,$notificationID);
Redirect::to('notif_remove_user.php?id='.$notificationID.'');