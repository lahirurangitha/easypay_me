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
    include "studentSidebar.php";
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
//                echo 'Your current password is wrong';
                echo "<div class='alert alert-danger'>Current password entered is wrong</div>";
            } else {
                $user->update(array(
                   'password' => Hash::make(Input::get('password_new'))
                ));
                Session::flash('home', 'Your password has been changed.');
                Redirect::to('index.php');

            }

        } else {
            foreach ($validation->errors() as $error) {
//                echo $error, '<br />';
                echo "<div class='alert alert-danger'>$error</div>";
            }
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