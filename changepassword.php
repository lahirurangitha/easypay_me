<?php
/**
 * Created by PhpStorm.
 * User: Lasith Niroshan
 * Date: 5/23/2015
 * Time: 1:44 PM
 */
require_once 'core/init.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Update | Page</title>
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
    <div class="jumbotron col-sm-5 col-sm-offset-1">
        <?php


$user = new User();

if(!$user->isLoggedIn()){
    Redirect::to('index.php');
}

if(Input::exists()){
    if(Token::check(Input::get('token'))) {
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'password_current' => array(
                'required' => true,
                'min' => 6
            ),
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
            if( Hash::make(Input::get('password_current')) !== $user->data()->password ){
//                echo "<div class='alert alert-danger'>Current password is invalid. Please try again.</div>";
                echo "<script>alert('Current password is invalid. Please try again.');window.location.href='changepassword.php';</script>";
            } else {
                $user->update(array(
                   'password' => Hash::make(Input::get('password_new'))
                ));
//                Session::flash('home', 'Your password has been changed.');
//                Redirect::to('index.php');
                echo "<script>alert('Your password has been changed.');window.location.href='update.php';</script>";

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

        <div id="updateForm">
            <form action="" method="post" class="form-horizontal">
                <h3><strong>Change Password</strong></h3>
            <div class="gap">
                <label>Current password</label>
                <input class="form-control" type="password" name="password_current" id="password_current">
            </div>

            <div class="gap">
                <label>New password</label>
                <input class="form-control" type="password" name="password_new" id="password_new">
            </div>

            <div class="gap">
                <label>New password again</label>
                <input class="form-control" type="password" name="password_new_again" id="password_new_again">
            </div>

            <input class="btn btn-default" id="change" type="submit" value="Change">
            <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
            </form>
        </div>
    </div>
</div>
        <?php
        include "footer.php";
        ?>

</body>
</html>