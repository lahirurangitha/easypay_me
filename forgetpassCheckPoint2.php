<?php
/**
 * Created by PhpStorm.
 * User: Shanika-Edirisinghe
 * Date: 20/08/15
 * Time: 11:54
 */

require_once 'core/init.php';
if(!isset($_SESSION['fp_flag1'])){
	Redirect::to('index.php');
}
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

$id1 = $_SESSION['id'];
//if(!$user->isLoggedIn()){
//    Redirect::to('index.php');
//}
if(Input::exists()){
    if(Token::check(Input::get('token'))) {
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'password_new' => array(
				'regexPassword' => 'password_new',
                'required' => true,
                'min' => 6
            ),
            'password_new_again' => array(
                'required' => true,
                'min' => 6,
                'matches' => 'password_new'
            )
        ));

        if($validation->passed()){
            $user->update(array(
                'password' => Hash::make(Input::get('password_new'))
                ),$id1);
            $_SESSION['s3']=0;
            echo "<script>alert('Password Changed Successfully.');window.location.href='login.php';</script>";
//            Redirect::to('login.php');
//            Session::flash('home', 'Your password has been changed.');
            }else {
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

        <form action="" method="post">
            <div class="gap">
                <label for="Password_new">Enter new password</label>
                <input class="form-control" type="password" name="password_new" id="password_new">
            </div>
            <div class="gap">
                <label for="Password_new_again">Re-enter password</label>
                <input class="form-control" type="password" name="password_new_again" id="password_new_again">
            </div>
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