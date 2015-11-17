<?php
/**
 * Created by PhpStorm.
 * User: Lasith Niroshan
 * Date: 5/23/2015
 * Time: 1:43 PM
 */
require_once 'core/init.php';

if(Session::exists('home')){
    echo '<p>' . Session::flash('home') . '</p>';
}
$user = new User();
if($user->isLoggedIn()) {
    $_SESSION['user_name'] = $user->data()->username;
    //check for admin
    if ($user->hasPermission('admin')) {
//        $msg= '<p> You logged as an Administrator</p>';
        Redirect::to('dashboard_admin.php');
    }
    else{
//        $msg= '<p> You logged as a Student </p>';
        Redirect::to('dashboard_student.php');
    }
} else {
    //include('loginfail.html');
    Redirect::to('homePage.php');
//    Redirect::to('login.php');
}
?>
