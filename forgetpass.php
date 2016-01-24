<?php
/**
 * Created by PhpStorm.
 * User: Shanika-Edirisinghe
 * Date: 12/08/15
 * Time: 11:47
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
<div id="mainWrapper" class="backgroundImg container-fluid">
    <br>
    <div id="ForgotPassword" class="jumbotron col-sm-6 col-sm-offset-3">
<?php

if(Input::exists()){
    if(Token::check(Input::get('token'))) {
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'name' => array(
                'required' => true
            )
        ));

    $uname = Input::get('name');
    if($validation->passed()){
        $user1 = new User();
        if($user1->find($uname)){
//            echo "User exist";
            echo "<div class='text text-info'><strong>User Found. Click on your username to continue.</strong></div>";
        ?>
            <p> <a href="forgetpassCheckPoint.php" onclick="return confirm('Are you sure?')"> <?php echo escape($user1->data()->username); ?> </a> </p>
        <?php
            $_SESSION['phone'] = $user1->data()->phone;
            $_SESSION['id'] = $user1->data()->id;
            $_SESSION['flag'] = 1;
        } else {
            echo "<script>alert('User Not Found');</script>";
//            echo "User Not Found";
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
<!--<form action="" method="post">-->
<!--    <div class="field">-->
<!--        <label for="name">Enter your username </label>-->
<!--        <input type="text" name="name" id="name">-->
<!--    </div>-->
<!--    <input type="submit" value="Search">-->
<!--    <input type="hidden" name="token" value="--><?php //echo Token::generate(); ?><!--">-->
<!--</form>-->

        <h3><strong>Recover Password</strong></h3>
        <form action="" method="POST" class="form-horizontal">
            <label>Enter Your Username</label>
            <div class="gap ">
                <input class="form-control " required id="verification" type="text" name="name" autocomplete="off" placeholder="Username" size="25" maxlength="20"/>
            </div>

            <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
            <input class="btn btn-default" type="submit" value="Next">
        </form>
        <div id="names">

        </div>


    </div>

</div>
<?php
include "footer.php";
?>

</body>
</html>