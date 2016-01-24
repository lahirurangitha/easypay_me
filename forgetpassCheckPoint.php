<?php
/**
 * Created by PhpStorm.
 * User: Shanika-Edirisinghe
 * Date: 12/08/15
 * Time: 14:10
 */
require_once 'core/init.php';
require 'SMS/sms.php';
require 'Files/accessFile.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Forgot password | page</title>
    <?php include 'headerScript.php'?>
</head>
<body>
<div>
    <?php
    include "header.php";
    ?>
</div>
<div class="backgroundImg container-fluid">
    <br>
    <div class="jumbotron col-sm-6 col-sm-offset-3">
        <h3><strong>Recover Password</strong></h3>
<?php

$user = new User();
$notification = new smsNotification();
$file = new accessFile();

$pNum = $_SESSION['phone'];
$id = $_SESSION['id'];

//try{
//$randomValue = $_SESSION['rSend'];
//} catch (customException $e){}

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
                //Session::flash('home', 'Your code is correct.');
				$_SESSION['fp_flag1']=true;
                Redirect::to('forgetpassCheckPoint2.php');
            } elseif ($randomValue != $hiddenValue) {
//                Session::flash('home', 'you enter wrong key code.');
//                Redirect::to('index.php');
                echo "<script>alert('Invalid key code. Please try again');</script>";
//                Redirect::to('forgetpassCheckPoint.php');
            }else{
                echo "<script>alert('Invalid key code. Please try again');</script>";
            }
        } else {
            $str = "";
            foreach ($validation->errors() as $error) {
                $str .= $error;
                $str .= '\n';
            }
            echo '<script type="text/javascript">alert("' . $str . '")</script>';
        }
    }
}
?>
        <form name="sending" action="sendcode_forgetPassword.php"  method="post">
            <div>
                <div class='text text-info'><strong>Your phone number is *******<?php echo substr($pNum,7 , 9); ?></strong></div>

                <div class="text text-info"><strong>Click here to send your verification code.</strong>
                    <input class="btn btn-info btn-xs" type="submit" value="Send">
                </div>

            </div>
        </form>
        <?php
        if(isset($_SESSION['s3']) && $_SESSION['s3']==1){
            echo "<div class='text text-warning'><strong>Verification code has been sent to your mobile.</strong></div><br>";
        }
        ?>

        <form name="data" action="" method="post">
            <div class="field">
                <label>Enter your verification </label>
                <div class="gap">
                    <input class="form-control" type="number" name="rand_number" id="rand_number" required>
                </div>
            </div>
            <input type="hidden" name="storeRandVal" value="<?php echo $randomValue; ?>">
            <input class="btn btn-default" type="submit" value="Change">
            <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
        </form>
    </div>
</div>
<?php
include "footer.php";
?>

</body>
</html>