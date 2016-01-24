<?php
/**
 * Created by PhpStorm.
 * User: lasith-niro
 * Date: 11/08/15
 * Time: 19:26
 */

require_once 'core/init.php';
require 'SMS/sms.php';
require 'Files/accessFile.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register | Page</title>
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
<?php

$notification = new smsNotification();
//echo "To confirm your registration enter your registration code..." . '<br />';
//echo $randomValue;
//$file = new accessFile();
//$detailArray = $file->read('Files/RouterPhone');
//$messageArray = $file->read_newLine('Files/messages');
//$from = $detailArray[0];
//$pNumber = $_SESSION['phoneNo'];
//$to = '94'.substr($pNumber,1,9);
//$pass = $detailArray[1];
//$message = $messageArray[0];
//$var = $notification->send($from,$to,$message ." ". $randomValue ,$pass); //for db
//echo $var;

$var1 = $_SESSION['username'];
$var2 = Hash::make($_SESSION['password']);
$var3 = $_SESSION['indexNumber'];
$var4 = $_SESSION['name1'];
$var5 = $_SESSION['name2'];
$var6 = $_SESSION['email'];
$var7 = $_SESSION['phoneNo'];
$var8 = $_SESSION['nic'];
$var9 = $_SESSION['dob'];
$var10 = $_SESSION['year'];

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
                $user = new User();
                try{
                    $user->create(array(
                        'username'  => $var1,
                        'password'  => $var2,
    //                    'salt' => $salt,
                        'indexNumber' => $var3,
                        'fname'     => $var4,
                        'lname'     => $var5,
                        'email'     => $var6,
                        'phone'     => $var7,
                        'nic'       => $var8,
                        'dob'       => $var9,
    //                  'course'  => Input::get('course'),
                        'year'      => $var10,
                        'group'     => 1
                    ));
//                    Session::flash('home', 'You are registered!');
//                    Redirect::to('index.php');
                    $_SESSION['s1']=0;
                    echo "<script>alert('You are successfully registered.');window.location.href='login.php'</script>";
                }catch (Exception $e){
//                    Redirect::to('index.php');
                    die($e->getMessage());
                }

            } elseif ($randomValue != $hiddenValue) {
                echo "<div class='text text-warning'>Invalid key code.</div>";
//                Session::flash('home', 'you enter wrong key code.');
//                Redirect::to('index.php');
//                echo "<script>alert('Invalid key code.');</script>";
            }else{
                echo "<script>alert('Invalid verification code.');</script>";
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
//session_unset();
?>

        <form name="sending3" action="sendcode_registration.php"  method="post">
            <div>
<!--                <div class='alert alert-info'>Your phone number is *******--><?php //echo substr($pNum,7 , 9); ?><!--</div>-->
                <div class="text text-info"><strong>Click on send button to send your verification code. </strong>
                    <input class="btn btn-info btn-xs" type="submit" value="Send" name="s1">
                </div>
            </div>
        </form>
        <?php
        if(isset($_SESSION['s1']) && $_SESSION['s1']==1){
            echo "<div class='text text-warning'><strong>Verification code has been sent to your mobile.</strong></div><br>";
        }
        ?>
        <form name="data" action="" method="post">
            <label>Enter verification code</label>
            <div class="gap">
                <input class="form-control" type="number" name="rand_number" id="rand_number">
            </div>
            <input type="hidden" name="storeRandVal" value="<?php echo $randomValue; ?>">
            <input class="btn btn-default" type="submit" value="Register">
            <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
        </form>

    </div>
</div>

<?php
include "footer.php";
?>

</body>
</html>