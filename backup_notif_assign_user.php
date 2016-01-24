<?php
/**
 * Created by PhpStorm.
 * User: lasithniro
 * Date: 1/2/16
 * Time: 1:10 PM
 */
require_once 'core/init.php';


$user = new User();
$notification = new Notification();
$send_date = date("d/m/y h:i:s");
//$myNotifyID = $_POST['dID'];
$myNotifyID = 5;
$Syear = array();
if(!$user->isLoggedIn()){Redirect::to('index.php');}

if(!$user->hasPermission('admin')){Redirect::to('index.php');}


    $dataSet = $notification->getRepeatStudent();
//    print_r($dataSet);
    foreach((array)$dataSet as $d){
        $index = $d->index_no;
        $userObjet = $notification->getUserID($index);
        foreach((array)$userObjet as $uo){
            $userID = $uo->id;
//            echo $userID."<br />";
        }
    }