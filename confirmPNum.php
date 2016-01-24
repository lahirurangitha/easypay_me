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

$user = new User();
if(!$user->isLoggedIn()){
    Redirect::to('index.php');
}


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
    <?php
    if(isset($_SESSION['student'])&&$_SESSION['student']==true){
		include "studentSidebar.php";
	}elseif(isset($_SESSION['admin'])&&$_SESSION['admin']==true){
		include "adminSidebar.php";
	}elseif(isset($_SESSION['coord'])&&$_SESSION['coord']==true){
		include "coordinatorSidebar.php";
	}
    ?>
    <br>
    <div class="jumbotron col-sm-offset-1 col-sm-6">
<?php
$notification = new smsNotification();
$file = new accessFile();

$randomValue = isset($_SESSION['rSend']) ? $_SESSION['rSend'] : '';
if(!isset($_POST['data'])){
    if(Token::check(Input::get('token'))) {
        $hiddenValue = Input::get('storeRandVal');

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
                $_SESSION['s2'] = 0;
                echo "<script>alert('Your phone number has been changed.');window.location.href='update.php';</script>";
//                Redirect::to('index.php');
            } elseif ($randomValue != $hiddenValue) {
//                echo "error";
//                Session::flash('home', 'you enter wrong key code.');
                echo "<script>alert('Update failed. You entered wrong key code.');window.location.href='confirmPNum.php';</script>";
//                Redirect::to('index.php');
            }
            else{
                echo "<script>alert('Update failed. You entered wrong key code.');window.location.href='confirmPNum.php';</script>";
            }
        } else {
            $str = "";
            foreach ($validation->errors() as $error) {
                $str .= $error;
                $str .= '\n';
            }
			//$str = 'Verification code is required.';
            echo '<script type="text/javascript">alert("' . $str . '")</script>';
        }
    }
}
?>
        <form name="sending2" action="sendcode_changePhone.php"  method="post">
            <div class="field">
                <div class="alert alert-success">Click here to send your verification code.
                    <input class="btnbtn-info btn-xs" type="submit" value="Send">
                </div>

            </div>
        </form>
        <?php
        if(isset($_SESSION['s2']) && $_SESSION['s2']==1){
            echo "<div class='text text-warning'><strong>Verification code has been sent to your mobile.</strong></div><br>";
        }
        ?>

        <form name="data" action="" method="post" class="form-horizontal">
            <div class="gap">
                <label>Enter received code here</label>
                <input class="form-control" type="text" name="rand_number" id="rand_number required">
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
