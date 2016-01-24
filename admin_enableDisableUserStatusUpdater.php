<?php
/**
 * Created by PhpStorm.
 * User: lahiru
 * Date: 1/7/2016
 * Time: 9:59 PM
 */

require_once 'core/init.php';
$user  = new User();
if(!$user->isLoggedIn()){Redirect::to('index.php');}
if(!$user->hasPermission('admin')){Redirect::to('index.php');}

$username = $_GET['username'];
$currStatus = $_GET['active'];
if($user->data()->username!=$username){
    if($currStatus==1){
        $deactivate = DB::getInstance()->query('UPDATE users SET active = 0 WHERE username = ?',array($username));
        if($deactivate->count()>0){
            echo "<script>alert('Deactivated');window.location.href='admin_enableDisableUser.php'</script>";
        }
    }elseif($currStatus==0){
        $activate = DB::getInstance()->query('UPDATE users SET active = 1 WHERE username = ?',array($username));
        if($activate->count()>0){
            echo "<script>alert('Activated');window.location.href='admin_enableDisableUser.php'</script>";
        }
    }
}else{
    echo "<script>alert('You cannot deactivate your own account.');window.location.href='admin_enableDisableUser.php'</script>";
}

