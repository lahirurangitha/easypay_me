<?php
/**
 * Created by PhpStorm.
 * User: lasith-niro
 * Date: 11/08/15
 * Time: 10:54
 */

require_once 'core/init.php';
require 'SMS/sms.php';
require 'Files/accessFile.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Confirm | Phone number</title>
    <?php include 'headerScript.php'?>
</head>
<body>
<?php
include "header.php";
?>
<div class="backgroundImg container-fluid">
    <br>
    <div class="jumbotron col-lg-offset-3 col-lg-6">
<?php

$user = new User();
$notification = new smsNotification();
$file = new accessFile();

//echo "Welcome to confirm your phone number!" . '<br />';
//echo $_SESSION['old_number'] . '<br />';
//echo $_SESSION['new_number'] . '<br />';
//echo $randomValue. '<br />';
//echo gettype($rnd);
$hiddenValue = Input::get('storeRandVal');
$randomValue = rand(1000, 9999);
$detailArray = $file->read('Files/RouterPhone');
$messageArray = $file->read_newLine('Files/messages');

//echo $randomValue;

if(!$user->isLoggedIn()){
    Redirect::to('index.php');
}
//variable for $notificationTEXT->send($from,$to,$message,$password)
$from = $detailArray[0];
$phNumber = $_SESSION['new_number'];
$to ='94'.substr($phNumber,1,9);
$pass = $detailArray[1];
//substr($old_phone_number,7 , 9)
$var = $notification->send($from,$to,$messageArray[1] . $randomValue ,$pass);
//echo $var;//for db(development)

if(Input::exists()){
    if(Token::check(Input::get('token'))) {
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'rand_number' => array(
                'required' => true,
                'min' => 4,
                'max' => 4,
            )
        ));
        if($validation->passed()){
            $input = htmlspecialchars(trim(Input::get('rand_number')));

            if($input == $hiddenValue){
                $user->update(array(
                    'phone' => $_SESSION['new_number']
                ));
//                Session::flash('home', 'Your phone number has been changed.');
                echo "<script type='text/javascript'>successAlert('Your phone number has been changed.')</script>";
                Redirect::to('index.php');
            } elseif ($randomValue != $hiddenValue) {
//                echo "error";
//                Session::flash('home', 'you enter wrong key code.');
                echo "<script type='text/javascript'>failedAlert('Update failed. You enter wrong key code.');</script>";
                Redirect::to('index.php');
            }
        } else {
            foreach ($validation->errors() as $error) {
                echo $error, '<br />';
            }
        }
    }
}
?>

        <form action="" method="post" class="form-horizontal">
            <div class="gap">
                <label>Enter received code here</label>
                <input class="form-control" type="text" name="rand_number" id="rand_number">
            </div>
            <input type="hidden" name="storeRandVal" value="<?php echo $randomValue; ?>">
            <input class="btn btn-default" id="change" type="submit" value="Confirm verification">
            <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
        </form>
    </div>
</div>
<?php
include "footer.php";
?>
</body>
</html>
